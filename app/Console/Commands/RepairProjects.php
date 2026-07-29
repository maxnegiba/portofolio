<?php

namespace App\Console\Commands;

use App\Models\Project;
use App\Support\Projects\ProjectImagePath;
use App\Support\Projects\ProjectTranslationNormalizer;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class RepairProjects extends Command
{
    protected $signature = 'projects:repair
        {--dry-run : Audit and report without changing database records or files}
        {--move-private-files : Copy recoverable private project images to the public disk}';

    protected $description = 'Audit and safely normalize legacy Project translations, categories, and image paths';

    public function handle(
        ProjectTranslationNormalizer $translations,
        ProjectImagePath $images,
    ): int {
        $dryRun = (bool) $this->option('dry-run');
        $copyPrivateFiles = (bool) $this->option('move-private-files');

        $this->components->info($dryRun ? 'Project audit (dry run)' : 'Project repair');

        Project::query()
            ->orderBy('id')
            ->eachById(function (Project $project) use ($translations, $images, $dryRun, $copyPrivateFiles): void {
                $changes = [];
                $rows = [];

                foreach (Project::TRANSLATABLE_FIELDS as $field) {
                    $raw = $project->getRawOriginal($field);
                    $inspection = $translations->inspect($raw);
                    $normalized = $translations->normalize($raw);
                    $issues = $this->translationIssues($inspection);
                    $unsafe = $inspection['conflicting_duplicates'] !== []
                        || $inspection['unexpected_nested_values'];

                    if (! $unsafe && $this->jsonChanged($raw, $normalized)) {
                        $changes[$field] = $this->encode($normalized);
                    }

                    $rows[] = [
                        $field,
                        $inspection['format'],
                        $issues === [] ? 'healthy' : implode('; ', $issues),
                        $unsafe ? 'report only' : (array_key_exists($field, $changes) ? 'normalize' : 'none'),
                    ];
                }

                $this->inspectCategory($project, $changes, $rows);
                $this->inspectTech($project, $changes, $rows);
                $this->inspectThumbnail($project, $changes, $rows, $images, $dryRun, $copyPrivateFiles);
                $this->inspectGallery($project, $changes, $rows, $images, $dryRun, $copyPrivateFiles);

                $this->newLine();
                $this->line(sprintf(
                    '<fg=cyan>Project #%d</>  slug=%s  category=%s',
                    $project->getKey(),
                    $project->slug,
                    (string) $project->getRawOriginal('category'),
                ));
                $this->table(['Field', 'Format', 'Audit', 'Action'], $rows);

                if ($changes === []) {
                    $this->components->twoColumnDetail('Database', 'No changes required');

                    return;
                }

                if ($dryRun) {
                    $this->components->twoColumnDetail('Database', '<fg=yellow>Would update: '.implode(', ', array_keys($changes)).'</>');

                    return;
                }

                DB::transaction(function () use ($project, $changes): void {
                    DB::table($project->getTable())
                        ->where($project->getKeyName(), $project->getKey())
                        ->update([...$changes, 'updated_at' => now()]);
                });

                $this->components->twoColumnDetail('Database', '<fg=green>Updated: '.implode(', ', array_keys($changes)).'</>');
            });

        $this->newLine();
        $this->components->info($dryRun
            ? 'Dry run complete. No database records or files were changed.'
            : 'Repair complete. Re-run with --dry-run to verify idempotence.');

        return self::SUCCESS;
    }

    /**
     * @param  array<string, mixed>  $inspection
     * @return array<int, string>
     */
    private function translationIssues(array $inspection): array
    {
        $issues = [];

        foreach ([
            'missing_locales' => 'missing',
            'empty_locales' => 'empty',
            'duplicate_locales' => 'duplicates',
            'conflicting_duplicates' => 'conflicts',
            'exact_duplicate_locales' => 'exact double-paste',
        ] as $key => $label) {
            if ($inspection[$key] !== []) {
                $issues[] = $label.':'.implode(',', $inspection[$key]);
            }
        }

        if ($inspection['malformed_json']) {
            $issues[] = 'malformed JSON';
        }

        if ($inspection['unexpected_nested_values']) {
            $issues[] = 'unexpected nested data';
        }

        return $issues;
    }

    /**
     * @param  array<string, mixed>  $changes
     * @param  array<int, array<int, string>>  $rows
     */
    private function inspectCategory(Project $project, array &$changes, array &$rows): void
    {
        $raw = $project->getRawOriginal('category');
        $canonical = Project::canonicalCategory($raw);
        $action = 'none';
        $audit = 'healthy';

        if (! in_array((string) $raw, Project::CATEGORIES, true)) {
            if ($canonical !== null) {
                $changes['category'] = $canonical;
                $action = 'normalize';
                $audit = 'legacy value';
            } else {
                $action = 'report only';
                $audit = 'unknown; frontend fallback=web_platform';
            }
        }

        $rows[] = ['category', (string) ($raw ?: 'empty'), $audit, $action];
    }

    /**
     * @param  array<string, mixed>  $changes
     * @param  array<int, array<int, string>>  $rows
     */
    private function inspectTech(Project $project, array &$changes, array &$rows): void
    {
        $raw = $project->getRawOriginal('tech');
        $format = 'array';
        $normalized = [];

        if (is_string($raw)) {
            try {
                $decoded = json_decode($raw, true, flags: JSON_THROW_ON_ERROR);
                $normalized = is_array($decoded) ? $decoded : [(string) $decoded];
                $format = 'json';
            } catch (\JsonException) {
                $normalized = array_map('trim', explode(',', $raw));
                $format = 'comma-separated';
            }
        } elseif (is_array($raw)) {
            $normalized = $raw;
        }

        $normalized = array_values(array_filter(
            $normalized,
            fn (mixed $item): bool => is_scalar($item) && trim((string) $item) !== '',
        ));

        if ($this->jsonChanged($raw, $normalized)) {
            $changes['tech'] = $this->encode($normalized);
        }

        $rows[] = ['tech', $format, $normalized === [] ? 'empty' : count($normalized).' entries', array_key_exists('tech', $changes) ? 'normalize' : 'none'];
    }

    /**
     * @param  array<string, mixed>  $changes
     * @param  array<int, array<int, string>>  $rows
     */
    private function inspectThumbnail(
        Project $project,
        array &$changes,
        array &$rows,
        ProjectImagePath $images,
        bool $dryRun,
        bool $copyPrivateFiles,
    ): void {
        $raw = $project->getRawOriginal('thumbnail');
        $normalized = $images->normalizeForStorage(is_string($raw) ? $raw : null);
        $existsPublic = $images->existsOnPublicDisk($normalized);
        $existsPrivate = $images->existsInPrivateDisk($normalized);
        $action = 'none';

        if ($normalized !== $raw && $normalized !== null) {
            $changes['thumbnail'] = $normalized;
            $action = 'normalize path';
        }

        if (! $existsPublic && $existsPrivate && $copyPrivateFiles) {
            $copied = $this->copyPrivateFile($normalized, $dryRun);
            $existsPublic = $existsPublic || ($copied && ! $dryRun);
            $copyAction = $dryRun ? 'would copy private' : ($copied ? 'copied private' : 'private copy failed');
            $action .= ($action === 'none' ? '' : ' + ').$copyAction;
        }

        $audit = $normalized === null
            ? 'empty'
            : ($existsPublic ? 'public exists' : ($existsPrivate ? 'private exists' : 'file not found'));

        $rows[] = ['thumbnail', $images->format(is_string($raw) ? $raw : null), $audit, $action];
    }

    /**
     * @param  array<string, mixed>  $changes
     * @param  array<int, array<int, string>>  $rows
     */
    private function inspectGallery(
        Project $project,
        array &$changes,
        array &$rows,
        ProjectImagePath $images,
        bool $dryRun,
        bool $copyPrivateFiles,
    ): void {
        $raw = $project->getRawOriginal('images');
        $gallery = $this->decodeImageArray($raw);
        $normalized = [];
        $missing = 0;
        $private = 0;
        $copied = 0;
        $formats = [];

        foreach ($gallery as $path) {
            $formats[] = $images->format($path);
            $normalizedPath = $images->normalizeForStorage($path);

            if ($normalizedPath === null) {
                continue;
            }

            $normalized[] = $normalizedPath;

            if ($images->existsOnPublicDisk($normalizedPath)) {
                continue;
            }

            if ($images->existsInPrivateDisk($normalizedPath)) {
                $private++;
                if ($copyPrivateFiles && $this->copyPrivateFile($normalizedPath, $dryRun)) {
                    $copied++;
                }
            } elseif (! filter_var($normalizedPath, FILTER_VALIDATE_URL)) {
                $missing++;
            }
        }

        if ($this->jsonChanged($raw, $normalized)) {
            $changes['images'] = $this->encode($normalized);
        }

        $audit = count($normalized).' entries; '.$missing.' missing; '.$private.' private';
        $action = array_key_exists('images', $changes) ? 'normalize paths' : 'none';

        if ($copied > 0) {
            $action .= ($action === 'none' ? '' : ' + ').($dryRun ? "would copy {$copied}" : "copied {$copied}");
        }

        $rows[] = ['images', implode(',', array_unique($formats)) ?: 'empty', $audit, $action];
    }

    private function copyPrivateFile(?string $path, bool $dryRun): bool
    {
        if ($path === null || filter_var($path, FILTER_VALIDATE_URL)) {
            return false;
        }

        if ($dryRun) {
            return true;
        }

        try {
            $contents = Storage::disk('local')->get($path);
            Storage::disk('public')->put($path, $contents);

            return Storage::disk('public')->exists($path)
                && Storage::disk('public')->size($path) === Storage::disk('local')->size($path);
        } catch (\Throwable) {
            return false;
        }
    }

    /**
     * @return array<int, string>
     */
    private function decodeImageArray(mixed $raw): array
    {
        if (is_string($raw)) {
            try {
                $raw = json_decode($raw, true, flags: JSON_THROW_ON_ERROR);
            } catch (\JsonException) {
                $raw = [$raw];
            }
        }

        return array_values(array_filter(
            is_array($raw) ? $raw : [],
            fn (mixed $path): bool => is_string($path) && trim($path) !== '',
        ));
    }

    private function jsonChanged(mixed $raw, array $normalized): bool
    {
        if (is_string($raw)) {
            try {
                $decoded = json_decode($raw, true, flags: JSON_THROW_ON_ERROR);
            } catch (\JsonException) {
                return true;
            }
        } else {
            $decoded = $raw;
        }

        return $decoded !== $normalized;
    }

    private function encode(array $value): string
    {
        return json_encode($value, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_THROW_ON_ERROR);
    }
}
