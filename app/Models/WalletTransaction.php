<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WalletTransaction extends Model
{
    use CrudTrait;
    use HasFactory, SoftDeletes;

    protected $table = 'wallet_transactions';

    protected $fillable = [
        'user_id',
        'current_balance',
        'previous_balance',
        'amount',
        'type',
        'payment_transaction_id',
        'currency',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function paymentTransaction()
    {
        return $this->belongsTo(PaymentTransaction::class, 'payment_transaction_id', 'id');
    }
}
