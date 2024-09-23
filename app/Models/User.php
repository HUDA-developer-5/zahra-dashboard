<?php

namespace App\Models;

use App\Helpers\FilesHelper;
use App\Traits\UserTrait;
use Backpack\CRUD\app\Models\Traits\CrudTrait;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Cashier\Billable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, CrudTrait, SoftDeletes, UserTrait, Billable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'status',
        'email_verified_at',
        'password',
        'phone_number',
        'phone_number_verified_at',
        'image',
        'nationality_id',
        'default_language',
        'balance',
        'provider',
        'provider_id',
        'balance_egp',
        'balance_sar',
        'balance_aed',
    ];

    public static string $destination_path = 'users';

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function getImagePathAttribute(): string
    {
        return FilesHelper::filePath($this->image);
    }

    public function nationality(): BelongsTo
    {
        return $this->belongsTo(Nationality::class, 'nationality_id', 'id');
    }

    public function favouritesAds(): BelongsToMany
    {
        return $this->belongsToMany(Advertisement::class, 'user_ads_favourites', 'user_id', 'advertisement_id');
    }

    public function getDefaultCurrencyAttribute()
    {
        return ($this->nationality) ? $this->nationality->currency : "sar";
    }

    public function commissions(): HasMany
    {
        return $this->hasMany(UserCommission::class, 'user_id', 'id');
    }

    public function userAdsCommentFollows(): HasMany
    {
        return $this->hasMany(UserAdsCommentFollow::class, 'user_id', 'id');
    }

    public function notifications(): HasMany
    {
        return $this->hasMany(Notification::class, 'user_id', 'id')->orderByDesc('is_read');
    }

    public function unreadNotifications(): HasMany
    {
        return $this->notifications()->where('is_read', '=', 0);
    }

    public function premiumSubscription(): HasOne
    {
        return $this->hasOne(PremiumUserSubscription::class, 'user_id', 'id');
    }

    public function getWalletBalanceAttribute()
    {
        return $this->balance . '' . $this->default_currency;
    }

    public function chats(): HasMany
    {
        return $this->hasMany(Chat::class, 'sender_id', 'id')
            ->orWhere(function ($query) {
                $query->where('receiver_id', $this->id);
            });
    }

    public function unReadChatMessagesCount(): int
    {
        return $this->chats()->whereHas('unReadMessages', function (Builder $builder) {
            $builder->where('receiver_id', '=', $this->id);
        })->count();
    }
}
