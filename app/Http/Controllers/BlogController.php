<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    /**
     * Display a listing of the blog posts.
     *
     * @param string $locale The current locale.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
    public function index($locale, Request $request)
    {
        // Middleware-ul SetLocale ar trebui să seteze deja limba.
        // Acest apel este redundant dacă middleware-ul funcționează corect,
        // dar nu strică să-l păstrăm pentru siguranță.
        app()->setLocale($locale);
        $posts = BlogPost::published()
            ->with('user')
            // Căutarea ar trebui ajustată pentru a funcționa cu JSON
            // Această metodă funcționează cu spatie/laravel-translatable
            ->when($request->search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    // Caută în titlu și conținut în limba curentă
                    // `title` și `content` sunt acum JSON, dar HasTranslations le gestionează
                    // pentru interogări simple. Laravel încearcă să le caute ca string-uri.
                    // Pentru o căutare mai precisă în JSON, ar fi nevoie de o abordare diferită.
                    // Varianta de mai jos funcționează adesea cu HasTranslations.
                    $q->where('title', 'like', "%{$search}%")
                      ->orWhere('content', 'like', "%{$search}%");
                    // Alternativ, pentru căutare în JSON:
                    // $q->whereJsonContains('title', $search) // Caută în toate localele
                    //   ->orWhereJsonContains('content', $search); // Caută în toate localele
                    // Sau, pentru căutare în limba curentă (necesită un pic mai multă logică):
                    // $currentLocale = app()->getLocale();
                    // $q->where("title->{$currentLocale}", 'like', "%{$search}%")
                    //   ->orWhere("content->{$currentLocale}", 'like', "%{$search}%");
                });
            })
            ->latest('published_at')
            ->paginate(6);

        return view('blog.index', compact('posts'));
    }

    /**
     * Display the specified blog post.
     *
     * @param string $locale The current locale.
     * @param string $slug The slug of the post.
     * @return \Illuminate\View\View
     */
    public function show($locale, string $slug)
    {
        // Middleware-ul SetLocale ar trebui să seteze deja limba.
        app()->setLocale($locale);

        // === MODIFIED QUERY for JSON slug ===
        // Caută un post unde slug-ul în limba curentă ($locale) este egal cu $slug
        // Folosește whereJsonContains.
        $post = BlogPost::published()
            ->with('user')
            // Verifică dacă JSON-ul slug conține {"$locale": "$slug"}
            ->whereJsonContains('slug', [$locale => $slug])
            ->firstOrFail();
        // ===================================

        // Recent posts - la fel, conținutul va fi în limba curentă
        $recentPosts = BlogPost::published()
            ->where('id', '!=', $post->id)
            ->latest('published_at')
            ->limit(3)
            ->get(); // Nu e nevoie de firstOrFail() pentru get()

        return view('blog.show', compact('post', 'recentPosts'));
    }

    /**
     * Display the blog feed (e.g., RSS).
     * Consider generating separate feeds for each language.
     *
     * @return \Illuminate\Http\Response
     */
    public function feed()
    {
        // TODO: Poate fi modificat pentru a genera feed pentru limba curentă
        // sau pentru toate limbile.
        $posts = BlogPost::published()
            ->latest('published_at')
            ->limit(20)
            ->get();
        return response()->view('blog.feed', compact('posts'))
            ->header('Content-Type', 'application/xml');
    }

    /**
     * Display the blog sitemap.
     * Consider generating separate sitemap entries for each language.
     *
     * @return \Illuminate\Http\Response
     */
    public function sitemap()
    {
        // TODO: Poate fi modificat pentru a include slug-uri în toate limbile
        // sau pentru limba curentă.
        $posts = BlogPost::published()
            ->latest('published_at')
            ->get();
        return response()->view('blog.sitemap', compact('posts'))
            ->header('Content-Type', 'text/xml');
    }
}