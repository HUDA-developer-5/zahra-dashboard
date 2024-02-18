<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Advertisement extends Model
{
    use HasFactory;

    protected $table = "advertisements";

    protected $fillable = [
        'name',
        'category_id',
        'user_id',
        'status',
        'is_sold',
        'price_type',
        'min_price',
        'max_price',
        'currency',
        'phone_number',
        'whatsapp_number',
        'type',
        'country_id',
        'state_id',
        'city_id',
        'latitude',
        'longitude',
        'description',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'country_id', 'id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'country_id', 'id');
    }

    public function state(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'state_id', 'id');
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'city_id', 'id');
    }
}
