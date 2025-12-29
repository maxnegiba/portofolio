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
        // Middleware handles setting locale, but we can reinforce it
        app()->setLocale($locale);
        
        $posts = BlogPost::published()
            ->with('user')
            ->when($request->search, function ($query, $search) use ($locale) {
                return $query->where(function ($q) use ($search, $locale) {
                    // Search in title and content in current language
                    $q->where("title->{$locale}", 'like', "%{$search}%")
                      ->orWhere("content->{$locale}", 'like', "%{$search}%")
                      // Fallback search in other languages if not found in current locale
                      ->orWhere("title->en", 'like', "%{$search}%")
                      ->orWhere("content->en", 'like', "%{$search}%");
                });
            })
            ->latest('published_at')
            ->paginate(6);
            
        return view('blog.index', compact('posts'));
    }

    /**
     * Display the specified blog post with fallback language support.
     *
     * @param string $locale The current locale.
     * @param string $slug The slug of the post.
     * @return \Illuminate\View\View
     */
    public function show($locale, string $slug)
    {
        app()->setLocale($locale);
        
        // 1. Attempt to find the post by looking up the slug in the CURRENT locale
        $post = BlogPost::published()
            ->with('user')
            ->where("slug->{$locale}", $slug)
            ->first();

        // 2. Fallback strategy: If not found, check if the slug matches ANY language
        // This handles the case where a user visits /ro/blog/english-slug
        // We find the post, then we can redirect them to the correct localized slug if we wanted,
        // but for now we just show the post.
        if (!$post) {
             $post = BlogPost::published()
                ->with('user')
                ->where(function($query) use ($slug) {
                    $query->where('slug->en', $slug)
                          ->orWhere('slug->ro', $slug)
                          ->orWhere('slug->vi', $slug)
                          ->orWhere('slug->vitameza', $slug);
                })
                ->first();
        }
        
        if (!$post) {
            abort(404, "Blog post not found");
        }

        // 3. Generate Alternate URLs for Language Switcher
        // This allows the navbar to switch to the translated version of THIS post
        // instead of redirecting to home.
        $alternateUrls = [];
        $supportedLocales = ['en', 'ro', 'vi'];

        foreach ($supportedLocales as $lang) {
            // Get the slug for the target language.
            // If it doesn't exist, we might fall back to English or current slug,
            // but ideally we want the specific translation.
            $translatedSlug = $post->getTranslation('slug', $lang, false);

            // Handle vitameza fallback if 'vi' is missing but 'vitameza' exists
            if ($lang === 'vi' && empty($translatedSlug)) {
                $translatedSlug = $post->getTranslation('slug', 'vitameza', false);
            }

            if (!empty($translatedSlug)) {
                $alternateUrls[$lang] = route('blog.show', ['locale' => $lang, 'slug' => $translatedSlug]);
            } else {
                // If translation doesn't exist, we could link to blog index or home
                // For now, let's link to blog index of that language
                $alternateUrls[$lang] = route('blog.index', ['locale' => $lang]);
            }
        }
        
        // Recent posts - content will be in current language
        $recentPosts = BlogPost::published()
            ->where('id', '!=', $post->id)
            ->latest('published_at')
            ->limit(3)
            ->get();
            
        return view('blog.show', compact('post', 'recentPosts', 'alternateUrls'));
    }

    /**
     * Display the blog feed (e.g., RSS).
     *
     * @param string $locale The current locale.
     * @return \Illuminate\Http\Response
     */
    public function feed($locale)
    {
        app()->setLocale($locale);
        
        $posts = BlogPost::published()
            ->latest('published_at')
            ->limit(20)
            ->get();
            
        return response()->view('blog.feed', compact('posts', 'locale'))
            ->header('Content-Type', 'application/xml');
    }

    /**
     * Display the blog sitemap.
     *
     * @param string $locale The current locale.
     * @return \Illuminate\Http\Response
     */
    public function sitemap($locale)
    {
        app()->setLocale($locale);
        
        $posts = BlogPost::published()
            ->latest('published_at')
            ->get();
            
        return response()->view('blog.sitemap', compact('posts', 'locale'))
            ->header('Content-Type', 'text/xml');
    }
}
