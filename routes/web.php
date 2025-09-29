<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AuthAdmin;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home.index');
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth'])->group(
    function () {
        Route::get('account-dashboard', [UserController::class, 'index'])->name('user.index');
    }
);

Route::middleware(['auth', AuthAdmin::class])->prefix('admin')->group(
    function () {
        Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.index');

        Route::get('brands', [AdminController::class, 'brands'])->name('admin.brands');
        Route::get('users', [AdminController::class, 'users'])->name('admin.users');
        Route::get('sliders', [AdminController::class, 'sliders'])->name('admin.sliders');
        Route::get('coupons', [AdminController::class, 'coupons'])->name('admin.coupons');
        Route::get('products', [AdminController::class, 'products'])->name('admin.products');
        Route::get('category', [AdminController::class, 'category'])->name('admin.category');
        Route::get('orders', [AdminController::class, 'orders'])->name('admin.orders');
        Route::get('settings', [AdminController::class, 'settings'])->name('admin.settings');
    }
);

require __DIR__ . '/auth.php';
