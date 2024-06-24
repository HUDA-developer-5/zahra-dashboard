<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notification extends Model
{
    use CrudTrait;
    use HasFactory;

    protected $fillable = [
        'title_en', 'title_ar', 'content_en', 'content_ar', 'payload', 'type', 'action', 'user_id', 'target_user_id',
        'status', 'is_read', 'advertisement_id', 'comment_id'
    ];

    protected $casts = [
        'payload' => 'array',
        'created_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function targetUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'target_user_id', 'id');
    }

    public function advertisement()
    {
        return $this->belongsTo(Advertisement::class, 'advertisement_id', 'id');
    }

    public function comment()
    {
        return $this->belongsTo(UserAdsComment::class, 'comment_id', 'id');
    }
}
