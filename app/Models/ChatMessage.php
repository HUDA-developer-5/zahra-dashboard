<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use App\Enums\ChatMessageFromTypeEnums;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChatMessage extends Model
{
    use CrudTrait;
    use HasFactory;

    protected $table = 'chat_messages';

    protected $fillable = ['chat_id', 'sender_id', 'receiver_id', 'message', 'type', 'from_type', 'offer_id', 'is_read'];


    public function chat(): BelongsTo
    {
        return $this->belongsTo(Chat::class, 'chat_id', 'id');
    }

    public function sender(): BelongsTo
    {
        if ($this->from_type == ChatMessageFromTypeEnums::FROM_ADMIN->value) {
            return $this->belongsTo(Admin::class, 'sender_id', 'id');
        } else {
            return $this->belongsTo(User::class, 'sender_id', 'id');
        }
    }

    public function receiver(): BelongsTo
    {
        if ($this->from_type == ChatMessageFromTypeEnums::FROM_ADMIN->value) {
            return $this->belongsTo(Admin::class, 'receiver_id', 'id');
        } else {
            return $this->belongsTo(User::class, 'receiver_id', 'id');
        }
    }

    public function offer(): BelongsTo
    {
        return $this->belongsTo(UserAdsOffer::class, 'offer_id', 'id');
    }
}
