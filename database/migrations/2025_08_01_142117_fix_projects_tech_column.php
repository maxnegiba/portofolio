<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            // Ensure the tech column is JSON type
            $table->json('tech')->nullable()->change();
        });
        
        // Fix existing tech data
        DB::table('projects')->get()->each(function ($project) {
            if ($project->tech && is_string($project->tech)) {
                // Try to decode as JSON
                $decoded = json_decode($project->tech, true);
                
                if (json_last_error() !== JSON_ERROR_NONE) {
                    // If it's not JSON, convert comma-separated to array
                    $techArray = array_map('trim', explode(',', $project->tech));
                    DB::table('projects')
                        ->where('id', $project->id)
                        ->update(['tech' => json_encode($techArray)]);
                }
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->text('tech')->nullable()->change();
        });
    }
};