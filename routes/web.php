<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\ShopController;
use App\Http\Controllers\Frontend\ProductController;
use App\Http\Controllers\Frontend\CategoryController;
use App\Http\Controllers\Frontend\BrandController;
use App\Http\Controllers\Frontend\CartController;
use App\Services\SEOService;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/shop', [ShopController::class, 'index'])->name('shop');
Route::get('/search', [ShopController::class, 'index'])->name('search');

Route::get('/category/{slug}', [CategoryController::class, 'show'])->name('category.show');
Route::get('/brand/{slug}', [BrandController::class, 'show'])->name('brand.show');
Route::get('/product/{slug}', [ProductController::class, 'show'])->name('product.show');

Route::get('/cart', [CartController::class, 'index'])->name('cart');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
Route::post('/cart/coupon', [CartController::class, 'applyCoupon'])->name('cart.coupon.apply');
Route::post('/cart/coupon/remove', [CartController::class, 'removeCoupon'])->name('cart.coupon.remove');
Route::get('/cart/summary', [CartController::class, 'summary'])->name('cart.summary');

Route::get('/checkout', [\App\Http\Controllers\Frontend\CheckoutController::class, 'index'])->name('checkout');
Route::post('/checkout/place', [\App\Http\Controllers\Frontend\CheckoutController::class, 'placeOrder'])->name('checkout.place');
Route::get('/checkout/success/{orderId}', [\App\Http\Controllers\Frontend\CheckoutController::class, 'success'])->name('checkout.success');
Route::get('/checkout/failed/{orderId}', [\App\Http\Controllers\Frontend\CheckoutController::class, 'failed'])->name('checkout.failed');
Route::get('/checkout/summary', [\App\Http\Controllers\Frontend\CheckoutController::class, 'summary'])->name('checkout.summary');
Route::post('/checkout/shipping-rates', [\App\Http\Controllers\Frontend\CheckoutController::class, 'shippingRates'])->name('checkout.shipping-rates');

Route::get('/order/invoice/{orderId}', [\App\Http\Controllers\Frontend\CheckoutController::class, 'invoice'])->name('order.invoice');
Route::get('/order/track/{orderNumber?}', [\App\Http\Controllers\Frontend\TrackOrderController::class, 'show'])->name('order.track');

Route::get('/wishlist', function () {
    if (auth()->guard('web')->check()) {
        return redirect()->route('customer.wishlist');
    }
    return view('frontend.wishlist');
})->name('wishlist');

Route::post('/wishlist/toggle', [\App\Http\Controllers\Frontend\WishlistController::class, 'toggle'])->name('wishlist.toggle');
Route::post('/wishlist/add', [\App\Http\Controllers\Frontend\WishlistController::class, 'store'])->name('wishlist.add');
Route::delete('/wishlist/{product}', [\App\Http\Controllers\Frontend\WishlistController::class, 'destroy'])->name('wishlist.remove');
Route::get('/wishlist/count', [\App\Http\Controllers\Frontend\WishlistController::class, 'count'])->name('wishlist.count');

Route::post('/product/{product}/review', [\App\Http\Controllers\Frontend\ReviewController::class, 'store'])->name('review.store');
Route::post('/review/{review}/helpful', [\App\Http\Controllers\Frontend\ReviewController::class, 'helpful'])->name('review.helpful');

Route::get('/notification/unread-count', [\App\Http\Controllers\Frontend\NotificationController::class, 'unreadCount'])->name('notification.unread-count');
Route::get('/notification/latest', [\App\Http\Controllers\Frontend\NotificationController::class, 'latest'])->name('notification.latest');

Route::get('/flash-sale', [\App\Http\Controllers\Frontend\FlashSaleController::class, 'index'])->name('flash-sale');

