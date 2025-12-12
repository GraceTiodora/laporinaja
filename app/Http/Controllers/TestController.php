<?php

namespace App\Http\Controllers;

use App\Services\ApiClient;
use Illuminate\Http\Request;

class TestController extends Controller
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
            // Test GET request ke backend
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
     * Test Login API
     */
    public function testLogin()
    {
        try {
            $response = $this->api->post('auth/login', [
                'email' => 'admin@laporinaja.com',
                'password' => 'password'
            ]);

            if ($response->successful()) {
                $data = $response->json();
                return response()->json([
                    'status' => 'success',
                    'message' => 'Login berhasil',
                    'data' => $data['data'] ?? $data
                ]);
            } else {
                $responseData = $response->json();
                return response()->json([
                    'status' => 'error',
                    'message' => 'Login gagal',
                    'code' => $response->status(),
                    'response' => $responseData
                ], $response->status());
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Connection error: ' . $e->getMessage(),
                'trace' => config('app.debug') ? $e->getTraceAsString() : null
            ], 500);
        }
    }

    /**
     * Test Register API with stored temp data
     */
    public function testRegisterWithSession(Request $request)
    {
        // Simulate having temp_register in session
        session(['temp_register' => [
            'name' => 'Session Test User',
            'email' => 'sessiontest' . time() . '@test.com'
        ]]);

        // Make the actual register call like storePassword does
        $temp = session('temp_register');
        $response = $this->api->post('auth/register', [
            'name' => $temp['name'],
            'email' => $temp['email'],
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        return response()->json([
            'status' => $response->status(),
            'successful' => $response->successful(),
            'body' => $response->body(),
            'json' => $response->json(),
            'headers_content_type' => $response->header('Content-Type'),
        ]);
    }

    /**
     * Show test page
     */
    public function show()
    {
        return view('test.connection');
    }
}
