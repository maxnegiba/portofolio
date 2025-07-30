<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index($locale) // Adăugăm $locale
    {
        // Middleware-ul SetLocale ar trebui să seteze deja limba.
        // Acest apel este redundant dacă middleware-ul funcționează corect,
        // dar nu strică să-l păstrăm pentru siguranță.
        app()->setLocale($locale);

        $projects = Project::paginate(9); // 9 proiecte per pagină
        return view('projects.index', compact('projects'));
    }

    public function show($locale, $slug)
    {
        // Middleware-ul SetLocale ar trebui să seteze deja limba.
        app()->setLocale($locale);

        // Când accesezi $project->title sau $project->description,
        // accessorii din modelul Project vor returna automat
        // traducerea în limba curentă (setată de app()->setLocale($locale))
        $project = Project::where('slug', $slug)->firstOrFail();
        return view('projects.show', compact('project'));
    }
}