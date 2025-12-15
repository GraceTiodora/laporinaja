<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ExploreController;
<<<<<<< Updated upstream
use App\Http\Controllers\TestController;
use App\Http\Controllers\VoteController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\DebugController;
=======
use App\Http\Controllers\GoogleAuthController;
>>>>>>> Stashed changes
use App\Models\Report;
use App\Models\User;

// ======= SIMPLE LOGIN FOR TESTING =======
Route::get('/simple-login', function () {
    return view('auth.simple_login');
})->name('simple-login');

Route::post('/simple-login', function (Illuminate\Http\Request $request) {
    $request->validate([
        'email' => 'required|email|exists:users,email',
    ]);

    $user = User::where('email', $request->email)->first();
    if (!$user) {
        return back()->withErrors(['email' => 'User tidak ditemukan']);
    }

    // Set session
    session([
        'user' => [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->role ?? 'user',
        ],
        'authenticated' => true,
    ]);

    return redirect('/')->with('success', 'Berhasil login sebagai ' . $user->name);
})->name('simple-login-submit');

Route::post('/logout', function () {
    session()->flush();
    return redirect('/')->with('success', 'Berhasil logout');
})->name('logout');
 
Route::get('/', function () {
    // load latest reports from database and map to the frontend structure
    try {
        // Ambil semua laporan untuk statistik sidebar kanan
        $allReports = Report::with('user', 'category', 'comments')->latest()->get();
        $dbReports = $allReports->map(function ($r) {
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

        // Top voted reports tetap hanya 5 teratas
        $topReports = Report::with('user', 'category')
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
                ];
            });

        // Trending by category tetap 5 teratas
        $trendingCategories = Report::with('category')
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
    } catch (\Exception $e) {
        $dbReports = [];
        $topReports = [];
        $trendingCategories = [];
    }

    return session()->has('user')
        ? view('homepage_auth', [
            'dbReports' => $dbReports,
            'topReports' => $topReports,
            'trendingCategories' => $trendingCategories
        ])
        : view('homepage', [
            'dbReports' => $dbReports,
            'topReports' => $topReports,
            'trendingCategories' => $trendingCategories
        ]);
})->name('home');

// Auth Routes
Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login'])->name('login.post');

