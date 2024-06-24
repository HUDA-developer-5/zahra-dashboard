<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserCommission extends Model
{
    use CrudTrait;
    use HasFactory, SoftDeletes;

    protected $table = 'user_commissions';

    protected $fillable = [
        'user_id',
        'advertisement_id',
        'amount',
        'currency',
        'commission',
        'amount_after_commission',
        'is_paid',
        'payment_transaction_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function advertisement()
    {
        return $this->belongsTo(Advertisement::class, 'advertisement_id', 'id');
    }

    public function paymentTransaction()
    {
        return $this->belongsTo(PaymentTransaction::class, 'payment_transaction_id', 'id');
    }
}
