<?php

namespace App\Http\Controllers;

use App\Services\ApiClient;
use Illuminate\Http\Request;

class TestApiController extends Controller
{
    protected $api;

    public function __construct(ApiClient $api)
    {
        $this->api = $api;
    }

    /**
     * Test API connection
     */
    public function testConnection()
    {
        try {
            $response = $this->api->get('user');
            
            if ($response->successful()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Backend API berjalan dengan baik',
                    'data' => $response->json()
                ]);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Backend API error',
                    'code' => $response->status()
                ], 500);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Connection error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Test login with email and password
     */
    public function testLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        try {
            $response = $this->api->post('auth/login', [
                'email' => $request->email,
                'password' => $request->password,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                return response()->json([
                    'status' => 'success',
                    'message' => 'Login berhasil!',
                    'data' => $data['data'] ?? $data
                ]);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Login gagal - Email atau password salah',
                    'code' => $response->status()
                ], 401);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Connection error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Test register
     */
    public function testRegister(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'password' => 'required|string|min:6',
            'password_confirmation' => 'required|same:password',
        ]);

        try {
            $response = $this->api->post('auth/register', [
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password,
                'password_confirmation' => $request->password_confirmation,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                return response()->json([
                    'status' => 'success',
                    'message' => 'Registrasi berhasil!',
                    'data' => $data['data'] ?? $data
                ], 201);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Registrasi gagal',
                    'code' => $response->status(),
                    'errors' => $response->json()
                ], $response->status());
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Connection error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show test page
     */
    public function show()
    {
        return view('test.api');
    }
}
