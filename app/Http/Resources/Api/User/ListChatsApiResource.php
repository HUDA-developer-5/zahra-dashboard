<?php

namespace App\Http\Resources\Api\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ListChatsApiResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'sender_name' => $this->sender_name,
            'sender_avatar' => $this->sender_avatar,
            'unread_count' => $this->unReadChatMessagesCount(auth('api')->id()),
            'created_at' => $this->created_at->format('h:i A'),
            'message' => $this->messages?->last()?->message,
        ];
    }
}
