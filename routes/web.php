<?php

use App\Http\Controllers\Api\User\Auth\PasswordResetTokenAPIController;
use App\Http\Controllers\Api\User\Auth\SocialAuthApiController;
use App\Http\Controllers\Payment\PaymentWebHookController;
use App\Http\Controllers\Web\HomeWebController;
use App\Http\Controllers\Web\PaymentWebController;
use App\Http\Controllers\Web\UserRegisterWebController;
use App\Http\Controllers\Web\UserWebController;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use Lunaweb\Localization\Facades\Localization;
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
Route::get('/reset-password/{token}', [PasswordResetTokenAPIController::class, 'showResetPasswordPage'])->name('reset_password');
Route::get('states/{country_id}', [HomeWebController::class, 'getStates']);
Route::get('cities/{state_id}', [HomeWebController::class, 'getCities']);

// social routes
Route::get('social/auth/{provider}', [SocialAuthApiController::class, 'authenticateWithProvider'])->name('social.auth-provider');
Route::any('social/auth/{provider}/callback', [SocialAuthApiController::class, 'handleProviderCallback']);

Route::group(['middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'localize'], 'prefix' => LaravelLocalization::setLocale()], function () {

    Livewire::setUpdateRoute(function ($handle) {
        return Route::post('/livewire/update', $handle);
    });

    Livewire::setScriptRoute(function ($handle) {
        return Route::get('/livewire/livewire.js', $handle);
    });

    // signup routes
    Route::group(['prefix' => 'users'], function () {
        Route::group(['prefix' => 'auth'], function () {
            // signup routes
            Route::post('signup', [UserRegisterWebController::class, 'register'])->name('register');
            Route::post('login', [UserRegisterWebController::class, 'login'])->name('login');
            Route::get('login', function () {
                return redirect()->route('web.home');
            });
            Route::post('password/forget', [PasswordResetTokenAPIController::class, 'sendResetLinkWeb'])->name('password.forget');
            Route::post('password/reset', [PasswordResetTokenAPIController::class, 'resetPassword'])->name('password.reset');
        });
    });


    // get subCategories using ajax
    Route::get('/categories/{parentId}/subcategories', [HomeWebController::class, 'getSubCategories']);
    Route::get('/categories/{parentId}/subcategoriesUsingView', [HomeWebController::class, 'getSubCategoriesUsingView']);

    Route::get('/comments/{productId}', [HomeWebController::class, 'getComments'])->name('comments.get');
    Route::post('/comments/add', [HomeWebController::class, 'addComment'])->name('comments.add');
    Route::post('/comments/edit/{commentId}', [HomeWebController::class, 'editComment'])->name('comments.edit');
    Route::delete('/comments/delete/{commentId}', [HomeWebController::class, 'deleteComment'])->name('comments.delete');





    Route::get('get-featured-ads', [HomeWebController::class, 'getFeaturedAds'])->name('web.get_featured_ads');
    Route::get('get-latest-ads', [HomeWebController::class, 'getLatestAds'])->name('web.get_latest_ads');
    Route::get('/', [HomeWebController::class, 'index'])->name('web.home');
    Route::post('/change-lang', [HomeWebController::class, 'changeLanguage'])->name('web.change_lang');
    Route::get('/categories', [HomeWebController::class, 'listCategories'])->name('web.categories');
    Route::get('/categories/{id}', [HomeWebController::class, 'listCategories'])->name('web.show_category');
    Route::post('/subscribe', [HomeWebController::class, 'subscribeNewsletter'])->name('web.subscribe');
    Route::get('/contact-us', [HomeWebController::class, 'showContactUs'])->name('web.contactus.show');
    Route::post('/contact-us', [HomeWebController::class, 'storeContactUs'])->name('web.contactus.store');
    Route::get('/about-us', [HomeWebController::class, 'showAboutus'])->name('web.aboutus.show');
    Route::get('/how-to-be-premium', [HomeWebController::class, 'showPremiumPage'])->name('web.premium.show');
    Route::post('/add-comment-guest/{id}', [HomeWebController::class, 'addCommentGuest'])->name('web.comments.add.guest-user');
    Route::group(['prefix' => 'products'], function () {
        Route::get('/translate/{id}', [HomeWebController::class, 'translateProduct'])->name('web.products.translate');
        Route::get('/search', [HomeWebController::class, 'filterProducts'])->name('web.products.search');
        Route::get('/menu-search', [HomeWebController::class, 'searchProductsFromMenu'])->name('web.search.menu');
        Route::get('/{id}', [HomeWebController::class, 'showProduct'])->name('web.products.show');
    });


    Route::group(['middleware' => ['auth:users']], function () {
        Route::get('profile', [UserWebController::class, 'profile'])->name('profile');
        Route::get('notifications', [UserWebController::class, 'showNotifications'])->name('web.notifications.list');
        Route::post('profile', [UserWebController::class, 'updateProfile'])->name('web.update_profile');
        Route::post('change-password', [UserWebController::class, 'changePassword'])->name('web.change_password');
        Route::get('delete-account', [UserWebController::class, 'deleteAccount'])->name('web.delete_account');
        Route::get('logout', [UserWebController::class, 'logout'])->name('web.logout');
        Route::get('/favourites', [HomeWebController::class, 'myFavourites'])->name('web.favourite.list');
        Route::get('/wallet', [HomeWebController::class, 'myWallet'])->name('wallet');
        Route::get('/my-commissions', [HomeWebController::class, 'myCommission'])->name('web.my-commissions.list');
        Route::post('/my-commissions', [HomeWebController::class, 'payMyCommission'])->name('web.my-commissions.pay');
        Route::get('/pay-my-commissions/{id}', [HomeWebController::class, 'payMyCommissionWithCard'])->name('web.my-commissions.payWithCard');
        Route::get('/my-cards', [HomeWebController::class, 'listMyCards'])->name('web.my-cards.list');
        Route::get('/my-products', [HomeWebController::class, 'myProducts'])->name('web.my-products.list');
        Route::get('/add-products', [HomeWebController::class, 'showAddProduct'])->name('web.products.add');
        Route::post('/store-product', [HomeWebController::class, 'storeProduct'])->name('web.products.save');
        Route::get('/product/{id}/edit', [HomeWebController::class, 'showEditProduct'])->name('web.products.edit');
        Route::post('/product/{id}/update', [HomeWebController::class, 'updateProduct'])->name('web.products.update');

        Route::group(['prefix' => 'products'], function () {
            Route::post('/{id}/report', [HomeWebController::class, 'reportAds'])->name('web.products.report');
            Route::get('/{id}/favourite/add', [HomeWebController::class, 'addToFavourite'])->name('web.products.favourite.add');
            Route::get('/{id}/favourite/remove', [HomeWebController::class, 'removeFromFavourite'])->name('web.products.favourite.remove');
            Route::post('/{id}/comments', [HomeWebController::class, 'addComment'])->name('web.comments.add');
            Route::get('/{id}/comments/{commentId}', [HomeWebController::class, 'deleteComment'])->name('web.comments.delete');
            Route::post('/{id}/comments/{commentId}', [HomeWebController::class, 'updateComment'])->name('web.comments.update');
            Route::post('/{id}/comments/{commentId}/report', [HomeWebController::class, 'reportComment'])->name('web.comments.report');
            Route::get('/{id}/comments/{commentId}/follow', [HomeWebController::class, 'followComment'])->name('web.comments.follow');
            Route::get('/{id}/comments/{commentId}/unfollow', [HomeWebController::class, 'unFollowComment'])->name('web.comments.unFollow');
            Route::get('/{id}/purchased', [HomeWebController::class, 'purchasedProduct'])->name('web.products.purchased');
            Route::get('/{id}/actions/{action}', [HomeWebController::class, 'addAction'])->name('web.products.action');
            Route::post('/{id}/offers', [HomeWebController::class, 'addOffers'])->name('web.products.addOffer');
            Route::get('/{id}/offers/{offerId}/{status}', [HomeWebController::class, 'updateOfferStatus'])->name('web.products.updateOffer');
            Route::get('/get-premium-discount/{amount}', [HomeWebController::class, 'getPremiumAdsDiscount'])->name('web.products.getPremiumDiscount');
            Route::post('/pay-premium-discount', [HomeWebController::class, 'payMyPremiumProduct'])->name('web.my-premium-product.pay');
        });

        Route::group(['prefix' => 'payment'], function () {
            Route::post('/process-payment', [PaymentWebController::class, 'processPayment'])->name('web.pay.process');
            Route::post('/charge-wallet', [PaymentWebController::class, 'submitChargeWallet'])->name('web.wallet.recharge');
            Route::post('/pay-my-commissions', [PaymentWebController::class, 'submitPayMyCommissionWithCard'])->name('web.pay.payCommissionWithCard');
            Route::post('/pay-premium', [PaymentWebController::class, 'payPremiumSubscription'])->name('web.pay.premium');
            Route::get('/pay-premium/card', [PaymentWebController::class, 'payPremiumSubscriptionWithCard'])->name('web.premium.payWithCard');
            Route::post('/pay-premium/card', [PaymentWebController::class, 'submitPremiumSubscriptionWithCard'])->name('web.premium.payWithCard.submit');
        });

        Route::group(['prefix' => 'messages'], function () {
            Route::get('/', [HomeWebController::class, 'listChats'])->name('web.chats.list');
            Route::get('/start-chat/{id}', [HomeWebController::class, 'startChat'])->name('web.chats.start');
            Route::post('/send', [HomeWebController::class, 'sendMessage'])->name('web.chats.send');
        });
    });

    Route::get('/page/{slug}', [HomeWebController::class, 'showDynamicPage'])->name('web.dynamic.show');
});

Route::any('payment-webhook/{provider}', [PaymentWebHookController::class, 'handleWebhook'])->name('payment.webhook');
if (App::environment(['local', 'development', 'staging', 'production'])) {
    Route::any('/update-me', function () {
        $output = [];
        $retval = null;
        exec('cd /public_html/zahra-dashboard/ && git pull 2>&1', $output, $retval);
        if (App::environment(['local', 'development', 'staging'])) {
            exec('cd /public_html/zahra-dashboard/ && composer install && php artisan migrate && php artisan config:clear && php artisan route:cache 2>&1', $output, $retval); //&& php artisan package:discover --ansi
//            exec('cd /public_html/zahra-dashboard/ && apidoc -i ./app/Http -o ./apidoc 2>&1', $output,$retval);
        }
        print_r($output);
        print_r($retval);
        echo "<br/>";
        return 'Go Ahead .....>>>> Thanks :)';
    });
}
