<?php

namespace App\Http\Controllers;

use App\Services\ApiClient;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    protected $api;

    public function __construct(ApiClient $api)
    {
        $this->api = $api;
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        try {
            // Try backend API first
            $response = $this->api->post('auth/login', [
                'email' => $request->email,
                'password' => $request->password,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $user = $data['data']['user'];
                $token = $data['data']['token'];

                // Store in session
                session([
                    'user' => [
                        'id' => $user['id'],
                        'name' => $user['name'],
                        'email' => $user['email'],
                        'role' => $user['role'] ?? 'user',
                    ],
                    'token' => $token,
                    'authenticated' => true,
                ]);

                // Redirect based on role
                if ($user['role'] === 'admin') {
                    return redirect()->route('admin.dashboard')->with('success', 'Berhasil login sebagai Admin!');
                }

                return redirect()->route('home')->with('success', 'Berhasil login!');
            }

            return back()->withInput()->with('error', 'Email atau password salah.');
        } catch (\Exception $e) {
            // Fallback: coba login dari database lokal
            $user = User::where('email', $request->email)->first();

            if ($user && Hash::check($request->password, $user->password)) {
                session([
                    'user' => [
                        'id' => $user->id,
                        'name' => $user->name,
                        'email' => $user->email,
                        'role' => $user->role ?? 'user',
                    ],
                    'token' => Str::random(60),
                    'authenticated' => true,
                ]);

                return redirect()->route('home')->with('success', 'Berhasil login!');
            }

            return back()->withInput()->with('error', 'Email atau password salah.');
        }
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        // Validasi tanpa unique (backend akan handle)
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email',
            'bulan' => 'required|string',
            'hari'  => 'required|integer|min:1|max:31',
            'tahun' => 'required|integer|min:1900',
        ]);

        // Simpan sementara data registrasi (flow 2-step)
        session(['temp_register' => [
            'name' => $request->name,
            'email' => $request->email,
            'dob' => $request->hari . ' ' . $request->bulan . ' ' . $request->tahun,
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

        $request->validate([
            'password' => 'required|string|min:6',
            'password_confirmation' => 'required|same:password',
        ]);

        $temp = session('temp_register');

        try {
            // Try backend API first
            $response = $this->api->post('auth/register', [
                'name' => $temp['name'],
                'email' => $temp['email'],
                'password' => $request->password,
                'password_confirmation' => $request->password_confirmation,
            ]);

            if ($response->successful()) {
                $responseData = $response->json();
                
                // Backend response structure: { status, message, data: { user, token } }
                $user = $responseData['data']['user'] ?? null;
                $token = $responseData['data']['token'] ?? null;

                if (!$user || !$token) {
                    return back()->withInput()->with('error', 'Registrasi gagal - data tidak valid');
                }

                session()->forget('temp_register');

                session([
                    'user' => [
                        'id' => $user['id'],
                        'name' => $user['name'],
                        'email' => $user['email'],
                        'role' => $user['role'] ?? 'user',
                    ],
                    'token' => $token,
                    'authenticated' => true,
                ]);

                return redirect('/')->with('success', 'Registrasi berhasil! Selamat datang ' . $user['name'] . '.');
            }

            return back()->withInput()->with('error', 'Email sudah terdaftar atau data invalid');
        } catch (\Exception $e) {
            // Fallback: registrasi ke database lokal
            $existingUser = User::where('email', $temp['email'])->first();
            
            if ($existingUser) {
                return back()->withInput()->with('error', 'Email sudah terdaftar');
            }

            try {
                $newUser = User::create([
                    'name' => $temp['name'],
                    'email' => $temp['email'],
                    'password' => Hash::make($request->password),
                    'role' => 'user',
                ]);

                $token = Str::random(60);

                session()->forget('temp_register');

                session([
                    'user' => [
                        'id' => $newUser->id,
                        'name' => $newUser->name,
                        'email' => $newUser->email,
                        'role' => $newUser->role ?? 'user',
                    ],
                    'token' => $token,
                    'authenticated' => true,
                ]);

                return redirect('/')->with('success', 'Registrasi berhasil! Selamat datang ' . $newUser->name . '.');
            } catch (\Exception $createError) {
                return back()->withInput()->with('error', 'Gagal membuat akun: ' . $createError->getMessage());
            }
        }
    }

    public function logout(Request $request)
    {
        try {
            // Call backend logout API
            $this->api->post('auth/logout');
        } catch (\Exception $e) {
            // Continue logout even if API fails
        }

        $request->session()->forget('user');
        $request->session()->forget('token');
        $request->session()->forget('authenticated');
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

    /**
     * Test registrasi langsung ke database
     */
    public function testRegisterForm()
    {
        $users = User::latest()->get();
        return view('auth.test-register', ['users' => $users]);
    }

    public function testRegisterStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'user',
            ]);

            session([
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $user->role,
                ],
                'token' => Str::random(60),
                'authenticated' => true,
            ]);

            return redirect('/')->with('success', 'Registrasi berhasil! Selamat datang ' . $user->name . '!');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Gagal registrasi: ' . $e->getMessage());
        }
    }

    /**
     * Simple register form (1 halaman)
     */
    public function showSimpleRegisterForm()
    {
        return view('auth.register-simple');
    }

    public function storeSimpleRegister(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ], [
            'email.unique' => 'Email sudah terdaftar. Gunakan email lain.',
            'password.confirmed' => 'Password tidak cocok.',
            'password.min' => 'Password minimal 6 karakter.',
        ]);

        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'user',
            ]);

            session([
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $user->role,
                ],
                'token' => Str::random(60),
                'authenticated' => true,
            ]);

            return redirect('/')->with('success', '✅ Registrasi Berhasil! Selamat datang ' . $user->name . '!');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', '❌ Gagal registrasi: ' . $e->getMessage());
        }
    }
}
