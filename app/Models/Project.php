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
     * Get the title for Filament admin panel.
     */
    public function getFilamentTitleAttribute(): string
    {
        try {
            $rawValue = $this->getRawOriginal('title');
            
            // Handle array directly from DB
            if (is_array($rawValue)) {
                $firstValue = reset($rawValue);
                return is_scalar($firstValue) ? (string) $firstValue : 'No Title (Array)';
            }
            
            // Handle JSON string from DB
            if (is_string($rawValue)) {
                $decoded = json_decode($rawValue, true);
                if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                    // Check if it's the array of objects format
                    if (isset($decoded[0]) && is_array($decoded[0]) && isset($decoded[0]['value'])) {
                         // Return the first 'value'
                         return $decoded[0]['value'];
                    }
                    $firstValue = reset($decoded);
                    return is_scalar($firstValue) ? (string) $firstValue : 'No Title (JSON Array)';
                }
                // If it's a string but not valid JSON, return it
                return $rawValue;
            }
            
            // Handle any other type (null, etc.)
            if (is_scalar($rawValue)) {
                return (string) $rawValue;
            }
        } catch (\Exception $e) {
            \Log::warning("Error in getFilamentTitleAttribute for project ID {$this->id}: " . $e->getMessage());
        }
        
        // Ultimate fallback
        return 'Title Error';
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
        
        // Asigură-te că tech este întotdeauna un array înainte de salvare
        static::saving(function ($project) {
            if (!is_array($project->tech)) {
                $project->tech = [];
            }
        });
    }
    
    /**
     * Get the localized title with fallback
     */
    public function getLocalizedTitle()
    {
        $rawTitle = $this->getRawOriginal('title'); // Obține valoarea brută din DB (un string JSON)
        $locale = app()->getLocale();
        $fallbackLocale = config('app.fallback_locale', 'en');

        // Pasul 1: Decodează stringul JSON într-un array PHP
        $dataArray = null;
        if (is_string($rawTitle)) {
            $dataArray = json_decode($rawTitle, true);
        } elseif (is_array($rawTitle)) {
            // Poate fi deja un array dacă Laravel face casting
            $dataArray = $rawTitle;
        }

        // Pasul 2: Verifică dacă este un array și are structura așteptată (array de obiecte)
        if (is_array($dataArray)) {
            // Verificăm dacă este un array de obiecte (formatul tău actual)
            // Ex: [ ['locale' => 'en', 'value' => '...'], ['locale' => 'ro', 'value' => '...'] ]
            if (isset($dataArray[0]) && is_array($dataArray[0]) && isset($dataArray[0]['locale'])) {
                // Caută valoarea pentru locale-ul curent
                foreach ($dataArray as $item) {
                    if (isset($item['locale']) && $item['locale'] === $locale && isset($item['value'])) {
                        return $item['value'];
                    }
                }
                // Caută valoarea pentru locale-ul de rezervă
                foreach ($dataArray as $item) {
                    if (isset($item['locale']) && $item['locale'] === $fallbackLocale && isset($item['value'])) {
                        return $item['value'];
                    }
                }
                // Dacă nici locale-ul curent, nici cel de rezervă nu sunt găsite, returnează prima valoare disponibilă
                if (isset($dataArray[0]['value'])) {
                    return $dataArray[0]['value'];
                }
            } else {
                // Dacă este un obiect JSON standard { "en": "...", "ro": "..." }
                return $dataArray[$locale] ?? $dataArray[$fallbackLocale] ?? '';
            }
        }

        // Fallback final
        return '';
    }
    
    /**
     * Get the localized description with fallback
     */
    public function getLocalizedDescription()
    {
        $rawDesc = $this->getRawOriginal('description');
        $locale = app()->getLocale();
        $fallbackLocale = config('app.fallback_locale', 'en');

        // Pasul 1: Decodează stringul JSON într-un array PHP
        $dataArray = null;
        if (is_string($rawDesc)) {
            $dataArray = json_decode($rawDesc, true);
        } elseif (is_array($rawDesc)) {
            // Poate fi deja un array dacă Laravel face casting
            $dataArray = $rawDesc;
        }

        // Pasul 2: Verifică dacă este un array și are structura așteptată (array de obiecte)
        if (is_array($dataArray)) {
            // Verificăm dacă este un array de obiecte (formatul tău actual)
            if (isset($dataArray[0]) && is_array($dataArray[0]) && isset($dataArray[0]['locale'])) {
                // Caută valoarea pentru locale-ul curent
                foreach ($dataArray as $item) {
                    if (isset($item['locale']) && $item['locale'] === $locale && isset($item['value'])) {
                        return $item['value'];
                    }
                }
                // Caută valoarea pentru locale-ul de rezervă
                foreach ($dataArray as $item) {
                    if (isset($item['locale']) && $item['locale'] === $fallbackLocale && isset($item['value'])) {
                        return $item['value'];
                    }
                }
                // Dacă nici locale-ul curent, nici cel de rezervă nu sunt găsite, returnează prima valoare disponibilă
                if (isset($dataArray[0]['value'])) {
                    return $dataArray[0]['value'];
                }
            } else {
                // Dacă este un obiect JSON standard { "en": "...", "ro": "..." }
                return $dataArray[$locale] ?? $dataArray[$fallbackLocale] ?? '';
            }
        }

        // Fallback final
        return '';
    }
}