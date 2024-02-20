<?php

use App\Http\Controllers\Api\CategoryApiController;
use App\Http\Controllers\Api\NationalityApiController;
use App\Http\Controllers\Api\User\Auth\LoginApiController;
use App\Http\Controllers\Api\User\Auth\LogoutApiController;
use App\Http\Controllers\Api\User\Auth\PasswordResetTokenAPIController;
use App\Http\Controllers\Api\User\Auth\RegisterApiController;
use App\Http\Controllers\Api\User\Auth\SocialAuthApiController;
use App\Http\Controllers\Api\User\UserApiController;
use Illuminate\Http\Request;
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

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::group(['middleware' => ['throttle:10,1', 'api-language']], function () {

    // social routes
    Route::post('social/auth/{provider}', [SocialAuthApiController::class, 'authenticateWithProvider']);
    Route::get('social/auth/{provider}/callback', [SocialAuthApiController::class, 'handleProviderCallback']);


    // signup routes
    Route::group(['prefix' => 'users'], function () {
        Route::group(['prefix' => 'auth'], function () {
            // signup routes
            Route::post('signup', [RegisterApiController::class, 'register']);
            Route::post('login', [LoginApiController::class, 'login']);
            Route::post('login', [LoginApiController::class, 'login']);
            Route::post('password/forget', [PasswordResetTokenAPIController::class, 'sendResetLink']);
            Route::post('password/reset', [PasswordResetTokenAPIController::class, 'resetPassword']);
        });
    });
    Route::get('nationalities', [NationalityApiController::class, 'index']);
    Route::get('categories', [CategoryApiController::class, 'index']);
    Route::get('categories/{id}', [CategoryApiController::class, 'listChild']);

    // Authed Routes
    Route::group(['middleware' => ['auth:api']], function () {
        Route::group(['prefix' => 'users'], function () {
            Route::get('logout', [LogoutApiController::class, 'logout']);
            Route::get('profile', [UserApiController::class, 'getProfile']);
            Route::post('profile', [UserApiController::class, 'update']);
            Route::delete('profile', [UserApiController::class, 'deleteAccount']);
            Route::post('password/change', [UserApiController::class, 'changePassword']);
        });
    });
});