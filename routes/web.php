<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SeoController;

// HOME
Route::get('/', [SeoController::class, 'show'])->name('home');

// ADMIN
Route::prefix('admin')->group(function () {
    Route::get('/', [SeoController::class, 'index'])->name('admin.index');
    Route::get('/create', [SeoController::class, 'create']);
    Route::post('/store', [SeoController::class, 'store']);
    Route::get('/edit/{id}', [SeoController::class, 'edit']);
    Route::post('/update/{id}', [SeoController::class, 'update']);
    Route::get('/delete/{id}', [SeoController::class, 'destroy']);
    Route::get('/toggle/{id}', [SeoController::class, 'toggle']);
    Route::get('/trash', [SeoController::class, 'trash']);
    Route::get('/restore/{id}', [SeoController::class, 'restore']);
    Route::get('/force-delete/{id}', [SeoController::class, 'forceDelete']);
});

// SEO pages
Route::get('/{slug}', [SeoController::class, 'show'])
    ->where('slug', '[A-Za-z0-9\-]+')
    ->name('seo.page');