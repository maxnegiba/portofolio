<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\BlogController; // Adaugă această linie
use Livewire\Volt\Volt;

// Redirect pentru rădăcină
Route::redirect('/', '/en');

// Grupul principal de rute localizate
Route::prefix('{locale}')
    ->where(['locale' => 'en|ro'])
    ->group(function () {

        // Pagini existente
        Route::get('/', fn () => view('home'))->name('home');
        Route::get('/projects', [ProjectController::class, 'index'])->name('projects');
        Route::get('/projects/{project}', [ProjectController::class, 'show'])->name('project');
        Route::get('/contact', fn () => view('contact'))->name('contact');
        Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');

        // === MUTĂM RUTELE BLOGULUI AICI ===
        Route::prefix('blog')->group(function () {
            Route::get('/', [BlogController::class, 'index'])->name('blog.index');
            Route::get('/{slug}', [BlogController::class, 'show'])->name('blog.show');
            // Adaugă aici și alte rute de blog dacă sunt necesare (ex: feed, sitemap)
        });

    });

// Rutele de autentificare (dacă nu au nevoie de locale)
require __DIR__.'/auth.php';