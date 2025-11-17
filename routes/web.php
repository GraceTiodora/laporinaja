<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ReportController;
<<<<<<< HEAD
use App\Http\Controllers\ExploreController;  // ← TAMBAH INI

Route::get('/', function () {
    return session()->has('user')
        ? view('homepage_auth') 
        : view('homepage');
=======
use App\Http\Controllers\ExploreController;
use App\Http\Controllers\NotificationController;

Route::get('/', function () { 
    if (session()->has('user')) {
        if (view()->exists('home-auth')) {
            return view('home-auth');
        } elseif (view()->exists('homepage_auth')) {
            return view('homepage_auth');
        } else {
            return view('homepage');
        }
    }
    return view('homepage');
>>>>>>> ef3212d4aa787342e59da5fedbeeb6896ed30c0c
})->name('home');


// Auth Routes
Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login'])->name('login.post');

Route::get('register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('register', [AuthController::class, 'register'])->name('register.post');

Route::get('register/password', [AuthController::class, 'showPasswordForm'])->name('register.password.form');
Route::post('register/password', [AuthController::class, 'storePassword'])->name('register.password');

Route::post('logout', [AuthController::class, 'logout'])->name('logout');

<<<<<<< HEAD

Route::get('explore', [ExploreController::class, 'index'])->name('explore');

// Reports Routes
Route::get('reports/create', [ReportController::class, 'create'])->name('reports.create');
Route::post('reports', [ReportController::class, 'store'])->name('reports.store');

// Fallback for Google login
=======
>>>>>>> ef3212d4aa787342e59da5fedbeeb6896ed30c0c
Route::get('login/google', function () {
    return redirect()->route('login')->with('error', 'Login dengan Google belum dikonfigurasi.');
})->name('login.google');

<<<<<<< HEAD
Route::post('profile/update', [AuthController::class, 'updateProfile'])->name('profile.update');

use App\Http\Controllers\NotificationController;

Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications');
Route::post('/notifications/read/{id}', [NotificationController::class, 'markAsRead'])->name('notifications.read');
Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.readAll');

Route::get('/messages', function () {
    return view('messages');
})->name('messages');

Route::get('/my-reports', [ReportController::class, 'myReports'])->name('my.reports');


=======
Route::get('explore', [ExploreController::class, 'index'])->name('explore');

Route::get('notifications', [NotificationController::class, 'index'])->name('notifications');
Route::post('notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
Route::post('notifications/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-read');

Route::get('reports/create', [ReportController::class, 'create'])->name('reports.create');
Route::post('reports', [ReportController::class, 'store'])->name('reports.store');
Route::get('reports', [ReportController::class, 'index'])->name('reports.index'); // Optional: List all reports

Route::post('profile/update', [AuthController::class, 'updateProfile'])->name('profile.update');
Route::get('messages', function () {
    if (!session()->has('user')) {
        return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
    }
    return view('messages'); 
})->name('messages');

Route::get('my-reports', function () {
    if (!session()->has('user')) {
        return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
    }
    return view('my-reports'); 
})->name('my-reports');

Route::get('communities', function () {
    if (!session()->has('user')) {
        return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
    }
    return view('communities');
})->name('communities');
Route::get('profile', function () {
    if (!session()->has('user')) {
        return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
    }
    return view('profile');
})->name('profile');

Route::get('settings', function () {
    if (!session()->has('user')) {
        return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
    }
    return view('settings');
})->name('settings');

Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});
>>>>>>> ef3212d4aa787342e59da5fedbeeb6896ed30c0c
