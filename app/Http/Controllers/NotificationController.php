<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
	/**
	 * Filter notifications by type
	 */
	public function filter($type = null)
	{
		if (!session()->has('user')) {
			return redirect()->route('login')->with('error', 'Silakan login untuk melihat notifikasi.');
		}
		$userId = session('user.id');
		$query = Notification::where('user_id', $userId);
		if ($type) {
			$query->where('type', $type);
		}
		$notifications = $query->orderBy('created_at', 'desc')->get();
		$unreadCount = $notifications->where('read', false)->count();
		return view('warga.notifications', compact('notifications', 'unreadCount', 'type'));
	}

	/**
	 * Show archived (read) notifications
	 */
	public function archive()
	{
		if (!session()->has('user')) {
			return redirect()->route('login')->with('error', 'Silakan login untuk melihat notifikasi.');
		}
		$userId = session('user.id');
		$notifications = Notification::where('user_id', $userId)
			->where('read', true)
			->orderBy('created_at', 'desc')
			->get();
		$unreadCount = Notification::where('user_id', $userId)->where('read', false)->count();
		$archive = true;
		return view('warga.notifications', compact('notifications', 'unreadCount', 'archive'));
	}
	/**
	 * Display notifications page (only for authenticated users)
	 */
	public function index()
	{
		// Cek apakah user sudah login
		if (!session()->has('user')) {
			return redirect()->route('login')->with('error', 'Silakan login untuk melihat notifikasi.');
		}
        
<<<<<<< Updated upstream

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
=======
		$userId = session('user.id');
        
		// Ambil notifications dari database
		$notifications = Notification::where('user_id', $userId)
			->with('report')
			->orderBy('created_at', 'desc')
			->get();

		$unreadCount = $notifications->where('read', false)->count();

		// Data laporan untuk sidebar kanan (konsisten dengan homepage)
		$dbReports = \App\Models\Report::with('user', 'category', 'comments')->latest()->get()->map(function ($r) {
			return [
				'id' => $r->id,
				'user' => ['name' => $r->user->name ?? 'Anonymous'],
				'title' => $r->title,
				'description' => $r->description,
				'location' => $r->location,
				'category' => $r->category->name ?? 'Umum',
				'status' => $r->status ?? 'Baru',
				'votes' => method_exists($r, 'votes') ? $r->votes->where('is_upvote', 1)->count() : 0,
				'comments' => $r->comments->count() ?? 0,
				'created_at' => $r->created_at->diffForHumans(),
				'image' => $r->image ? $r->image : null,
			];
		})->toArray();
>>>>>>> Stashed changes

		$topReports = \App\Models\Report::with('user', 'category')
			->withCount(['votes' => function($query) {
				$query->where('is_upvote', 1);
			}])
			->orderBy('votes_count', 'desc')
			->take(5)
			->get()
			->map(function($r) {
				return [
					'id' => $r->id,
					'title' => $r->title,
					'location' => $r->location,
					'votes' => $r->votes_count,
					'created_at' => $r->created_at->diffForHumans(),
				];
			});

<<<<<<< Updated upstream
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
=======
		$trendingCategories = \App\Models\Report::with('category')
			->select('category_id', \DB::raw('count(*) as total'))
			->whereDate('created_at', '>=', now()->subDays(7))
			->groupBy('category_id')
			->orderBy('total', 'desc')
			->take(5)
			->get()
			->map(function($r) {
				return [
					'category' => $r->category->name ?? 'Umum',
					'total' => $r->total,
				];
			});

		return view('warga.notifications', compact('notifications', 'unreadCount', 'dbReports', 'topReports', 'trendingCategories'));
	}

	/**
	 * Mark notification as read
	 */
	public function markAsRead($id)
	{
		if (!session()->has('user')) {
			return response()->json(['error' => 'Unauthorized'], 401);
		}

		$userId = session('user.id');
        
		$notification = Notification::where('id', $id)
			->where('user_id', $userId)
			->first();
        
		if ($notification) {
			$notification->read = true;
			$notification->save();
			return response()->json(['success' => true]);
		}

		return response()->json(['error' => 'Notification not found'], 404);
	}
>>>>>>> Stashed changes

	/**
	 * Mark all notifications as read
	 */
	public function markAllAsRead()
	{
		if (!session()->has('user')) {
			return response()->json(['error' => 'Unauthorized'], 401);
		}

<<<<<<< Updated upstream
        $notifications = session('notifications', []);
        
        foreach ($notifications as $key => $notification) {
            $notifications[$key]['read'] = true;
        }

        session(['notifications' => $notifications]);
=======
		$userId = session('user.id');
        
		Notification::where('user_id', $userId)
			->where('read', false)
			->update(['read' => true]);
>>>>>>> Stashed changes

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