Route::get('register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('register', [AuthController::class, 'register'])->name('register.post');
Route::get('register/reset', function() {
    session()->forget('temp_register');
    return redirect()->route('register')->with('info', 'Silakan coba lagi dengan email yang berbeda');
})->name('register.reset');

Route::get('register/password', [AuthController::class, 'showPasswordForm'])->name('register.password.form');
Route::post('register/password', [AuthController::class, 'storePassword'])->name('register.password');

// Simple register (1 halaman, lebih mudah)
Route::get('register-simple', [AuthController::class, 'showSimpleRegisterForm'])->name('register.simple');
Route::post('register-simple', [AuthController::class, 'storeSimpleRegister'])->name('register.simple.store');

Route::get('test-register', [AuthController::class, 'testRegisterForm'])->name('test.register.form');
Route::post('test-register', [AuthController::class, 'testRegisterStore'])->name('test.register.store');

Route::post('logout', [AuthController::class, 'logout'])->name('logout');

// Debug routes
Route::prefix('debug')->group(function () {
    Route::get('register', [DebugController::class, 'testRegister'])->name('debug.register');
    Route::post('api/register', [DebugController::class, 'apiRegisterTest'])->name('debug.api.register');
    Route::get('health', [DebugController::class, 'checkHealth'])->name('debug.health');
});

Route::get('explore', [ExploreController::class, 'index'])->name('explore');

// Reports Routes
Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
Route::get('reports/create', [ReportController::class, 'create'])->name('reports.create');
Route::post('reports', [ReportController::class, 'store'])->name('reports.store');

// Test Report Form (untuk debugging)
Route::get('test-post-report', function() {
    try {
        $categories = \App\Models\Category::all()->map(function($cat) {
            return [
                'id' => $cat->id,
                'name' => $cat->name,
            ];
        })->toArray();
    } catch (\Exception $e) {
        $categories = [];
    }
    return view('test-post-report', compact('categories'));
})->name('test.post.report');

Route::get('/reports/{id}', [ReportController::class, 'show'])->name('reports.show');
Route::post('/votes', [VoteController::class, 'store'])->name('reports.vote');
Route::post('/comments', [CommentController::class, 'store'])->name('reports.comment');
Route::get('/reports/{id}/edit', [ReportController::class, 'edit'])->name('reports.edit');
Route::put('/reports/{id}', [ReportController::class, 'update'])->name('reports.update');
Route::delete('/reports/{id}', [ReportController::class, 'destroy'])->name('reports.destroy');
// Fallback for Google login
Route::get('login/google', function () {
    return redirect()->route('login')->with('error', 'Login dengan Google belum dikonfigurasi.');
})->name('login.google');

use App\Http\Controllers\NotificationController;

Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications');
Route::post('/notifications/read/{id}', [NotificationController::class, 'markAsRead'])->name('notifications.read');
Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.readAll');

Route::get('/messages', function () {
    return view('messages');
})->name('messages');


Route::get('my-reports', [UserDashboardController::class, 'myReports'])->name('my-reports');


Route::get('/communities', function () {
    return view('communities');
})->name('communities');


Route::prefix('admin')->group(function () {

    // Dashboard utama admin
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    // Verifikasi & Penanganan
    Route::get('/verifikasi', function () {
        $reports = App\Models\Report::with(['user', 'category'])
            ->orderBy('created_at', 'desc')
            ->get();
        return view('admin.verifikasi', ['reports' => $reports]);
    })->name('admin.verifikasi');

    // Detail Verifikasi - menampilkan detail laporan untuk diverifikasi
    Route::get('/verifikasi/{id}', function ($id) {
        $report = App\Models\Report::with(['user', 'category', 'comments.user'])->findOrFail($id);
        return view('admin.detail_verifikasi', ['report' => $report]);
    })->name('admin.verifikasi.detail');

    // Halaman Validasi - menampilkan form validasi laporan
    Route::get('/verifikasi/{id}/validasi', function ($id) {
        $report = App\Models\Report::with(['user', 'category', 'comments.user'])->findOrFail($id);
        return view('admin.validasi', ['report' => $report]);
    })->name('admin.verifikasi.validasi');

    // Proses Validasi - menerima dan memproses laporan
    Route::post('/verifikasi/{id}/validasi', function ($id) {
        $report = App\Models\Report::findOrFail($id);
        $report->status = 'diproses';
        $report->save();
        return redirect()->route('admin.verifikasi')->with('success', 'Laporan berhasil divalidasi dan sedang diproses');
    })->name('admin.verifikasi.validasi.submit');

    // Halaman Tolak - menampilkan form penolakan laporan
    Route::get('/verifikasi/{id}/tolak', function ($id) {
        $report = App\Models\Report::with(['user', 'category', 'comments.user'])->findOrFail($id);
        return view('admin.tolak', ['report' => $report]);
    })->name('admin.verifikasi.tolak');

    // Proses Tolak - menolak laporan
    Route::post('/verifikasi/{id}/tolak', function ($id) {
        $report = App\Models\Report::findOrFail($id);
        $report->status = 'ditolak';
        $report->save();
        return redirect()->route('admin.verifikasi')->with('success', 'Laporan berhasil ditolak');
    })->name('admin.verifikasi.tolak.submit');

    // Halaman Update Status - menampilkan form update status
    Route::get('/verifikasi/{id}/update-status', function ($id) {
        $report = App\Models\Report::with(['user', 'category', 'comments.user'])->findOrFail($id);
        return view('admin.update_status', ['report' => $report]);
    })->name('admin.verifikasi.update_status');

    // Proses Update Status - mengubah status laporan
    Route::post('/verifikasi/{id}/update-status', function (Illuminate\Http\Request $request, $id) {
        $report = App\Models\Report::findOrFail($id);
        
        // Get status from form if provided, otherwise toggle
        if ($request->has('status_baru') && !empty($request->status_baru)) {
            $report->status = $request->status_baru;
        } else {
            // Fallback: Toggle status
            if ($report->status == 'baru') {
                $report->status = 'diproses';
            } elseif ($report->status == 'diproses') {
                $report->status = 'selesai';
            }
        }
        
        $report->save();
        return redirect()->route('admin.verifikasi')->with('success', 'Status laporan berhasil diupdate');
    })->name('admin.verifikasi.update_status.submit');

    // Monitoring & Statistik
    Route::get('/monitoring', function () {
        return view('admin.monitoring');
    })->name('admin.monitoring');

    // Voting Publik
    Route::get('/voting', function () {
        return view('admin.voting');
    })->name('admin.voting');

    // Pengaturan Akun
    Route::get('/pengaturan', function () {
        return view('admin.pengaturan');
    })->name('admin.pengaturan');
});

// Test API Connection
Route::get('/test-api', [TestController::class, 'testConnection'])->name('test.api');
Route::get('/test', [TestController::class, 'show'])->name('test.show');
Route::get('/test-login', [TestController::class, 'testLogin'])->name('test.login');
Route::get('/test-register', [TestController::class, 'testRegister'])->name('test.register');

// Vote Routes (authenticated)
Route::middleware('web')->post('/votes', [VoteController::class, 'store'])->name('votes.store');

// Comment Routes (authenticated)
Route::middleware('web')->post('/comments', [CommentController::class, 'store'])->name('comments.store');
Route::middleware('web')->get('/comments/{reportId}', [CommentController::class, 'index'])->name('comments.index');

// User Dashboard Routes
Route::middleware('web')->group(function () {
    Route::put('/profile', [UserDashboardController::class, 'updateProfile'])->name('profile.update');
});

// Profile Route (setelah middleware web routes, agar tidak conflict)
Route::get('/profile', function () {
    if (!session()->has('user')) {
        return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
    }

    $userId = session('user.id');
    $user = App\Models\User::find($userId);
    
    if (!$user) {
        return redirect()->route('login')->with('error', 'User tidak ditemukan.');
    }
    
    // Get user's reports
    $reports = App\Models\Report::where('user_id', $userId)
        ->with(['category', 'votes'])
        ->latest()
        ->get();

    // Get user's comments
    $comments = App\Models\Comment::where('user_id', $userId)->with('report.user')->latest()->get();

    // Get user's votes
    $votes = App\Models\Vote::where('user_id', $userId)->latest()->get();

    // Calculate total likes (upvotes) received on all user's reports
    $likes_count = $reports->sum(function($report) {
        return $report->votes->where('is_upvote', 1)->count();
    });

    // Get all reports that the user has liked (upvoted)
    $likedReportIds = App\Models\Vote::where('user_id', $userId)
        ->where('is_upvote', 1)
        ->where('votable_type', App\Models\Report::class)
        ->pluck('votable_id');
    $likedReports = App\Models\Report::whereIn('id', $likedReportIds)
        ->with(['category', 'user', 'votes', 'comments'])
        ->get();

    // Calculate stats
    $stats = [
        'reports_sent' => $reports->count(),
        'issues_resolved' => $reports->where('status', 'Selesai')->count(),
        'community_posts' => $comments->count(),
        'likes_count' => $likes_count,
    ];

    return view('warga.profile', [
        'user' => $user,
        'reports' => $reports,
        'comments' => $comments,
        'votes' => $votes,
        'stats' => $stats,
        'likedReports' => $likedReports,
    ]);
<<<<<<< Updated upstream
})->name('profile');
=======
})->name('profile');

