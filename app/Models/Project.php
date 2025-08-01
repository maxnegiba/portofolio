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
        'images', // Add the new 'images' column to fillable
    ];

    protected $casts = [
        'title'       => 'array', // Cast la array pentru manipulare
        'description' => 'array',
        'tech'        => 'array',
        'images'      => 'array', // Cast 'images' to array
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

    /**
     * Get the URLs of the additional images.
     * Ensures each path is converted to a full URL.
     * Usage: $project->image_urls // Returns array of full URLs
     *
     * @return array
     */
    public function getImageUrlsAttribute(): array
    {
        $urls = [];
        if (is_array($this->images)) {
            foreach ($this->images as $imagePath) {
                // Assuming images are stored using the same disk as thumbnail
                if ($imagePath) { // Check if path is not empty
                     $urls[] = Storage::url($imagePath);
                }
            }
        }
        return $urls;
    }


    public function getRouteKeyName()
    {
        return 'slug';
    }
}