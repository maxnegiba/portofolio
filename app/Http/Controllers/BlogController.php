<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $posts = BlogPost::published()
            ->with('user')
            ->when($request->search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                      ->orWhere('content', 'like', "%{$search}%");
                });
            })
            ->latest('published_at')
            ->paginate(6);

        return view('blog.index', compact('posts'));
    }

    public function show(string $slug)
    {
        $post = BlogPost::published()
            ->with('user')
            ->where('slug', $slug)
            ->firstOrFail();

        $recentPosts = BlogPost::published()
            ->where('id', '!=', $post->id)
            ->latest('published_at')
            ->limit(3)
            ->get();

        return view('blog.show', compact('post', 'recentPosts'));
    }

    public function feed()
    {
        $posts = BlogPost::published()
            ->latest('published_at')
            ->limit(20)
            ->get();

        return response()->view('blog.feed', compact('posts'))
            ->header('Content-Type', 'application/xml');
    }

    public function sitemap()
    {
        $posts = BlogPost::published()
            ->latest('published_at')
            ->get();

        return response()->view('blog.sitemap', compact('posts'))
            ->header('Content-Type', 'text/xml');
    }
}