Route::get('/profile/edit', function () {
    if (!session()->has('user')) {
        return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
    }
    return view('warga.edit_profile');
})->name('profile.edit');

// Auth Routes
Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login'])->name('login.post');

Route::get('register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('register', [AuthController::class, 'register'])->name('register.post');

Route::get('register/password', [AuthController::class, 'showPasswordForm'])->name('register.password.form');
Route::post('register/password', [AuthController::class, 'storePassword'])->name('register.password');

Route::post('logout', [AuthController::class, 'logout'])->name('logout');


Route::get('explore', [ExploreController::class, 'index'])->name('explore');

// Reports Routes
Route::get('reports/create', [ReportController::class, 'create'])->name('reports.create');
Route::post('reports', [ReportController::class, 'store'])->name('reports.store');
Route::get('/reports/{id}', [ReportController::class, 'show'])->name('reports.show');
Route::post('/reports/{id}/vote', [ReportController::class, 'vote'])->name('reports.vote');
Route::post('/reports/{id}/comment', [ReportController::class, 'addComment'])->name('reports.comment');
Route::get('/reports/{id}/edit', [ReportController::class, 'edit'])->name('reports.edit');
Route::put('/reports/{id}', [ReportController::class, 'update'])->name('reports.update');
Route::delete('/reports/{id}', [ReportController::class, 'destroy'])->name('reports.destroy');

// Google Auth Routes
Route::get('login/google', [GoogleAuthController::class, 'redirect'])->name('login.google');
Route::get('auth/google/callback', [GoogleAuthController::class, 'callback'])->name('auth.google.callback');

Route::post('profile/update', [AuthController::class, 'updateProfile'])->name('profile.update');

use App\Http\Controllers\NotificationController;

Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications');
Route::post('/notifications/read/{id}', [NotificationController::class, 'markAsRead'])->name('notifications.read');
Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.readAll');

Route::get('/messages', function () {
    return view('warga.messages');
})->name('messages');

Route::get('/communities', function () {
    return view('warga.communities');
})->name('communities');

Route::get('my-reports', [ReportController::class, 'myReports'])->name('my-reports');


Route::prefix('admin')->middleware('admin')->group(function () {
    // Daftar semua laporan (admin)
    Route::get('/reports', [App\Http\Controllers\AdminController::class, 'reports'])->name('admin.reports');

    // Dashboard utama admin - menggunakan controller
    Route::get('/dashboard', [App\Http\Controllers\AdminController::class, 'dashboard'])
        ->name('admin.dashboard');

    // Verifikasi & Penanganan
    Route::get('/verifikasi', function () {
        $reports = App\Models\Report::with(['user', 'category'])
            ->orderBy('created_at', 'desc')
            ->get();

        // Statistik sama seperti dashboard dan monitoring
        $totalReports = App\Models\Report::count();
        $inProgress = App\Models\Report::where('status', 'Dalam Pengerjaan')->count();
        $completed = App\Models\Report::where('status', 'Selesai')->count();
        $waitingVerification = App\Models\Report::where('status', 'Baru')->count();

        return view('admin.verifikasi', [
            'reports' => $reports,
            'totalReports' => $totalReports,
            'inProgress' => $inProgress,
            'completed' => $completed,
            'waitingVerification' => $waitingVerification,
        ]);
    })->name('admin.verifikasi');

    // Detail Verifikasi - menampilkan detail laporan untuk diverifikasi
    Route::get('/verifikasi/{id}', function ($id) {
        $report = App\Models\Report::with(['user', 'category', 'comments.user'])->findOrFail($id);
        return view('admin.detail_verifikasi', ['report' => $report]);
    })->name('admin.verifikasi.detail');

    // Halaman Validasi - menampilkan form validasi laporan
    Route::get('/verifikasi/{id}/validasi', function ($id) {
        $report = App\Models\Report::with(['user', 'category', 'comments.user'])->findOrFail($id);
        return view('admin.validasi', ['report' => $report]);
    })->name('admin.verifikasi.validasi');

    // Proses Validasi - menerima dan memproses laporan (dengan notifikasi)
    Route::post('/verifikasi/{id}/validasi', function ($id) {
        $report = App\Models\Report::findOrFail($id);
        $report->status = 'Dalam Pengerjaan';
        $report->save();
        
        // Kirim notifikasi ke user
        App\Models\Notification::create([
            'user_id' => $report->user_id,
            'report_id' => $report->id,
            'type' => 'status_update',
            'title' => 'Laporan Sedang Diproses',
            'message' => 'Laporan Anda "' . $report->title . '" sedang dalam pengerjaan oleh tim kami.',
            'data' => json_encode([
                'status' => 'Dalam Pengerjaan',
                'icon' => 'sync'
            ]),
            'read' => false
        ]);
        
        return redirect()->route('admin.verifikasi')->with('success', 'Laporan berhasil divalidasi dan sedang diproses');
    })->name('admin.verifikasi.validasi.submit');

    // Halaman Tolak - menampilkan form penolakan laporan
    Route::get('/verifikasi/{id}/tolak', function ($id) {
        $report = App\Models\Report::with(['user', 'category', 'comments.user'])->findOrFail($id);
        return view('admin.tolak', ['report' => $report]);
    })->name('admin.verifikasi.tolak');

    // Proses Tolak - menolak laporan (dengan notifikasi)
    Route::post('/verifikasi/{id}/tolak', function (Illuminate\Http\Request $request, $id) {
        $report = App\Models\Report::findOrFail($id);
        $report->status = 'Ditolak';
        $report->save();
        
        // Kirim notifikasi ke user
        App\Models\Notification::create([
            'user_id' => $report->user_id,
            'report_id' => $report->id,
            'type' => 'status_update',
            'title' => 'Laporan Ditolak',
            'message' => 'Laporan Anda "' . $report->title . '" tidak dapat diproses. Alasan: ' . ($request->input('alasan', 'Tidak memenuhi kriteria')),
            'data' => json_encode([
                'status' => 'Ditolak',
                'icon' => 'times',
                'alasan' => $request->input('alasan')
            ]),
            'read' => false
        ]);
        
        return redirect()->route('admin.verifikasi')->with('success', 'Laporan berhasil ditolak');
    })->name('admin.verifikasi.tolak.submit');

    // Halaman Update Status - menampilkan form update status
    Route::get('/verifikasi/{id}/update-status', function ($id) {
        $report = App\Models\Report::with(['user', 'category', 'comments.user'])->findOrFail($id);
        return view('admin.update_status', ['report' => $report]);
    })->name('admin.verifikasi.update_status');

    // Proses Update Status - menggunakan AdminController dengan notifikasi otomatis
    Route::post('/verifikasi/{id}/update-status', [App\Http\Controllers\AdminController::class, 'updateStatus'])
        ->name('admin.verifikasi.update_status.submit');

    // Monitoring & Statistik
    Route::get('/monitoring', [App\Http\Controllers\AdminController::class, 'monitoring'])->name('admin.monitoring');
    Route::get('/monitoring/pdf', [App\Http\Controllers\AdminController::class, 'exportPDF'])->name('admin.monitoring.pdf');

    // Voting Publik
    Route::get('/voting', function () {
        return view('admin.voting');
    })->name('admin.voting');

    // Pengaturan Akun
    Route::get('/pengaturan', [AdminController::class, 'pengaturan'])->name('admin.pengaturan');
    Route::put('/pengaturan/profile', [AdminController::class, 'updateProfileAdmin'])->name('admin.updateProfile');
    Route::put('/pengaturan/password', [AdminController::class, 'updatePasswordAdmin'])->name('admin.updatePassword');
});
>>>>>>> Stashed changes
