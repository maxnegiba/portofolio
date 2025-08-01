<?php
namespace App\Console\Commands;

use App\Models\Project;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class FixProjectData extends Command
{
    protected $signature = 'app:fix-project-data';
    protected $description = 'Fix project data format';

    public function handle()
    {
        $this->info('Fixing project data...');
        
        $projects = Project::all();
        
        foreach ($projects as $project) {
            $changed = false;
            
            // Fix title
            $rawTitle = $project->getRawOriginal('title');
            if (is_string($rawTitle)) {
                $decoded = json_decode($rawTitle, true);
                if (json_last_error() !== JSON_ERROR_NONE) {
                    // If it's not JSON, create a simple array with the string as the value for all locales
                    $locales = config('app.available_locales', ['en']);
                    $titleArray = [];
                    foreach ($locales as $locale) {
                        $titleArray[$locale] = $rawTitle;
                    }
                    $project->title = $titleArray;
                    $changed = true;
                }
            }
            
            // Fix description
            $rawDescription = $project->getRawOriginal('description');
            if (is_string($rawDescription)) {
                $decoded = json_decode($rawDescription, true);
                if (json_last_error() !== JSON_ERROR_NONE) {
                    // If it's not JSON, create a simple array with the string as the value for all locales
                    $locales = config('app.available_locales', ['en']);
                    $descArray = [];
                    foreach ($locales as $locale) {
                        $descArray[$locale] = $rawDescription;
                    }
                    $project->description = $descArray;
                    $changed = true;
                }
            }
            
            // Fix tech
            $rawTech = $project->getRawOriginal('tech');
            if (is_string($rawTech)) {
                $decoded = json_decode($rawTech, true);
                if (json_last_error() !== JSON_ERROR_NONE) {
                    // If it's not JSON, convert comma-separated to array
                    $techArray = array_map('trim', explode(',', $rawTech));
                    $project->tech = $techArray;
                    $changed = true;
                }
            }
            
            if ($changed) {
                $project->save();
                $this->info("Fixed project ID: {$project->id}");
            }
        }
        
        $this->info('All projects have been fixed.');
    }
}