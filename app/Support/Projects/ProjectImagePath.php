<?php

namespace App\Support\Projects;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

final class ProjectImagePath
{
    public function normalizeForStorage(?string $value): ?string
    {
        if ($value === null || trim($value) === '') {
            return null;
        }

        $value = trim(str_replace('\\', '/', $value));

        if ($this->isExternalUrl($value)) {
            return $value;
        }

        if ($this->isAbsoluteUrl($value)) {
            $parts = parse_url($value);
            $appHost = parse_url((string) config('app.url'), PHP_URL_HOST);

            if (($parts['host'] ?? null) !== $appHost) {
                return $value;
            }

            $value = (string) ($parts['path'] ?? '');
        }

        $value = preg_replace('#^/?storage/#', '', $value) ?? $value;
        $value = preg_replace('#^/?public/storage/#', '', $value) ?? $value;

        return ltrim($value, '/');
    }

    public function publicUrl(?string $value): ?string
    {
        $normalized = $this->normalizeForStorage($value);

        if ($normalized === null) {
            return null;
        }

        if ($this->isAbsoluteUrl($normalized)) {
            return $normalized;
        }

        if ($this->isStaticPublicPath($normalized)) {
            return asset($normalized);
        }

        return Storage::disk('public')->url($normalized);
    }

    public function optimizerPath(?string $value): ?string
    {
        $normalized = $this->normalizeForStorage($value);

        if ($normalized === null || $this->isAbsoluteUrl($normalized) || $this->containsTraversal($normalized)) {
            return null;
        }

        if ($this->isStaticPublicPath($normalized) || Storage::disk('public')->exists($normalized)) {
            return $normalized;
        }

        return null;
    }

    public function existsOnPublicDisk(?string $value): bool
    {
        $normalized = $this->normalizeForStorage($value);

        return $normalized !== null
            && ! $this->isAbsoluteUrl($normalized)
            && ! $this->isStaticPublicPath($normalized)
            && ! $this->containsTraversal($normalized)
            && Storage::disk('public')->exists($normalized);
    }

    public function existsInPrivateDisk(?string $value): bool
    {
        $normalized = $this->normalizeForStorage($value);

        return $normalized !== null
            && ! $this->isAbsoluteUrl($normalized)
            && ! $this->containsTraversal($normalized)
            && Storage::disk('local')->exists($normalized);
    }

    public function format(?string $value): string
    {
        if ($value === null || trim($value) === '') {
            return 'empty';
        }

        $value = trim($value);

        if ($this->isExternalUrl($value)) {
            return 'external_url';
        }

        if ($this->isAbsoluteUrl($value)) {
            return 'same_domain_url';
        }

        if (Str::startsWith($value, ['/storage/', 'storage/', '/public/storage/', 'public/storage/'])) {
            return 'legacy_storage_url';
        }

        if ($this->isStaticPublicPath(ltrim($value, '/'))) {
            return 'public_asset';
        }

        return 'public_disk_relative';
    }

    public function containsTraversal(string $value): bool
    {
        return str_contains($value, '..') || str_contains($value, "\0");
    }

    private function isStaticPublicPath(string $value): bool
    {
        return Str::startsWith(ltrim($value, '/'), ['img/', 'images/', 'build/']);
    }

    private function isAbsoluteUrl(string $value): bool
    {
        return filter_var($value, FILTER_VALIDATE_URL) !== false;
    }

    private function isExternalUrl(string $value): bool
    {
        if (! $this->isAbsoluteUrl($value)) {
            return false;
        }

        $host = parse_url($value, PHP_URL_HOST);
        $appHost = parse_url((string) config('app.url'), PHP_URL_HOST);

        return $host !== null && $host !== $appHost;
    }
}
