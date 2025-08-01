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
        'images',
    ];

    protected $casts = [
        'title' => 'array',
        'description' => 'array',
        'images' => 'array',
    ];

    /**
     * Get the title in the current app locale.
     */
    public function getTitleAttribute($value)
    {
        if (is_array($value)) {
            $locale = app()->getLocale();
            return $value[$locale] ?? $value[config('app.fallback_locale', 'en')] ?? null;
        }
        return $value;
    }

    /**
     * Get the description in the current app locale.
     */
    public function getDescriptionAttribute($value)
    {
        if (is_array($value)) {
            $locale = app()->getLocale();
            return $value[$locale] ?? $value[config('app.fallback_locale', 'en')] ?? null;
        }
        return $value;
    }

    /**
     * Get the tech attribute as an array.
     */
    public function getTechAttribute($value)
    {
        // If it's already an array, return it
        if (is_array($value)) {
            return $value;
        }
        
        // If it's a JSON string, decode it
        if (is_string($value) && !empty($value)) {
            $decoded = json_decode($value, true);
            if (json_last_error() === JSON_ERROR_NONE) {
                return $decoded;
            }
            
            // If it's a comma-separated string, split it
            return array_map('trim', explode(',', $value));
        }
        
        // Default to empty array
        return [];
    }

    /**
     * Set the tech attribute.
     */
    public function setTechAttribute($value)
    {
        $this->attributes['tech'] = is_array($value) ? json_encode($value) : $value;
    }

    /**
     * Get the URL of the thumbnail image.
     */
    public function getThumbnailUrlAttribute(): ?string
    {
        return $this->thumbnail ? Storage::url($this->thumbnail) : null;
    }

    /**
     * Get the URLs of the additional images.
     */
    public function getImageUrlsAttribute(): array
    {
        $urls = [];
        if (is_array($this->images)) {
            foreach ($this->images as $imagePath) {
                if ($imagePath) {
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