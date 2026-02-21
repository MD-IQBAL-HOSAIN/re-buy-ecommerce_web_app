<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\Web\Backend\FaqController;
use App\Http\Controllers\Web\Backend\ColorController;
use App\Http\Controllers\Web\Backend\OrderController;
use App\Http\Controllers\Web\Backend\BannerController;
use App\Http\Controllers\Web\Backend\ProductController;
use App\Http\Controllers\Web\Backend\ProjectController;
use App\Http\Controllers\Web\Backend\StorageController;
use App\Http\Controllers\Web\Backend\LanguageController;
use App\Http\Controllers\RefurbishedElectronicController;
use App\Http\Controllers\Web\Backend\ConditionController;
use App\Http\Controllers\Web\Backend\DashboardController;
use App\Http\Controllers\Web\Backend\HowItWorksController;
use App\Http\Controllers\Web\Backend\SystemUserController;
use App\Http\Controllers\Web\Backend\AccessoriesController;
use App\Http\Controllers\Web\Backend\BuyCategoryController;
use App\Http\Controllers\Web\Backend\DynamicPageController;
use App\Http\Controllers\Web\Backend\ReviewRatingsController;
use App\Http\Controllers\Web\Backend\BuySubcategoryController;
use App\Http\Controllers\Web\Backend\WhatLikeToSellController;
use App\Http\Controllers\Web\Backend\CustomerDetailsController;
use App\Http\Controllers\Web\Backend\SellElectronicsController;
use App\Http\Controllers\Web\Backend\HowItWorksHeaderController;
use App\Http\Controllers\Web\Backend\BuyCategoryHeaderController;
use App\Http\Controllers\Web\Backend\ProtectionServiceController;
use App\Http\Controllers\Web\Backend\FeatureDeviceHeaderController;
use App\Http\Controllers\Web\Backend\SellElectronicsHeaderController;
use App\Http\Controllers\Web\Backend\ProtectionServiceHeaderController;
use App\Http\Controllers\Web\Backend\RefurbishedElectronicsHeaderController;
use App\Http\Controllers\Web\Backend\TrustFeatureController;
use App\Http\Controllers\Web\Backend\TrustFeatureHeaderController;
use App\Http\Controllers\Web\Backend\SellProductController;
use App\Http\Controllers\Web\Backend\QuestionController;
use App\Http\Controllers\Web\Backend\QuestionAnswerController;

Route::group(['as' => 'backend.'], function () {

    require_once __DIR__ . '/queue.php';

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::resource('project', ProjectController::class)->except(['show']);

    //!Route for F.A.Q
    Route::controller(FaqController::class)->group(function () {
        Route::get('/faq/list', 'index')->name('faq.index');
        Route::get('/faq/create', 'create')->name('faq.create');
        Route::post('/faq/store', 'store')->name('faq.store');
        Route::get('/faq/edit/{id}', 'edit')->name('faq.edit');
        Route::put('/faq/update/{id}', 'update')->name('faq.update');
        Route::get('/faq/show/{id}', 'show')->name('faq.show');
        Route::get('/faq/status/{id}', 'status')->name('faq.status');
        Route::delete('/faq/delete/{id}', 'destroy')->name('faq.destroy');
    });

    //optional route for Page
    Route::post('page/status/{id}', [PageController::class, 'status'])->name('page.status');
    Route::resource('page', PageController::class)->except(['show']);

    Route::post('system-user/status/{id}', [SystemUserController::class, 'status'])
        ->name('system-user.status');

    Route::resource('system-user', SystemUserController::class)
        ->except(['show']);

    require_once __DIR__ . '/settings.php';
});

/**
 * without prefix route
 */

// Routes for Dynamic Page
Route::controller(DynamicPageController::class)->group(function () {
    Route::get('/dynamic', 'index')->name('dynamic.index');
    Route::get('/dynamic/create', 'create')->name('dynamic.create');
    Route::post('/dynamic/store', 'store')->name('dynamic.store');
    Route::get('/dynamic/edit/{id}', 'edit')->name('dynamic.edit');
    Route::get('/dynamic/show/{id}', 'show')->name('dynamic.show');
    Route::post('/dynamic/update/{id}', 'update')->name('dynamic.update');
    Route::get('/dynamic/status/{id}', 'status')->name('dynamic.status');
    Route::delete('/dynamic/delete/{id}', 'destroy')->name('dynamic.destroy');
});

//! Route for Language
Route::controller(LanguageController::class)->group(function () {
    Route::get('/language', 'index')->name('language.index');
    Route::get('/language/create', 'create')->name('language.create');
    Route::post('/language/store', 'store')->name('language.store');
    Route::get('/language/edit/{id}', 'edit')->name('language.edit');
    Route::put('/language/update/{id}', 'update')->name('language.update');
    Route::get('/language/status/{id}', 'status')->name('language.status');
    Route::delete('/language/destroy/{id}', 'destroy')->name('language.destroy');
});


