<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\CartController;

Route::prefix('v1')->name('api.v1.')->group(function () {

    Route::post('/login', function () {
        return response()->json(['message' => 'Login endpoint']);
    })->name('login');

    Route::post('/register', function () {
        return response()->json(['message' => 'Register endpoint']);
    })->name('register');

    Route::get('/cart', [CartController::class, 'index'])->name('cart');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
    Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
    Route::post('/cart/coupon', [CartController::class, 'applyCoupon'])->name('cart.coupon.apply');
    Route::post('/cart/coupon/remove', [CartController::class, 'removeCoupon'])->name('cart.coupon.remove');
    Route::get('/cart/summary', [CartController::class, 'summary'])->name('cart.summary');

    Route::get('/user', function () {
        $user = Auth::guard('web')->user();
        if (!$user) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }
        return response()->json(['data' => $user]);
    })->name('user');

    Route::post('/logout', function () {
        Auth::guard('web')->logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return response()->json(['message' => 'Logged out']);
    })->name('logout');
});
