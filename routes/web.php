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

//find products by slug
Route::get('/product/category/{slug?}', [App\Http\Controllers\DefaultController::class, 'find_product_by_category'])->name('find_product_by_category');

// register customer
Route::get('/login', [App\Http\Controllers\Auth\LoginController::class, 'customerLoginForm'])->name('customer.loginview');
Route::get('/register', [App\Http\Controllers\Auth\RegisterController::class, 'customerRegisterForm'])->name('customer.registerview');
Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'customerLogin'])->name('customer.login');
Route::post('/register', [App\Http\Controllers\Auth\RegisterController::class, 'customerCreateRegister'])->name('customer.register');

//seeing detail product
Route::get('/product/cart', [App\Http\Controllers\DefaultController::class, 'cart'])->name('product.shop.cart');
Route::get('/product/{slug}', [App\Http\Controllers\DefaultController::class, 'detail'])->name('product.shop.detail');

//cart
Route::post('/cart/{slug}', [App\Http\Controllers\DefaultController::class, 'add_to_cart'])->name('cart.add');
Route::delete('/remove_cart/{id}', [App\Http\Controllers\DefaultController::class, 'remove_from_cart'])->name('cart.remove');
Route::put('/update_cart/{id}', [App\Http\Controllers\DefaultController::class, 'update_cart'])->name('cart.update');

//checkout
Route::get('/checkout', [App\Http\Controllers\CheckoutController::class, 'index'])->name('checkout.index');
