<?php

namespace App\Models;

use App\Casts\ProjectTranslationCast;
use App\Support\Projects\ProjectImagePath;
use App\Support\Projects\ProjectTranslationNormalizer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use RalphJSmit\Laravel\SEO\Support\HasSEO;

class Project extends Model
{
    use HasFactory, HasSEO;

    public const TRANSLATABLE_FIELDS = [
        'title',
        'description',
        'problem',
        'solution',
        'business_result',
    ];

    public const CATEGORIES = [
        'web_platform',
        'automation',
    ];

    protected $fillable = [
        'slug',
        'title',
        'description',
        'tech',
        'live_url',
        'github_url',
        'thumbnail',
        'images',
        'category',
        'problem',
        'solution',
        'business_result',
    ];

    protected function casts(): array
    {
        return [
            'title' => ProjectTranslationCast::class,
            'description' => ProjectTranslationCast::class,
            'problem' => ProjectTranslationCast::class,
            'solution' => ProjectTranslationCast::class,
            'business_result' => ProjectTranslationCast::class,
            'images' => 'array',
            'tech' => 'array',
        ];
    }

    /**
     * Return the complete normalized map without applying a display locale.
     *
     * @return array<string, string>
     */
    public function getTranslationMap(string $field): array
    {
        if (! in_array($field, self::TRANSLATABLE_FIELDS, true)) {
            throw new \InvalidArgumentException("{$field} is not a translatable Project field.");
        }

        return app(ProjectTranslationNormalizer::class)->normalize($this->getAttributes()[$field] ?? null);
    }

    public function getLocalizedProjectValue(string $field, ?string $locale = null): string
    {
        $translations = $this->getTranslationMap($field);
        $locale ??= app()->getLocale();
        $fallback = (string) config('app.fallback_locale', 'en');

        return (string) ($translations[$locale] ?? $translations[$fallback] ?? collect($translations)->first() ?? '');
    }

    public function getLocalizedTitle(): string
    {
        return $this->getLocalizedProjectValue('title');
    }

    public function getLocalizedDescription(): string
    {
        return $this->getLocalizedProjectValue('description');
    }

    public function getLocalizedProblem(): string
    {
        return $this->getLocalizedProjectValue('problem');
    }

    public function getLocalizedSolution(): string
    {
        return $this->getLocalizedProjectValue('solution');
    }

    public function getLocalizedBusinessResult(): string
    {
        return $this->getLocalizedProjectValue('business_result');
    }

    public function getFilamentTitleAttribute(): string
    {
        return $this->getLocalizedProjectValue('title', (string) config('app.fallback_locale', 'en'))
            ?: 'Untitled project';
    }

    public function getThumbnailUrlAttribute(): ?string
    {
        return app(ProjectImagePath::class)->publicUrl($this->getAttributes()['thumbnail'] ?? null);
    }

    /**
     * @return array<int, string>
     */
    public function getImageUrlsAttribute(): array
    {
        $images = $this->images;

        if (! is_array($images)) {
            return [];
        }

        return array_values(array_filter(array_map(
            fn (mixed $image): ?string => is_string($image)
                ? app(ProjectImagePath::class)->publicUrl($image)
                : null,
            $images,
        )));
    }

    public function getNormalizedCategoryAttribute(): string
    {
        return self::normalizeCategory($this->getAttributes()['category'] ?? null);
    }

    public static function normalizeCategory(mixed $category): string
    {
        return self::canonicalCategory($category) ?? 'web_platform';
    }

    public static function canonicalCategory(mixed $category): ?string
    {
        $value = strtolower(trim((string) $category));
        $value = str_replace(['-', ' '], '_', $value);

        return match ($value) {
            'automation', 'automations', 'workflow_automation', 'workflow_automations' => 'automation',
            'web_platform', 'web_app', 'web_application', 'webapp', 'website', '' => 'web_platform',
            default => null,
        };
    }

    public static function categoryNeedsNormalization(mixed $category): bool
    {
        return ! in_array((string) $category, self::CATEGORIES, true);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
