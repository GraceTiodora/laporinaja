<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $users = session('users', []);

        foreach ($users as $u) {
            if ($u['email'] === $data['email'] && $u['password'] === $data['password']) {
                session(['user' => ['name' => $u['name'], 'email' => $u['email']]]);
                return redirect()->route('home');
            }
        }

        return back()->withInput()->with('error', 'Email atau password salah.');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email',
            'password' => 'required|min:4',
        ]);

        $users = session('users', []);
        foreach ($users as $u) {
            if ($u['email'] === $data['email']) {
                return back()->withInput()->with('error', 'Email sudah terdaftar.');
            }
        }

        $users[] = [
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => $data['password'],
        ];

        session(['users' => $users, 'user' => ['name' => $data['name'], 'email' => $data['email']]]);

        return redirect()->route('home');
    }

    public function logout(Request $request)
    {
        $request->session()->forget('user');
        return redirect()->route('home');
    }
}