<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Display notifications page (only for authenticated users)
     */
    public function index()
    {
        if (!session()->has('user')) {
            return redirect()->route('login')->with('error', 'Silakan login untuk melihat notifikasi.');
        }

        $notifications = Notification::where('id_user', session('user.id_user'))
                                     ->orderByDesc('created_at')
                                     ->get();

        $unreadCount = Notification::getUnreadCount(session('user.id_user'));

        return view('notifications', [
            'notifications' => $notifications,
            'unreadCount' => $unreadCount
        ]);
    }

    /**
     * Mark notification as read
     */
    public function markAsRead($id)
    {
        if (!session()->has('user')) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $notification = Notification::findOrFail($id);
        
        if ($notification->id_user != session('user.id_user')) {
            return response()->json(['error' => 'Forbidden'], 403);
        }

        $notification->update(['read' => true]);

        return response()->json(['success' => true]);
    }

    /**
     * Mark all notifications as read
     */
    public function markAllAsRead()
    {
        if (!session()->has('user')) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        Notification::where('id_user', session('user.id_user'))
                    ->update(['read' => true]);

        return redirect()->back()->with('success', 'Semua notifikasi telah ditandai sebagai dibaca.');
    }

    /**
     * Add new notification (helper method)
     */
    public static function addNotification($userId, $type, $title, $message)
    {
        return Notification::createNew($userId, $type, $title, $message);
    }
}