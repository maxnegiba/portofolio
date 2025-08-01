<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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
        'tech' => 'array',
    ];

    /**
     * Get the title in the current app locale.
     */
    public function getTitleAttribute($value)
    {
        // If it's already an array, return the appropriate locale
        if (is_array($value)) {
            $locale = app()->getLocale();
            return $value[$locale] ?? $value[config('app.fallback_locale', 'en')] ?? '';
        }
        
        // If it's a string, try to decode it as JSON
        if (is_string($value)) {
            $decoded = json_decode($value, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                $locale = app()->getLocale();
                return $decoded[$locale] ?? $decoded[config('app.fallback_locale', 'en')] ?? '';
            }
        }
        
        // Default to empty string
        return $value ?? '';
    }

    /**
     * Get the description in the current app locale.
     */
    public function getDescriptionAttribute($value)
    {
        // If it's already an array, return the appropriate locale
        if (is_array($value)) {
            $locale = app()->getLocale();
            return $value[$locale] ?? $value[config('app.fallback_locale', 'en')] ?? '';
        }
        
        // If it's a string, try to decode it as JSON
        if (is_string($value)) {
            $decoded = json_decode($value, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                $locale = app()->getLocale();
                return $decoded[$locale] ?? $decoded[config('app.fallback_locale', 'en')] ?? '';
            }
        }
        
        // Default to empty string
        return $value ?? '';
    }

    /**
     * Get the raw title array.
     */
    public function getRawTitleAttribute()
    {
        $value = $this->getRawOriginal('title');
        
        if (is_string($value)) {
            $decoded = json_decode($value, true);
            if (json_last_error() === JSON_ERROR_NONE) {
                return $decoded;
            }
        }
        
        return is_array($value) ? $value : [];
    }

    /**
     * Get the raw description array.
     */
    public function getRawDescriptionAttribute()
    {
        $value = $this->getRawOriginal('description');
        
        if (is_string($value)) {
            $decoded = json_decode($value, true);
            if (json_last_error() === JSON_ERROR_NONE) {
                return $decoded;
            }
        }
        
        return is_array($value) ? $value : [];
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
        // If it's an array, encode it to JSON
        if (is_array($value)) {
            $this->attributes['tech'] = json_encode($value);
        } 
        // If it's a string, try to decode it first to see if it's JSON
        elseif (is_string($value)) {
            $decoded = json_decode($value, true);
            if (json_last_error() === JSON_ERROR_NONE) {
                $this->attributes['tech'] = $value; // It's already a JSON string
            } else {
                // If it's a comma-separated string, convert to array and then encode
                $array = array_map('trim', explode(',', $value));
                $this->attributes['tech'] = json_encode($array);
            }
        }
        // Otherwise, set to empty array
        else {
            $this->attributes['tech'] = json_encode([]);
        }
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
    
    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();
        
        // Ensure tech is always an array when saving
        static::saving(function ($project) {
            if (!is_array($project->tech)) {
                $project->tech = [];
            }
        });
    }
}