<?php

namespace App\Http\Controllers\Web;

use App\Enums\Advertisement\AdvertisementPriceTypeEnums;
use App\Enums\Advertisement\AdvertisementTypeEnums;
use App\Enums\Advertisement\OfferStatusEnums;
use App\Enums\ChatTypeEnums;
use App\Enums\CommonStatusEnums;
use App\Enums\StaticPagesEnums;
use App\Helpers\GlobalHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Advertisement\AdvertisementApiRequest;
use App\Http\Requests\Api\Advertisement\CommentAdvertisementApiRequest;
use App\Http\Requests\Api\Advertisement\FilterAdvertisementApiRequest;
use App\Http\Requests\Api\Advertisement\OfferAdvertisementApiRequest;
use App\Http\Requests\Api\Advertisement\ReportAdvertisementApiRequest;
use App\Http\Requests\Api\Advertisement\UpdateAdvertisementApiRequest;
use App\Http\Requests\Api\PayCommissionRequest;
use App\Http\Requests\Web\ContactusWebRequest;
use App\Http\Requests\Web\SubscribeNewsletterWebRequest;
use App\Http\Resources\Api\Advertisement\SimpleAdvertisementApiResource;
use App\Http\Resources\Api\CityApiResource;
use App\Http\Resources\Api\StateApiResource;
use App\Models\City;
use App\Models\State;
use App\Services\Advertisement\AdvertisementService;
use App\Services\CategoryService;
use App\Services\ChatMessageService;
use App\Services\DynamicPageService;
use App\Services\NationalityService;
use App\Services\NotificationService;
use App\Services\PayCommissionService;
use App\Services\TranslationService;
use App\Services\User\UserService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use function PHPUnit\Framework\isFalse;

class HomeWebController extends Controller
{
    public function index(FilterAdvertisementApiRequest $request)
    {
        $token = $request->get('token');
        $ads = (new AdvertisementService())->filterAds($request);
        $categoryService = new CategoryService();
        $parentCategories = $categoryService->listParentCatsToHome();
        $allCats = $categoryService->listAllCats();
        $parent_cat_id = $request->get('parent_cat_id');
        $subCats = [];
        if (!$parent_cat_id && $parentCategories) {
            $parent_cat_id = $parentCategories->first()?->id;
        }
        if ($parent_cat_id) {
            $subCats = $categoryService->listChild($parent_cat_id);
        }
        $data = [
            'parentCategories' => $parentCategories,
            'subCategories' => $subCats,
            'cities' => (new NationalityService())->listCitiesToFilter(),
            'latest' => $ads['latest'],
//            'moreList' => $ads['more'],
            'featured' => $ads['featured'],
            'parent_cat_id' => $parent_cat_id,
            'token' => $token,
            'termsAndConditions' => (new DynamicPageService())->getPage(StaticPagesEnums::TermsAndConditions->value),
            'banner' => (new AdvertisementService())->getActiveBanner(),
            'allCats' => $allCats
        ];
        return view('frontend.home.index')->with($data);
    }

    public function changeLanguage(Request $request)
    {
        $lang = $request->get('language');
        $country_id = $request->get('country_id');
        if ($lang && in_array($lang, LaravelLocalization::getSupportedLanguagesKeys())) {
            app()->setLocale($lang);
        } else {
            $default = app()->getLocale();
            app()->setLocale($default);
        }

        if ($country_id) {
            Session::put('country_id', $country_id);
        }
        return redirect()->to('/' . $lang);
    }

    public function listCategories(Request $request)
    {
        $search = $request->get('search');
        $subCats = null;
        $categoryService = new CategoryService();
        $parentCategories = $categoryService->listParentCatsToHome($search);
        $parent_cat_id = $request->get('category_id');
        if (!$parent_cat_id && $parentCategories) {
            $parent_cat_id = $parentCategories->first()?->id;
        }
        if ($parent_cat_id) {
            $subCats = $categoryService->listChild($parent_cat_id);
        }
        $selectedCat = $categoryService->find($parent_cat_id);
        $data = [
            'parentCategories' => $parentCategories,
            'subCategories' => $subCats,
            'selectedCat' => $selectedCat,
            'search' => $search,
        ];
        return view('frontend.category.index')->with($data);
    }