/*
|--------------------------------------------------------------------------
| Buy Parts Modules Start
|--------------------------------------------------------------------------
|
*/

//! Route for Buy-Category Header
Route::controller(BuyCategoryHeaderController::class)->group(function () {
    Route::get('/buy-category-header/edit', 'edit')->name('buy-category-header.edit');
    Route::post('/buy-category-header/update', 'update')->name('buy-category-header.update');
});

//! Route for Buy-Category
Route::controller(BuyCategoryController::class)->group(function () {
    Route::get('/buy-category', 'index')->name('buy-category.index');
    Route::get('/buy-category/create', 'create')->name('buy-category.create');
    Route::post('/buy-category/store', 'store')->name('buy-category.store');
    Route::get('/buy-category/edit/{id}', 'edit')->name('buy-category.edit');
    Route::get('/buy-category/show/{id}', 'show')->name('buy-category.show');
    Route::post('/buy-category/update/{id}', 'update')->name('buy-category.update');
    Route::get('/buy-category/status/{id}', 'status')->name('buy-category.status');
    Route::delete('/buy-category/delete/{id}', 'destroy')->name('buy-category.destroy');
});

//! Route for Buy-Subcategory
Route::controller(BuySubcategoryController::class)->group(function () {
    Route::get('/buy-subcategory', 'index')->name('buy-subcategory.index');
    Route::get('/buy-subcategory/create', 'create')->name('buy-subcategory.create');
    Route::post('/buy-subcategory/store', 'store')->name('buy-subcategory.store');
    Route::get('/buy-subcategory/edit/{id}', 'edit')->name('buy-subcategory.edit');
    Route::get('/buy-subcategory/show/{id}', 'show')->name('buy-subcategory.show');
    Route::post('/buy-subcategory/update/{id}', 'update')->name('buy-subcategory.update');
    Route::get('/buy-subcategory/status/{id}', 'status')->name('buy-subcategory.status');
    Route::delete('/buy-subcategory/delete/{id}', 'destroy')->name('buy-subcategory.destroy');
});


//! Route for Color
Route::controller(ColorController::class)->group(function () {
    Route::get('/color', 'index')->name('color.index');
    Route::get('/color/create', 'create')->name('color.create');
    Route::post('/color/store', 'store')->name('color.store');
    Route::get('/color/edit/{id}', 'edit')->name('color.edit');
    Route::get('/color/show/{id}', 'show')->name('color.show');
    Route::post('/color/update/{id}', 'update')->name('color.update');
    Route::delete('/color/delete/{id}', 'destroy')->name('color.destroy');
});

//! Route for Condition
Route::controller(ConditionController::class)->group(function () {
    Route::get('/condition', 'index')->name('condition.index');
    Route::get('/condition/create', 'create')->name('condition.create');
    Route::post('/condition/store', 'store')->name('condition.store');
    Route::get('/condition/edit/{id}', 'edit')->name('condition.edit');
    Route::get('/condition/show/{id}', 'show')->name('condition.show');
    Route::post('/condition/update/{id}', 'update')->name('condition.update');
    Route::delete('/condition/delete/{id}', 'destroy')->name('condition.destroy');
});

//! Route for Storage
Route::controller(StorageController::class)->group(function () {
    Route::get('/storage', 'index')->name('storage.index');
    Route::get('/storage/create', 'create')->name('storage.create');
    Route::post('/storage/store', 'store')->name('storage.store');
    Route::get('/storage/edit/{id}', 'edit')->name('storage.edit');
    Route::get('/storage/show/{id}', 'show')->name('storage.show');
    Route::post('/storage/update/{id}', 'update')->name('storage.update');
    Route::delete('/storage/delete/{id}', 'destroy')->name('storage.destroy');
});


//! Route for Protection Service Header
Route::controller(ProtectionServiceHeaderController::class)->group(function () {
    Route::get('/protection-service-header/edit', 'edit')->name('protection-service-header.edit');
    Route::post('/protection-service-header/update', 'update')->name('protection-service-header.update');
});

//! Route for Protection Service
Route::controller(ProtectionServiceController::class)->group(function () {
    Route::get('/protection-service', 'index')->name('protection-service.index');
    Route::get('/protection-service/create', 'create')->name('protection-service.create');
    Route::post('/protection-service/store', 'store')->name('protection-service.store');
    Route::get('/protection-service/edit/{id}', 'edit')->name('protection-service.edit');
    Route::get('/protection-service/show/{id}', 'show')->name('protection-service.show');
    Route::post('/protection-service/update/{id}', 'update')->name('protection-service.update');
    Route::get('/protection-service/status/{id}', 'status')->name('protection-service.status');
    Route::delete('/protection-service/delete/{id}', 'destroy')->name('protection-service.destroy');
});

