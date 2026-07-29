<?php

namespace App\Casts;

use App\Support\Projects\ProjectTranslationNormalizer;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class ProjectTranslationCast implements CastsAttributes
{
    public function get(Model $model, string $key, mixed $value, array $attributes): array
    {
        return app(ProjectTranslationNormalizer::class)->normalize($value);
    }

    public function set(Model $model, string $key, mixed $value, array $attributes): string
    {
        return json_encode(
            app(ProjectTranslationNormalizer::class)->normalize($value),
            JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_THROW_ON_ERROR,
        );
    }
}
