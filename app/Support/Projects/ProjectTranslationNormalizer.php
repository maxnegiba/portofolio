<?php

namespace App\Support\Projects;

use Illuminate\Support\Arr;

final class ProjectTranslationNormalizer
{
    /**
     * Convert every supported legacy representation to an associative locale map.
     *
     * Unknown locale keys are preserved. A plain string is assigned only to the
     * configured fallback locale; it is never copied into other languages.
     *
     * @return array<string, string>
     */
    public function normalize(mixed $value): array
    {
        $decoded = $this->decode($value)['value'];

        if ($decoded === null || $decoded === '') {
            return [];
        }

        if (is_scalar($decoded)) {
            return [$this->fallbackLocale() => $this->removeExactDuplicate((string) $decoded)];
        }

        if (! is_array($decoded)) {
            return [];
        }

        if ($this->isRepeater($decoded)) {
            return $this->normalizeRepeater($decoded);
        }

        if (isset($decoded['locale'], $decoded['value'])) {
            return $this->normalizeRepeater([$decoded]);
        }

        $translations = [];

        foreach ($decoded as $locale => $translation) {
            if (! is_string($locale) || (! is_scalar($translation) && $translation !== null)) {
                continue;
            }

            $normalizedLocale = $this->normalizeLocale($locale);
            if ($normalizedLocale === '') {
                continue;
            }

            $translations[$normalizedLocale] = $this->removeExactDuplicate((string) ($translation ?? ''));
        }

        if ($translations === [] && Arr::isList($decoded)) {
            $firstScalar = collect($decoded)->first(fn (mixed $item): bool => is_scalar($item));

            if ($firstScalar !== null) {
                $translations[$this->fallbackLocale()] = $this->removeExactDuplicate((string) $firstScalar);
            }
        }

        return $translations;
    }

    /**
     * @return array{
     *     format:string,
     *     decode_layers:int,
     *     malformed_json:bool,
     *     duplicate_locales:array<int, string>,
     *     conflicting_duplicates:array<int, string>,
     *     missing_locales:array<int, string>,
     *     empty_locales:array<int, string>,
     *     exact_duplicate_locales:array<int, string>,
     *     unexpected_nested_values:bool
     * }
     */
    public function inspect(mixed $value): array
    {
        $decoded = $this->decode($value);
        $data = $decoded['value'];
        $format = $this->formatOf($value, $data, $decoded['layers']);
        $duplicateLocales = [];
        $conflictingDuplicates = [];
        $exactDuplicateLocales = [];
        $seen = [];
        $unexpectedNestedValues = false;

        if (is_array($data) && $this->isRepeater($data)) {
            foreach ($data as $item) {
                if (! is_array($item)) {
                    $unexpectedNestedValues = true;
                    continue;
                }

                $locale = $this->normalizeLocale((string) ($item['locale'] ?? ''));
                $translation = $item['value'] ?? null;
                if ($locale === '') {
                    continue;
                }

                if (is_scalar($translation) && $this->isExactDuplicate((string) $translation)) {
                    $exactDuplicateLocales[] = $locale;
                }

                if (array_key_exists($locale, $seen)) {
                    $duplicateLocales[] = $locale;
                    if ($this->hasContent($seen[$locale]) && $this->hasContent($translation) && $seen[$locale] !== $translation) {
                        $conflictingDuplicates[] = $locale;
                    }
                } else {
                    $seen[$locale] = $translation;
                }
            }
        } elseif (is_array($data)) {
            foreach ($data as $locale => $translation) {
                if (! is_scalar($translation) && $translation !== null) {
                    $unexpectedNestedValues = true;
                }

                if (is_string($locale) && is_scalar($translation) && $this->isExactDuplicate((string) $translation)) {
                    $exactDuplicateLocales[] = $this->normalizeLocale($locale);
                }
            }
        } elseif (is_scalar($data) && $this->isExactDuplicate((string) $data)) {
            $exactDuplicateLocales[] = $this->fallbackLocale();
        }

        $normalized = $this->normalize($value);
        $supported = $this->supportedLocales();

        return [
            'format' => $format,
            'decode_layers' => $decoded['layers'],
            'malformed_json' => $decoded['malformed'],
            'duplicate_locales' => array_values(array_unique($duplicateLocales)),
            'conflicting_duplicates' => array_values(array_unique($conflictingDuplicates)),
            'missing_locales' => array_values(array_diff($supported, array_keys($normalized))),
            'empty_locales' => array_values(array_keys(array_filter(
                $normalized,
                fn (string $translation): bool => trim(strip_tags($translation)) === '',
            ))),
            'exact_duplicate_locales' => array_values(array_unique($exactDuplicateLocales)),
            'unexpected_nested_values' => $unexpectedNestedValues,
        ];
    }