//! Route for Accessories
Route::controller(AccessoriesController::class)->group(function () {
    Route::get('/accessory', 'index')->name('accessory.index');
    Route::get('/accessory/create', 'create')->name('accessory.create');
    Route::post('/accessory/store', 'store')->name('accessory.store');
    Route::get('/accessory/edit/{id}', 'edit')->name('accessory.edit');
    Route::get('/accessory/show/{id}', 'show')->name('accessory.show');
    Route::post('/accessory/update/{id}', 'update')->name('accessory.update');
    Route::get('/accessory/status/{id}', 'status')->name('accessory.status');
    Route::delete('/accessory/delete/{id}', 'destroy')->name('accessory.destroy');
});

//! Route for Product
Route::controller(ProductController::class)->group(function () {
    Route::get('/product', 'index')->name('product.index');
    Route::get('/product/create', 'create')->name('product.create');
    Route::post('/product/store', 'store')->name('product.store');
    Route::get('/product/edit/{id}', 'edit')->name('product.edit');
    Route::get('/product/show/{id}', 'show')->name('product.show');
    Route::post('/product/update/{id}', 'update')->name('product.update');
    Route::post('/product/import-csv', 'importCsv')->name('product.import-csv');
    Route::delete('/product/bulk-delete', 'bulkDestroy')->name('product.bulk-destroy');
    Route::get('/product/status/{id}', 'status')->name('product.status');
    Route::delete('/product/delete/{id}', 'destroy')->name('product.destroy');
    Route::get('/product/get-subcategories', 'getSubcategories')->name('product.get-subcategories');
});

//! Route for Refurbished Electronics Header
Route::controller(RefurbishedElectronicsHeaderController::class)->group(function () {
    Route::get('/refurbished-electronics-header/edit', 'edit')->name('refurbished-electronics-header.edit');
    Route::post('/refurbished-electronics-header/update', 'update')->name('refurbished-electronics-header.update');
});

//! Route for Refurbished Electronics
Route::controller(RefurbishedElectronicController::class)->group(function () {
    Route::get('/refurbished-electronics', 'index')->name('refurbished-electronics.index');
    Route::get('/refurbished-electronics/create', 'create')->name('refurbished-electronics.create');
    Route::post('/refurbished-electronics/store', 'store')->name('refurbished-electronics.store');
    Route::get('/refurbished-electronics/edit/{id}', 'edit')->name('refurbished-electronics.edit');
    Route::get('/refurbished-electronics/show/{id}', 'show')->name('refurbished-electronics.show');
    Route::post('/refurbished-electronics/update/{id}', 'update')->name('refurbished-electronics.update');
    Route::delete('/refurbished-electronics/delete/{id}', 'destroy')->name('refurbished-electronics.destroy');
});

//! Route for Banner
Route::controller(BannerController::class)->group(function () {
    Route::get('/banner/edit', 'edit')->name('banner.edit');
    Route::post('/banner/update', 'update')->name('banner.update');
});

//! Route for Feature Device Header
Route::controller(FeatureDeviceHeaderController::class)->group(function () {
    Route::get('/feature-device-header/edit', 'edit')->name('feature-device-header.edit');
    Route::post('/feature-device-header/update', 'update')->name('feature-device-header.update');
});

//! Route for Review Ratings Header
Route::controller(ReviewRatingsController::class)->group(function () {
    Route::get('/review-ratings', 'index')->name('review-ratings.index');
    Route::get('/review-ratings/show/{id}', 'show')->name('review-ratings.show');
    Route::get('/review-ratings/status/{id}', 'status')->name('review-ratings.status');
    Route::delete('/review-ratings/delete/{id}', 'destroy')->name('review-ratings.destroy');
    Route::get('/review-ratings-header/edit', 'edit')->name('review-ratings-header.edit');
    Route::post('/review-ratings-header/update', 'update')->name('review-ratings-header.update');
});

//! Route for Customer Details
Route::controller(CustomerDetailsController::class)->group(function () {
    Route::get('/customer-details/edit', 'edit')->name('customer-details.edit');
    Route::post('/customer-details/update', 'update')->name('customer-details.update');
});

//! Route for orders and order details
Route::controller(OrderController::class)->group(function () {
    Route::get('/order/list', 'index')->name('order.index');
    Route::get('/order/show/{id}', 'show')->name('order.show');
    Route::get('/order/status/{id}', 'status')->name('order.status');
    Route::delete('/order/delete/{id}', 'destroy')->name('order.destroy');
});







/*
|--------------------------------------------------------------------------
| Sell Parts Modules Start
|--------------------------------------------------------------------------
|
*/

