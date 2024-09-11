<?php

namespace App\Services\Advertisement;

use App\DTOs\Advertisement\AdvertisementCommissionDetailsDTO;
use App\DTOs\Advertisement\CreateAdvertisementDTO;
use App\DTOs\Advertisement\FilterAdvertisementDTO;
use App\DTOs\Advertisement\UpdateAdvertisementDTO;
use App\DTOs\User\CreateNotificationDTO;
use App\DTOs\User\CreateWalletTransactionDTO;
use App\DTOs\User\PaymentTransactionDTO;
use App\DTOs\User\ReturnPaymentTransactionDTO;
use App\Enums\Advertisement\AdvertisementMediaTypeEnums;
use App\Enums\Advertisement\AdvertisementPriceTypeEnums;
use App\Enums\Advertisement\AdvertisementStatusEnums;
use App\Enums\Advertisement\AdvertisementTypeEnums;
use App\Enums\Advertisement\OfferStatusEnums;
use App\Enums\Advertisement\PremiumCommissionTypeEnums;
use App\Enums\Advertisement\ReportingStatusEnums;
use App\Enums\ChatTypeEnums;
use App\Enums\CommissionPayWithTypesEnums;
use App\Enums\CommonStatusEnums;
use App\Enums\NotificationActionEnums;
use App\Enums\NotificationTypeEnums;
use App\Enums\User\PaymentMethodsEnum;
use App\Enums\User\PaymentTransactionStatusEnum;
use App\Enums\User\PaymentTransactionTypesEnum;
use App\Enums\User\WalletTransactionTypesEnum;
use App\Helpers\FilesHelper;
use App\Models\Advertisement;
use App\Models\AdvertisementMedia;
use App\Models\Banner;
use App\Models\FreeCommission;
use App\Models\PremiumCommission;
use App\Models\PremiumUserSetting;
use App\Models\Scopes\CurrencyScope;
use App\Models\User;
use App\Models\UserAdsChat;
use App\Models\UserAdsComment;
use App\Models\UserAdsCommentFollow;
use App\Models\UserAdsCommentReport;
use App\Models\UserAdsFavourite;
use App\Models\UserAdsOffer;
use App\Models\UserAdsReport;
use App\Models\UserAdvertisementAction;
use App\Models\UserCommission;
use App\Services\ChatMessageService;
use App\Services\NotificationService;
use App\Services\User\PaymentService;
use App\Services\User\WalletTransactionService;
use App\Services\UserCommentService;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;

class AdvertisementService
{
    public function filterAds(Request $request): array
    {
        $limit = (int)$request->get('limit', 8);

        $featuredQuery = $this->adsBuilder();
        if ($request->get('type') == 'featured') {
            $featuredQuery = $this->commonFilters($featuredQuery, $request);
        }
        $featured = $featuredQuery->where('type', '=', AdvertisementTypeEnums::Premium->value)
            ->where('status', '=', AdvertisementStatusEnums::Active->value)
            ->inRandomOrder()
            ->latest()
            ->take($limit)
            ->get();

        $ignoreFeatured = $featured->pluck('id', 'id')->toArray();

        $latestQuery = $this->adsBuilder();
        if ($request->get('type') == 'latest') {
            $latestQuery = $this->commonFilters($featuredQuery, $request);
        }
        $latest = $latestQuery->whereNotIn('id', $ignoreFeatured)
            ->where('status', '=', AdvertisementStatusEnums::Active->value)
            ->orderByDesc('type')
            ->inRandomOrder()
            ->latest()
            ->take($limit)
            ->get();

        $ignoreLatest = $latest->pluck('id', 'id')->toArray();

        $more = $this->adsBuilder()
            ->whereNotIn('id', array_merge($ignoreFeatured, $ignoreLatest))
            ->where('status', '=', AdvertisementStatusEnums::Active->value)
            ->orderByDesc('type')
            ->inRandomOrder()
            ->latest()
            ->take($limit)
            ->get();
        return [
            'featured' => $featured,
            'latest' => $latest,
            'more' => $more,
        ];
    }


    public function filterAdvertisements(Request $request, string $adType)
    {
        $limit = (int)$request->get('limit', 8);

        $adsQuery = $this->adsBuilder();
        $adsQuery = $this->commonFilters($adsQuery, $request);

        $ads = $adsQuery->where('type', '=', $adType)
            ->where('status', '=', AdvertisementStatusEnums::Active->value)
            ->inRandomOrder()
            ->latest()
            ->take($limit)
            ->get();

        return $ads;
    }

    public function getHomeAdsToMobile()
    {
        $limit = 8;
        $featured = $this->adsBuilder()
            ->where('type', '=', AdvertisementTypeEnums::Premium->value)
            ->where('status', '=', AdvertisementStatusEnums::Active->value)
            ->inRandomOrder()
            ->take($limit)
            ->get();

        $ignoreFeatured = $featured->pluck('id', 'id')->toArray();

        $latest = $this->adsBuilder()
            ->whereNotIn('id', $ignoreFeatured)
            ->where('status', '=', AdvertisementStatusEnums::Active->value)
            ->orderByDesc('type')
            ->inRandomOrder()
            ->take($limit)
            ->get();

        $ignoreLatest = $featured->pluck('id', 'id')->toArray();

        $more = $this->adsBuilder()
            ->whereNotIn('id', array_merge($ignoreFeatured, $ignoreLatest))
            ->where('status', '=', AdvertisementStatusEnums::Active->value)
            ->orderByDesc('type')
            ->inRandomOrder()
            ->take($limit)
            ->get();
        return [
            'featured' => $featured,
            'latest' => $latest,
            'more' => $more,
        ];
    }