    public function filterProducts(Request $request)
    {
        $products = (new AdvertisementService())->filterAdsToWeb($request);
        $searchForCats = '';
        if ($request->get('categories_id')) {
            $searchForCats = implode(',', (new CategoryService())->getCategoriesByIds($request->get('categories_id'))->pluck('name')->toArray());
        }
        $data = [
            'products' => $products,
            'searchForCats' => $searchForCats
        ];
        return view('frontend.product.filter_products')->with($data);
    }

    public function searchProductsFromMenu(Request $request)
    {
        // filter in product by ajax call
        $products = (new AdvertisementService())->searchFromMenu($request->get('search'));
        $html = '';
        $success = false;
        if ($products->count()) {
            $success = true;
            foreach ($products as $product) {
                $html .= '
                <div class="d-flex gap-3 item">
                                <div class="img">
                                    <img src="' . $product->image_path . '" alt="' . $product->name . '"
                                         class="img-fluid">
                                </div>
                                <div class="item-details">
                                    <div class="d-flex justify-content-between fs-7 mb-1">
                                        <span class="cat text-secondary">#' . $product->category?->name . '</span>
                                        <span>  ' . $product->created_at->format('d/m/Y') . '</span>
                                    </div>
                                    <h6 class="title mb-0"><a href="' . route('web.products.show', $product->id) . '">' . $product->name . '</a></h6>
                                    <div class="location">
                                        <span class="icon me-2"><i class="fas fa-location-dot"></i></span>
                                        <span>' . $product->nationality?->name . ', ' . $product->state?->name . '</span>
                                    </div>
                                    <p class="price text-primary fw-bold mb-0">' . $product->price . $product->currency . '</p>
                                </div>
                            </div>';
            }
        }
        return response()->json(['success' => $success, 'html' => $html]);
    }

    public function showProduct(int $id, Request $request)
    {
        $advertisementService = new AdvertisementService();
        $advertisement = $advertisementService->findActiveAds($id, ['category', 'user', 'nationality', 'state', 'images', 'comments.user']);
        if (!$advertisement) {
            toastr()->error(trans('api.not found'));
            return redirect()->route('web.home');
        }
        // set social media attributes
        GlobalHelper::setMetaTagsAttributes($advertisement->name, $advertisement->description, $advertisement->image_path);
        $advertisementService->incrementViewCount($advertisement);
        if ($request->get('notification')) {
            // mark notification as read
            (new NotificationService())->markAsRead($request->get('notification'), auth('users')->id());
        }
        $data = [
            'product' => $advertisement,
            'relatedProducts' => (new AdvertisementService())->getRelatedAds($advertisement, 4),
        ];
        return view('frontend.product.show')->with($data);
    }

    public function reportAds(int $id, ReportAdvertisementApiRequest $request)
    {
        $advertisementService = new AdvertisementService();
        $advertisement = $advertisementService->findActiveAds($id);
        if (!$advertisement) {
            toastr()->error(trans('api.not found'));
            return redirect()->route('web.home');
        }
        $advertisementService->reportAd(auth('users')->user(), $advertisement, $request->get('comment'));
        toastr()->success(trans('api.added successfully'));
        return redirect()->route('web.products.show', $advertisement->id);
    }

    public function myFavourites()
    {
        $products = auth('users')->user()->favouritesAds;
        return view('frontend.favourite.index')->with('favouriteProducts', $products);
    }

    //addToFavourite
    public function addToFavourite(int $id)
    {
        $advertisementService = new AdvertisementService();
        $advertisement = $advertisementService->findActiveAds($id, ['category', 'user', 'nationality', 'state', 'images', 'comments.user']);
        if (!$advertisement) {
            toastr()->error(trans('api.not found'));
            return redirect()->route('web.home');
        }
        $advertisementService->addAdsToFavourite(auth('users')->user(), $advertisement);
        toastr()->success(trans('api.added successfully'));
        return redirect()->back();
    }

    //removeFromFavourite
    public function removeFromFavourite(int $id)
    {
        $advertisementService = new AdvertisementService();
        $advertisement = $advertisementService->findActiveAds($id, ['category', 'user', 'nationality', 'state', 'images', 'comments.user']);
        if (!$advertisement) {
            toastr()->error(trans('api.not found'));
            return redirect()->route('web.home');
        }
        $advertisementService->removeAdsFromFavourite(auth('users')->user(), $advertisement);
        toastr()->success(trans('api.deleted successfully'));
        return redirect()->back();
    }

