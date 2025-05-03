<?php

use App\Enums\UserRole;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DiscountController;
use App\Http\Controllers\Admin\PaymentMethodController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\TestimoniController;
use App\Http\Controllers\User\CartController;
use App\Http\Controllers\User\TransactionController;
use App\Http\Controllers\User\UserDashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', [HomeController::class, 'index']);
Route::get('/shop', [ShopController::class, 'shop']);
Route::get('/contact', [ContactController::class, 'contact']);
Route::get('/testimoni', [TestimoniController::class, 'testimoni']);

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return auth()->user()->role === UserRole::Admin
            ? redirect()->route('admin.dashboard')
            : redirect()->route('user.dashboard');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::middleware('role:Admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::resource('/category', CategoryController::class)->names('category');
        Route::resource('/product', ProductController::class)->names('product');
        Route::resource('/payment-methods', PaymentMethodController::class)->names('payment_methods');

        Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
        Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
        Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
        Route::delete('/cart/{cartItem}', [CartController::class, 'destroy'])->name('cart.destroy');

        //discount
        Route::resource('discount', DiscountController::class);

        
    });

    Route::middleware('role:User')->prefix('user')->name('user.')->group(function () {
        Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');

        Route::resource('/cart', CartController::class)->names('cart')->only(['index', 'store', 'destroy']);
        Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');

        Route::post('/transactions', [TransactionController::class, 'store'])->name('transactions.store');

    });
});

require __DIR__.'/auth.php';
