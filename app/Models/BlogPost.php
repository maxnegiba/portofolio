<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Spatie\Translatable\HasTranslations;

class BlogPost extends Model
{
    use HasFactory, HasTranslations; // Combinat într-o singură linie

    /**
     * The attributes that are translatable.
     *
     * @var array
     */
    public $translatable = [
        'title',
        // 'slug', // Dacă slug-ul este tradus, adaugă-l aici și schimbă tipul în migrare
        'excerpt',
        'content',
        'meta_description',
         'slug'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', // Va fi gestionat de HasTranslations
        'slug', // Va fi gestionat de HasTranslations dacă e în $translatable, altfel e string
        'excerpt', // Va fi gestionat de HasTranslations
        'content', // Va fi gestionat de HasTranslations
        'featured_image',
        'is_published',
        'published_at',
        'meta_keywords', // JSON
        'meta_description', // Va fi gestionat de HasTranslations
        'user_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        // 'title', 'slug', 'excerpt', 'content', 'meta_description' sunt gestionate automat de HasTranslations
        'meta_keywords' => 'array', // Poate fi diferit per limbă sau global
        'is_published' => 'boolean',
        'published_at' => 'datetime',
    ];

    /**
     * The "booted" method of the model.
     * Handle automatic slug generation and uniqueness.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($post) {
            // Verifică dacă slug-ul este translatable
            $isSlugTranslatable = in_array('slug', $post->getTranslatableAttributes());

            if ($isSlugTranslatable) {
                // Dacă slug este translatable, trebuie să-l generăm pentru fiecare limbă
                // Presupunem că title este translatable și conține date pentru toate localele configurate
                $locales = config('app.available_locales', [config('app.locale', 'en')]);
                $slugs = [];
                foreach ($locales as $locale) {
                    $titleInLocale = $post->getTranslation('title', $locale);
                    if ($titleInLocale) {
                         $baseSlug = Str::slug($titleInLocale);
                         $originalSlug = $baseSlug;
                         $count = 1;
                         // Verifică unicitatea pentru slug-ul în această limbă
                         // Această logică este simplificată; în practică, ar trebui să verifici slug-urile
                         // din toate limbile sau să ai o structură mai complexă.
                         // Pentru simplitate, vom genera slug-uri unice per limbă.
                         // O implementare mai robustă ar implica verificarea tuturor slug-urilor JSON din BD.
                         // Aici doar generăm slug-ul, presupunând că logica de unicitate este la nivel de aplicație.
                         $slugs[$locale] = $baseSlug;
                    }
                }
                $post->slug = $slugs; // Salvează array-ul de sluguri
            } else {
                 // Dacă slug nu este translatable (string), generează unul unic global
                 // Presupunem că luăm titlul în limba implicită pentru generarea slugului
                 $defaultLocale = config('app.locale', 'en');
                 $titleForSlug = $post->getTranslation('title', $defaultLocale, false) ?? $post->title; // Fallback

                 if (empty($post->slug) && $titleForSlug) {
                     $post->slug = Str::slug($titleForSlug);
                 } elseif (empty($post->slug)) {
                     $post->slug = Str::uuid(); // Fallback dacă nu avem titlu
                 }

                 // Ensure unique slug (pentru slug string)
                 $originalSlug = $post->slug;
                 $count = 1;
                 while (static::where('slug', $post->slug)->exists()) {
                     $post->slug = $originalSlug . '-' . $count;
                     $count++;
                 }
            }
        });

        static::updating(function ($post) {
             $isSlugTranslatable = in_array('slug', $post->getTranslatableAttributes());

             if (!$isSlugTranslatable && $post->isDirty('title') && (empty($post->slug) || $post->isDirty('slug'))) {
                 // Dacă slug nu e translatable și titlul s-a schimbat sau slug-ul e gol
                 $defaultLocale = config('app.locale', 'en');
                 $titleForSlug = $post->getTranslation('title', $defaultLocale, false) ?? $post->title;

                 if ($titleForSlug) {
                     $newSlug = Str::slug($titleForSlug);
                     // Verifică unicitate doar dacă slug-ul s-ar schimba
                     if ($newSlug !== $post->getOriginal('slug')) {
                         $originalSlug = $newSlug;
                         $count = 1;
                         while (static::where('slug', $newSlug)->where('id', '!=', $post->id)->exists()) {
                             $newSlug = $originalSlug . '-' . $count;
                             $count++;
                         }
                         $post->slug = $newSlug;
                     }
                 }
             }
             // Dacă slug este translatable, logica de actualizare ar trebui să fie în Filament/Form
             // sau să fie mai complexă aici.
        });
    }

    /**
     * Get the user that owns the blog post.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the URL of the featured image.
     */
    public function getImageUrlAttribute(): ?string
    {
        return $this->featured_image
            ? Storage::url($this->featured_image)
            : null;
    }

    /**
     * Get the estimated reading time in minutes.
     * Uses the content in the current app locale.
     */
    public function getReadingTimeAttribute(): int
    {
        // Obține conținutul în limba curentă setată de aplicație
        $contentInCurrentLocale = $this->getTranslation('content', app()->getLocale(), false);
        $words = str_word_count(strip_tags($contentInCurrentLocale ?? ''));
        return max(1, ceil($words / 200)); // Minimum 1 minute
    }

    /**
     * Scope a query to only include published posts.
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', true)
                    ->where('published_at', '<=', now());
    }

    /**
     * Scope a query to only include draft posts.
     */
    public function scopeDraft($query)
    {
        return $query->where('is_published', false);
    }

    /**
     * Scope a query to only include recent published posts.
     */
    public function scopeRecent($query)
    {
        return $query->published()->orderBy('published_at', 'desc');
    }
}