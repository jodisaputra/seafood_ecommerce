<?php

use Illuminate\Support\Facades\Route;

Route::get('/', [App\Http\Controllers\DefaultController::class, 'index'])->name('default');

Route::prefix('admin')->group(function () {
    Auth::routes(['register' => false]);

    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::resource('category', App\Http\Controllers\CategoryController::class);
    Route::resource('product', App\Http\Controllers\ProductController::class);
});

Route::get('/check_slug_category', [App\Http\Controllers\CheckSlugController::class, 'check_slug_category'])->name('check_slug_category');
Route::get('/check_slug_product', [App\Http\Controllers\CheckSlugController::class, 'check_slug_product'])->name('check_slug_product');

