<?php
namespace App\Http\Controllers;

use App\Models\BlogPost;
use Illuminate\Http\Request;
use Artesaos\SEOTools\Facades\SEOTools as SEO;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    /**
     * Display a listing of the blog posts.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $locale = app()->getLocale();
        
        $posts = BlogPost::published()
            ->with('user')
            ->when($request->search, function ($query, $search) use ($locale) {
                return $query->where(function ($q) use ($search, $locale) {
                    // Căutare în titlu și conținut în limba curentă
                    $q->where("title->{$locale}", 'like', "%{$search}%")
                      ->orWhere("content->{$locale}", 'like', "%{$search}%");
                });
            })
            ->latest('published_at')
            ->paginate(6);
            
        SEO::setTitle('Blog');
        SEO::setDescription(__('pages.hero_subtitle'));
        return view('blog.index', compact('posts'));
    }

    /**
     * Display the specified blog post.
     *
     * @param string $slug The slug of the post.
     * @return \Illuminate\View\View
     */
    public function show(string $slug)
    {
        $locale = app()->getLocale();
        
        // Căutare folosind slug-ul tradus
        $post = BlogPost::published()
            ->with('user')
            ->where("slug->{$locale}", $slug)
            ->firstOrFail();
            
        // Recent posts - conținutul va fi în limba curentă
        $recentPosts = BlogPost::published()
            ->where('id', '!=', $post->id)
            ->latest('published_at')
            ->limit(3)
            ->get();
            
        SEO::setTitle($post->getLocalizedTitle());
        SEO::setDescription(Str::limit(strip_tags($post->getTranslation('excerpt', app()->getLocale())), 160));
        SEO::opengraph()->setType('article')->setUrl(url()->current());

        // Social previews must use the actual featured image. Storage::url() can
        // return a relative /storage/... path, so normalize it to an absolute URL.
        $imageUrl = $post->image_url;

        if ($imageUrl && ! Str::startsWith($imageUrl, ['http://', 'https://'])) {
            $imageUrl = url($imageUrl);
        }

        $imageUrl = $imageUrl ?: asset('img/avatar-400.jpg');

        SEO::addImages([$imageUrl]);

        return view('blog.show', compact('post', 'recentPosts'));
    }

    /**
     * Display the blog feed (e.g., RSS).
     *
     * @return \Illuminate\Http\Response
     */
    public function feed()
    {
        $locale = app()->getLocale();
        
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
     * @return \Illuminate\Http\Response
     */
    public function sitemap()
    {
        $locale = app()->getLocale();
        
        $posts = BlogPost::published()
            ->latest('published_at')
            ->get();
            
        return response()->view('blog.sitemap', compact('posts', 'locale'))
            ->header('Content-Type', 'text/xml');
    }
}