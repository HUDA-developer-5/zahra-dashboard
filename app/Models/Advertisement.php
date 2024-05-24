<?php

namespace App\Models;

use App\Enums\Advertisement\AdvertisementMediaTypeEnums;
use App\Enums\Advertisement\AdvertisementPriceTypeEnums;
use App\Enums\Advertisement\AdvertisementTypeEnums;
use App\Enums\Advertisement\OfferStatusEnums;
use App\Helpers\FilesHelper;
use App\Traits\HasTranslatedDescription;
use App\Traits\HasTranslatedName;
use Backpack\CRUD\app\Models\Traits\SpatieTranslatable\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Advertisement extends Model
{
    use HasFactory, HasTranslatedName, HasTranslations, SoftDeletes, HasTranslatedDescription;

    protected $table = "advertisements";

    public static string $destination_path = 'advertisement';

    protected array $translatable = ['name', 'description'];

    protected $fillable = [
        'name',
        'category_id',
        'user_id',
        'admin_id',
        'status',
        'is_sold',
        'image',
        'is_negotiable',
        'price_type',
        'price',
        'min_price',
        'max_price',
        'currency',
        'phone_number',
        'whatsapp_number',
        'type',
        'nationality_id',
        'state_id',
        'city_id',
        'latitude',
        'longitude',
        'description',
        'view_count',
        'name_ar',
        'description_ar',
        'payment_transaction_id',
        'premium_amount',
        'start_date',
        'expire_date',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'admin_id', 'id');
    }

    public function getOwnerIdAttribute(): string
    {
        return ($this->admin_id) ?: $this->user_id;
    }

    public function getOwnerNameAttribute(): string
    {
        return ($this->admin_id) ? $this->admin->name : $this->user->name;
    }

    public function getOwnerImageAttribute(): string
    {
        return ($this->admin_id) ? $this->admin->image_path : $this->user->image_path;
    }

    public function nationality(): BelongsTo
    {
        return $this->belongsTo(Nationality::class, 'nationality_id', 'id');
    }

    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class, 'state_id', 'id');
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class, 'city_id', 'id');
    }

    public function getImagePathAttribute(): string
    {
        return FilesHelper::filePath($this->image);
    }

    public function images(): HasMany
    {
        return $this->hasMany(AdvertisementMedia::class, 'advertisement_id', 'id')->where('type', '=', AdvertisementMediaTypeEnums::Image->value);
    }

    public function videos(): HasMany
    {
        return $this->hasMany(AdvertisementMedia::class, 'advertisement_id', 'id')->where('type', '=', AdvertisementMediaTypeEnums::Video->value);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(UserAdsComment::class, 'advertisement_id', 'id')->whereNull('parent');
    }

    public function allComments(): HasMany
    {
        return $this->hasMany(UserAdsComment::class, 'advertisement_id', 'id');
    }

    public function allParentComments(): HasMany
    {
        return $this->hasMany(UserAdsComment::class, 'advertisement_id', 'id')->whereNull('parent');
    }

    public function getCommentsCountAttribute(): int
    {
        return $this->hasMany(UserAdsComment::class, 'advertisement_id', 'id')->count();
    }

    public function getIsPremiumAttribute(): string
    {
        return $this->type == AdvertisementTypeEnums::Premium->value;
    }

    public function getDefaultPriceAttribute(): string
    {
        return ($this->price_type == AdvertisementPriceTypeEnums::Fixed->value) ? $this->price : $this->max_price;
    }

    public function getIsFavouriteAttribute(): bool
    {
        return $this->favourites()->where('user_id', auth('users')->id())->exists();
    }

    public function favourites(): HasMany
    {
        return $this->hasMany(UserAdsFavourite::class, 'advertisement_id', 'id');
    }

    public function offers()
    {
        return $this->hasMany(UserAdsOffer::class, 'advertisement_id', 'id');
    }

    public function getMaxOfferPriceAttribute()
    {
        if ($this->price_type == AdvertisementPriceTypeEnums::OpenOffer->value) {
            // check if the this ads has any accepted offers
            if ($this->offers()->where('status', OfferStatusEnums::Approved->value)->exists()) {
                return $this->offers()->where('status', OfferStatusEnums::Approved->value)->max('offer');
            }
            return $this->max_price;
        } else {
            return $this->price;
        }
    }
}
