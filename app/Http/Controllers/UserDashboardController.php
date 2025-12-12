<?php

namespace App\Http\Controllers;

use App\Services\ApiClient;
use Illuminate\Http\Request;

class UserDashboardController extends Controller
{
    protected $api;

    public function __construct(ApiClient $api)
    {
        $this->api = $api;
    }

    public function profile()
    {
        if (!session('authenticated')) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu');
        }

        return view('profile.dashboard', [
            'user' => session('user'),
        ]);
    }

    public function myReports()
    {
        if (!session('authenticated')) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu');
        }

        try {
            $response = $this->api->get('reports?user_id=' . session('user.id'));
            $reports = $response->successful() ? $response->json()['data'] : [];
            
            return view('profile.reports', [
                'user' => session('user'),
                'reports' => $reports,
            ]);
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memuat laporan Anda');
        }
    }

    public function updateProfile(Request $request)
    {
        if (!session('authenticated')) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
        ]);

        try {
            $response = $this->api->put('user', [
                'name' => $request->name,
                'email' => $request->email,
            ]);

            if ($response->successful()) {
                session(['user' => array_merge(session('user'), [
                    'name' => $request->name,
                    'email' => $request->email,
                ])]);
                
                return back()->with('success', 'Profil berhasil diperbarui');
            }

            return back()->with('error', 'Gagal memperbarui profil');
        } catch (\Exception $e) {
            return back()->with('error', 'Koneksi gagal');
        }
    }
}
