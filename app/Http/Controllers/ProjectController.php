<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::paginate(9); // 9 proiecte per pagină
        return view('projects.index', compact('projects'));
    }

    public function show($locale, $slug)
    {
        $project = Project::where('slug', $slug)->firstOrFail();
        return view('projects.show', compact('project'));
    }
}