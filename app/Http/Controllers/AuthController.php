<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // Cari user berdasarkan username
        $user = User::findByUsername($data['username']);

        if ($user && $user->checkPassword($data['password'])) {
            $request->session()->regenerate();
            session(['user' => [
                'id_user' => $user->id_user,
                'name' => $user->name,
                'username' => $user->username,
                'email' => $user->email,
            ]]);

            if (session()->has('intended_url')) {
                $intended = session('intended_url');
                session()->forget('intended_url');
                return redirect($intended)->with('success', 'Berhasil login!');
            }

            return redirect()->route('home')->with('success', 'Berhasil login!');
        }

        return back()->withInput()->with('error', 'Username atau password salah.');
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'bulan' => 'required|string',
            'hari'  => 'required|integer|min:1|max:31',
            'tahun' => 'required|integer|min:1900',
        ]);

        // Simpan sementara di session
        session(['temp_register' => [
            'name' => $data['name'],
            'email' => $data['email'],
            'dob' => $data['hari'] . ' ' . $data['bulan'] . ' ' . $data['tahun'],
        ]]);

        return redirect()->route('register.password.form');
    }

    public function showPasswordForm()
    {
        if (!session()->has('temp_register')) {
            return redirect()->route('register');
        }
        return view('auth.password');
    }

    public function storePassword(Request $request)
    {
        if (!session()->has('temp_register')) {
            return redirect()->route('register');
        }

        $data = $request->validate([
            'username' => 'required|alpha_num|min:3|max:30|unique:users,username',
            'password' => 'required|string|min:6',
        ]);

        $temp = session('temp_register');

        // Create user di database
        $user = User::create([
            'name' => $temp['name'],
            'email' => $temp['email'],
            'username' => $data['username'],
            'password' => password_hash($data['password'], PASSWORD_DEFAULT),
            'date_of_birth' => $temp['dob'],
            'role' => 'user',
        ]);

        session()->forget('temp_register');

        // Auto-login
        session(['user' => [
            'id_user' => $user->id_user,
            'name' => $user->name,
            'username' => $user->username,
            'email' => $user->email,
        ]]);

        $request->session()->regenerate();

        if (session()->has('intended_url')) {
            $intended = session('intended_url');
            session()->forget('intended_url');
            return redirect($intended)->with('success', 'Registrasi sukses!');
        }

        return redirect()->route('home')->with('success', 'Registrasi sukses!');
    }

    public function logout(Request $request)
    {
        $request->session()->forget('user');
        $request->session()->regenerate();
        return redirect()->route('home')->with('success', 'Berhasil logout!');
    }

    public function updateProfile(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|alpha_num|max:50|unique:users,username,' . session('user.id_user') . ',id_user',
            'email' => 'nullable|email|max:255|unique:users,email,' . session('user.id_user') . ',id_user',
        ]);

        if (!session()->has('user')) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $user = User::find(session('user.id_user'));
        $user->update($data);

        session(['user' => [
            'id_user' => $user->id_user,
            'name' => $user->name,
            'username' => $user->username,
            'email' => $user->email,
        ]]);

        return redirect()->back()->with('success', 'Profil diperbarui.');
    }
}
