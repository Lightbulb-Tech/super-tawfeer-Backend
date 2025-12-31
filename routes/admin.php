<?php

use App\Http\Controllers\TamoTech\Authentication\AdminController;
use App\Http\Controllers\TamoTech\Authentication\ProfileController;
use App\Http\Controllers\TamoTech\Backup\BackupController;
use App\Http\Controllers\TamoTech\Commands\CommandController;
use App\Http\Controllers\TamoTech\DashboardController;
use App\Http\Controllers\TamoTech\Env\EnvController;
use App\Http\Controllers\TamoTech\FileManager\FileManagerController;
use App\Http\Controllers\TamoTech\Permission\PermissionController;
use App\Http\Controllers\TamoTech\Permission\RoleController;
use App\Http\Controllers\TamoTech\Settings\SettingsController;
use App\Http\Controllers\TamoTech\Terminal\TerminalController;
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
            Route::resource('dashboard', DashboardController::class);
            Route::resource('admins', AdminController::class);
            Route::resource('profile', ProfileController::class);
            Route::resource('settings', SettingsController::class);
            Route::resource('roles', RoleController::class);
            Route::resource('permissions', PermissionController::class);
            Route::resource('env', EnvController::class);
            Route::resource('commands', CommandController::class);
            Route::resource('file-manager', FileManagerController::class);
            Route::resource('terminal', TerminalController::class);
        });
    });

});
Route::get('/makeBackup', [BackupController::class, 'makeBackup'])->name('backup');


