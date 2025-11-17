<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportController extends Controller
{

<<<<<<< HEAD
    /**
     * ================================
     * SHOW CREATE REPORT PAGE
     * ================================
     */
    public function create()
    {
        if (!session()->has('user')) {
=======
    public function create()
    {
        // Cek apakah user sudah login
        if (!session()->has('user')) {
            // Simpan intended URL lalu redirect ke login
>>>>>>> ef3212d4aa787342e59da5fedbeeb6896ed30c0c
            session(['intended_url' => route('reports.create')]);
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu untuk membuat laporan.');
        }

<<<<<<< HEAD
        // Cari view yang tersedia
        foreach (['reports.create', 'create_report', 'reports.create_report'] as $view) {
            if (view()->exists($view)) {
                return view($view);
            }
        }

        return redirect()->route('home')->with('error', 'Halaman buat laporan belum tersedia.');
    }



    /**
     * ================================
     * STORE NEW REPORT
     * ================================
     */
    public function store(Request $request)
    {
=======
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
>>>>>>> ef3212d4aa787342e59da5fedbeeb6896ed30c0c
        if (!session()->has('user')) {
            session(['intended_url' => route('reports.create')]);
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Validasi input
        $data = $request->validate([
<<<<<<< HEAD
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



    /**
     * ================================
     * SHOW ALL REPORTS (OPTIONAL)
     * ================================
=======
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
>>>>>>> ef3212d4aa787342e59da5fedbeeb6896ed30c0c
     */
    public function index()
    {
        $reports = session('reports', []);
        return view('reports.index', compact('reports'));
    }
<<<<<<< HEAD



    /**
     * ================================
     * MY REPORTS (KHUSUS USER LOGIN)
     * ================================
     */
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
=======
    
}
>>>>>>> ef3212d4aa787342e59da5fedbeeb6896ed30c0c
