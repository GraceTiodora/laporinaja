<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Display notifications page (only for authenticated users)
     */
    public function index()
    {
        // Cek apakah user sudah login
        if (!session()->has('user')) {
            return redirect()->route('login')->with('error', 'Silakan login untuk melihat notifikasi.');
        }
        

        // Ambil notifications dari session
        $notifications = session('notifications', []);

        // Jika belum ada, buat dummy notifications
        if (empty($notifications)) {
            $notifications = $this->getDummyNotifications();
            session(['notifications' => $notifications]);
        }

        return view('notifications', [
            'notifications' => $notifications,
            'unreadCount' => count(array_filter($notifications, function($n) {
                return !$n['read'];
            }))
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

        $notifications = session('notifications', []);
        
        foreach ($notifications as $key => $notification) {
            if ($notification['id'] == $id) {
                $notifications[$key]['read'] = true;
                break;
            }
        }

        session(['notifications' => $notifications]);

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

        $notifications = session('notifications', []);
        
        foreach ($notifications as $key => $notification) {
            $notifications[$key]['read'] = true;
        }

        session(['notifications' => $notifications]);

        return redirect()->back()->with('success', 'Semua notifikasi telah ditandai sebagai dibaca.');
    }

    /**
     * Get dummy notifications for demo
     */
    private function getDummyNotifications()
    {
        return [
            [
                'id' => 1,
                'type' => 'vote',
                'title' => 'Seseorang memberikan vote pada laporanmu',
                'message' => 'Laporan "Jalan berlubang di Jl. Melati" menerima 5 vote baru',
                'time' => '12 menit lalu',
                'read' => false,
                'created_at' => now()->subMinutes(12)->toDateTimeString(),
            ],
            [
                'id' => 2,
                'type' => 'comment',
                'title' => 'Komentar baru pada laporanmu',
                'message' => 'Siti Rahma berkomentar: "Saya juga sering lewat sini, memang sangat berbahaya."',
                'time' => '2 jam lalu',
                'read' => false,
                'created_at' => now()->subHours(2)->toDateTimeString(),
            ],
            [
                'id' => 3,
                'type' => 'status',
                'title' => 'Status laporan diperbarui',
                'message' => 'Laporan "Lampu jalan mati di RT 05" telah ditandai sebagai "Sedang Diproses".',
                'time' => '12 jam lalu',
                'read' => true,
                'created_at' => now()->subHours(12)->toDateTimeString(),
            ],
            [
                'id' => 4,
                'type' => 'trending',
                'title' => 'Laporanmu sedang trending',
                'message' => 'Laporan "Sampah menumpuk di Pasar Baru" telah menerima lebih dari 50 vote dan kini masuk daftar trending.',
                'time' => '1 hari yang lalu',
                'read' => true,
                'created_at' => now()->subDay()->toDateTimeString(),
            ],
            [
                'id' => 5,
                'type' => 'status',
                'title' => 'Laporanmu telah diselesaikan',
                'message' => 'Laporan "Lampu jalan mati di RT 05" yang kamu buat telah diperbaiki dan ditandai sebagai selesai.',
                'time' => '2 hari yang lalu',
                'read' => true,
                'created_at' => now()->subDays(2)->toDateTimeString(),
            ],
            [
                'id' => 6,
                'type' => 'comment',
                'title' => 'Komentar baru pada laporanmu',
                'message' => 'Ada 3 komentar baru pada laporan "Jalan berlubang di Jl. Melati".',
                'time' => '3 hari yang lalu',
                'read' => true,
                'created_at' => now()->subDays(3)->toDateTimeString(),
            ],
        ];
    }

    /**
     * Add new notification (helper method)
     */
    public static function addNotification($type, $title, $message)
    {
        if (!session()->has('user')) {
            return;
        }

        $notifications = session('notifications', []);
        
        $newNotification = [
            'id' => count($notifications) + 1,
            'type' => $type,
            'title' => $title,
            'message' => $message,
            'time' => 'Baru saja',
            'read' => false,
            'created_at' => now()->toDateTimeString(),
        ];

        array_unshift($notifications, $newNotification);
        session(['notifications' => $notifications]);
    }
}