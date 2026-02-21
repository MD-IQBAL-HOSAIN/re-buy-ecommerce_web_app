<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\BannerController;
use App\Http\Controllers\API\ReviewController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\OrderHistoryController;
use App\Http\Controllers\API\FcmTokenController;
use App\Http\Controllers\API\FilterDataController;
use App\Http\Controllers\API\BuyCategoryController;
use App\Http\Controllers\API\DynamicPageController;
use App\Http\Controllers\API\SocialLoginController;
use App\Http\Controllers\API\FeatureDeviceController;
use App\Http\Controllers\API\ProtectionServiceController;
use App\Http\Controllers\API\RefurbishedElectronicController;
use App\Http\Controllers\API\CustomerInformationController;
use App\Http\Controllers\API\TrustFeatureApiController;
use App\Http\Controllers\API\SellElectronicsApiController;
use App\Http\Controllers\API\SellProductApiController;
use App\Http\Controllers\API\WhatLikeToSellApiController;
use App\Http\Controllers\API\HowItWorksApiController;
use App\Http\Controllers\API\QuestionAnswerApiController;

/*
|--------------------------------------------------------------------------
| without jwt api middleware
|--------------------------------------------------------------------------
|
*/

Route::controller(AuthController::class)->group(function () {
    Route::post('/register', 'register');
    Route::post('/login', 'login');
    Route::post('/password/forgot', 'forgotPassword');
    Route::post('/password/reset', 'resetPassword');
    Route::post('/password/resend-otp', 'resendOtp');
    Route::post('/password/verify-otp', 'verifyOtp');
});

//Continue with google,facebook and apple login
Route::controller(SocialLoginController::class)->group(function () {
    Route::post('/social/login', 'socialLogin');
    Route::post('/guest/login', 'guestLogin');
});

// Routes for Reviews & Ratings - Public Access
Route::controller(ReviewController::class)->group(function () {
    Route::get('/reviews', 'index');
});

// Routes for Banner - Public Access
Route::controller(BannerController::class)->group(function () {
    Route::get('/banner', 'index');
});

// Routes for Refurbished Electronics - Public Access
Route::controller(RefurbishedElectronicController::class)->group(function () {
    Route::get('/refurbished-electronics', 'index');
});

// Routes for Buy Categories - Public Access
Route::controller(BuyCategoryController::class)->group(function () {
    Route::get('/buy-categories', 'index');
});

// Routes for Feature Devices - Public Access
Route::controller(FeatureDeviceController::class)->group(function () {
    Route::get('/feature-devices', 'index');
});

// Routes for Protection Services - Public Access
Route::controller(ProtectionServiceController::class)->group(function () {
    Route::get('/protection-services', 'index');
});

// Routes for Filter Data (Categories, Brands(Subcategories), Colors, Conditions, Storages) - Public Access
Route::controller(FilterDataController::class)->group(function () {
    Route::get('/filter-data', 'index');
});

// Routes for Products - Public Access
Route::controller(ProductController::class)->group(function () {
    Route::get('/products', 'index');
    //id or slug both will work for product details
    Route::get('/products/{idOrSlug}', 'show');
});

// Route for Cart Payment with Stripe - Protected Access
Route::controller(PaymentController::class)->group(function () {
    Route::get('/payment/success', 'success')->name('payment.success');
    Route::get('/payment/cancel', 'cancel')->name('payment.cancel');
});

// Routes for Trust Feature - Public Access
Route::controller(TrustFeatureApiController::class)->group(function () {
    Route::get('/trust-feature', 'index');
});

// Routes for Sell Electronics - Public Access
Route::controller(SellElectronicsApiController::class)->group(function () {
    Route::get('/sell-electronics', 'index');
});

// Routes for 'What would you like to sell?' - Public Access
Route::controller(WhatLikeToSellApiController::class)->group(function () {
    Route::get('/what-like-to-sell', 'index');
    Route::get('/what-like-to-sell/sub-category/{id}', 'getSubCategories');
    Route::get('/what-like-to-sell/product/{id}', 'getProductsBySubCategory');

});

// Routes for 'How It Works' - Public Access
Route::controller(HowItWorksApiController::class)->group(function () {
    Route::get('/how-it-works/cms', 'index');
});

// Routes for sell products - Public Access
Route::controller(SellProductApiController::class)->group(function () {
    Route::get('/sell-products', 'index');
});

// Routes for sell product questions - Public Access
Route::controller(QuestionAnswerApiController::class)->group(function () {
    Route::get('/sell-products/questions/{sellProductId}', 'questionsBySellProduct');
});






/*
|--------------------------------------------------------------------------
| with jwt middlware api
|--------------------------------------------------------------------------
|
*/
// Throttle: max 60 requests per minute
Route::middleware(['auth:api', 'throttle:60,1'])->group(function () {

    Route::controller(AuthController::class)->group(function () {
        Route::post('logout', 'logout');
        Route::post('refresh', 'refresh');
        Route::post('/profile', 'profile');
        Route::delete('/delete-account', 'deleteAccount');
        Route::post('/profile/update/user', 'ProfileUpdate');
        Route::post('/password/update/user', 'ChangePassword');
        Route::get('/user/profile/get', 'profileRetrieval');
    });

    // Routes for Dynamic Page
    Route::controller(DynamicPageController::class)->group(function () {
        Route::get('dynamic-page', 'index');
        Route::get('faq-list', 'faq');
    });

    //Route for Fcm token store
    Route::controller(FcmTokenController::class)->group(function () {
        Route::post('/fcm/token/store', 'store');
        Route::delete('/fcm/token/delete/{id}', 'destroy');
    });

    // Routes for Reviews & Ratings - Protected Access
    Route::controller(ReviewController::class)->group(function () {
        Route::post('/reviews', 'store');
    });

    //! Routes for Cart Management - Protected Access
    Route::controller(CartController::class)->group(function () {
        Route::post('/add-to-cart', 'addToCart');
        Route::get('/cart', 'viewCart');
        Route::post('/cart/quantity-plus/{id}', 'incrementCartQuantity');
        Route::post('/cart/quantity-minus/{id}', 'decrementCartQuantity');
        Route::delete('/cart/remove/{id}', 'removeCartItem');
    });

    // Route for Cart Payment with Stripe - Protected Access
    Route::controller(PaymentController::class)->group(function () {
        Route::post('/stripe-checkout', 'payWithStripe');
    });

    // Routes for Customer Information - Protected Access
    Route::controller(CustomerInformationController::class)->group(function () {
        Route::post('/customer-information', 'store');
    });

    // Routes for Question Answers - Protected Access
    Route::controller(QuestionAnswerApiController::class)->group(function () {
        Route::get('/question-answers', 'index');
        Route::post('/question-answers', 'store');
        //after submit the question answer user can update it.
        Route::post('/pick-up-details', 'storePickUpDetails');
    });

    // Routes for Order History - Protected Access
    Route::controller(OrderHistoryController::class)->group(function () {
        Route::get('/orders/history', 'index');
        Route::get('/orders/{id}', 'show');
    });
});

//no need now. when frontend needed then we will implement it
require_once __DIR__ . '/frontend/dashboard.php';
require_once __DIR__ . '/frontend/payments.php';