$staticPages = [
    'about' => ['title' => 'About Us', 'description' => 'Learn more about our company and mission'],
    'contact' => ['title' => 'Contact Us', 'description' => 'Get in touch with our team'],
    'faq' => ['title' => 'FAQ', 'description' => 'Frequently asked questions about our products and services', 'schema' => true],
    'blog' => ['title' => 'Blog', 'description' => 'Read our latest articles and news'],
    'terms' => ['title' => 'Terms & Conditions', 'description' => 'Terms and conditions for using our store'],
    'privacy-policy' => ['title' => 'Privacy Policy', 'description' => 'Our privacy policy and data handling practices'],
    'shipping-policy' => ['title' => 'Shipping Policy', 'description' => 'Shipping information and delivery times'],
    'refund-policy' => ['title' => 'Refund Policy', 'description' => 'Our return and refund policy'],
];

foreach ($staticPages as $routeName => $pageData) {
    Route::get('/' . $routeName, function () use ($routeName, $pageData) {
        $seo = app(SEOService::class);
        $seo->setTitle($pageData['title']);
        $seo->setDescription($pageData['description']);

        if (!empty($pageData['schema']) && $routeName === 'faq') {
            $faqSchema = [
                '@context' => 'https://schema.org',
                '@type' => 'FAQPage',
                'mainEntity' => [
                    [
                        '@type' => 'Question',
                        'name' => 'How do I place an order?',
                        'acceptedAnswer' => ['@type' => 'Answer', 'text' => 'Simply browse our shop, add products to your cart, and proceed to checkout. You can pay using credit/debit cards, PayPal, or other available payment methods.'],
                    ],
                    [
                        '@type' => 'Question',
                        'name' => 'What is the shipping policy?',
                        'acceptedAnswer' => ['@type' => 'Answer', 'text' => 'We offer free shipping on all orders over $50. Standard shipping takes 3-5 business days. Express shipping (1-2 business days) is available at checkout for an additional fee.'],
                    ],
                    [
                        '@type' => 'Question',
                        'name' => 'How do I return a product?',
                        'acceptedAnswer' => ['@type' => 'Answer', 'text' => 'You can return most items within 30 days of delivery. Go to your order history, select the order, and click "Return Item." Refunds are processed within 5-7 business days after we receive the returned item.'],
                    ],
                    [
                        '@type' => 'Question',
                        'name' => 'Can I cancel or modify my order?',
                        'acceptedAnswer' => ['@type' => 'Answer', 'text' => 'You can cancel or modify your order within 1 hour of placing it. After that, the order may have already been processed for shipping. Please contact our support team immediately if you need to make changes.'],
                    ],
                    [
                        '@type' => 'Question',
                        'name' => 'How do I track my order?',
                        'acceptedAnswer' => ['@type' => 'Answer', 'text' => 'Once your order ships, you\'ll receive a tracking number via email. You can use this number to track your package on our website or the carrier\'s website.'],
                    ],
                    [
                        '@type' => 'Question',
                        'name' => 'Do you offer international shipping?',
                        'acceptedAnswer' => ['@type' => 'Answer', 'text' => 'Currently, we only ship within the country. We are working on expanding our shipping services internationally.'],
                    ],
                    [
                        '@type' => 'Question',
                        'name' => 'How do I create an account?',
                        'acceptedAnswer' => ['@type' => 'Answer', 'text' => 'Click the "Register" button at the top of the page and fill in your details. Having an account allows you to track orders, save items to your wishlist, and enjoy a faster checkout experience.'],
                    ],
                    [
                        '@type' => 'Question',
                        'name' => 'What payment methods do you accept?',
                        'acceptedAnswer' => ['@type' => 'Answer', 'text' => 'We accept Visa, MasterCard, American Express, PayPal, and bank transfers. All transactions are processed securely using SSL encryption.'],
                    ],
                ],
            ];
            $seo->addSchema($faqSchema);
        }

        $seoData = $seo->build();

        return view('frontend.' . $routeName, compact('seoData') + [
            'breadcrumbLabel' => $pageData['title'],
        ]);
    })->name($routeName);
}

require __DIR__.'/seo.php';
require __DIR__.'/auth.php';
