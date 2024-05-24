<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserAdsOffer extends Model
{
    use HasFactory;

    protected $table = 'user_ads_offers';

    protected $fillable = ['user_id', 'owner_id', 'advertisement_id', 'status', 'offer'];

    protected $casts = [
        'created_at' => 'datetime'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function advertisement(): BelongsTo
    {
        return $this->belongsTo(Advertisement::class, 'advertisement_id', 'id');
    }
}
