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
            'password' => 'required|string',
        ]);

        $users = session('users', []);

        foreach ($users as $u) {
            if (($u['username'] ?? null) === $data['username'] && password_verify($data['password'], $u['password_hash'] ?? '')) {
                $request->session()->regenerate();
                session(['user' => [
                    'name' => $u['name'] ?? '',
                    'username' => $u['username'],
                    'email' => $u['email'] ?? '',
                ]]);

                if (session()->has('intended_url')) {
                    $intended = session('intended_url');
                    session()->forget('intended_url');
                    return redirect($intended)->with('success', 'Berhasil login!');
                }

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

        // simpan sementara data registrasi (flow 2-step)
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
            'username' => 'required|alpha_num|min:3|max:30',
            'password' => 'required|string|min:6',
        ]);

        $temp = session('temp_register');
        $users = session('users', []);

        // cek unik username/email
        foreach ($users as $u) {
            if (!empty($u['username']) && $u['username'] === $data['username']) {
                return back()->withInput()->with('error', 'Username sudah dipakai.');
            }
            if (!empty($u['email']) && $u['email'] === $temp['email']) {
                return back()->withInput()->with('error', 'Email sudah terdaftar.');
            }
        }

        $users[] = [
            'name' => $temp['name'],
            'email' => $temp['email'],
            'username' => $data['username'],
            'password_hash' => password_hash($data['password'], PASSWORD_DEFAULT),
            'dob' => $temp['dob'],
        ];

        session(['users' => $users]);
        session()->forget('temp_register');

        // auto-login
        session(['user' => [
            'name' => $temp['name'],
            'username' => $data['username'],
            'email' => $temp['email'],
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
    public function updateProfile(\Illuminate\Http\Request $request)
{
    $data = $request->validate([
        'name' => 'required|string|max:255',
        'username' => 'required|alpha_num|max:50',
        'email' => 'nullable|email|max:255',
    ]);

    if (! session()->has('user')) {
        return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
    }

    $user = session('user');
    $user['name'] = $data['name'];
    $user['username'] = $data['username'];
    $user['email'] = $data['email'] ?? ($user['email'] ?? null);

    session(['user' => $user]);

    return redirect()->back()->with('success', 'Profil diperbarui.');
}

}
