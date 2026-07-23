<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::all()->groupBy('category');
        return view('projects.index', compact('projects'));
    }
    
    public function show($slug)
    {
        $project = Project::where('slug', $slug)->firstOrFail();
        
        // Ensure tech is an array
        if (!is_array($project->tech)) {
            $project->tech = [];
        }
        
        return view('projects.show', compact('project'));
    }
}
