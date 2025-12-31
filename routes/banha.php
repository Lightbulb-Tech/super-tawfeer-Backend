<?php

use App\Http\Controllers\Banha\AddressController;
use App\Http\Controllers\Banha\AppSettingController;
use App\Http\Controllers\Banha\AreaActiveController;
use App\Http\Controllers\Banha\AreaController;
use App\Http\Controllers\Banha\BrandController;
use App\Http\Controllers\Banha\CanceledOrderController;
use App\Http\Controllers\Banha\CanceledReservationsController;
use App\Http\Controllers\Banha\CancelExternalOrderController;
use App\Http\Controllers\Banha\ChooseDriverToExternalOrderController;
use App\Http\Controllers\Banha\ChooseDriverToOrderController;
use App\Http\Controllers\Banha\CompleteExternalOrderController;
use App\Http\Controllers\Banha\CompleteOrderController;
use App\Http\Controllers\Banha\CompleteReservationsController;
use App\Http\Controllers\Banha\CountryController;
use App\Http\Controllers\Banha\CouponActiveController;
use App\Http\Controllers\Banha\CouponController;
use App\Http\Controllers\Banha\CurrentExternalOrderController;
use App\Http\Controllers\Banha\CurrentOrderController;
use App\Http\Controllers\Banha\CurrentReservationsController;
use App\Http\Controllers\Banha\DriverController;
use App\Http\Controllers\Banha\FaqController;
use App\Http\Controllers\Banha\GeneralNotificationsController;
use App\Http\Controllers\Banha\GetAvailableDriversController;
use App\Http\Controllers\Banha\GetAvailableDriversToExternalOrdersController;
use App\Http\Controllers\Banha\GovernorateController;
use App\Http\Controllers\Banha\ImportProductController;
use App\Http\Controllers\Banha\InvoiceController;
use App\Http\Controllers\Banha\MainCategoryActiveController;
use App\Http\Controllers\Banha\MainCategoryController;
use App\Http\Controllers\Banha\MostDriverDeliveriesController;
use App\Http\Controllers\Banha\MostProductsOrderedController;
use App\Http\Controllers\Banha\MostProductsSoldController;
use App\Http\Controllers\Banha\NewExternalOrderController;
use App\Http\Controllers\Banha\NewOrderController;
use App\Http\Controllers\Banha\NewReservationsController;
use App\Http\Controllers\Banha\OrderCategoryActiveController;
use App\Http\Controllers\Banha\OrderCategoryController;
use App\Http\Controllers\Banha\PointsHistoriesController;
use App\Http\Controllers\Banha\PointsTransferRequestsController;
use App\Http\Controllers\Banha\ProductActiveController;
use App\Http\Controllers\Banha\ProductAttributeController;
use App\Http\Controllers\Banha\ProductController;
use App\Http\Controllers\Banha\ProductImageController;
use App\Http\Controllers\Banha\ProductWithZeroQuantityController;
use App\Http\Controllers\Banha\ReasonCancellationController;
use App\Http\Controllers\Banha\RegisterFinalPriceToExternalOrderController;
use App\Http\Controllers\Banha\SliderController;
use App\Http\Controllers\Banha\StoreController;
use App\Http\Controllers\Banha\SubCategoriesForMainCategoryController;
use App\Http\Controllers\Banha\SubCategoryController;
use App\Http\Controllers\Banha\UpdateExternalOrderStatusController;
use App\Http\Controllers\Banha\UpdateOrderStatusController;
use App\Http\Controllers\Banha\UpdateReservationStatusController;
use App\Http\Controllers\Banha\UserController;
use App\Http\Controllers\Banha\VehicleActiveController;
use App\Http\Controllers\Banha\VehicleController;
use App\Http\Controllers\Banha\WalletHistoriesController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
    ], function () {
    Route::group(['prefix' => "dashboard"], function () {
        Route::group(["middleware" => ["checkAuth", 'checkPermission']], function () {
            Route::resource('countries', CountryController::class);
            Route::resource('reason-cancellation', ReasonCancellationController::class);
            Route::resource('governorates', GovernorateController::class);
            Route::resource('areas', AreaController::class);
            Route::resource('area-active', AreaActiveController::class);
            Route::resource('users', UserController::class);
            Route::resource('users-address', AddressController::class);
            Route::resource('stores', StoreController::class);
            Route::resource('main-categories', MainCategoryController::class);
            Route::resource('sub-categories', SubCategoryController::class);
            Route::resource('main-categories-active', MainCategoryActiveController::class);
            Route::resource('products', ProductController::class);
            Route::resource('products-with-zero-quantity', ProductWithZeroQuantityController::class);
            Route::resource('product-attribute', ProductAttributeController::class);
            Route::resource('product-images', ProductImageController::class);
            Route::resource('product-active', ProductActiveController::class);
            Route::resource('subCategories-for-mainCategory', SubCategoriesForMainCategoryController::class);
            Route::resource('faqs', FaqController::class);
            Route::resource('coupons', CouponController::class);
            Route::resource('coupon-active', CouponActiveController::class);
            Route::resource('points-transfer-requests', PointsTransferRequestsController::class);
            Route::resource('app-settings', AppSettingController::class);
            Route::resource('import-products', ImportProductController::class);
            Route::resource('new-orders', NewOrderController::class);
            Route::resource('current-orders', CurrentOrderController::class);
            Route::resource('complete-orders', CompleteOrderController::class);
            Route::resource('canceled-orders', CanceledOrderController::class);
            Route::resource('update-order-status', UpdateOrderStatusController::class);
            Route::resource('points-histories', PointsHistoriesController::class);
            Route::resource('wallet-histories', WalletHistoriesController::class);
            Route::resource('sliders', SliderController::class);
            Route::resource('drivers', DriverController::class);
            Route::resource('brands', BrandController::class);
            Route::resource('general-notifications', GeneralNotificationsController::class);
            Route::resource('get-available-drivers', GetAvailableDriversController::class);
            Route::resource('choose-driver-to-order', ChooseDriverToOrderController::class);
            Route::resource('most-products-sold', MostProductsSoldController::class);
            Route::resource('most-products-ordered', MostProductsOrderedController::class);
            Route::resource('most-drivers-deliveries', MostDriverDeliveriesController::class);
            Route::resource('invoices', InvoiceController::class);
            Route::resource('vehicles', VehicleController::class);
            Route::resource('vehicle-active', VehicleActiveController::class);
            Route::resource('order-categories', OrderCategoryController::class);
            Route::resource('order-category-active', OrderCategoryActiveController::class);
            Route::resource('new-reservations', NewReservationsController::class);
            Route::resource('current-reservations', CurrentReservationsController::class);
            Route::resource('complete-reservations', CompleteReservationsController::class);
            Route::resource('cancel-reservations', CanceledReservationsController::class);
            Route::resource('update-reservation-status', UpdateReservationStatusController::class);
            Route::resource('new-external-orders', NewExternalOrderController::class);
            Route::resource('current-external-orders', CurrentExternalOrderController::class);
            Route::resource('complete-external-orders', CompleteExternalOrderController::class);
            Route::resource('cancel-external-orders', CancelExternalOrderController::class);
            Route::resource('update-external-order-status', UpdateExternalOrderStatusController::class);
            Route::resource('get-drivers-for-external-orders', GetAvailableDriversToExternalOrdersController::class);
            Route::resource('choose-driver-to-external-order', ChooseDriverToExternalOrderController::class);
            Route::resource('register-final-to-external-order', RegisterFinalPriceToExternalOrderController::class);


        });
    });

});

Route::view('test','banha.invoices.index');


