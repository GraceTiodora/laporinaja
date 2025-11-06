<?php

namespace App\Http\Controllers;

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
            'password' => 'required',
        ]);

        $users = session('users', []);

        foreach ($users as $u) {
            if ($u['username'] === $data['username'] && $u['password'] === $data['password']) {
                session(['user' => [
                    'name' => $u['name'],
                    'username' => $u['username'],
                    'email' => $u['email']
                ]]);
                return redirect()->route('home')->with('success', 'Berhasil login!');
            }
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
            'email' => 'required|email',
            'bulan' => 'required|string',
            'hari'  => 'required|integer|min:1|max:31',
            'tahun' => 'required|integer|min:1900',
        ]);

        $users = session('users', []);
        
        foreach ($users as $u) {
            if ($u['email'] === $data['email']) {
                return back()->withInput()->with('error', 'Email sudah terdaftar.');
            }
        }

        // Simpan data temporary ke session
        session([
            'temp_register' => [
                'name' => $data['name'],
                'email' => $data['email'],
                'dob' => $data['hari'] . ' ' . $data['bulan'] . ' ' . $data['tahun'],
            ]
        ]);

        return redirect()->route('register.password.form');
    }

    public function showPasswordForm()
    {
        if (!session()->has('temp_register')) {
            return redirect()->route('register');
        }
        return view('auth.create-password');
    }

    public function storePassword(Request $request)
    {
        if (!session()->has('temp_register')) {
            return redirect()->route('register');
        }

        $data = $request->validate([
            'password' => 'required|string|min:6',
        ]);

        $tempData = session('temp_register');
        $username = explode('@', $tempData['email'])[0];

        $users = session('users', []);
        $users[] = [
            'name'     => $tempData['name'],
            'email'    => $tempData['email'],
            'username' => $username,
            'password' => $data['password'],
            'dob'      => $tempData['dob'],
        ];

        session(['users' => $users]);
        session()->forget('temp_register');

        // Auto login setelah register
        session(['user' => [
            'name' => $tempData['name'],
            'username' => $username,
            'email' => $tempData['email']
        ]]);

        return redirect()->route('home')->with('success', 'Registrasi berhasil!');
    }

    public function logout(Request $request)
    {
        $request->session()->forget('user');
        return redirect()->route('home')->with('success', 'Berhasil logout!');
    }
}