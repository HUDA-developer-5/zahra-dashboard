<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\ChatMessage;
use Illuminate\Http\Request;

class ChatApiController extends Controller
{
    public function createChat(Request $request)
    {
        $request->validate(['user_ids' => 'required|array', 'user_ids.*' => 'exists:users,id']);

        // Check if a chat already exists between the users
        $existingChat = Chat::whereHas('participants', function($query) use ($request) {
            $query->whereIn('user_id', $request->user_ids);
        }, '=', count($request->user_ids))->first();

        if ($existingChat) {
            return response()->json($existingChat, 200);
        }

        $chat = Chat::create();
        $chat->participants()->attach($request->user_ids);

        return response()->json($chat, 201);
    }

    public function sendMessage(Request $request, $chatId)
    {
        $request->validate(['message_text' => 'required_without:message_url|string', 'message_url' => 'nullable|string']);
        $chat = Chat::findOrFail($chatId);

        if (!$chat->participants->contains(auth('api')->id())) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $message = ChatMessage::create([
            'chat_id' => $chatId,
            'user_id' => auth('api')->id(),
            'message_text' => $request->message_text,
            'message_type' => $request->message_type ?? 'text',
            'message_url' => $request->message_url,
        ]);

        return response()->json($message, 201);
    }

    public function getMessages($chatId)
    {
        $chat = Chat::findOrFail($chatId);

        if (!$chat->participants->contains(auth('api')->id())) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $messages = $chat->messages()->with('user')->get();
        return response()->json($messages);
    }

    public function listUserChats()
    {
        $chats = auth('api')->user()->chats()->with(['participants', 'messages' => function ($query) {
            $query->latest();
        }])->get();

        return response()->json($chats);
    }
}
