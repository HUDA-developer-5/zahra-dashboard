<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PremiumCommission extends Model
{
    use CrudTrait;
    use HasFactory;

    protected $table = "premium_commissions";

    protected $fillable = ['commission', 'days', 'type'];
}
