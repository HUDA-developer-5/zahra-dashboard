<?php

namespace App\Models;

use App\Enums\ChatTypeEnums;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Chat extends Model
{
    use HasFactory;

    protected $table = 'chats';

    protected $fillable = ['sender_id', 'receiver_id', 'type'];

    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id', 'id');
    }

    public function receiver(int $type, $receiver_id)
    {
        if ($type == ChatTypeEnums::USER_TO_USER->value) {
            return User::find($receiver_id);
        } else {
            return Admin::find($receiver_id);
        }
    }

    public function messages(): HasMany
    {
        return $this->hasMany(ChatMessage::class, 'chat_id', 'id');
    }

    public function unReadMessages()
    {
        return $this->hasMany(ChatMessage::class, 'chat_id', 'id')
            ->where('is_read', '=', 0);
    }

    public function unReadMessagesCount(): int
    {
        return $this->unReadMessages()->count();
    }

    public function unReadChatMessagesCount($userId): int
    {
        return $this->unReadMessages()
            ->where('receiver_id', '=', $userId)
            ->count();
    }

    public function getSenderNameAttribute()
    {
        if ($this->type == ChatTypeEnums::USER_TO_USER->value) {
            if (auth('users')->check() && $this->sender_id == auth('users')->user()->id) {
                $receiver = $this->receiver((int)$this->type, $this->receiver_id);
                if ($receiver) {
                    return $receiver->name;
                }
            }
            return $this->sender->name;
        } else {
            return "Unknown";
        }
    }

    public function getSenderAvatarAttribute()
    {
        if ($this->type == ChatTypeEnums::USER_TO_USER->value) {
            if (auth('users')->check() && $this->sender_id == auth('users')->user()->id) {
                $receiver = $this->receiver((int)$this->type, $this->receiver_id);
                if ($receiver) {
                    return $receiver->image ? $receiver->image_path : asset('frontend/assets/images/icons/profile-circle.svg');
                }
            }
            return $this->sender->image ? $this->sender->image_path : asset('frontend/assets/images/icons/profile-circle.svg');
        }
        return asset('frontend/assets/images/icons/profile-circle.svg');
    }
}
