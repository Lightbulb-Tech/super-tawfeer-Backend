<?php

use App\Http\Controllers\FirebaseController;
use App\Http\Controllers\TamoTech\Authentication\AuthController;
use App\Http\Middleware\CheckAuth;
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
        Route::controller(AuthController::class)->group(function () {
            Route::get('/', 'loginPage')->name('login');
            Route::post('/login/check', 'checkLogin')->name('checkLogin');
            Route::get('/logout', 'logout')->name('logout')->middleware(CheckAuth::class);
        });

});



