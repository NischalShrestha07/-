<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SettingController;
use App\Http\Middleware\AuthAdmin;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home.index');
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::get('account-dashboard', [UserController::class, 'index'])->name('user.index');
});

Route::middleware(['auth', AuthAdmin::class])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.index');

    // Brands Routes
    Route::get('brands', [BrandController::class, 'index'])->name('admin.brands.index');
    Route::get('brands/create', [BrandController::class, 'create'])->name('admin.brands.create');
    Route::post('brands', [BrandController::class, 'store'])->name('admin.brands.store');
    Route::get('brands/{brand}/edit', [BrandController::class, 'edit'])->name('admin.brands.edit');
    Route::put('brands/{brand}', [BrandController::class, 'update'])->name('admin.brands.update');
    Route::delete('brands/{brand}', [BrandController::class, 'destroy'])->name('admin.brands.destroy');

    // Users Routes
    Route::get('users', [UserController::class, 'adminIndex'])->name('admin.users.index');
    Route::get('users/create', [UserController::class, 'create'])->name('admin.users.create');
    Route::post('users', [UserController::class, 'store'])->name('admin.users.store');
    Route::get('users/{user}/edit', [UserController::class, 'edit'])->name('admin.users.edit');
    Route::put('users/{user}', [UserController::class, 'update'])->name('admin.users.update');
    Route::delete('users/{user}', [UserController::class, 'destroy'])->name('admin.users.destroy');

    // Sliders Routes
    Route::get('sliders', [SliderController::class, 'index'])->name('admin.sliders.index');
    Route::get('sliders/create', [SliderController::class, 'create'])->name('admin.sliders.create');
    Route::post('sliders', [SliderController::class, 'store'])->name('admin.sliders.store');
    Route::get('sliders/{slider}/edit', [SliderController::class, 'edit'])->name('admin.sliders.edit');
    Route::put('sliders/{slider}', [SliderController::class, 'update'])->name('admin.sliders.update');
    Route::delete('sliders/{slider}', [SliderController::class, 'destroy'])->name('admin.sliders.destroy');

    // Coupons Routes
    Route::get('coupons', [CouponController::class, 'index'])->name('admin.coupons.index');
    Route::get('coupons/create', [CouponController::class, 'create'])->name('admin.coupons.create');
    Route::post('coupons', [CouponController::class, 'store'])->name('admin.coupons.store');
    Route::get('coupons/{coupon}/edit', [CouponController::class, 'edit'])->name('admin.coupons.edit');
    Route::put('coupons/{coupon}', [CouponController::class, 'update'])->name('admin.coupons.update');
    Route::delete('coupons/{coupon}', [CouponController::class, 'destroy'])->name('admin.coupons.destroy');

    // Products Routes
    Route::get('products', [ProductController::class, 'index'])->name('admin.products.index');
    Route::get('products/create', [ProductController::class, 'create'])->name('admin.products.create');
    Route::post('products', [ProductController::class, 'store'])->name('admin.products.store');
    Route::get('products/{product}/edit', [ProductController::class, 'edit'])->name('admin.products.edit');
    Route::put('products/{product}', [ProductController::class, 'update'])->name('admin.products.update');
    Route::delete('products/{product}', [ProductController::class, 'destroy'])->name('admin.products.destroy');

    // Categories Routes
    Route::get('categories', [CategoryController::class, 'index'])->name('admin.categories.index');
    Route::get('categories/create', [CategoryController::class, 'create'])->name('admin.categories.create');
    Route::post('categories', [CategoryController::class, 'store'])->name('admin.categories.store');
    Route::get('categories/{category}/edit', [CategoryController::class, 'edit'])->name('admin.categories.edit');
    Route::put('categories/{category}', [CategoryController::class, 'update'])->name('admin.categories.update');
    Route::delete('categories/{category}', [CategoryController::class, 'destroy'])->name('admin.categories.destroy');

    // Orders Routes
    Route::get('orders', [OrderController::class, 'index'])->name('admin.orders.index');
    Route::get('orders/{order}', [OrderController::class, 'show'])->name('admin.orders.show');
    Route::put('orders/{order}', [OrderController::class, 'update'])->name('admin.orders.update');

    // Settings Routes
    Route::get('settings', [SettingController::class, 'index'])->name('admin.settings.index');
    Route::put('settings', [SettingController::class, 'updateSiteSettings'])->name('admin.settings.update');
    Route::put('settings/profile', [SettingController::class, 'updateProfile'])->name('admin.settings.profile');
});

require __DIR__ . '/auth.php';
