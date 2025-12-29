<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\BlogController;
use Livewire\Volt\Volt;

// Redirect root to English, or check for cookie
Route::get('/', function () {
    // Check if a locale cookie exists and is valid
    $cookieLocale = request()->cookie('locale');
    if ($cookieLocale && in_array($cookieLocale, ['en', 'ro', 'vi'])) {
        return redirect('/' . $cookieLocale);
    }
    // Default fallback
    return redirect('/en');
});

// Main localized route group
Route::prefix('{locale}')
    ->where(['locale' => 'en|ro|vi|vitameza'])
    ->middleware(\App\Http\Middleware\SetLocale::class) // Ensure middleware runs here to set locale from param
    ->group(function () {

        // Static pages - Pass locale to view or let middleware handle it
        Route::get('/', function ($locale) {
            // Middleware SetLocale should have already set the app locale,
            // but we can explicitly set it just in case or for clarity if middleware behavior varies.
            // app()->setLocale($locale);
            return view('home');
        })->name('home');

        Route::get('/projects', [ProjectController::class, 'index'])->name('projects');
        Route::get('/projects/{project}', [ProjectController::class, 'show'])->name('project');

        Route::get('/contact', function ($locale) {
            return view('contact');
        })->name('contact');

        Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');
        
        // Blog Routes
        Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
        Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');
        Route::get('/blog/feed', [BlogController::class, 'feed'])->name('blog.feed');
        Route::get('/blog/sitemap', [BlogController::class, 'sitemap'])->name('blog.sitemap');
    });

// Auth routes
require __DIR__.'/auth.php';
