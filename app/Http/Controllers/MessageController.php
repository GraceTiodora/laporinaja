<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Message;
use App\Events\MessageSent;

class MessageController extends Controller
{
    // Get messages between authenticated user and another user
    public function index(Request $request)
    {
        $userId = Auth::id();
        $otherUserId = $request->query('user_id');
        $lastId = $request->query('last_id');

        $query = Message::where(function($q) use ($userId, $otherUserId) {
            $q->where('sender_id', $userId)->where('receiver_id', $otherUserId);
        })->orWhere(function($q) use ($userId, $otherUserId) {
            $q->where('sender_id', $otherUserId)->where('receiver_id', $userId);
        });

        if ($lastId) {
            $query->where('id', '>', $lastId);
        }

        $messages = $query->orderBy('id')->get();
        return response()->json($messages);
    }

    // Send a message
    public function store(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'content' => 'required|string',
        ]);
        $message = Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'content' => $request->content,
        ]);
        // Broadcast pesan baru
        broadcast(new MessageSent($message))->toOthers();
        return response()->json($message, 201);
    }
}
