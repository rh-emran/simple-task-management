<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Schema;
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
        Schema::defaultStringLength(191);

        Blade::if('can', function ($permission) {
            return auth()->check() && auth()->user()->hasPermission($permission);
        });

        Blade::if('canAny', function ($permissions) {
            if (is_array($permissions)) {
                return auth()->check() && auth()->user()->hasAnyPermission($permissions);
            }

            return auth()->check() && auth()->user()->hasAnyPermission([$permissions]);
        });
    }
}
