<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::get('cart', [CartController::class, 'showCart'])->name('cart.show');
    Route::post('checkout', [CartController::class, 'checkout'])->name('cart.checkout');
    Route::get('checkout/success', [CartController::class, 'success'])->name('cart.success');
    Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
});

require __DIR__ . '/auth.php';