    public function filterAdsToWeb(Request $request)
    {
        $query = $this->adsBuilder();
        return $this->commonFilters($query, $request)
            ->where('status', '=', AdvertisementStatusEnums::Active->value)
            ->get();
    }

    public function searchFromMenu(string $search)
    {
        return $this->adsBuilder()
            ->where('status', '=', AdvertisementStatusEnums::Active->value)
            ->orWhere(function ($q) use ($search) {
                $q->whereRaw("LOWER(json_extract(name,'$.en')) like ?", ["%" . strtolower($search) . "%"])
                    ->orWhereRaw("LOWER(json_extract(name,'$.ar')) like ?", ["%" . strtolower($search) . "%"]);
            })
            ->orWhere(function ($q) use ($search) {
                $q->whereRaw("LOWER(json_extract(description,'$.en')) like ?", ["%" . strtolower($search) . "%"])
                    ->orWhereRaw("LOWER(json_extract(description,'$.ar')) like ?", ["%" . strtolower($search) . "%"]);
            })
            ->orWhereHas('category', function ($q) use ($search) {
                $q->whereRaw("LOWER(json_extract(name,'$.en')) like ?", ["%" . strtolower($search) . "%"])
                    ->orWhereRaw("LOWER(json_extract(name,'$.ar')) like ?", ["%" . strtolower($search) . "%"]);
            })
            ->orWhereHas('nationality', function ($q) use ($search) {
                $q->whereRaw("LOWER(json_extract(name,'$.en')) like ?", ["%" . strtolower($search) . "%"])
                    ->orWhereRaw("LOWER(json_extract(name,'$.ar')) like ?", ["%" . strtolower($search) . "%"]);
            })

//            ->orWhereHas('user', function (Builder $query) use ($search) {
//                $query->where('name', 'like', '%' . $search . '%');
//            })
//            ->orWhereHas('city', function (Builder $query) use ($search) {
//                $query->where('name', 'like', '%' . $search . '%');
//            })
//            ->orWhereHas('state', function (Builder $query) use ($search) {
//                $query->where('name', 'like', '%' . $search . '%');
//            })
            ->inRandomOrder()
            ->latest()
            ->take(20)
            ->get();
    }

    public function filterAdsToMobile(Request $request, string $type)
    {
        $query = $this->adsBuilder();
        $query = $this->commonFilters($query, $request)
            ->where('status', '=', AdvertisementStatusEnums::Active->value);
        if ($type == 'featured') {
            $query->where('type', '=', AdvertisementTypeEnums::Premium->value);
        }

        if ($type == 'latest') {
            $query->orderByDesc('created_at');
        }

        return $query->paginate(10);
    }

    public function getMoreAds(FilterAdvertisementDTO $filterAdvertisementDTO)
    {
        return $this->applyFilters($filterAdvertisementDTO)
            ->where('status', '=', AdvertisementStatusEnums::Active->value)
            ->orderByDesc('type')
            ->paginate(10);
    }

    public function getRelatedAds(Advertisement $advertisement, int $limit = 10)
    {
        return $this->adsBuilder()
            ->where('status', '=', AdvertisementStatusEnums::Active->value)
            ->where('category_id', '=', $advertisement->category_id)
            ->orderByDesc('type')
            ->inRandomOrder()
            ->paginate($limit);
    }

    public function getAllUserAds(User $user)
    {
        return $this->adsBuilder()->where('user_id', '=', $user->id)->latest()->get();
    }

    public function getUserAds(User $user): ?LengthAwarePaginator
    {
        return $this->adsBuilder()->where('user_id', '=', $user->id)->paginate(10);
    }

    public function find(User $user, int $id)
    {
        return $this->adsBuilder()->where('user_id', '=', $user->id)->find($id);
    }

    public function findPublic(int $id)
    {
        return $this->adsBuilder()->find($id);
    }

    public function findToAdmin(int $id)
    {
        return $this->adsBuilder()->whereNull('user_id')->whereNotNull('admin_id')->find($id);
    }

    public function findActiveAds(int $id, array $with = [])
    {
        $ads = $this->adsBuilder()
            ->where('status', '=', AdvertisementStatusEnums::Active->value)
            ->where('id', '=', $id);

        if (!empty($with)) {
            $ads = $ads->with($with);
        }
        return $ads->first();
    }

    public function incrementViewCount(Advertisement $advertisement): void
    {
        $advertisement->view_count = $advertisement->view_count + 1;
        $advertisement->save();
    }

