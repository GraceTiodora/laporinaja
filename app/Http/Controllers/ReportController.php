<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function create()
    {
        if (!session()->has('user')) {
            session(['intended_url' => route('reports.create')]);
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu untuk membuat laporan.');
        }

        // Cari view yang tersedia
        foreach (['reports.create', 'create_report', 'reports.create_report'] as $view) {
            if (view()->exists($view)) {
                return view($view);
            }
        }

        return redirect()->route('home')->with('error', 'Halaman buat laporan belum tersedia.');
    }


    public function store(Request $request)
    {
        if (!session()->has('user')) {
            session(['intended_url' => route('reports.create')]);
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Validasi input
        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'location'    => 'nullable|string|max:255',
            'category'    => 'nullable|string|max:255',
            'status'      => 'nullable|string|max:255',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Upload gambar jika ada
        $imagePath = null;

        if ($request->hasFile('image')) {

            $filename = time() . '_' . $request->file('image')->getClientOriginalName();

            if (!file_exists(public_path('images/reports'))) {
                mkdir(public_path('images/reports'), 0777, true);
            }

            $request->file('image')->move(public_path('images/reports'), $filename);

            $imagePath = 'images/reports/' . $filename;
        }

        // Ambil semua reports dari session
        $reports = session('reports', []);

        // Data report baru
        $reports[] = [
            'id'          => count($reports) + 1,
            'user'        => session('user'),
            'title'       => $data['title'],
            'description' => $data['description'],
            'location'    => $data['location'] ?? 'Tidak diketahui',
            'category'    => $data['category'] ?? 'Umum',
            'status'      => $data['status'] ?? 'Baru',
            'image'       => $imagePath,
            'votes'       => 0,
            'comments'    => 0,
            'created_at'  => now()->format('d M Y H:i'),
        ];

        // Simpan kembali data
        session(['reports' => $reports]);
        session()->forget('intended_url');

        return redirect()->route('home')->with('success', 'Laporan berhasil dikirim!');
    }

    public function index()
    {
        $reports = session('reports', []);
        return view('reports.index', compact('reports'));
    }

    public function myReports()
    {
        if (!session()->has('user')) {
            return redirect()->route('login')->with('error', 'Silakan login untuk melihat laporan Anda.');
        }

        $user = session('user');
        $allReports = session('reports', []);

        // Filter laporan milik user
        $myReports = array_filter($allReports, function ($r) use ($user) {
            return isset($r['user']['username']) &&
                   $r['user']['username'] === $user['username'];
        });
        

        return view('my_reports', [
            'user'    => $user,
            'reports' => array_reverse($myReports) // tampilkan terbaru dulu
        ]);
    }
}
