<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ContactController;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

Route::redirect('/', '/en');

Route::prefix('{locale}')
    ->where(['locale' => 'en|ro'])
    ->group(function () {
        Route::get('/', fn () => view('home'))->name('home');
        Route::get('/projects', [ProjectController::class, 'index'])->name('projects');
        Route::get('/projects/{project}', [ProjectController::class, 'show'])->name('project');
        Route::get('/contact', fn () => view('contact'))->name('contact');
        Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');
    });

    use App\Http\Controllers\BlogController;

// Blog routes
Route::prefix('blog')->group(function () {
    Route::get('/', [BlogController::class, 'index'])->name('blog.index');
    Route::get('/{slug}', [BlogController::class, 'show'])->name('blog.show');
    Route::get('/feed', [BlogController::class, 'feed'])->name('blog.feed');
    Route::get('/sitemap', [BlogController::class, 'sitemap'])->name('blog.sitemap');
});

require __DIR__.'/auth.php';