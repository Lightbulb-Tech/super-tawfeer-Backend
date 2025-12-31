<?php

use App\Http\Controllers\Api\AddressController;
use App\Http\Controllers\Api\AllProductsController;
use App\Http\Controllers\Api\AppSettingsController;
use App\Http\Controllers\Api\AreaController;
use App\Http\Controllers\Api\Auth\ConfirmCodeController;
use App\Http\Controllers\Api\Auth\LogoutController;
use App\Http\Controllers\Api\Auth\RefreshTokenController;
use App\Http\Controllers\Api\Auth\SendCodeController;
use App\Http\Controllers\Api\Auth\UserController;
use App\Http\Controllers\Api\CancelExternalOrderController;
use App\Http\Controllers\Api\CancelOrderController;
use App\Http\Controllers\Api\CancelReservationController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\CartCountController;
use App\Http\Controllers\Api\ChangeAddressController;
use App\Http\Controllers\Api\CheckCouponController;
use App\Http\Controllers\Api\CompleteExternalOrderController;
use App\Http\Controllers\Api\CompleteOrderController;
use App\Http\Controllers\Api\CompleteReservationController;
use App\Http\Controllers\Api\CountriesController;
use App\Http\Controllers\Api\CurrentExternalOrderController;
use App\Http\Controllers\Api\CurrentOrderController;
use App\Http\Controllers\Api\CurrentReservationController;
use App\Http\Controllers\Api\ExternalOrderController;
use App\Http\Controllers\Api\FaqController;
use App\Http\Controllers\Api\FavouriteController;
use App\Http\Controllers\Api\FavouriteProductsController;
use App\Http\Controllers\Api\FireBaseTokenController;
use App\Http\Controllers\Api\GovernorateController;
use App\Http\Controllers\Api\MadeInEgyptProductsController;
use App\Http\Controllers\Api\MadeInEgyptSubCategoryController;
use App\Http\Controllers\Api\MainCategoryController;
use App\Http\Controllers\Api\MainCategorySubCategoryController;
use App\Http\Controllers\Api\MakeOrderController;
use App\Http\Controllers\Api\MostSellingProductsController;
use App\Http\Controllers\Api\NewExternalOrderController;
use App\Http\Controllers\Api\NewOrderController;
use App\Http\Controllers\Api\NewReservationController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\OffersProductsController;
use App\Http\Controllers\Api\OffersSubCategoryController;
use App\Http\Controllers\Api\OrderCategoryController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\OurProductsController;
use App\Http\Controllers\Api\OurProductsSubCategoryController;
use App\Http\Controllers\Api\PointHistoriesController;
use App\Http\Controllers\Api\PointsTransferRequestController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ProductsForSubCategoryController;
use App\Http\Controllers\Api\ReadNotificationController;
use App\Http\Controllers\Api\ReasonCancellationController;
use App\Http\Controllers\Api\ReservationController;
use App\Http\Controllers\Api\SearchProductController;
use App\Http\Controllers\Api\SliderController;
use App\Http\Controllers\Api\TotalPointHistoriesController;
use App\Http\Controllers\Api\TotalWalletController;
use App\Http\Controllers\Api\UnReadNotificationCountController;
use App\Http\Controllers\Api\VehicleController;
use App\Http\Controllers\Api\WalletHistoriesController;
use App\Http\Controllers\Banha\CompleteReservationsController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group(['middleware' => ['lang', 'acceptJson', 'checkBlockedUser']], function () {
    Route::group(['prefix' => 'auth'], function () {
        Route::resource('send-code', SendCodeController::class);
        Route::resource('confirm-code', ConfirmCodeController::class);

        // routes with auth prefix and auth middleware
        Route::middleware('auth:api')->group(function () {
            Route::resource('firebase-token', FireBaseTokenController::class);
            Route::resource('logout', LogoutController::class);
            Route::resource('refresh-token', RefreshTokenController::class);
            Route::resource('users', UserController::class);
        });
    });
    Route::middleware('auth:api')->group(function () {
        Route::resource('countries', CountriesController::class);
        Route::resource('governorate', GovernorateController::class);
        Route::resource('areas', AreaController::class);
        Route::resource('addresses', AddressController::class);
        Route::resource('change-address', ChangeAddressController::class);
    });
    Route::resource('main-categories', MainCategoryController::class);
    Route::resource('all-products', AllProductsController::class);
    Route::resource('main-category-sub-categories', MainCategorySubCategoryController::class);
    Route::resource('products-for-sub-category', ProductsForSubCategoryController::class);
    Route::resource('made-in-egypt-products', MadeInEgyptProductsController::class);
    Route::resource('made-in-egypt-sub-categories', MadeInEgyptSubCategoryController::class);
    Route::resource('offers-products', OffersProductsController::class);
    Route::resource('offers-sub-categories', OffersSubCategoryController::class);
    Route::resource('our-products', OurProductsController::class);
    Route::resource('our-products-sub-categories', OurProductsSubCategoryController::class);
    Route::resource('products', ProductController::class);
    Route::resource('most-selling-products', MostSellingProductsController::class);
    Route::resource('sliders', SliderController::class);
    Route::resource('vehicles', VehicleController::class);
    Route::resource('order-categories', OrderCategoryController::class);
    Route::resource('reservations', ReservationController::class);
    Route::resource('new-reservations', NewReservationController::class);
    Route::resource('current-reservations', CurrentReservationController::class);
    Route::resource('complete-reservations', CompleteReservationController::class);
    Route::resource('cancel-reservations', CancelReservationController::class);
    Route::resource('external-order', ExternalOrderController::class);
    Route::resource('new-external-order', NewExternalOrderController::class);
    Route::resource('current-external-order', CurrentExternalOrderController::class);
    Route::resource('cancel-external-order', CancelExternalOrderController::class);
    Route::resource('complete-external-order', CompleteExternalOrderController::class);
    Route::middleware('auth:api')->group(function () {
        Route::resource('favourites', FavouriteController::class);
        Route::resource('carts', CartController::class);
        Route::resource('cart-counts', CartCountController::class);
        Route::resource('reason-cancellations', ReasonCancellationController::class);
        Route::resource('new-orders', NewOrderController::class);
        Route::resource('current-orders', CurrentOrderController::class);
        Route::resource('complete-orders', CompleteOrderController::class);
        Route::resource('make-order', MakeOrderController::class);
        Route::resource('check-coupon', CheckCouponController::class);
        Route::resource('points-histories', PointHistoriesController::class);
        Route::resource('total-points-histories', TotalPointHistoriesController::class);
        Route::resource('favourite-products', FavouriteProductsController::class);
        Route::resource('faqs', FaqController::class);
        Route::resource('app-settings', AppSettingsController::class);
        Route::resource('cancel-order', CancelOrderController::class);
        Route::resource('points-transfer-request', PointsTransferRequestController::class);
        Route::resource('total-wallets', TotalWalletController::class);
        Route::resource('wallet-history', WalletHistoriesController::class);
        Route::resource('orders', OrderController::class);
        Route::resource('search-products', SearchProductController::class);
        Route::resource('notifications', NotificationController::class);
        Route::resource('read-notifications', ReadNotificationController::class);
        Route::resource('un-read-notifications-count', UnReadNotificationCountController::class);
    });


});
