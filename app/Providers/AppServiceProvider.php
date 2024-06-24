<?php

namespace App\Providers;

use App\Services\CategoryService;
use App\Services\NationalityService;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            \Backpack\PermissionManager\app\Http\Controllers\UserCrudController::class, //this is package controller
            \App\Http\Controllers\Admin\AdminCrudController::class //this should be your own controller
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //check if the table exists
        if (Schema::hasTable('categories')) {
            View::share("menuCategories", (new CategoryService())->listCatsToMenu());
        } else {
            View::share("menuCategories", []);
        }

        if (Schema::hasTable('nationalities')) {
            View::share("countries", (new NationalityService())->listToMenu());
        } else {
            View::share("countries", []);
        }
    }
}
