<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ExploreController;  // ← TAMBAH INI
use App\Models\Report;


Route::get('/', function () {
    // load latest reports from database and map to the frontend structure
    try {
        $latest = Report::with('user', 'category', 'comments')->latest()->take(10)->get();
        $dbReports = $latest->map(function ($r) {
            return [
                'id' => $r->id,
                'user' => ['name' => $r->user->name ?? 'Anonymous'],
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
    } catch (\Exception $e) {
        $dbReports = [];
    }

    return session()->has('user')
        ? view('homepage_auth', ['dbReports' => $dbReports])
        : view('homepage', ['dbReports' => $dbReports]);
})->name('home');

Route::get('/profile', function () {
    if (!session()->has('user')) {
        return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
    }

    $userId = session('user.id');
    $user = App\Models\User::find($userId);
    
    // Get user's reports
    $reports = App\Models\Report::where('user_id', $userId)
        ->with('category')
        ->withCount(['comments', 'votes'])
        ->latest()
        ->get();
    
    // Get user's comments
    $comments = App\Models\Comment::where('user_id', $userId)->with('report.user')->latest()->get();
    
    // Get user's votes
    $votes = App\Models\Vote::where('user_id', $userId)->latest()->get();
    
    // Calculate stats
    $stats = [
        'reports_sent' => $reports->count(),
        'issues_resolved' => $reports->where('status', 'resolved')->count(),
        'community_posts' => $comments->count(),
        'vote_helps' => $votes->where('is_upvote', 1)->count(),
    ];
    
    return view('profile', [
        'user' => $user,
        'reports' => $reports,
        'comments' => $comments,
        'votes' => $votes,
        'stats' => $stats,
    ]);
})->name('profile');

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
// Fallback for Google login
Route::get('login/google', function () {
    return redirect()->route('login')->with('error', 'Login dengan Google belum dikonfigurasi.');
})->name('login.google');

Route::post('profile/update', [AuthController::class, 'updateProfile'])->name('profile.update');

use App\Http\Controllers\NotificationController;

Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications');
Route::post('/notifications/read/{id}', [NotificationController::class, 'markAsRead'])->name('notifications.read');
Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.readAll');

Route::get('/messages', function () {
    return view('messages');
})->name('messages');


Route::get('my-reports', [ReportController::class, 'myReports'])->name('my-reports');


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
        return view('admin.verifikasi');
    })->name('admin.verifikasi');

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