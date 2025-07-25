<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Project;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
   public function run(): void
{
    Project::create([
        'slug'        => 'ecommerce-platform',
        'title'       => ['en' => 'E-commerce Platform', 'ro' => 'Platformă e-commerce'],
        'description' => [
            'en' => 'Full-featured online store with Laravel, Stripe and Vue.',
            'ro' => 'Magazin complet cu Laravel, Stripe și Vue.',
        ],
        'tech'        => ['Laravel', 'Vue', 'MySQL', 'Stripe'],
        'live_url'    => 'https://demo.ro',
        'github_url'  => 'https://github.com/you/ecommerce',
        'thumbnail'   => 'img/projects/ecommerce.jpg',
    ]);

    Project::create([
        'slug'        => 'task-board',
        'title'       => ['en' => 'Task Board', 'ro' => 'Tablou de sarcini'],
        'description' => [
            'en' => 'Real-time kanban with Laravel Echo and Vue.',
            'ro' => 'Kanban în timp real cu Laravel Echo și Vue.',
        ],
        'tech'        => ['Laravel', 'Vue', 'Pusher'],
        'live_url'    => 'https://tasks.demo.ro',
        'github_url'  => 'https://github.com/you/tasks',
        'thumbnail'   => 'img/projects/tasks.jpg',
    ]);

    // ... încă 1-2 proiecte
}
}