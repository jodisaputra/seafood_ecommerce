<?php

use Illuminate\Support\Facades\Route;

Route::get('/', [App\Http\Controllers\DefaultController::class, 'index'])->name('default');

Route::prefix('admin')->group(function () {
    Auth::routes(['register' => false]);

    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::resource('category', App\Http\Controllers\CategoryController::class);
    Route::resource('product', App\Http\Controllers\ProductController::class);

    //product gallery routes
    Route::get('/product/gallery/{product_id}', [App\Http\Controllers\ProductController::class, 'gallery'])->name('product.gallery.index');
    Route::get('/product/gallery/create/{product_id}', [App\Http\Controllers\ProductController::class, 'gallery_create'])->name('product.gallery.create');
    Route::post('/product/gallery/store', [App\Http\Controllers\ProductController::class, 'gallery_store'])->name('product.gallery.store');
    Route::delete('/product/gallery/destroy/{product_id}/{gallery_id}', [App\Http\Controllers\ProductController::class, 'gallery_destroy'])->name('product.gallery.destroy');
});

Route::get('/check_slug_category', [App\Http\Controllers\CheckSlugController::class, 'check_slug_category'])->name('check_slug_category');
Route::get('/check_slug_product', [App\Http\Controllers\CheckSlugController::class, 'check_slug_product'])->name('check_slug_product');