    /**
     * @throws Exception
     */
    public function addNewAdvertisement(User $user, CreateAdvertisementDTO $createAdvertisementDTO): Advertisement
    {
        try {
            DB::beginTransaction();
            // store new add
            $createAdvertisementDTO->user_id = $user->id;
            $createAdvertisementDTO->is_sold = false;
            $createAdvertisementDTO->status = $this->getAdsDefaultStatus($createAdvertisementDTO->type);
            $advertisement = $this->store($createAdvertisementDTO);
            // check ads type if premium return payment link
            if ($createAdvertisementDTO->type->value == AdvertisementTypeEnums::Premium->value) {
                $advertisementCommissionDetailsDTO = $this->calculatePremiumAmount($createAdvertisementDTO->premium_amount);
                $returnPaymentTransactionDTO = $this->payPremiumAdsCommission($user, $advertisementCommissionDetailsDTO->amount_after_commission, $createAdvertisementDTO->payment_type, $createAdvertisementDTO->payment_method);
                if ($returnPaymentTransactionDTO->status->value == PaymentTransactionStatusEnum::Completed->value) {
                    $advertisement->status = AdvertisementStatusEnums::Active->value;
                    $advertisement->payment_transaction_id = $returnPaymentTransactionDTO->payment_transaction_id;
                    $advertisement->premium_amount = $createAdvertisementDTO->premium_amount;
                    $advertisement->start_date = Carbon::now()->format('Y-m-d');
                    $advertisement->expire_date = Carbon::now()->addDays($advertisementCommissionDetailsDTO->days)->format('Y-m-d');
                    $advertisement->save();
                } else {
                    throw new Exception($returnPaymentTransactionDTO->message);
                }
            }
            DB::commit();
            return $advertisement;
        } catch (Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }

    public function updateAds(Advertisement $advertisement, UpdateAdvertisementDTO $updateAdvertisementDTO): Advertisement
    {
        $isSold = (bool)$advertisement->is_sold;
        $advertisement->update(array_filter($updateAdvertisementDTO->except('image', 'images', 'videos', 'is_sold', 'type')->toArray()));
        // if user mark the ad as sold, change status to sold and insert new commission record
        if (!$isSold && $updateAdvertisementDTO->is_sold == 1 && $advertisement->user) {
            $this->createUserAdsCommission($advertisement->user, $advertisement);
            $advertisement->is_sold = true;
            $advertisement->save();
        }

        // add commission to user if ads is sold

        if ($updateAdvertisementDTO->image && $updateAdvertisementDTO->image->isFile()) {
            $image = FilesHelper::uploadImage($updateAdvertisementDTO->image, $advertisement::$destination_path);
            if ($image && $advertisement->image) {
                FilesHelper::deleteImage($advertisement->image);
            }
            $advertisement->image = $image;
            $advertisement->save();
        }

        // upload images
        if ($updateAdvertisementDTO->images && count($updateAdvertisementDTO->images) > 0) {
            foreach ($updateAdvertisementDTO->images as $imageFile) {
                if ($imageFile->isFile()) {
                    $this->uploadMedia($imageFile, $advertisement, AdvertisementMediaTypeEnums::Image);
                }
            }
        }

        // upload videos
        if ($updateAdvertisementDTO->videos && count($updateAdvertisementDTO->videos) > 0) {
            foreach ($updateAdvertisementDTO->videos as $videoFile) {
                if ($videoFile->isFile()) {
                    $this->uploadMedia($videoFile, $advertisement, AdvertisementMediaTypeEnums::Video);
                }
            }
        }
        return $advertisement;
    }

    public function addChat(User $user, Advertisement $advertisement, string $message): void
    {
        UserAdsChat::create([
            'user_id' => $user->id,
            'advertisement_id' => $advertisement->id,
            'channel' => $this->generateAdsChatChannel($user, $advertisement),
            'message' => $message,
        ]);
    }

    protected function generateAdsChatChannel(User $user, Advertisement $advertisement): string
    {
        return "channel_" . $user->id . '_' . $advertisement->id . '_' . $advertisement->admin_id;
    }

    public function listChat(User $user, Advertisement $advertisement)
    {
        $channel = $this->generateAdsChatChannel($user, $advertisement);
        return UserAdsChat::where('channel', '=', $channel)
            ->where('advertisement_id', '=', $advertisement->id)
            ->paginate(15);
    }

    public function addOffer(User $user, Advertisement $advertisement, float $offer): array
    {
        $status = false;
        // check if ads is open offer type
        if ($advertisement->price_type != AdvertisementPriceTypeEnums::OpenOffer->value) {
            return ['status' => $status, 'message' => trans('web.advertisement is not open offer')];
        }

        // check if the offer not less than ads min price and not greater than ads max price
        if ($offer < $advertisement->min_price || $offer > $advertisement->max_price) {
            return ['status' => $status, 'message' => trans('web.offer should be between :min and :max', ['min' => $advertisement->min_price, 'max' => $advertisement->max_price])];
        }

        $offer = UserAdsOffer::UpdateOrCreate(
            [
                'user_id' => $user->id,
                'advertisement_id' => $advertisement->id,
                'status' => OfferStatusEnums::Pending->value,
            ],
            [
                'owner_id' => $advertisement->owner_id,
                'offer' => $offer,
            ]
        );

        // send chat offer message to owner
        // start chat
        $chatMessageService = new ChatMessageService();
        if ($advertisement->admin_id) {
            $chat = $chatMessageService->startChat($user->id, $advertisement->admin_id, ChatTypeEnums::USER_TO_ADMIN);
            $chatMessageService->sendOfferMessage($chat, $offer);
        } else {
            $chat = $chatMessageService->startChat($advertisement->user_id, $user->id, ChatTypeEnums::USER_TO_USER);
            $chatMessageService->sendOfferMessage($chat, $offer);
        }

        // send notification to owner
//        (new NotificationService())->save(CreateNotificationDTO::from([
//            'user_id' => $advertisement->admin_id,
//            'target_user_id' => $user->id,
//            'action' => NotificationActionEnums::NotifyAdsOwnerWithOpenOffer->value,
//            'type' => NotificationTypeEnums::Push->value,
//            'title_ar' => $user->name,
//            'title_en' => $user->name,
//            'content_ar' => 'احصل على عرضك',
//            'content_en' => 'I want to buy your product',
//            'payload' => [
//                'user_id' => $user->id,
//                'advertisement_id' => $advertisement->id
//            ],
//            'advertisement_id' => $advertisement->id,
//        ]));

        return ['status' => true, 'message' => trans('web.offer sent successfully')];
    }

    public function findOffer(int $id, int $ownerId, int $advertisementId)
    {
        return UserAdsOffer::where('status', '=', OfferStatusEnums::Pending->value)
            ->where('owner_id', '=', $ownerId)
            ->where('advertisement_id', '=', $advertisementId)
            ->find($id);
    }

    public function updateOfferStatus(UserAdsOffer $offer, OfferStatusEnums $offerStatusEnums): bool
    {
        $offer->update(['status' => $offerStatusEnums->value]);
        // send notification to the offer owner
        $title_ar = $message_ar = 'تم تغيير حالة العرض';
        $title_en = $message_en = 'Offer status changed';
        if ($offerStatusEnums->value == OfferStatusEnums::Approved->value) {
            $message_ar = 'تم قبول العرض';
            $message_en = 'Offer accepted';
        } elseif ($offerStatusEnums->value == OfferStatusEnums::Rejected->value) {
            $message_ar = 'تم رفض العرض';
            $message_en = 'Offer rejected';
        }
        (new NotificationService())->save(CreateNotificationDTO::from([
            'user_id' => $offer->user_id,
            'target_user_id' => $offer->owner_id,
            'action' => NotificationActionEnums::NotifyAdsOwnerWithOpenOffer->value,
            'type' => NotificationTypeEnums::Push->value,
            'title_ar' => $title_ar,
            'title_en' => $title_en,
            'content_ar' => $message_ar,
            'content_en' => $message_en,
            'payload' => [
                'user_id' => $offer->user_id,
                'offer_id' => $offer->id,
                'advertisement_id' => $offer->advertisement_id,
            ],
            'advertisement_id' => $offer->advertisement_id,
        ]));

        return true;
    }

    public function listOffers(User $user, Advertisement $advertisement)
    {
        return UserAdsOffer::where('user_id', '=', $user->id)
            ->where('advertisement_id', '=', $advertisement->id)
            ->paginate(15);
    }

    protected function store(CreateAdvertisementDTO $createAdvertisementDTO): Advertisement
    {
        $advertisement = (new Advertisement())->create($createAdvertisementDTO->except('image', 'images', 'videos')->toArray());

        if ($createAdvertisementDTO->image && $createAdvertisementDTO->image->isFile()) {
            $image = FilesHelper::uploadImage($createAdvertisementDTO->image, $advertisement::$destination_path);
            $advertisement->image = $image;
            $advertisement->save();
        }

        // upload images
        if ($createAdvertisementDTO->images && count($createAdvertisementDTO->images) > 0) {
            foreach ($createAdvertisementDTO->images as $imageFile) {
                if ($imageFile->isFile()) {
                    $this->uploadMedia($imageFile, $advertisement, AdvertisementMediaTypeEnums::Image);
                }
            }
        }

        // upload videos
        if ($createAdvertisementDTO->videos && count($createAdvertisementDTO->videos) > 0) {
            foreach ($createAdvertisementDTO->videos as $videoFile) {
                if ($videoFile->isFile()) {
                    $this->uploadMedia($videoFile, $advertisement, AdvertisementMediaTypeEnums::Video);
                }
            }
        }

        return $advertisement;
    }

    public function uploadMedia(UploadedFile $file, Advertisement $advertisement, AdvertisementMediaTypeEnums $mediaTypeEnums): void
    {
        (new AdvertisementMedia())->create([
            'advertisement_id' => $advertisement->id,
            'type' => $mediaTypeEnums->value,
            'file' => FilesHelper::uploadImage($file, AdvertisementMedia::$destination_path)
        ]);
    }

    public function deleteMedia(int $advertisementId, int $mediaId): bool
    {
        $media = AdvertisementMedia::where('advertisement_id', '=', $advertisementId)->find($mediaId);
        if ($media) {
            if ($media->file) {
                FilesHelper::deleteImage($media->file);
            }
            return $media->delete();
        }
        return false;
    }

    public function getAdsDefaultStatus(AdvertisementTypeEnums $advertisementTypeEnums): AdvertisementStatusEnums
    {
        return ($advertisementTypeEnums->value == AdvertisementTypeEnums::Premium->value) ? AdvertisementStatusEnums::Pending : AdvertisementStatusEnums::Active;
    }

    public function applyFilters(FilterAdvertisementDTO $filterAdvertisementDTO): Builder
    {
        $builder = $this->adsBuilder();
        $builder
            ->when($filterAdvertisementDTO->category_id, function (Builder $query, $value) {
                return $query->where('category_id', $value);
            })
            ->when($filterAdvertisementDTO->nationality_id, function (Builder $query, $value) {
                return $query->where('nationality_id', '=', $value);
            })
            ->when($filterAdvertisementDTO->state_id, function (Builder $query, $value) {
                return $query->where('state_id', '=', $value);
            })
            ->when($filterAdvertisementDTO->city_id, function (Builder $query, $value) {
                return $query->where('city_id', '=', $value);
            })
            ->when($filterAdvertisementDTO->price_from, function (Builder $query, $value) {
                return $query->where('min_price', '>=', $value)
                    ->where('price', '>=', $value);
            })->when($filterAdvertisementDTO->price_to, function (Builder $query, $value) {
                return $query->where('max_price', '<=', $value)
                    ->where('price', '<=', $value);
            })->when($filterAdvertisementDTO->is_negotiable, function (Builder $query, $value) {
                return $query->where('is_negotiable', '=', $value);
            });
        return $builder;
    }

    protected function commonFilters(Builder $query, Request $request): Builder
    {
//        if ($request->filled('search')) {
//            $query->where('name', 'like', '%' . $request->search . '%');
//        }

        if ($request->filled('categories_id')) {
            $query->whereIn('category_id', $request->categories_id);
        }

        if ($request->filled('category_id') && $request->category_id !== "null") {
            $query->where('category_id', $request->category_id);
        }
//
        if ($request->filled('sub_category_id_1') && $request->sub_category_id_1 !== "null") {
            $query->where('sub_category_id_1', $request->sub_category_id_1);
        }

        if ($request->filled('sub_category_id_2') && $request->sub_category_id_2 !== "null") {
            $query->where('sub_category_id_2', $request->sub_category_id_2);
        }

        if ($request->filled('sub_category_id_3') && $request->sub_category_id_3 !== "null") {
            $query->where('sub_category_id_3', $request->sub_category_id_3);
        }

        if ($request->filled('country_id')) {
            $query->where('nationality_id', $request->country_id);
        }

        if ($request->filled('state_id')) {
            $query->where('state_id', $request->state_id);
        }

        if ($request->filled('city_id')) {
            $query->where('city_id', $request->city_id);
        }

        if ($request->filled('price_from')) {
            $query->where('price', '>=', $request->price_from)
                ->where('min_price', '>=', $request->price_from);
        }

        if ($request->filled('price_to')) {
            $query->where('price', '<=', $request->price_to)
                ->where('max_price', '<=', $request->price_to);
        }

        // is_negotiable
        if ($request->filled('negotiable') && !$request->filled('non_negotiable')) {
            $query->where('is_negotiable', '=', 1);
        }

        // not_negotiable
        if ($request->filled('non_negotiable') && !$request->filled('negotiable')) {
            $query->where('is_negotiable', '=', 0);
        }

        // available photo
        if ($request->filled('available_photo')) {
            $query->whereHas('images', function (Builder $query) {
                $query->where('type', '=', AdvertisementMediaTypeEnums::Image->value);
            });
        }

        if ($request->filled('is_featured')) {
            $query->where('type', '=', AdvertisementTypeEnums::Premium->value);
        }

        // nearby
        if ($request->filled('near_by') && $request->filled('latitude') && $request->filled('longitude')) {
            $query->whereRaw(
                "6371 * acos(cos(radians(" . $request->get('latitude') . ")) * cos(radians(latitude)) * cos(radians(longitude) - radians(" . $request->get('longitude') . ")) + sin(radians(" . $request->get('latitude') . ")) * sin(radians(latitude))) <= 50"
            );
        }

        // filter by most viewed
        if ($request->filled('most_viewed')) {
            $query->orderBy('view_count', 'desc');
        }

        // filter by created_at today/yesterday/week/month/year
        if ($request->filled('created_at')) {
            if ($request->created_at == 'today') {
                $query->whereDate('created_at', Carbon::today());
            }

            if ($request->created_at == 'yesterday') {
                $query->whereDate('created_at', Carbon::yesterday());
            }

            if ($request->created_at == 'week') {
                $query->whereDate('created_at', '>=', Carbon::now()->subDays(7));
            }

            if ($request->created_at == 'month') {
                $query->whereDate('created_at', '>=', Carbon::now()->subMonths(1));
            }

            if ($request->created_at == 'month_2') {
                $query->whereDate('created_at', '>=', Carbon::now()->subMonths(2));
            }

            if ($request->created_at == 'month_3') {
                $query->whereDate('created_at', '>=', Carbon::now()->subMonths(3));
            }

            if ($request->created_at == 'month_6') {
                $query->whereDate('created_at', '>=', Carbon::now()->subMonths(6));
            }

            if ($request->created_at == 'year') {
                $query->whereDate('created_at', '>=', Carbon::now()->subYear(1));
            }
        }


        // sort_by
        if ($request->filled('sort_by')) {
            $sortBy = $request->sort_by;
            if ($sortBy == 'default') {
                $query->latest();
            }

            if ($sortBy == 'low_price') {
                $query->where('price_type', '=', AdvertisementPriceTypeEnums::Fixed->value)
                    ->orderBy('price', 'asc');
            }

            if ($sortBy == 'high_price') {
                $query->where('price_type', '=', AdvertisementPriceTypeEnums::Fixed->value)
                    ->orderBy('price', 'desc');
            }

            if ($sortBy == 'low_offer') {
                $query->where('price_type', '=', AdvertisementPriceTypeEnums::OpenOffer->value)
                    ->orderBy('min_price');
            }

            if ($sortBy == 'high_offer') {
                $query->where('price_type', '=', AdvertisementPriceTypeEnums::OpenOffer->value)
                    ->orderBy('max_price', 'desc');
            }
        }
        return $query;
    }

    protected function adsBuilder(): Builder
    {
        return (new Advertisement())->withoutGlobalScope(CurrencyScope::class)->where('status', '=', AdvertisementStatusEnums::Active->value)->newQuery();
    }

    public function addAdsToFavourite(User $user, Advertisement $advertisement): void
    {
        UserAdsFavourite::updateOrCreate([
            'user_id' => $user->id,
            'advertisement_id' => $advertisement->id,
        ]);
    }

    public function removeAdsFromFavourite(User $user, Advertisement $advertisement): void
    {
        UserAdsFavourite::where('user_id', '=', $user->id)->where('advertisement_id', '=', $advertisement->id)->delete();
    }

    public function isFavouriteAds(int $userId, int $advertisement_id): bool
    {
        return UserAdsFavourite::where('user_id', '=', $userId)->where('advertisement_id', '=', $advertisement_id)->exists();
    }

    public function reportAd(User $user, Advertisement $advertisement, $comment): void
    {
        $report = UserAdsReport::where('user_id', '=', $user->id)->where('advertisement_id', '=', $advertisement->id)->first();
        if (!$report) {
            UserAdsReport::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'advertisement_id' => $advertisement->id,
                ],
                [
                    'status' => ReportingStatusEnums::Pending->value,
                    'comment' => $comment
                ]
            );
        }
    }

    public function addComment(User $user, Advertisement $advertisement, string $comment, $parent = null)
    {
        $related_id = null;
        if ($parent) {
            $userAdsComment = UserAdsComment::find($parent);
            if ($userAdsComment && $userAdsComment->related_id) {
                $related_id = $userAdsComment->related_id;
            } else {
                $related_id = $parent;
            }
        }
        $userComment = UserAdsComment::create([
            'user_id' => $user->id,
            'advertisement_id' => $advertisement->id,
            'related_id' => $related_id,
            'parent' => $parent,
            'comment' => $comment
        ]);

        // send notification to all users who follow this comment
        $userCommentService = new UserCommentService();
        $userCommentService->sendNotificationToCommentFollowers($related_id != null ? UserAdsComment::find($related_id) : $userComment);
        // skip notification for advertisement owner
        if ($advertisement->user_id && $user->id !== $advertisement->user_id) {
            $userCommentService->sendNotificationToAdvertisementOwner($userComment);
        }

        return $userComment;
    }

    public function getUserComment(int $userId, int $adsId, int $commentId)
    {
        return UserAdsComment::where('user_id', '=', $userId)->where('advertisement_id', '=', $adsId)->find($commentId);
    }

    public function isCommentInPast(UserAdsComment $userAdsComment)
    {
        return $userAdsComment->created_at->lessThan(Carbon::now()->subMinutes(5));
    }

    public function updateComment(UserAdsComment $userAdsComment, string $comment): void
    {
        $userAdsComment->update([
            'comment' => $comment
        ]);
    }

    public function deleteComment(UserAdsComment $userAdsComment): void
    {
        // delete child
        $userAdsComment->child()->delete();
        //delete comment
        $userAdsComment->delete();
    }

    public function findComment(int $commentId)
    {
        return UserAdsComment::find($commentId);
    }

    public function reportComment(User $user, Advertisement $advertisement, UserAdsComment $userAdsComment, $comment): void
    {
        $report = UserAdsCommentReport::where('user_id', '=', $user->id)
            ->where('advertisement_id', '=', $advertisement->id)
            ->where('comment_id', '=', $userAdsComment->id)
            ->first();
        if (!$report) {
            UserAdsCommentReport::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'advertisement_id' => $advertisement->id,
                    'comment_id' => $userAdsComment->id,
                ],
                [
                    'status' => ReportingStatusEnums::Pending->value,
                    'comment' => $comment
                ]
            );
        }
    }

    public function followComment(User $user, Advertisement $advertisement, UserAdsComment $userAdsComment): void
    {
        UserAdsCommentFollow::updateOrCreate([
            'user_id' => $user->id,
            'advertisement_id' => $advertisement->id,
            'comment_id' => $userAdsComment->id,
        ]);
    }

    public function unFollowComment(User $user, Advertisement $advertisement, UserAdsComment $userAdsComment): void
    {
        UserAdsCommentFollow::where('user_id', '=', $user->id)
            ->where('advertisement_id', '=', $advertisement->id)
            ->where('comment_id', '=', $userAdsComment->id)
            ->delete();
    }

    public function purchaseProduct(User $user, Advertisement $advertisement): bool
    {
        // check if the advertisement is created by normal user not admin
        if (is_null($advertisement->user_id)) {
            return false;
        }

        // check if the advertisement is not sold
        if ($advertisement->is_sold == 1) {
            return false;
        }

        // check if the user can press on the purchase button
        if (!$this->isUserActionOnAdvertisement($user, $advertisement)) {
            return false;
        }

        // send notification to advertisement owner
        (new NotificationService())->save(CreateNotificationDTO::from([
            'user_id' => $advertisement->user_id,
            'target_user_id' => $user->id,
            'action' => NotificationActionEnums::NotifyAdsOwnerWithPurchased->value,
            'type' => NotificationTypeEnums::Push->value,
            'title_ar' => $user->name,
            'title_en' => $user->name,
            'content_ar' => 'قمت بشراء منتجك',
            'content_en' => 'I purchased your product',
            'payload' => [
                'user_id' => $user->id,
                'advertisement_id' => $advertisement->id
            ],
            'advertisement_id' => $advertisement->id,
        ]));
        return true;
    }

    public function addActionToAdvertisement(User $user, Advertisement $advertisement, string $action): void
    {
        // add action to advertisement
        $userAdvertisementAction = UserAdvertisementAction::where('user_id', '=', $user->id)
            ->where('advertisement_id', '=', $advertisement->id)
            ->first();
        if (!$userAdvertisementAction) {
            UserAdvertisementAction::create([
                'user_id' => $user->id,
                'advertisement_id' => $advertisement->id,
                'action' => $action
            ]);
        } else {
            $userAdvertisementAction->update([
                'action' => $userAdvertisementAction->action . ',' . $action
            ]);
        }
    }

    public function isUserActionOnAdvertisement(User $user, Advertisement $advertisement): bool
    {
        return UserAdvertisementAction::where('user_id', '=', $user->id)
            ->where('advertisement_id', '=', $advertisement->id)
            ->exists();
    }

    public function isValidAction(string $action): bool
    {
        return in_array($action, ['chat', 'whatsapp', 'call', 'openOffer']);
    }

    public function getActiveBanner()
    {
        return Banner::where('status', '=', CommonStatusEnums::Active->value)
            ->where('start_date', '<=', Carbon::now())
            ->where('end_date', '>=', Carbon::now())
            ->inRandomOrder()->first();
    }

    public function createUserAdsCommission(User $user, Advertisement $advertisement): bool
    {
        $userCommission = UserCommission::where('user_id', '=', $user->id)
            ->where('advertisement_id', '=', $advertisement->id)
            ->first();

        if (!$userCommission) {
            $advertisementCommissionDetailsDTO = $this->getCommissionDetails($advertisement->default_price);
            if ($advertisementCommissionDetailsDTO->amount_after_commission > 0) {
                UserCommission::create([
                    'user_id' => $user->id,
                    'advertisement_id' => $advertisement->id,
                    'currency' => $user->default_currency,
                    'amount' => $advertisementCommissionDetailsDTO->amount,
                    'commission' => $advertisementCommissionDetailsDTO->commission,
                    'amount_after_commission' => $advertisementCommissionDetailsDTO->amount_after_commission
                ]);
            }
        }
        return true;
    }

    public function getCommissionDetails(float $advertisementPrice): AdvertisementCommissionDetailsDTO
    {
        // get commission from free commission
        $adsCommission = FreeCommission::first();
        $amount = 0;
        $commission = 0;
        $amount_after_commission = 0;

        if ($adsCommission && $adsCommission->commission_percentage) {
            $amount = $advertisementPrice;
            $commission = ($adsCommission->commission_percentage / 100) * $advertisementPrice;
            $amount_after_commission = $amount - $commission;
        }

        return AdvertisementCommissionDetailsDTO::from([
            'commission' => $commission,
            'amount_after_commission' => $amount_after_commission,
            'amount' => $amount,
        ]);
    }

    public function calculatePremiumAmount(int $amount): AdvertisementCommissionDetailsDTO
    {
        $days = 0;
        $commission = 0;
        $amount_after_commission = $amount;
        // get fixed commission from premium commission table
        $fixedCommission = PremiumCommission::where('type', '=', PremiumCommissionTypeEnums::Fixed->value)->first();
        if ($fixedCommission && $fixedCommission->commission > 0) {
            // calculate number of days
            $days = intval($amount / $fixedCommission->commission);

            if ($days > 0) {
                $selectDays = 0;
                if ($days == 7) {
                    $selectDays = 7;
                }
                if ($days > 7 && $days <= 30) {
                    $selectDays = 30;
                }
                if ($days > 30) {
                    $selectDays = 31;
                }
                // select premium commission from premium commission table according to number of days
                $premiumCommission = PremiumCommission::where('type', '=', PremiumCommissionTypeEnums::Percentage->value)
                    ->where('days', '=', $selectDays)
                    ->first();
                if ($premiumCommission && $premiumCommission->commission > 0) {
                    $amount_after_commission = $amount - (($premiumCommission->commission / 100) * $amount);
                    $commission = $premiumCommission->commission;
                }
            }
        }
        return AdvertisementCommissionDetailsDTO::from([
            'commission' => $commission,
            'amount_after_commission' => $amount_after_commission,
            'amount' => $amount,
            'days' => $days
        ]);
    }

    public function payPremiumAdsCommission(User $user, float $amount, CommissionPayWithTypesEnums $paymentType, string $paymentMethod = null): ReturnPaymentTransactionDTO
    {
        $returnPaymentTransactionDTO = ReturnPaymentTransactionDTO::from([
            'status' => PaymentTransactionStatusEnum::Failed,
            'message' => trans('api.not enough balance'),
            'payment_transaction_id' => null,
        ]);
        if ($paymentType->value == CommissionPayWithTypesEnums::Wallet->value) {
            $returnPaymentTransactionDTO = $this->payByWallet($user, $amount);
        }

        if ($paymentType->value == CommissionPayWithTypesEnums::Card->value) {
            $returnPaymentTransactionDTO = $this->payByCard($user, $amount, $paymentMethod);
        }
        return $returnPaymentTransactionDTO;
    }

    public function payByWallet(User $user, float $totalAmount): ReturnPaymentTransactionDTO
    {
        $status = PaymentTransactionStatusEnum::Failed;
        $transactionId = null;
        $message = trans('api.not enough balance');
        // check the wallet amount
        $walletBalance = $user->balance;
        if ($walletBalance < $totalAmount) {
            return ReturnPaymentTransactionDTO::from([
                'status' => $status,
                'payment_transaction_id' => $transactionId,
                'message' => $message
            ]);
        }

        try {
            $currency = $user->default_currency;
            // add new payment transaction with wallet type
            $paymentTransactionDTO = PaymentTransactionDTO::from([
                'payment_method' => PaymentMethodsEnum::Wallet,
                'type' => PaymentTransactionTypesEnum::PayPremiumAdvertisement,
                'status' => PaymentTransactionStatusEnum::Completed,
                'amount' => $totalAmount,
                'currency' => $currency,
                'user_id' => $user->id,
                'description' => 'Pay Premium Advertisement from Wallet with ' . $totalAmount . ' ' . $currency . ' using ' . PaymentMethodsEnum::Wallet->value,
            ]);

            $paymentTransaction = (new PaymentService())->createPaymentTransaction($paymentTransactionDTO);
            // add new wallet transaction with deduct type
            $walletTransactionService = new WalletTransactionService();
            // deduct this amount from balance
            $user = $walletTransactionService->deductWalletBalance($user, $totalAmount);
            // add wallet transaction
            $walletTransactionService->createWalletTransaction(CreateWalletTransactionDTO::from([
                'user_id' => $user->id,
                'current_balance' => $user->balance,
                'amount' => $totalAmount,
                'previous_balance' => $user->balance - $totalAmount,
                'type' => WalletTransactionTypesEnum::Deduct,
                'payment_transaction_id' => $paymentTransaction->id
            ]));

            return ReturnPaymentTransactionDTO::from([
                'status' => PaymentTransactionStatusEnum::Completed,
                'payment_transaction_id' => $paymentTransaction->id,
                'message' => trans('api.paid successfully')
            ]);
        } catch (\Exception $exception) {
            return ReturnPaymentTransactionDTO::from([
                'status' => $status,
                'message' => trans('api.PaymentFailed')
            ]);
        }
    }

    public function payByCard(User $user, float $totalAmount, string $paymentMethod): ReturnPaymentTransactionDTO
    {
        $status = PaymentTransactionStatusEnum::Failed;
        $currency = $user->default_currency;
        $returnPaymentTransactionDTO = (new PaymentService())->payPremiumAdvertisementAdjustment($user, $totalAmount, $paymentMethod, $currency);
        if ($returnPaymentTransactionDTO->status->value == PaymentTransactionStatusEnum::Completed->value) {
            $message = trans('api.paid successfully');
            $status = PaymentTransactionStatusEnum::Completed;
        } else {
            $message = trans('api.PaymentFailed');
        }
        return ReturnPaymentTransactionDTO::from([
            'status' => $status,
            'message' => $message,
            'payment_transaction_id' => $returnPaymentTransactionDTO->payment_transaction_id
        ]);
    }
}
