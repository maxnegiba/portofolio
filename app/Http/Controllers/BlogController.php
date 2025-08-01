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

        $query = BlogPost::published()
            ->with('user'); // Încarcă utilizatorul

        // Aplică filtrul de căutare dacă există
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $currentLocale = app()->getLocale();

            $query->where(function ($q) use ($searchTerm, $currentLocale) {
                // Caută în titlu și excerpt în limba curentă
                // Presupunem că excerpt este și el translat (JSON)
                $q->whereJsonContains("title->{$currentLocale}", $searchTerm)
                  ->orWhereJsonContains("excerpt->{$currentLocale}", $searchTerm)
                  ->orWhereJsonContains("content->{$currentLocale}", $searchTerm);
            });
        }

        // Paginare articole
        $posts = $query->latest('published_at')
                       ->paginate(6)
                       ->appends(['search' => $request->search]); // Păstrează termenul de căutare în URL

        return view('blog.index', compact('posts'));
    }

    /**
     * Display the specified blog post.
     *
     * @param string $locale The current locale.
     * @param string $slug The localized slug of the post.
     * @return \Illuminate\View\View
     */
    public function show($locale, string $slug)
    {
        // Middleware-ul SetLocale ar trebui să seteze deja limba.
        app()->setLocale($locale);

        // Caută postul publicat unde slug-ul în limba curentă ($locale) este egal cu $slug
        // Presupunem că metoda `scopePublished` există în modelul BlogPost
        $post = BlogPost::published()
            ->with('user') // Încarcă autorul
            ->whereJsonContains("slug->{$locale}", $slug) // Căutare în JSON pentru slug-ul localizat
            ->firstOrFail();

        // Obține articole recente (doar cele publicate, excluzând articolul curent)
        // Se încarcă doar datele necesare pentru afișare în Blade
        $recentPosts = BlogPost::published()
            ->where('id', '!=', $post->id)
            ->latest('published_at')
            ->limit(3)
            ->get(['id', 'title', 'excerpt', 'slug', 'featured_image', 'published_at', 'reading_time']); // Selectează doar coloanele necesare

        return view('blog.show', compact('post', 'recentPosts'));
    }

    /**
     * Display the blog feed (e.g., RSS).
     * Consider generating separate feeds for each language or a single feed with language tags.
     *
     * @return \Illuminate\Http\Response
     */
    public function feed()
    {
        // TODO: Implementare completă pentru feed XML (RSS/Atom)
        // Ar trebui să țină cont de localizare (slug-uri, titluri, conținut)
        $posts = BlogPost::published()
            ->latest('published_at')
            ->limit(20)
            ->get();
        return response()->view('blog.feed', compact('posts'))
            ->header('Content-Type', 'application/xml');
    }

    /**
     * Display the blog sitemap.
     * Consider generating separate sitemap entries for each language or a single sitemap with hreflang tags.
     *
     * @return \Illuminate\Http\Response
     */
    public function sitemap()
    {
        // TODO: Implementare completă pentru sitemap XML
        // Ar trebui să includă toate slug-urile pentru toate limbile disponibile
        $posts = BlogPost::published()
            ->latest('published_at')
            ->get();
        return response()->view('blog.sitemap', compact('posts'))
            ->header('Content-Type', 'text/xml');
    }
}