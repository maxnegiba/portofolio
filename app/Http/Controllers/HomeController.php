<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\BlogPost;
use App\Models\Testimonial;

class HomeController extends Controller
{
    public function index()
    {
        $projects = Project::latest()->take(3)->get();
        $blogPosts = BlogPost::published()->latest('published_at')->take(3)->get();
        $testimonials = Testimonial::where('is_active', true)->latest()->get();

        return view('home', compact('projects', 'blogPosts', 'testimonials'));
    }

    public function storeTestimonial(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'nullable|string|max:255',
            'content' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        Testimonial::create([
            'name' => $validated['name'],
            'role' => $validated['role'],
            'content' => $validated['content'],
            'rating' => $validated['rating'],
            'is_active' => false,
        ]);

        return redirect()->back()->with('success', __('pages.testimonial_submitted') ?? 'Thank you for your feedback! It will be reviewed shortly.');
    }
}
