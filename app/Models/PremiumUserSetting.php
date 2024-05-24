<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PremiumUserSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'price',
        'duration_in_months',
        'premium_ads_percentage',
        'premium_ads_count'
    ];
}
