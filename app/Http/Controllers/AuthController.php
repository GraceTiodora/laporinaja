<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        // Cek user di database
        $user = User::where('email', $data['email'])->first();

        if ($user && Hash::check($data['password'], $user->password)) {
            // Login berhasil
            Auth::login($user, $request->has('remember'));
            $request->session()->regenerate();

            session(['user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'avatar' => $user->avatar,
                'role' => $user->role ?? 'user',
            ]]);

            // Redirect berdasarkan role
            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard')->with('success', 'Berhasil login sebagai Admin!');
            }

            return redirect()->route('home')->with('success', 'Berhasil login!');
        }

        return back()->withInput()->with('error', 'Email atau password salah.');
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'bulan' => 'required|string',
            'hari'  => 'required|integer|min:1|max:31',
            'tahun' => 'required|integer|min:1900',
        ]);

        // Simpan sementara data registrasi (flow 2-step)
        session(['temp_register' => [
            'name' => $data['name'],
            'email' => $data['email'],
            'dob' => $data['hari'] . ' ' . $data['bulan'] . ' ' . $data['tahun'],
        ]]);

        return redirect()->route('register.password.form');
    }

    public function showPasswordForm()
    {
        if (! session()->has('temp_register')) {
            return redirect()->route('register');
        }
        return view('auth.password');
    }

    public function storePassword(Request $request)
    {
        if (! session()->has('temp_register')) {
            return redirect()->route('register');
        }

        $data = $request->validate([
            'password' => 'required|string|min:6',
            'password_confirmation' => 'required|same:password',
        ]);

        $temp = session('temp_register');

        try {
            // Buat user baru di database
            $user = User::create([
                'name' => $temp['name'],
                'email' => $temp['email'],
                'password' => Hash::make($data['password']),
            ]);

            session()->forget('temp_register');

            // Auto-login setelah register
            Auth::login($user);
            $request->session()->regenerate();

            session(['user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'avatar' => $user->avatar,
            ]]);

            return redirect()->route('home')->with('success', 'Registrasi sukses! Selamat datang.');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->forget('user');
        $request->session()->regenerate();
        return redirect()->route('home')->with('success', 'Berhasil logout!');
    }

    public function updateProfile(Request $request)
    {
        if (! session()->has('user')) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $data = $request->validate([
            'name' => 'required|string|min:3|max:255',
            'username' => 'required|string|min:3|max:255|alpha_dash',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'bio' => 'nullable|string|max:500',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'name.required' => 'Nama wajib diisi.',
            'name.min' => 'Nama minimal 3 karakter.',
            'username.required' => 'Username wajib diisi.',
            'username.min' => 'Username minimal 3 karakter.',
            'username.alpha_dash' => 'Username hanya boleh huruf, angka, dash dan underscore.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'phone.max' => 'Nomor telepon maksimal 20 karakter.',
            'bio.max' => 'Bio maksimal 500 karakter.',
            'avatar.image' => 'File harus berupa gambar.',
            'avatar.mimes' => 'Format gambar harus: JPEG, PNG, JPG, atau GIF.',
            'avatar.max' => 'Ukuran gambar maksimal 2MB.',
        ]);

        try {
            $userId = session('user.id');
            $user = User::find($userId);

            if (! $user) {
                return redirect()->route('login')->with('error', 'User tidak ditemukan.');
            }

            // Handle avatar upload
            if ($request->hasFile('avatar')) {
                $avatarPath = $request->file('avatar')->store('avatars', 'public');
                $data['avatar'] = '/storage/' . $avatarPath;
                
                // Delete old avatar if exists and not default
                if ($user->avatar && !str_contains($user->avatar, 'ui-avatars.com')) {
                    $oldPath = str_replace('/storage/', '', $user->avatar);
                    if (\Storage::disk('public')->exists($oldPath)) {
                        \Storage::disk('public')->delete($oldPath);
                    }
                }
            }

            $user->update($data);

            // Update session with new data
            session(['user' => [
                'id' => $user->id,
                'name' => $user->name,
                'username' => $user->username,
                'email' => $user->email,
                'phone' => $user->phone,
                'bio' => $user->bio,
                'avatar' => $user->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($user->name),
                'role' => $user->role ?? 'user',
            ]]);

            return redirect()->route('profile')->with('success', '✨ Profil berhasil diperbarui! Semua perubahan sudah disimpan.');
        } catch (\Exception $e) {
            return back()->with('error', '❌ Gagal memperbarui profil: ' . $e->getMessage());
        }
    }
}