    /**
     * @param  array<int, mixed>  $items
     * @return array<string, string>
     */
    public function normalizeRepeater(array $items): array
    {
        $translations = [];

        foreach ($items as $item) {
            if (! is_array($item)) {
                continue;
            }

            $locale = $this->normalizeLocale((string) ($item['locale'] ?? ''));
            $value = $item['value'] ?? '';

            if ($locale === '' || (! is_scalar($value) && $value !== null)) {
                continue;
            }

            $translation = $this->removeExactDuplicate((string) ($value ?? ''));

            // First non-empty value wins. An empty duplicate can never erase data.
            if (! array_key_exists($locale, $translations) || ! $this->hasContent($translations[$locale])) {
                $translations[$locale] = $translation;
            }
        }

        return $translations;
    }

    public function removeExactDuplicate(string $value): string
    {
        $value = trim($value);

        if (! $this->isExactDuplicate($value)) {
            return $value;
        }

        return rtrim(substr($value, 0, intdiv(strlen($value), 2)));
    }

    public function isExactDuplicate(string $value): bool
    {
        $value = trim($value);
        $length = strlen($value);

        if ($length === 0 || $length % 2 !== 0) {
            return false;
        }

        $half = intdiv($length, 2);

        return substr($value, 0, $half) === substr($value, $half);
    }

    /**
     * @return array{value:mixed,layers:int,malformed:bool}
     */
    private function decode(mixed $value): array
    {
        $layers = 0;
        $malformed = false;
        $decoded = $value;

        while (is_string($decoded) && $layers < 3) {
            $trimmed = trim($decoded);
            if ($trimmed === '') {
                break;
            }

            try {
                $candidate = json_decode($trimmed, true, flags: JSON_THROW_ON_ERROR);
            } catch (\JsonException) {
                $malformed = $this->looksLikeJson($trimmed);
                break;
            }

            $decoded = $candidate;
            $layers++;

            if (! is_string($decoded)) {
                break;
            }
        }

        return ['value' => $decoded, 'layers' => $layers, 'malformed' => $malformed];
    }

    private function formatOf(mixed $raw, mixed $decoded, int $layers): string
    {
        if ($raw === null || $raw === '') {
            return 'empty';
        }

        if ($layers > 1) {
            return 'double_encoded_json';
        }

        if (is_array($decoded) && $this->isRepeater($decoded)) {
            return 'filament_repeater';
        }

        if (is_array($decoded) && ! Arr::isList($decoded)) {
            return 'associative_map';
        }

        if (is_array($decoded)) {
            return 'numeric_array';
        }

        return $layers === 1 ? 'json_scalar' : 'plain_string';
    }

    private function isRepeater(array $value): bool
    {
        if (! Arr::isList($value) || $value === []) {
            return false;
        }

        return collect($value)->contains(
            fn (mixed $item): bool => is_array($item) && (array_key_exists('locale', $item) || array_key_exists('value', $item)),
        );
    }

    private function normalizeLocale(string $locale): string
    {
        return strtolower(trim(str_replace('_', '-', $locale)));
    }

    private function hasContent(mixed $value): bool
    {
        return is_scalar($value) && trim((string) $value) !== '';
    }

    private function looksLikeJson(string $value): bool
    {
        return str_starts_with($value, '{')
            || str_starts_with($value, '[')
            || str_starts_with($value, '"');
    }

    /**
     * @return array<int, string>
     */
    private function supportedLocales(): array
    {
        return array_values(array_map(
            fn (mixed $locale): string => $this->normalizeLocale((string) $locale),
            config('app.available_locales', ['en', 'ro']),
        ));
    }

    private function fallbackLocale(): string
    {
        return $this->normalizeLocale((string) config('app.fallback_locale', 'en')) ?: 'en';
    }
}