    //addComment
    public function addComment(int $id, CommentAdvertisementApiRequest $request)
    {
        $advertisementService = new AdvertisementService();
        $advertisement = $advertisementService->findActiveAds($id);
        if (!$advertisement) {
            toastr()->error(trans('api.not found'));
            return redirect()->route('web.home');
        }
        $advertisementService->addComment(auth('users')->user(), $advertisement, $request->get('comment'), $request->get('parent'));
        toastr()->success(trans('api.added successfully'));
        return redirect()->route('web.products.show', $advertisement->id);
    }

    // updateComment
    public function updateComment(int $id, int $commentId, CommentAdvertisementApiRequest $request)
    {
        $advertisementService = new AdvertisementService();
        $advertisement = $advertisementService->findActiveAds($id);
        if (!$advertisement) {
            toastr()->error(trans('api.not found'));
            return redirect()->route('web.home');
        }
        $userComment = $advertisementService->getUserComment(auth('users')->user()->id, $advertisement->id, $commentId);
        if (!$userComment) {
            toastr()->error(trans('api.not found'));
            return redirect()->route('web.products.show', $advertisement->id);
        }
        if ($advertisementService->isCommentInPast($userComment)) {
            toastr()->error(trans('api.not allowed'));
            return redirect()->route('web.products.show', $advertisement->id);
        }
        $advertisementService->updateComment($userComment, $request->get('comment'));
        toastr()->success(trans('api.updated successfully'));
        return redirect()->route('web.products.show', $advertisement->id);
    }

    public function deleteComment(int $id, int $commentId)
    {

        $advertisementService = new AdvertisementService();
        $advertisement = $advertisementService->findActiveAds($id);
        if (!$advertisement) {
            toastr()->error(trans('api.not found'));
            return redirect()->route('web.home');
        }
        $userComment = $advertisementService->getUserComment(auth('users')->user()->id, $advertisement->id, $commentId);
        if (!$userComment) {
            toastr()->error(trans('api.not found'));
            return redirect()->route('web.home');
        }
        if ($advertisementService->isCommentInPast($userComment)) {
            toastr()->error(trans('api.not allowed'));
            return redirect()->route('web.products.show', $advertisement->id);
        }
        $advertisementService->deleteComment($userComment);
        toastr()->success(trans('api.deleted successfully'));
        return redirect()->route('web.products.show', $advertisement->id);
    }

    public function reportComment(int $id, int $commentId, ReportAdvertisementApiRequest $request)
    {
        $advertisementService = new AdvertisementService();
        $advertisement = $advertisementService->findActiveAds($id);
        if (!$advertisement) {
            toastr()->error(trans('api.not found'));
            return redirect()->route('web.home');
        }
        $reportedComment = $advertisementService->findComment($commentId);
        $user = auth('users')->user();
        if (!$reportedComment || $reportedComment->user_id == $user->id) {
            toastr()->error(trans('api.not allowed to report your comment'));
            return redirect()->route('web.products.show', $advertisement->id);
        }
        $advertisementService->reportComment($user, $advertisement, $reportedComment, $request->get('comment'));

        toastr()->success(trans('api.added successfully'));
        return redirect()->route('web.products.show', $advertisement->id);
    }

    public function followComment(int $id, int $commentId)
    {
        $advertisementService = new AdvertisementService();
        $advertisement = $advertisementService->findActiveAds($id);
        if (!$advertisement) {
            toastr()->error(trans('api.not found'));
            return redirect()->route('web.home');
        }
        $reportedComment = $advertisementService->findComment($commentId);
        $user = auth('users')->user();
        if (!$reportedComment || $reportedComment->user_id == $user->id) {
            toastr()->error(trans('api.not allowed to follow your comment'));
            return redirect()->route('web.products.show', $advertisement->id);
        }

        $advertisementService->followComment($user, $advertisement, $reportedComment);
        toastr()->success(trans('api.added successfully'));
        return redirect()->route('web.products.show', $advertisement->id);
    }

