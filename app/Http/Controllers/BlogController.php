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
        
        // First, try to find post using slug in current locale
        $post = BlogPost::published()
            ->with('user')
            ->where("slug->{$locale}", $slug)
            ->first();
        
        // If not found in current locale, try English as fallback
        if (!$post && $locale !== 'en') {
            $post = BlogPost::published()
                ->with('user')
                ->where("slug->en", $slug)
                ->first();
        }
        
        // If still not found, try Romanian as second fallback
        if (!$post && $locale !== 'ro') {
            $post = BlogPost::published()
                ->with('user')
                ->where("slug->ro", $slug)
                ->first();
        }
        
        // If still not found, try Vietnamese as third fallback
        if (!$post && $locale !== 'vi') {
            $post = BlogPost::published()
                ->with('user')
                ->where("slug->vi", $slug)
                ->first();
        }
        
        // If post not found after all attempts, throw 404
        if (!$post) {
            abort(404, "Blog post not found");
        }
        
        // Recent posts - content will be in current language
        $recentPosts = BlogPost::published()
            ->where('id', '!=', $post->id)
            ->latest('published_at')
            ->limit(3)
            ->get();
            
        return view('blog.show', compact('post', 'recentPosts'));
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
