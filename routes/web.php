<?php

use Illuminate\Support\Facades\Route;

Route::get('/', [App\Http\Controllers\DefaultController::class, 'index'])->name('default');

Route::prefix('admin')->group(function () {
    Auth::routes(['register' => false]);

    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::resource('category', App\Http\Controllers\CategoryController::class);
});

Route::get('/check_slug', [App\Http\Controllers\CategoryController::class, 'check_slug'])->name('check_slug');