    public function unFollowComment(int $id, int $commentId)
    {
        $advertisementService = new AdvertisementService();
        $advertisement = $advertisementService->findActiveAds($id);
        if (!$advertisement) {
            toastr()->error(trans('api.not found'));
            return redirect()->route('web.home');
        }
        $reportedComment = $advertisementService->findComment($commentId);
        $user = auth('users')->user();
        if (!$reportedComment || $reportedComment->user_id == $user->id) {
            toastr()->error(trans('api.not allowed'));
            return redirect()->route('web.products.show', $advertisement->id);
        }

        $advertisementService->unFollowComment($user, $advertisement, $reportedComment);
        toastr()->success(trans('api.deleted successfully'));
        return redirect()->route('web.products.show', $advertisement->id);
    }

    public function myWallet()
    {
        $userService = new UserService();
        // list user payment methods from stripe
        $user = auth('users')->user();
        $cards = $userService->listUserCards($user);
        $intent = $userService->createSetupIntent($user);
        return view('frontend.profile.wallet')->with(['intent' => $intent->client_secret, 'cards' => $cards]);
    }

    public function myCommission()
    {
        $commissions = auth('users')->user()->commissions()->with('advertisement')->orderBy('is_paid', 'asc')->get();
        return view('frontend.profile.commission')->with(['commissions' => $commissions]);
    }

    public function payMyCommission(PayCommissionRequest $request)
    {
        return (new PayCommissionService())->payCommission(auth('users')->user(), $request->getDTO());
    }

    public function payMyCommissionWithCard($id)
    {
        $userService = new UserService();
        // list user payment methods from stripe
        $user = auth('users')->user();
        $cards = $userService->listUserCards($user);
        $intent = $userService->createSetupIntent($user);
        // get total amount to pay
        $totalAmount = (new PayCommissionService())->getCommissionAmount(auth('users')->user(), $id);
        return view('frontend.profile.pay_commission_by_card')->with([
            'intent' => $intent->client_secret,
            'cards' => $cards,
            'totalAmount' => $totalAmount,
            'commissionId' => $id
        ]);
    }

    public function showAddProduct(Request $request)
    {
        $user = auth('users')->user();
        $cards = (new UserService())->listUserCards($user);
        $allCategories = (new CategoryService())->listAllCats();
        $data = [
            'price_types' => AdvertisementPriceTypeEnums::asArray(),
            'premiumDetails' => (new DynamicPageService())->getPage(StaticPagesEnums::HowToBePremium->value),
            'cards' => $cards,
            'allCategories' => $allCategories
        ];
        return view('frontend.product.form')->with($data);
    }

    //save product
    public function storeProduct(AdvertisementApiRequest $request)
    {
        try {
            $user = auth('users')->user();
            $advertisementService = new AdvertisementService();
            $advertisement = $advertisementService->addNewAdvertisement($user, $request->getDTO());
            toastr()->success(trans('api.added successfully'));
            \session()->flash('advertisement_published', true);
            return redirect()->route('web.products.add');
        } catch (Exception $exception) {
            toastr()->error($exception->getMessage());
            return redirect()->route('web.products.add');
        }
    }

    public function showEditProduct(int $id)
    {
        $user = auth('users')->user();
        $advertisementService = new AdvertisementService();
        $product = $advertisementService->find($user, $id);
        if (!$product) {
            toastr()->error(trans('api.not found'));
            return redirect()->route('web.my-products.list');
        }
        $data = [
            'product' => $product,
            'price_types' => AdvertisementPriceTypeEnums::asArray(),
        ];
        return view('frontend.product.edit_form')->with($data);
    }

    //updateProduct AdvertisementApiRequest
    public function updateProduct(int $id, UpdateAdvertisementApiRequest $request)
    {
        $user = auth('users')->user();
        $advertisementService = new AdvertisementService();
        $product = $advertisementService->find($user, $id);
        if (!$product) {
            toastr()->error(trans('api.not found'));
            return redirect()->route('web.my-products.list');
        }

        if ($product->is_sold) {
            toastr()->error(trans('api.not allowed'));
            return redirect()->route('web.my-products.list');
        }

        $advertisementService->updateAds($product, $request->getDTO());
        toastr()->success(trans('api.updated successfully'));
        return redirect()->route('web.my-products.list');
    }

    public function myProducts()
    {
        $user = auth('users')->user();
        $products = (new AdvertisementService())->getAllUserAds($user);
        return view('frontend.profile.my_products')->with([
            'products' => $products
        ]);
    }

    public function getStates($country_id)
    {
        $states = State::where('nationality_id', '=', $country_id)->where('status', '=', CommonStatusEnums::Active->value)->get();
        return StateApiResource::collection($states);
    }

