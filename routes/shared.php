<?php

use App\Api\Media\Controllers\AssetController;
use App\Api\Media\Controllers\DownloadController;
use App\Api\Media\Controllers\ResponsiveController;
use Illuminate\Support\Facades\Route;

Route::name('api.')->prefix('api/v1')->group(function () {
    // Media
    Route::name('media.')->group(function () {
        Route::get('/asset/{media}/{conversion?}', AssetController::class)->name('asset');
        Route::get('/download/{media}/{conversion?}', DownloadController::class)->name('download');
        Route::get('/responsive/{media}/{conversion?}', ResponsiveController::class)->name('responsive');
    });
});
