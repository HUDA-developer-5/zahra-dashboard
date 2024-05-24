<?php

namespace App\Services;

use App\Enums\ChatMessageFromTypeEnums;
use App\Enums\ChatTypeEnums;
use App\Models\Chat;
use App\Models\ChatMessage;
use App\Models\UserAdsOffer;

class ChatMessageService
{
    public function startChat(int $receiverId, int $senderId, ChatTypeEnums $type): Chat
    {
        // check if there is no chat between sender and receiver
        $chat = $this->findChat($receiverId, $senderId, $type);
        if (!$chat) {
            $chat = $this->createChat($receiverId, $senderId, $type);
        }

        return $chat;
    }

    public function sendOfferMessage(Chat $chat, UserAdsOffer $offer): ChatMessage
    {
        // create chatMessage record
        if ($chat->type == ChatTypeEnums::USER_TO_USER->value) {
            $fromType = ChatMessageFromTypeEnums::FROM_USER->value;
        } else {
            $fromType = ChatMessageFromTypeEnums::FROM_ADMIN->value;
        }
        return ChatMessage::updateOrCreate(
            [
                'chat_id' => $chat->id,
                'offer_id' => $offer->id,
                'sender_id' => $chat->sender_id,
                'receiver_id' => $chat->receiver_id
            ],
            [
                'from_type' => $fromType,
                'type' => 'offer',
                'message' => 'Offer: ' . $offer->offer . ' ' . $offer->advertisement->currency . ' for ' . $offer->advertisement->name
            ]);
    }

    public function sendTextMessage(int $chatId, string $message, int $sender_id): bool
    {
        $chat = Chat::find($chatId);
        if (!$chat) {
            return false;
        }
        if ($sender_id == $chat->sender_id) {
            $receiver_id = $chat->receiver_id;
        } else {
            $receiver_id = $chat->sender_id;
        }
        // mark previous messages as read from this user
        $this->marchChatMessagesAsRead($chatId, $sender_id);
        $this->createTextMessage($chat, $message, ChatMessageFromTypeEnums::FROM_USER, $sender_id, $receiver_id);
        return true;
    }

    public function createTextMessage(Chat $chat, $message, ChatMessageFromTypeEnums $fromType, int $senderId, int $receiverId): ChatMessage
    {
        return ChatMessage::create([
            'chat_id' => $chat->id,
            'sender_id' => $senderId,
            'receiver_id' => $receiverId,
            'from_type' => $fromType->value,
            'message' => $message,
            'type' => 'text'
        ]);
    }

    public function marchChatMessagesAsRead(int $chatId, int $sender_id): void
    {
        // mark previous messages as read from this user
        ChatMessage::where('chat_id', '=', $chatId)->where('receiver_id', '=', $sender_id)->update(['is_read' => 1]);
    }

    public function findChat(int $receiverId, int $senderId, ChatTypeEnums $type)
    {
        $chat = null;
        if ($type->value == ChatTypeEnums::USER_TO_USER->value) {
            $chat = Chat::where('sender_id', $senderId)
                ->where('receiver_id', $receiverId)
                ->where('type', $type->value)
                ->first();
            if (!$chat) {
                $chat = Chat::where('sender_id', $receiverId)
                    ->where('receiver_id', $senderId)
                    ->where('type', $type->value)
                    ->first();
            }
        }
        if ($type->value == ChatTypeEnums::USER_TO_ADMIN->value) {
            $chat = Chat::where('sender_id', $senderId)
                ->where('receiver_id', $receiverId)
                ->where('type', $type->value)
                ->first();
        }
        if (!$chat) {
            $chat = Chat::create([
                'sender_id' => $senderId,
                'receiver_id' => $receiverId,
                'type' => $type->value
            ]);
        }
        return $chat;
    }

    private function createChat(int $receiverId, int $senderId, ChatTypeEnums $type): Chat
    {
        return Chat::create([
            'sender_id' => $senderId,
            'receiver_id' => $receiverId,
            'type' => $type->value
        ]);
    }

    public function getUserChats(int $userId, $search = null)
    {
        return Chat::where('sender_id', '=', $userId)
            ->orWhere(function ($query) use ($userId, $search) {
                if ($search) {
                    $query->whereHas('messages', function ($query) use ($search) {
                        $query->where('message', 'like', "%" . $search . "%");
                    });
                }
                $query->where('receiver_id', '=', $userId);
            })->with('messages', 'sender', 'unReadMessages')->latest()->get();
    }

    public function getChatMessages(int $chatId)
    {
        return ChatMessage::where('chat_id', '=', $chatId)
            ->with('sender', 'receiver', 'offer.advertisement')
            ->get();
    }

    public function getUserUnreadMessages(int $userId, int $limit = null)
    {
        $chats = $this->getUserChats($userId);
        if ($chats->count() == 0) {
            return [];
        }
        $query = ChatMessage::whereIn('chat_id', $chats->pluck('id')->toArray())
            ->where('receiver_id', '=', $userId)
            ->where('is_read', '=', 0);
        if ($limit) {
            $query->limit($limit);
        }
        return $query->with('chat', 'sender')->get();
    }

    public function getUserUnreadMessagesCount(int $userId): int
    {
        $chats = $this->getUserChats($userId);
        if ($chats->count() == 0) {
            return 0;
        }
        $query = ChatMessage::whereIn('chat_id', $chats->pluck('id')->toArray())
            ->where('receiver_id', '=', $userId)
            ->where('is_read', '=', 0);

        return $query->count();
    }
}