<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UserAdsComment extends Model
{
    use CrudTrait;
    use HasFactory;

    protected $table = 'user_ads_comments';

    protected $fillable = ['user_id', 'advertisement_id', 'parent', 'comment', 'related_id'];

    protected $casts = [
        'created_at' => 'datetime'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function child(): HasMany
    {
        return $this->hasMany(UserAdsComment::class, 'parent', 'id');
    }

    public function relatedComments(): HasMany
    {
        return $this->hasMany(UserAdsComment::class, 'related_id', 'id');
    }

    public function getIsFollowingAttribute()
    {
        if (auth('users')->check()) {
            return UserAdsCommentFollow::where('user_id', auth('users')->user()->id)->where('comment_id', $this->id)->exists();
        }
        return false;
    }

    public function advertisement(): BelongsTo
    {
        return $this->belongsTo(Advertisement::class, 'advertisement_id', 'id');
    }
}
