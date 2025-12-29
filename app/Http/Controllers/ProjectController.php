<?php
namespace App\Http\Controllers;
use App\Models\Project;
use Illuminate\Http\Request;
class ProjectController extends Controller
{
    public function index($locale)
    {
        app()->setLocale($locale);
        $projects = Project::paginate(9);
        return view('projects.index', compact('projects'));
    }
    
    public function show($locale, $slug)
    {
        app()->setLocale($locale);
        
        // Căutare folosind slug tradus (pentru limbile cu traduceri JSON)
        $project = Project::where(function ($query) use ($slug, $locale) {
            // Caută în slug JSON: slug->vitameza, slug->en, etc.
            $query->where("slug->{$locale}", $slug)
                  ->orWhere('slug', $slug); // Fallback la slug direct dacă e string
        })->firstOrFail();
        
        // Ensure tech is an array
        if (!is_array($project->tech)) {
            $project->tech = [];
        }
        
        return view('projects.show', compact('project'));
    }
}
