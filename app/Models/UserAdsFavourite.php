<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAdsFavourite extends Model
{
    use CrudTrait;
    use HasFactory;

    protected $table = 'user_ads_favourites';

    protected $fillable = ['user_id', 'advertisement_id'];
}
