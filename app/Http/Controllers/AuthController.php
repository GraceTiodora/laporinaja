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
            ]]);

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
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'bio' => 'nullable|string|max:500',
        ]);

        try {
            $userId = session('user.id');
            $user = User::find($userId);

            if (! $user) {
                return redirect()->route('login')->with('error', 'User tidak ditemukan.');
            }

            $user->update($data);

            session(['user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'avatar' => $user->avatar,
            ]]);

            return redirect()->route('profile')->with('success', 'Profil berhasil diperbarui!');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}

