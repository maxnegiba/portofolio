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
        $projects = Project::query()
            ->latest()
            ->get()
            ->groupBy(fn (Project $project): string => $project->normalized_category);

        SEO::setTitle(__('pages.projects_title'));
        SEO::setDescription(__('pages.hero_subtitle'));
        return view('projects.index', compact('projects'));
    }
    
    public function show(Project $project)
    {
        SEO::setTitle($project->getLocalizedTitle());
        SEO::setDescription(Str::limit(strip_tags($project->getLocalizedDescription()), 160));
        SEO::opengraph()->setType('article');

        $imageUrl = $project->thumbnail_url ?: asset('img/avatar.webp');
        SEO::addImages([$imageUrl]);

        return view('projects.show', compact('project'));
    }
}