    public function getCities($state_id)
    {
        $cities = City::where('state_id', '=', $state_id)->where('status', '=', CommonStatusEnums::Active->value)->get();
        return CityApiResource::collection($cities);
    }

    public function listMyCards()
    {
        $user = auth('users')->user();
        $userService = new UserService();
        $cards = $userService->listUserCards($user);
        $intent = $userService->createSetupIntent($user);
        $data = [
            'cards' => $cards,
            'intent' => $intent->client_secret,
            'termsAndConditions' => (new DynamicPageService())->getPage(StaticPagesEnums::TermsAndConditions->value),
        ];
        return view('frontend.profile.my_cards')->with($data);
    }

    public function subscribeNewsletter(SubscribeNewsletterWebRequest $request)
    {
        (new UserService())->subscribeNewsletter($request->get('email'));
        toastr()->success(trans('web.subscribed successfully'));
        return redirect()->back();
    }

    public function showContactUs()
    {
        return view('frontend.static.contactus');
    }

    public function storeContactUs(ContactusWebRequest $request)
    {
        (new UserService())->storeContactus($request->getDTO());
        toastr()->success(trans('web.your message sent successfully'));
        return redirect()->route('web.contactus.show');
    }

    public function showAboutus()
    {
        return view('frontend.static.aboutus')->with(['dynamicPage' => (new DynamicPageService())->getAboutStatistic()]);
    }

    public function showPremiumPage()
    {
        $data = [
            'dynamicPage' => (new DynamicPageService())->getPage(StaticPagesEnums::HowToBePremium->value),
            'premiumUserSetting' => (new DynamicPageService())->getPremiumSetting(),
        ];
        return view('frontend.static.how_to_be_premium')->with($data);
    }

    public function showDynamicPage(string $slug)
    {
        $data = [
            'dynamicPage' => (new DynamicPageService())->getPage($slug),
            'title' => trans('web.' . $slug),
        ];
        return view('frontend.static.dynamic_page')->with($data);
    }

    public function addCommentGuest(int $id)
    {
        toastr()->error(trans('web.you need to login first'));
        return redirect()->route('web.products.show', ['id' => $id]);
    }

    public function purchasedProduct(int $id)
    {
        $user = auth('users')->user();
        $advertisementService = new AdvertisementService();
        $advertisement = $advertisementService->findActiveAds($id);
        if (!$advertisement) {
            toastr()->error(trans('api.not found'));
            return redirect()->route('web.home');
        }
        if ($advertisement->user_id == $user->id) {
            toastr()->error(trans('api.not allowed'));
            return redirect()->route('web.products.show', $advertisement->id);
        }

        if ($advertisementService->purchaseProduct($user, $advertisement)) {
            toastr()->success(trans('api.added successfully'));
        } else {
            toastr()->error(trans('api.not allowed'));
        }
        return redirect()->back();
    }

    public function addAction(int $id, string $action)
    {
        $advertisementService = new AdvertisementService();
        $advertisement = $advertisementService->findActiveAds($id);
        if (!$advertisement) {
            toastr()->error(trans('api.not found'));
            return redirect()->route('web.home');
        }

        $user = auth('users')->user();
        if ($advertisement->user_id == $user->id) {
            return response()->json(['success' => false]);
        }

        $advertisementService->addActionToAdvertisement($user, $advertisement, $action);
        return response()->json(['success' => true]);
    }

    public function addOffers(int $id, OfferAdvertisementApiRequest $request)
    {
        $user = auth('users')->user();
        $advertisementService = new AdvertisementService();
        $advertisement = $advertisementService->findPublic($id);
        if (!$advertisement || $advertisement->user_id == $user->id || $advertisement->is_sold) {
            toastr()->error(trans('api.not found'));
            return redirect()->route('web.products.show', ['id' => $id]);
        }
        $result = $advertisementService->addOffer($user, $advertisement, (float)$request->get('offer'));
        if (!$result['status']) {
            toastr()->error($result['message']);
        } else {
            toastr()->success($result['message']);
        }
        return redirect()->route('web.products.show', ['id' => $id]);
    }

