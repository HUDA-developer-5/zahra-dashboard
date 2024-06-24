<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentTransaction extends Model
{
    use CrudTrait;
    use HasFactory, SoftDeletes;

    protected $table = 'payment_transactions';

    protected $fillable = [
        'user_id',
        'payment_method',
        'type',
        'amount',
        'currency',
        'status',
        'transaction_number',
        'description',
        'response',
        'cart_id',
    ];

    protected $casts = [
        'response' => 'array',
    ];
}
