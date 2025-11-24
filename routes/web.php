<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ExploreController;
use App\Http\Controllers\AdminController;


Route::get('/', function () {
    return session()->has('user')
        ? view('warga.homepage_auth') 
        : view('warga.homepage');
})->name('home');

Route::get('/profile', function () {
    if (!session()->has('user')) {
        return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
    }

    return view('warga.profile', ['user' => session('user')]);
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
Route::get('/reports', [ReportController::class, 'index'])->name('reports');
Route::get('/reports/{id}', [ReportController::class, 'show'])->name('reports.show');
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
    return view('warga.messages');
})->name('messages');


Route::get('my-reports', [ReportController::class, 'myReports'])->name('my-reports');


Route::get('/communities', function () {
    return view('warga.communities');
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