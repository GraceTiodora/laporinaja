<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportController extends Controller
{

    public function create()
    {
        // Cek apakah user sudah login
        if (!session()->has('user')) {
            // Simpan intended URL lalu redirect ke login
            session(['intended_url' => route('reports.create')]);
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu untuk membuat laporan.');
        }

        // Pilih view yang tersedia (support beberapa nama file)
        if (view()->exists('reports.create')) {
            return view('reports.create');
        }

        if (view()->exists('create_report')) {
            return view('create_report');
        }

        if (view()->exists('reports.create_report')) {
            return view('reports.create_report');
        }

        // Fallback: redirect ke home jika view belum ada
        return redirect()->route('home')->with('error', 'Halaman buat laporan belum tersedia.');
    }

    /**
     * Store new report
     */
    public function store(Request $request)
    {
        // Cek apakah user sudah login
        if (!session()->has('user')) {
            session(['intended_url' => route('reports.create')]);
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Validasi input
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle file upload
        $imagePath = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            
            // Buat folder jika belum ada
            if (!file_exists(public_path('images/reports'))) {
                mkdir(public_path('images/reports'), 0777, true);
            }
            
            $image->move(public_path('images/reports'), $imageName);
            $imagePath = 'images/reports/' . $imageName;
        }

        // Ambil reports dari session
        $reports = session('reports', []);
        
        // Tambah report baru
        $newReport = [
            'id' => count($reports) + 1,
            'user' => session('user'),
            'title' => $data['title'],
            'description' => $data['description'],
            'image' => $imagePath,
            'likes' => 0,
            'comments' => 0,
            'created_at' => now()->toDateTimeString(),
        ];
        
        array_unshift($reports, $newReport); // Tambah di awal array
        
        // Simpan kembali ke session
        session(['reports' => $reports]);

        // Hapus intended URL jika ada
        session()->forget('intended_url');

        // Redirect ke home dengan pesan sukses
        return redirect()->route('home')->with('success', 'Postinganmu telah dikirim!');
    }

    /**
     * Display all reports (optional)
     */
    public function index()
    {
        $reports = session('reports', []);
        return view('reports.index', compact('reports'));
    }
    
}