    public function getPremiumAdsDiscount(int $amount)
    {
        $advertisementCommissionDetailsDTO = (new AdvertisementService())->calculatePremiumAmount($amount);
        // Total 1500 SR and Discount <span class="text-primary">20%</span> = 1000 SR

        return response()->json(['data' => trans('web.premium ad amount details', [
            'amount' => $amount,
            'commission' => $advertisementCommissionDetailsDTO->commission,
            'amount_after_commission' => $advertisementCommissionDetailsDTO->amount_after_commission,
            'currency' => auth('users')->user()->default_currency,
        ]),
            'amount_after_commission' => $advertisementCommissionDetailsDTO->amount_after_commission,
            'currency' => auth('users')->user()->default_currency,
        ]);
    }

    public function payMyPremiumProduct(Request $request)
    {
        return (new PayCommissionService())->payCommission(auth('users')->user(), $request->getDTO());
    }

    public function listChats(Request $request)
    {
        $user = auth('users')->user();
        if ($request->get('notification_id')) {
            (new NotificationService())->markAsRead($request->get('notification_id'), $user->id);
        }
        $chatMessagesService = new ChatMessageService();
        $data = [
            'chats' => $chatMessagesService->getUserChats($user->id, $request->get('search')),
            'total_unread_messages' => $chatMessagesService->getUserUnreadMessagesCount($user->id)
        ];

        if (!count($data['chats'])) {
            return view('frontend.messages.no_chats');
        }
        return view('frontend.messages.index')->with($data);
    }

    public function startChat(int $id)
    {
        $user = auth('users')->user();
        $advertisementService = new AdvertisementService();
        $advertisement = $advertisementService->findPublic($id);
        if (!$advertisement || $advertisement->user_id == $user->id) {
            toastr()->error(trans('api.not found'));
            return redirect()->route('web.home');
        }
        if ($advertisement->user_id) {
            $chatType = ChatTypeEnums::USER_TO_USER;
            $receiver_id = $advertisement->user_id;
        } else {
            $chatType = ChatTypeEnums::USER_TO_ADMIN;
            $receiver_id = $advertisement->admin_id;
        }
        $chatMessagesService = new ChatMessageService();
        $chatMessagesService->startChat($receiver_id, $user->id, $chatType);
        $data = [
            'chats' => $chatMessagesService->getUserChats($user->id),
            'total_unread_messages' => $chatMessagesService->getUserUnreadMessagesCount($user->id)
        ];

        return view('frontend.messages.index')->with($data);
    }

    public function updateOfferStatus(int $id, int $offerId, string $status)
    {
        try {
            $user = auth('users')->user();
            $advertisementService = new AdvertisementService();
            $advertisement = $advertisementService->findPublic($id);
            if (!$advertisement || $advertisement->user_id != $user->id || $advertisement->is_sold) {
                toastr()->error(trans('api.not found'));
                return redirect()->route('web.chats.list');
            }
            $offer = $advertisementService->findOffer($offerId, $advertisement->user_id, $advertisement->id);
            if (!$offer) {
                toastr()->error(trans('api.not found'));
                return redirect()->route('web.chats.list');
            }
            $advertisementService->updateOfferStatus($offer, OfferStatusEnums::from($status));
            toastr()->success(trans('api.updated successfully'));
            return redirect()->route('web.chats.list');
        } catch (\Exception|\TypeError $exception) {
            toastr()->error(trans('api.something went wrong'));
            return redirect()->route('web.chats.list');
        }
    }

    public function sendMessage(Request $request)
    {
        if (!$request->get('chat_id') || !$request->get('message')) {
            toastr()->error(trans('api.invalid request'));
            return redirect()->route('web.chats.list');
        }
        $user = auth('users')->user();
        $chatMessagesService = new ChatMessageService();
        if ($chatMessagesService->sendTextMessage($request->get('chat_id'), $request->get('message'), $user->id)) {
            toastr()->success(trans('api.message sent successfully'));
            return redirect()->route('web.chats.list');
        }
        toastr()->error(trans('api.something went wrong'));
        return redirect()->route('web.chats.list');
    }

    public function translateProduct(int $id)
    {
        $advertisementService = new AdvertisementService();
        $advertisement = $advertisementService->findActiveAds($id);
        if (!$advertisement) {
            return response()->json(['success' => false, 'message' => trans('api.not found')]);
        }
        $translatedDescription = (new TranslationService())->translateProduct($advertisement);
        return response()->json(['success' => true, 'data' => $translatedDescription]);
    }
}
