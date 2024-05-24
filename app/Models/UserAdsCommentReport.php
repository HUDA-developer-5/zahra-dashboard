<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAdsCommentReport extends Model
{
    use HasFactory;

    protected $table = 'user_ads_comment_reports';

    protected $fillable = ['user_id', 'advertisement_id', 'comment_id', 'status', 'comment'];
}
