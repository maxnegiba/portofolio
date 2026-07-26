<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Artesaos\SEOTools\Facades\SEOTools as SEO;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::all()->groupBy('category');

        SEO::setTitle(__('pages.projects_title'));
        SEO::setDescription(__('pages.hero_subtitle'));
        return view('projects.index', compact('projects'));
    }
    
    public function show($slug)
    {
        $project = Project::where('slug', $slug)->firstOrFail();
        
        // Ensure tech is an array
        if (!is_array($project->tech)) {
            $project->tech = [];
        }
        
        SEO::setTitle($project->getLocalizedTitle());
        SEO::setDescription(Str::limit(strip_tags($project->getLocalizedDescription()), 160));
        SEO::opengraph()->setType('article');

        $imageUrl = $project->thumbnail_url ? (str_starts_with($project->thumbnail_url, 'http') ? $project->thumbnail_url : asset($project->thumbnail_url)) : asset('img/avatar.jpg');
        SEO::addImages([$imageUrl]);

        return view('projects.show', compact('project'));
    }
}
