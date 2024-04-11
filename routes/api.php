<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::name('api.')->prefix('v1')->group(function () {
    // Home
    Route::get('/', fn (Request $request) => abort(403))->name('home');
});
