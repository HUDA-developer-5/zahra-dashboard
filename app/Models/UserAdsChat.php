<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserAdsChat extends Model
{
    use HasFactory;

    protected $table = 'user_ads_chats';

    protected $fillable = ['user_id', 'advertisement_id', 'admin_id', 'channel', 'message'];

    protected $casts = [
        'created_at' => 'datetime'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function advertisement(): BelongsTo
    {
        return $this->belongsTo(Advertisement::class, 'advertisement_id', 'id');
    }

    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'admin_id', 'id');
    }
}
