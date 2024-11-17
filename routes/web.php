<?php

declare(strict_types=1);

use App\Web\Projects\Controllers\ProjectViewController;
use App\Web\Landing\Controllers\HomeController;
use App\Web\Posts\Controllers\PostViewController;
use Illuminate\Support\Facades\Route;

// Landing
Route::get('/', HomeController::class)->name('home');
// Route::get('/search', SearchController::class)->name('search');

// Projects
Route::name('projects.')->prefix('projects')->group(function () {
    Route::get('/{project}', ProjectViewController::class)->name('view');
});

// Posts
Route::name('posts.')->prefix('posts')->group(function () {
    Route::get('/{project}/{post}', PostViewController::class)->scopeBindings()->name('view');
});
