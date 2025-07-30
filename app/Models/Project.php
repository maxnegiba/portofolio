<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'title',
        'description',
        'tech',
        'live_url',
        'github_url',
        'thumbnail',
    ];

    protected $casts = [
        'title'       => 'array', // Cast la array pentru manipulare
        'description' => 'array',
        'tech'        => 'array',
    ];

    /**
     * Get the title in the current app locale.
     * Usage: $project->title // Returns title in app()->getLocale()
     *
     * @param  array|null  $value // Valoarea cast-uita ca array
     * @return string|null
     */
    public function getTitleAttribute($value)
    {
        // $value este array-ul JSON decodat din cauza cast-ului 'array'
        if (is_array($value)) {
            $locale = app()->getLocale();
            return $value[$locale] ?? $value[config('app.fallback_locale', 'en')] ?? null;
        }
        return $value; // Fallback dacă nu e array
    }

    /**
     * Get the description in the current app locale.
     * Usage: $project->description
     *
     * @param  array|null  $value // Valoarea cast-uita ca array
     * @return string|null
     */
    public function getDescriptionAttribute($value)
    {
        // $value este array-ul JSON decodat
        if (is_array($value)) {
            $locale = app()->getLocale();
            return $value[$locale] ?? $value[config('app.fallback_locale', 'en')] ?? null;
        }
        return $value; // Fallback dacă nu e array
    }

     /**
     * Get the URL of the thumbnail image.
     *
     * @return string|null
     */
    public function getThumbnailUrlAttribute(): ?string
    {
        return $this->thumbnail ? Storage::url($this->thumbnail) : null;
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}