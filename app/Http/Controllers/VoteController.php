<?php

namespace App\Http\Controllers;

use App\Services\ApiClient;
use Illuminate\Http\Request;

class VoteController extends Controller
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
            'vote_type' => 'required|in:upvote,downvote',
        ]);

        try {
            $response = $this->api->post('votes', [
                'report_id' => $request->report_id,
                'vote_type' => $request->vote_type,
                'user_id' => session('user.id'),
            ]);

            if ($response->successful()) {
                return response()->json($response->json());
            }

            return response()->json(['error' => 'Gagal membuat vote'], 400);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Koneksi gagal'], 500);
        }
    }
}
