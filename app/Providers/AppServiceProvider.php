<?php

namespace App\Providers;

use App\Models\Banha\AppSetting;
use App\Models\TamoTech\Settings;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $migrationsPath = database_path('migrations');
        $directories = glob($migrationsPath . '/*', GLOB_ONLYDIR);
        $paths = array_merge([$migrationsPath], $directories);

        $this->loadMigrationsFrom($paths);

        $this->app->singleton('settings', function () {
            return Settings::with('translations')->first();
        });
        $this->app->singleton('app-settings', function () {
            return AppSetting::with('translations')->first();
        });
        View::composer('*', function ($view) {
            $view->with('settings', app('settings'))
                ->with('app_settings', app('app-settings'));
        });

    }
}
