<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAdvertisementAction extends Model
{
    use CrudTrait;
    use HasFactory;

    protected $table = "user_advertisement_actions";

    protected $fillable = [
        'user_id',
        'advertisement_id',
        'action'
    ];
}
