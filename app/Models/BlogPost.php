<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Support\Facades\Storage; // Asigură-te că acesta este importat
use RalphJSmit\Laravel\SEO\Support\HasSEO;

class BlogPost extends Model
{
    use HasFactory, HasTranslations, HasSEO;

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'featured_image',
        'is_published',
        'published_at',
        'user_id',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'published_at' => 'datetime',
        'title' => 'array',
        'slug' => 'array',
        'excerpt' => 'array',
        'content' => 'array',
    ];

    public $translatable = [
        'title',
        'slug',
        'excerpt',
        'content',
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
            // Deoarece $this->featured_image este deja 'blog/featured/filename.jpg',
            // trebuie doar să îl pasăm direct lui Storage::url().
            return Storage::url($this->featured_image);
        }

        // Opțional: Returnează un placeholder dacă nu există imagine
        // return asset('images/default-post-image.jpg');

        return null; // Sau '' dacă preferi un string gol
    }

    public function getReadingTimeAttribute(): int
    {
        $content = $this->getTranslation('content', app()->getLocale());
        $wordCount = str_word_count(strip_tags($content));
        $minutes = ceil($wordCount / 200);

        return max(1, $minutes);
    }

    public function getReadingTimeLabelAttribute(): string
    {
        return trans_choice(
            'pages.blog.minute_read',
            $this->reading_time,
            ['minutes' => $this->reading_time],
        );
    }
}
