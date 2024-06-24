<?php

use App\Http\Controllers\Api\Advertisement\AdvertisementApiController;
use App\Http\Controllers\Api\CategoryApiController;
use App\Http\Controllers\Api\ChatApiController;
use App\Http\Controllers\Api\NationalityApiController;
use App\Http\Controllers\Api\PagesApiController;
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

Route::group(['middleware' => ['throttle:100,1', 'api-language']], function () {

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

    //Public Routes
    Route::get('nationalities', [NationalityApiController::class, 'index']);
    Route::get('categories', [CategoryApiController::class, 'index']);
    Route::get('categories/{id}', [CategoryApiController::class, 'listChild']);
    Route::get('static-pages/{page}', [PagesApiController::class, 'getPage']);
    Route::get('banner', [PagesApiController::class, 'getBanner']);

    Route::group(['prefix' => 'advertisement'], function () {
        Route::get('/filter', [AdvertisementApiController::class, 'filter']);
        Route::get('/filter/{type}', [AdvertisementApiController::class, 'filterHomeProducts']);
//        Route::get('/filter/more', [AdvertisementApiController::class, 'moreAds']);
        Route::get('/{advertisement}/related', [AdvertisementApiController::class, 'relatedAds']);
        Route::get('/{id}/show', [AdvertisementApiController::class, 'show']);
        Route::get('/{id}/comments', [AdvertisementApiController::class, 'listComments']);
    });

    // Authed Routes
    Route::group(['middleware' => ['auth:api']], function () {
        Route::group(['prefix' => 'users'], function () {
            Route::get('logout', [LogoutApiController::class, 'logout']);
            Route::get('profile', [UserApiController::class, 'getProfile']);
            Route::post('profile', [UserApiController::class, 'update']);
            Route::delete('profile', [UserApiController::class, 'deleteAccount']);
            Route::post('password/change', [UserApiController::class, 'changePassword']);
            Route::get('notifications', [UserApiController::class, 'getNotifications']);
            Route::get('notifications/read', [UserApiController::class, 'markAsReadNotifications']);
            Route::get('notifications/read/{id}', [UserApiController::class, 'markAsReadNotification']);

            Route::group(['prefix' => 'commissions'], function () {
                Route::post('pay-card', [UserApiController::class, 'payCommissionByCard']);
                Route::get('{id}/pay-wallet', [UserApiController::class, 'payCommissionByWallet']);
                Route::get('/', [UserApiController::class, 'listCommissions']);
            });

            Route::group(['prefix' => 'wallet'], function () {
                Route::get('show', [UserApiController::class, 'showWallet']);
                Route::post('recharge', [UserApiController::class, 'rechargeWallet']);
            });

            Route::group(['prefix' => 'cards'], function () {
                Route::get('/', [UserApiController::class, 'listCards']);
                Route::post('/', [UserApiController::class, 'addCard']);
            });

            // advertisement
            Route::group(['prefix' => 'advertisement'], function () {
                Route::post('/', [AdvertisementApiController::class, 'create']);
                Route::get('/', [AdvertisementApiController::class, 'index']);
                Route::get('/{id}/show', [AdvertisementApiController::class, 'details']);
                Route::post('/{id}/update', [AdvertisementApiController::class, 'update']);
                Route::delete('/{id}/delete/{media_id}/media', [AdvertisementApiController::class, 'deleteAdsMedia']);
                Route::post('/{id}/offers', [AdvertisementApiController::class, 'addOffers']);
//                Route::get('/{id}/offers', [AdvertisementApiController::class, 'listOffers']);
                Route::put('/{id}/offers/{offerId}', [AdvertisementApiController::class, 'updateOffers']);
                Route::post('/{id}/chat', [AdvertisementApiController::class, 'chatWithAdmin']);
                Route::get('/{id}/chat', [AdvertisementApiController::class, 'listChatWithAdmin']);
                Route::get('/favourites', [AdvertisementApiController::class, 'myFavourites']);
                Route::get('/{id}/favourite/add', [AdvertisementApiController::class, 'addToFavourite']);
                Route::get('/{id}/favourite/remove', [AdvertisementApiController::class, 'removeFromFavourite']);
                Route::post('/{id}/report', [AdvertisementApiController::class, 'reportAds']);
                Route::post('/{id}/comments', [AdvertisementApiController::class, 'addComment']);
                Route::put('/{id}/comments/{commentId}', [AdvertisementApiController::class, 'updateComment']);
                Route::delete('/{id}/comments/{commentId}', [AdvertisementApiController::class, 'deleteComment']);
                Route::post('/{id}/comments/{commentId}/report', [AdvertisementApiController::class, 'reportComment']);
                Route::get('/{id}/comments/{commentId}/follow', [AdvertisementApiController::class, 'followComment']);
                Route::get('/{id}/comments/{commentId}/unfollow', [AdvertisementApiController::class, 'unFollowComment']);
                Route::get('/{id}/purchased', [AdvertisementApiController::class, 'purchasedProduct']);
                Route::get('/{id}/actions/{action}', [AdvertisementApiController::class, 'addAction']);
            });

            // Chat
            Route::group(['prefix' => 'chat'], function () {
                Route::get('/', [UserApiController::class, 'listChats']);
                Route::get('/start-chat/{id}', [UserApiController::class, 'startChat']);
                Route::get('/{id}/messages', [UserApiController::class, 'listChatMessages']);
                Route::get('/{id}/messages/mark-as-read', [UserApiController::class, 'markChatAsRead']);
                Route::post('/send', [UserApiController::class, 'sendMessage']);
            });
        });
    });
});