<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Models\Message;

class MessageApiController extends Controller
{
    // IS TYPING: Set typing status in cache
    public function typing(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|integer',
        ]);
        $senderId = session('user.id');
        $receiverId = $request->receiver_id;
        $key = "typing:{$senderId}:{$receiverId}";
        Cache::put($key, true, now()->addSeconds(4));
        return response()->json(['typing' => true]);
    }

    // IS TYPING: Get typing status from cache
    public function typingStatus(Request $request)
    {
        $request->validate([
            'sender_id' => 'required|integer',
        ]);
        $senderId = $request->sender_id;
        $receiverId = session('user.id');
        $key = "typing:{$senderId}:{$receiverId}";
        return response()->json(['typing' => Cache::has($key)]);
    }

    // READ MESSAGE: Mark message as read
    public function markAsRead($id)
    {
        $userId = session('user.id');
        $message = Message::where('id', $id)
            ->where('receiver_id', $userId)
            ->firstOrFail();
        if ($message->read_at === null) {
            $message->update(['read_at' => now()]);
        }
        return response()->json([
            'read' => true,
            'read_at' => $message->read_at
        ]);
    }
}
