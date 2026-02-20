<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\BlogController;
use Livewire\Volt\Volt;

// Redirect pentru rădăcină
Route::redirect('/', '/en');

// Grupul principal de rute localizate
Route::prefix('{locale}')
    ->where(['locale' => 'en|ro'])
    ->group(function () {
        // Pagini existente
        Route::get('/', [HomeController::class, 'index'])->name('home');
        Route::post('/testimonials', [HomeController::class, 'storeTestimonial'])->name('testimonials.store');

        Route::get('/projects', [ProjectController::class, 'index'])->name('projects');
        Route::get('/projects/{project}', [ProjectController::class, 'show'])->name('project');
        Route::get('/contact', fn () => view('contact'))->name('contact');
        Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');
        
        // Rute pentru blog - MODIFICATE
        Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
        Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');
        Route::get('/blog/feed', [BlogController::class, 'feed'])->name('blog.feed');
        Route::get('/blog/sitemap', [BlogController::class, 'sitemap'])->name('blog.sitemap');
    });

// Dashboard & Settings (Outside locale prefix to match tests/legacy behavior)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', fn () => view('dashboard'))->name('dashboard');

    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

// Rutele de autentificare (dacă nu au nevoie de locale)
require __DIR__.'/auth.php';
