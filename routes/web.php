<?php

use App\Landing\Controllers\AboutController;
use App\Landing\Controllers\HomeController;
use App\Landing\Controllers\SearchController;
use App\Posts\Controllers\PostViewController;
use App\Projects\Controllers\ProjectViewController;
use Illuminate\Support\Facades\Route;

// Landing
Route::get('/', HomeController::class)->name('home');
Route::get('/about', AboutController::class)->name('about');
Route::get('/search', SearchController::class)->name('search');

// Projects
Route::name('projects.')->prefix('projects')->group(function () {
    Route::get('/{project}', ProjectViewController::class)->name('view');
});

// Posts
Route::name('posts.')->prefix('posts')->group(function () {
    Route::get('/{project}/{post}', PostViewController::class)->scopeBindings()->name('view');
});
