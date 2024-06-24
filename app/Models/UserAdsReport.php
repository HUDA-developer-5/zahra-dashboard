<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAdsReport extends Model
{
    use CrudTrait;
    use HasFactory;

    protected $table = 'user_ads_reports';

    protected $fillable = ['user_id', 'advertisement_id', 'status', 'comment'];
}
