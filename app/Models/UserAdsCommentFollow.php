<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAdsCommentFollow extends Model
{
    use HasFactory;

    protected $table = 'user_ads_comment_follows';

    protected $fillable = ['user_id', 'advertisement_id', 'comment_id'];
}
