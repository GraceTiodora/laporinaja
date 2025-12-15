<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Carbon;

class MessageController extends Controller
{
    // Get all conversations for the logged in user
    public function conversations()
    {
        $userId = session('user.id');
        $users = User::where('id', '!=', $userId)->get(['id', 'name', 'username', 'avatar']);
        return response()->json($users);
    }

    // Get messages between two users
    public function fetch($userId)
    {
        $authId = session('user.id');
        $messages = Message::where(function($q) use ($authId, $userId) {
            $q->where('sender_id', $authId)->where('receiver_id', $userId);
        })->orWhere(function($q) use ($authId, $userId) {
            $q->where('sender_id', $userId)->where('receiver_id', $authId);
        })->orderBy('created_at')->get();
        return response()->json($messages);
    }

    // Send a message
    public function send(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'content' => 'required|string',
        ]);
        $message = Message::create([
            'sender_id' => session('user.id'),
            'receiver_id' => $request->receiver_id,
            'content' => $request->content,
        ]);
        event(new \App\Events\MessageSent($message));
        return response()->json($message);
    }

    // Mark messages as read
    public function markRead($userId)
    {
        $authId = session('user.id');
        Message::where('sender_id', $userId)
            ->where('receiver_id', $authId)
            ->where('is_read', false)
            ->update(['is_read' => true, 'read_at' => now()]);
        return response()->json(['status' => 'ok']);
    }

    // Typing indicator (simple API, can be improved with broadcasting)
    public function typing(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'is_typing' => 'required|boolean',
        ]);
        // Broadcast typing event
        $senderId = session('user.id');
        $receiverId = $request->receiver_id;
        $isTyping = $request->is_typing;
        event(new \App\Events\TypingStatus($senderId, $receiverId, $isTyping));
        return response()->json(['status' => 'ok']);
    }
}
