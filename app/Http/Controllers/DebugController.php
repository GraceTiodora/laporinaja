<?php

namespace App\Http\Controllers;

use App\Services\ApiClient;
use Illuminate\Http\Request;

class DebugController extends Controller
{
    protected $api;

    public function __construct(ApiClient $api)
    {
        $this->api = $api;
    }

    /**
     * Test registrasi step by step
     */
    public function testRegister()
    {
        return view('debug.test-register');
    }

    /**
     * Test API register endpoint
     */
    public function apiRegisterTest(Request $request)
    {
        $data = [
            'name' => $request->input('name', 'Test User'),
            'email' => 'test' . time() . '@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        try {
            $response = $this->api->post('auth/register', $data);

            return response()->json([
                'status' => 'success',
                'data' => $data,
                'api_response' => $response->json(),
                'api_status' => $response->status(),
                'api_successful' => $response->successful(),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
                'data' => $data,
            ], 500);
        }
    }

    /**
     * Check API health
     */
    public function checkHealth()
    {
        try {
            $response = $this->api->get('health');
            
            return response()->json([
                'status' => 'success',
                'backend_running' => true,
                'response' => $response->json(),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
                'backend_running' => false,
            ], 500);
        }
    }
}
