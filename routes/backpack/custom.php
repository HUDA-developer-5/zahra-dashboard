<?php

use Illuminate\Support\Facades\Route;

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\Base.
// Routes you generate using Backpack\Generators will be placed here.

Route::get('home', function () {
    return redirect()->to('/');
});

Route::group([
    'namespace' => 'App\Http\Controllers\Admin',
    'middleware' => config('backpack.base.web_middleware', 'web'),
    'prefix' => config('backpack.base.route_prefix'),
],
    function () {
        // if not otherwise configured, setup the auth routes
        if (config('backpack.base.setup_auth_routes')) {
            // Authentication Routes...
            Route::get('login', 'Auth\LoginController@showLoginForm')->name('backpack.auth.login');
            Route::post('login', 'Auth\LoginController@login');
            Route::get('logout', 'Auth\LoginController@logout')->name('backpack.auth.logout');
            Route::post('logout', 'Auth\LoginController@logout');
        }
    });

// Admin Routes
Route::group([
    'prefix' => config('backpack.base.route_prefix', 'admin'),
    'middleware' => array_merge(
        (array)config('backpack.base.web_middleware', 'web'),
        (array)config('backpack.base.middleware_key', 'admin'),
    ),
    'namespace' => 'App\Http\Controllers\Admin',
], function () {
    Route::crud('admin', 'AdminCrudController');
    Route::crud('user', 'UserCrudController');
    Route::crud('nationality', 'NationalityCrudController');
    Route::crud('state', 'StateCrudController');
    Route::crud('city', 'CityCrudController');
    Route::crud('category', 'CategoryCrudController');
    Route::crud('premium-commission', 'PremiumCommissionCrudController');
    Route::crud('free-commission', 'FreeCommissionCrudController');
    Route::crud('dynamic-page', 'DynamicPageCrudController');
    Route::crud('banner', 'BannerCrudController');
});