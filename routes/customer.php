<?php

use App\Http\Controllers\Auth\CustomerAuthController;
use App\Http\Controllers\Auth\ProfileController;
use App\Http\Controllers\Frontend\CheckoutController;
use App\Http\Controllers\Frontend\WishlistController;
use App\Http\Controllers\Frontend\AddressController;
use App\Http\Controllers\Frontend\ReviewController;
use App\Http\Controllers\Frontend\NotificationController;
use Illuminate\Support\Facades\Route;

Route::prefix('customer')->name('customer.')->group(function () {

    Route::middleware('guest')->group(function () {

        Route::get('/login', [CustomerAuthController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [CustomerAuthController::class, 'login']);

        Route::get('/register', [CustomerAuthController::class, 'showRegisterForm'])->name('register');
        Route::post('/register', [CustomerAuthController::class, 'register']);
    });

    Route::middleware(['customer'])->group(function () {

        Route::post('/logout', [CustomerAuthController::class, 'logout'])->name('logout');

        Route::get('/dashboard', function () {
            $user = auth()->guard('web')->user();
            $userId = $user->id;

            return view('customer.dashboard', [
                'totalOrders' => \App\Models\Order::where('user_id', $userId)->count(),
                'completedOrders' => \App\Models\Order::where('user_id', $userId)->where('status', 'delivered')->count(),
                'wishlistCount' => \App\Models\Wishlist::where('user_id', $userId)->count(),
                'reviewCount' => \App\Models\Review::where('user_id', $userId)->count(),
                'recentOrders' => \App\Models\Order::with(['items', 'payment'])
                    ->where('user_id', $userId)
                    ->latest()
                    ->take(5)
                    ->get(),
            ]);
        })->name('dashboard');

        Route::get('/profile', [ProfileController::class, 'showCustomerProfile'])->name('profile');
        Route::put('/profile', [ProfileController::class, 'updateProfile'])->name('profile.update');
        Route::put('/profile/password', [ProfileController::class, 'changePassword'])->name('profile.password');
        Route::post('/profile/sessions/destroy', [ProfileController::class, 'destroySession'])->name('sessions.destroy');
        Route::get('/login-history', [ProfileController::class, 'loginHistory'])->name('login.history');

        Route::get('/orders', [\App\Http\Controllers\Frontend\OrderController::class, 'index'])->name('orders');
        Route::get('/orders/{order}', [\App\Http\Controllers\Frontend\OrderController::class, 'show'])->name('order-detail');

        Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist');

        Route::get('/addresses', [AddressController::class, 'index'])->name('addresses');
        Route::get('/addresses/create', [AddressController::class, 'create'])->name('addresses.create');
        Route::post('/addresses', [AddressController::class, 'store'])->name('addresses.store');
        Route::get('/addresses/{address}/edit', [AddressController::class, 'edit'])->name('addresses.edit');
        Route::put('/addresses/{address}', [AddressController::class, 'update'])->name('addresses.update');
        Route::delete('/addresses/{address}', [AddressController::class, 'destroy'])->name('addresses.destroy');
        Route::post('/addresses/{address}/default', [AddressController::class, 'setDefault'])->name('addresses.default');

        Route::get('/reviews', [ReviewController::class, 'index'])->name('reviews');
        Route::put('/reviews/{review}', [ReviewController::class, 'update'])->name('reviews.update');
        Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');

        Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications');
        Route::post('/notifications/{notification}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
        Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.read-all');
        Route::delete('/notifications/{notification}', [NotificationController::class, 'destroy'])->name('notifications.destroy');
    });
});
