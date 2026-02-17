<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PrivateGalleryController;
use App\Http\Controllers\UploadController;
use Illuminate\Support\Facades\Route;

Route::get('/', [CategoryController::class, 'index'])->name('home');

Route::prefix('kategori')->group(function () {
    Route::get('/create', [CategoryController::class, 'create'])->name('kategori.create');
    Route::post('/create', [CategoryController::class, 'store'])->name('kategori.store');
    Route::get('/{slug}', [CategoryController::class, 'show'])->name('kategori.show');
});

// Private Gallery - Sederhana
Route::get('/private', [PrivateGalleryController::class, 'showForm'])->name('private.form');
Route::post('/private', [PrivateGalleryController::class, 'verify'])->name('private.verify');
Route::get('/private/gallery', [PrivateGalleryController::class, 'gallery'])->name('private.gallery');
Route::post('/private/logout', [PrivateGalleryController::class, 'logout'])->name('private.logout');

Route::prefix('upload')->group(function () {
    Route::get('/', [UploadController::class, 'create'])->name('upload.create');
    Route::post('/', [UploadController::class, 'store'])->name('upload.store');
});

Route::get('/test-cloudinary', function() {
    return [
        'cloud_name' => env('CLOUDINARY_CLOUD_NAME'),
        'api_key' => env('CLOUDINARY_KEY'),
        'api_secret' => env('CLOUDINARY_SECRET') ? 'set' : 'not set',
        'cloud_url' => env('CLOUDINARY_URL'),
        'config_cloud_name' => config('cloudinary.cloud_url'),
    ];
});