//! Route for sell your Electronics Header
Route::controller(SellElectronicsHeaderController::class)->group(function () {
    Route::get('/sell-electronics-header/edit', 'edit')->name('sell-electronics-header.edit');
    Route::post('/sell-electronics-header/update', 'update')->name('sell-electronics-header.update');
});

//! Route for sell your Electronics
Route::controller(SellElectronicsController::class)->group(function () {
    Route::get('/sell-electronics', 'index')->name('sell-electronics.index');
    Route::get('/sell-electronics/create', 'create')->name('sell-electronics.create');
    Route::post('/sell-electronics/store', 'store')->name('sell-electronics.store');
    Route::get('/sell-electronics/edit/{id}', 'edit')->name('sell-electronics.edit');
    Route::get('/sell-electronics/show/{id}', 'show')->name('sell-electronics.show');
    Route::post('/sell-electronics/update/{id}', 'update')->name('sell-electronics.update');
    Route::delete('/sell-electronics/delete/{id}', 'destroy')->name('sell-electronics.destroy');
});


//! Route for What would you like to sell? (Header for sell category)
Route::controller(WhatLikeToSellController::class)->group(function () {
    Route::get('/what-like-to-sell/edit', 'edit')->name('what-like-to-sell.edit');
    Route::post('/what-like-to-sell/update', 'update')->name('what-like-to-sell.update');
});


//! Route for how it works cms Header
Route::controller(HowItWorksHeaderController::class)->group(function () {
    Route::get('/how-it-works-header/edit', 'edit')->name('how-it-works-header.edit');
    Route::post('/how-it-works-header/update', 'update')->name('how-it-works-header.update');
});

//! Route for how it works cms
Route::controller(HowItWorksController::class)->group(function () {
    Route::get('/how-it-works', 'index')->name('how-it-works.index');
    Route::get('/how-it-works/create', 'create')->name('how-it-works.create');
    Route::post('/how-it-works/store', 'store')->name('how-it-works.store');
    Route::get('/how-it-works/edit/{id}', 'edit')->name('how-it-works.edit');
    Route::get('/how-it-works/show/{id}', 'show')->name('how-it-works.show');
    Route::post('/how-it-works/update/{id}', 'update')->name('how-it-works.update');
    Route::delete('/how-it-works/delete/{id}', 'destroy')->name('how-it-works.destroy');
});

//! Route for Trust Features Header
Route::controller(TrustFeatureHeaderController::class)->group(function () {
    Route::get('/trust-feature-header/edit', 'edit')->name('trust-feature-header.edit');
    Route::post('/trust-feature-header/update', 'update')->name('trust-feature-header.update');
});

//! Route for Trust Features (Items)
Route::controller(TrustFeatureController::class)->group(function () {
    Route::get('/trust-feature', 'index')->name('trust-feature.index');
    Route::get('/trust-feature/create', 'create')->name('trust-feature.create');
    Route::post('/trust-feature/store', 'store')->name('trust-feature.store');
    Route::get('/trust-feature/edit/{id}', 'edit')->name('trust-feature.edit');
    Route::post('/trust-feature/update/{id}', 'update')->name('trust-feature.update');
    Route::delete('/trust-feature/delete/{id}', 'destroy')->name('trust-feature.destroy');
});

// Routes for Sell products - Protected Access
Route::controller(SellProductController::class)->group(function () {
    Route::get('/sell-products', 'index')->name('sell-products.index');
    Route::get('/sell-products/create', 'create')->name('sell-products.create');
    Route::post('/sell-products/store', 'store')->name('sell-products.store');
    Route::get('/sell-products/edit/{id}', 'edit')->name('sell-products.edit');
    Route::post('/sell-products/update/{id}', 'update')->name('sell-products.update');
    Route::get('/sell-products/show/{id}', 'show')->name('sell-products.show');
    Route::delete('/sell-products/delete/{id}', 'destroy')->name('sell-products.destroy');
});

//! Route for Sell products Questions - Protected Access
Route::controller(QuestionController::class)->group(function () {
    Route::get('/question', 'index')->name('question.index');
    Route::get('/question/create', 'create')->name('question.create');
    Route::post('/question/store', 'store')->name('question.store');
    Route::get('/question/edit/{id}', 'edit')->name('question.edit');
    Route::get('/question/show/{id}', 'show')->name('question.show');
    Route::post('/question/update/{id}', 'update')->name('question.update');
    Route::delete('/question/delete/{id}', 'destroy')->name('question.destroy');
});

//! Route for Question Answers - Protected Access
Route::controller(QuestionAnswerController::class)->group(function () {
    Route::get('/question-answers', 'index')->name('question-answers.index');
    Route::get('/question-answers/show/{id}', 'show')->name('question-answers.show');
    Route::delete('/question-answers/delete/{id}', 'destroy')->name('question-answers.destroy');
});
