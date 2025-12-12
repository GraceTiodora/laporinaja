<?php

namespace App\Http\Controllers;

use App\Services\ApiClient;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    protected $api;

    public function __construct(ApiClient $api)
    {
        $this->api = $api;
    }

    public function store(Request $request)
    {
        if (!session('authenticated')) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $request->validate([
            'report_id' => 'required|integer',
            'content' => 'required|string|min:3',
        ]);

        try {
            $response = $this->api->post('comments', [
                'report_id' => $request->report_id,
                'content' => $request->content,
                'user_id' => session('user.id'),
            ]);

            if ($response->successful()) {
                return response()->json($response->json());
            }

            return response()->json(['error' => 'Gagal membuat komentar'], 400);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Koneksi gagal'], 500);
        }
    }

    public function index($reportId)
    {
        try {
            $response = $this->api->get("comments?report_id=$reportId");
            
            if ($response->successful()) {
                return response()->json($response->json());
            }

            return response()->json(['error' => 'Gagal memuat komentar'], 400);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Koneksi gagal'], 500);
        }
    }
}
