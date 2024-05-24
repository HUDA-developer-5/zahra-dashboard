<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class PremiumUserSubscription extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'premium_ads_percentage',
        'premium_ads_count',
        'start_date',
        'end_date',
        'transaction_id'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class ,'user_id');
    }
}
