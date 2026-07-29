<?php

namespace App\Support\Projects;

use App\Models\Project;

final class ProjectFormData
{
    public function __construct(
        private readonly ProjectTranslationNormalizer $translations,
        private readonly ProjectImagePath $images,
    ) {}

    /**
     * Hydrate locale-specific tabs from raw database values.
     *
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    public function hydrate(Project $project, array $data): array
    {
        $data['translations'] = [];

        foreach ($this->supportedLocales() as $locale) {
            foreach (Project::TRANSLATABLE_FIELDS as $field) {
                $data['translations'][$locale][$field] = $project->getTranslationMap($field)[$locale] ?? '';
            }
        }

        foreach (Project::TRANSLATABLE_FIELDS as $field) {
            unset($data[$field]);
        }

        $thumbnail = $this->images->normalizeForStorage($project->getRawOriginal('thumbnail'));
        $data['thumbnail'] = $this->images->existsOnPublicDisk($thumbnail) ? $thumbnail : null;

        $rawImages = $this->rawImageArray($project);
        $data['images'] = array_values(array_filter(
            array_map(fn (string $path): ?string => $this->images->existsOnPublicDisk($path)
                ? $this->images->normalizeForStorage($path)
                : null, $rawImages),
        ));

        $data['remove_existing_thumbnail'] = false;
        $data['apply_gallery_changes'] = false;
        $data['remove_all_images'] = false;
        $data['category'] = $project->normalized_category;

        return $data;
    }

    /**
     * Merge submitted locale tabs with untouched legacy locales and protect
     * image paths which FileUpload could not hydrate.
     *
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    public function dehydrate(array $data, ?Project $project = null): array
    {
        $submittedTranslations = is_array($data['translations'] ?? null) ? $data['translations'] : [];

        foreach (Project::TRANSLATABLE_FIELDS as $field) {
            $map = $project?->getTranslationMap($field) ?? [];

            foreach ($this->supportedLocales() as $locale) {
                if (array_key_exists($field, $submittedTranslations[$locale] ?? [])) {
                    $map[$locale] = (string) ($submittedTranslations[$locale][$field] ?? '');
                }
            }

            $data[$field] = $this->translations->normalize($map);
        }

        unset($data['translations']);

        $removeExistingThumbnail = (bool) ($data['remove_existing_thumbnail'] ?? false);
        $applyGalleryChanges = (bool) ($data['apply_gallery_changes'] ?? false);
        $removeAllImages = (bool) ($data['remove_all_images'] ?? false);
        unset($data['remove_existing_thumbnail'], $data['apply_gallery_changes'], $data['remove_all_images']);

        $data['category'] = Project::normalizeCategory($data['category'] ?? null);
        $data['tech'] = array_values(array_filter(
            is_array($data['tech'] ?? null) ? $data['tech'] : [],
            fn (mixed $technology): bool => is_string($technology) && trim($technology) !== '',
        ));

        $submittedThumbnail = is_string($data['thumbnail'] ?? null)
            ? $this->images->normalizeForStorage($data['thumbnail'])
            : null;
        $originalThumbnail = $project
            ? $this->images->normalizeForStorage($project->getRawOriginal('thumbnail'))
            : null;

        if ($removeExistingThumbnail) {
            $data['thumbnail'] = null;
        } elseif ($submittedThumbnail !== null) {
            $data['thumbnail'] = $submittedThumbnail;
        } elseif ($project) {
            $data['thumbnail'] = $originalThumbnail;
        } else {
            $data['thumbnail'] = null;
        }

        $submittedImages = array_values(array_filter(array_map(
            fn (mixed $path): ?string => is_string($path) ? $this->images->normalizeForStorage($path) : null,
            is_array($data['images'] ?? null) ? $data['images'] : [],
        )));

        if ($project && ! $removeAllImages) {
            $originalImages = array_values(array_filter(array_map(
                fn (string $path): ?string => $this->images->normalizeForStorage($path),
                $this->rawImageArray($project),
            )));

            if ($applyGalleryChanges) {
                $unhydratedLegacyImages = array_values(array_filter(
                    $originalImages,
                    fn (string $path): bool => ! $this->images->existsOnPublicDisk($path),
                ));

                $submittedImages = array_values(array_unique([
                    ...$unhydratedLegacyImages,
                    ...$submittedImages,
                ]));
            } else {
                $submittedImages = array_values(array_unique([
                    ...$originalImages,
                    ...$submittedImages,
                ]));
            }
        }

        $data['images'] = $removeAllImages ? [] : $submittedImages;

        return $data;
    }

    /**
     * @return array<int, string>
     */
    private function rawImageArray(Project $project): array
    {
        $raw = $project->getRawOriginal('images');

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

    /**
     * @return array<int, string>
     */
    private function supportedLocales(): array
    {
        return array_values(array_map(
            fn (mixed $locale): string => strtolower(trim((string) $locale)),
            config('app.available_locales', ['en', 'ro']),
        ));
    }
}
