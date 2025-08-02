<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Support\Facades\Storage; // Asigură-te că acesta este importat


class BlogPost extends Model
{
    use HasFactory, HasTranslations;

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'featured_image',
        'is_published',
        'published_at',
        'meta_keywords',
        'meta_description',
        'user_id',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'published_at' => 'datetime',
        'meta_keywords' => 'array',
        'title' => 'array',
        'slug' => 'array',
        'excerpt' => 'array',
        'content' => 'array',
        'meta_description' => 'array',
    ];

    public $translatable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'meta_description',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true)
                    ->where('published_at', '<=', now());
    }

    public function getLocalizedTitle()
    {
        return $this->getTranslation('title', app()->getLocale());
    }

    public function getLocalizedSlug()
    {
        return $this->getTranslation('slug', app()->getLocale());
    }
    // Adaugă această metodă:
     public function getImageUrlAttribute()
    {
        if ($this->featured_image) {
            // Construiește URL-ul corect către fișierul din storage/app/public/blog/featured/
            // Presupunând că $this->featured_image conține numele fișierului (e.g., 01K1JJGPWHGHC7HPAR92DVM5PB.jpg)
            return Storage::url('blog/featured/' . $this->featured_image);
        }

        // Opțional: Returnează un placeholder dacă nu există imagine
        // return asset('images/default-post-image.jpg');

        return null; // Sau '' dacă preferi un string gol
    }
}