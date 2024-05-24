<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FreeCommission extends Model
{
    use CrudTrait;
    use HasFactory;

    protected $table = 'free_commissions';

    protected $fillable = ['days', 'limit', 'commission_percentage'];
}
