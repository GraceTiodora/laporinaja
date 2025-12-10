<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;
use App\Models\User;
use App\Models\Notification;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    /**
     * Tampilkan halaman Pengaturan Akun
     */
    public function pengaturan()
    {
        $user = auth()->user();
        return view('admin.pengaturan', compact('user'));
    }

    /**
     * Update profile admin
     */
    public function updateProfileAdmin(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|min:3|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . auth()->id(),
            'phone' => 'nullable|string|max:20',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'name.required' => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.unique' => 'Email sudah terdaftar.',
            'phone.max' => 'Nomor telepon maksimal 20 karakter.',
            'avatar.image' => 'File harus berupa gambar.',
            'avatar.max' => 'Ukuran gambar maksimal 2MB.',
        ]);

        try {
            $user = auth()->user();

            if ($request->hasFile('avatar')) {
                $avatarPath = $request->file('avatar')->store('avatars', 'public');
                $validated['avatar'] = $avatarPath;
                
                if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                    Storage::disk('public')->delete($user->avatar);
                }
            }

            $user->update($validated);

            return response()->json(['message' => 'Profil berhasil diperbarui!', 'user' => $user], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal memperbarui profil: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Update password admin
     */
    public function updatePasswordAdmin(Request $request)
    {
        $validated = $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ], [
            'current_password.required' => 'Password saat ini wajib diisi.',
            'new_password.required' => 'Password baru wajib diisi.',
            'new_password.min' => 'Password baru minimal 8 karakter.',
            'new_password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        try {
            $user = auth()->user();

            if (!Hash::check($validated['current_password'], $user->password)) {
                return response()->json(['message' => 'Password saat ini tidak sesuai.'], 422);
            }

            $user->update(['password' => Hash::make($validated['new_password'])]);

            return response()->json(['message' => 'Password berhasil diubah!'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal mengubah password: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Tampilkan halaman Monitoring & Statistik
     */
    public function monitoring(Request $request)
    {
        // Ambil filter dari request
        $kategoriFilter = $request->get('kategori');
        $statusFilter = $request->get('status');

        // Query dasar
        $query = Report::with('category');

        // Filter berdasarkan kategori
        if ($kategoriFilter && $kategoriFilter !== 'all') {
            $query->whereHas('category', function ($q) use ($kategoriFilter) {
                $q->where('name', 'like', '%' . ucfirst($kategoriFilter) . '%');
            });
        }

        // Filter berdasarkan status
        if ($statusFilter && $statusFilter !== 'all') {
            $statusMap = [
                'open' => ['Baru', 'Dalam Pengerjaan'],
                'progress' => 'Dalam Pengerjaan',
                'closed' => 'Selesai'
            ];
            $mappedStatus = $statusMap[$statusFilter] ?? [];
            if (is_array($mappedStatus)) {
                $query->whereIn('status', $mappedStatus);
            } else {
                $query->where('status', $mappedStatus);
            }
        }

        $reports = $query->get();

        // Data untuk statistik
        $totalLaporan = $reports->count();
        $laporanSelesai = $reports->where('status', 'Selesai')->count();
        $laporanDiproses = $reports->where('status', 'Dalam Pengerjaan')->count();

        // Data tren bulanan - aggregate by month
        $trenBulanan = Report::selectRaw('MONTH(created_at) as bulan, COUNT(*) as total, 
                                          SUM(CASE WHEN status = "Selesai" THEN 1 ELSE 0 END) as selesai')
            ->whereYear('created_at', date('Y'))
            ->groupByRaw('MONTH(created_at)')
            ->orderBy('bulan')
            ->get();

        // Pastikan 12 bulan ada dengan fill 0 untuk bulan yang tidak ada
        $trenData = collect();
        for ($i = 1; $i <= 12; $i++) {
            $data = $trenBulanan->where('bulan', $i)->first();
            $trenData->push([
                'bulan' => $i,
                'total' => $data->total ?? 0,
                'selesai' => $data->selesai ?? 0,
                'diproses' => 0
            ]);
        }

        // Data per kategori dengan real data
        $categoryPerformance = Report::with('category')
            ->selectRaw('category_id, COUNT(*) as total, 
                        SUM(CASE WHEN status = "Selesai" THEN 1 ELSE 0 END) as selesai')
            ->whereNotNull('category_id')
            ->groupBy('category_id')
            ->get()
            ->map(function ($item) {
                $persentase = $item->total > 0 ? round(($item->selesai / $item->total) * 100) : 0;
                
                return [
                    'kategori' => $item->category->name ?? 'Umum',
                    'total' => $item->total,
                    'selesai' => $item->selesai,
                    'persentase' => $persentase,
                ];
            })->toArray();

        return view('admin.monitoring', compact(
            'totalLaporan',
            'laporanSelesai',
            'laporanDiproses',
            'trenData',
            'categoryPerformance'
        ));
    }

    /**
     * Export data monitoring ke PDF
     */
    public function exportPDF(Request $request)
    {
        $kategori = $request->get('kategori');
        $status = $request->get('status');

        // Query dengan filter
        $query = Report::query();
        
        if ($kategori) {
            $query->where('kategori', $kategori);
        }
        
        if ($status) {
            $query->where('status', $status);
        }

        $reports = $query->with('user')->get();

        // Data statistik untuk PDF
        $dataKategori = Report::selectRaw('kategori, COUNT(*) as total, 
                                          SUM(CASE WHEN status = "selesai" THEN 1 ELSE 0 END) as selesai')
            ->groupBy('kategori')
            ->get();

        // Jika menggunakan DomPDF
        // $pdf = PDF::loadView('admin.monitoring-pdf', compact('reports', 'dataKategori'));
        // return $pdf->download('monitoring-statistik-' . date('Y-m-d') . '.pdf');

        // Sementara return response biasa
        return response()->json([
            'message' => 'Export PDF berhasil',
            'data' => $reports
        ]);
    }

    /**
     * Export data monitoring ke Excel
     */
    public function exportExcel(Request $request)
    {
        $kategori = $request->get('kategori');
        $status = $request->get('status');

        // Query dengan filter
        $query = Report::query();
        
        if ($kategori) {
            $query->where('kategori', $kategori);
        }
        
        if ($status) {
            $query->where('status', $status);
        }

        $reports = $query->get();

        // Jika menggunakan Maatwebsite Excel
        // return Excel::download(new MonitoringExport($kategori, $status), 'monitoring-statistik-' . date('Y-m-d') . '.xlsx');

        // Sementara return response biasa
        return response()->json([
            'message' => 'Export Excel berhasil',
            'data' => $reports
        ]);
    }

    /**
     * Filter data monitoring (AJAX)
     */
    public function filterMonitoring(Request $request)
    {
        $kategori = $request->get('kategori');
        $status = $request->get('status');

        $query = Report::query();

        if ($kategori) {
            $query->where('kategori', $kategori);
        }

        if ($status) {
            $query->where('status', $status);
        }

        $data = $query->get();

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    /**
     * Admin Dashboard
     */
    public function dashboard()
    {
        $stats = [
            'total_reports' => Report::count(),
            'new_reports' => Report::where('status', 'Baru')->count(),
            'in_progress' => Report::where('status', 'Dalam Pengerjaan')->count(),
            'completed' => Report::where('status', 'Selesai')->count(),
            'rejected' => Report::where('status', 'Ditolak')->count(),
            'total_users' => User::where('role', 'user')->count(),
        ];

        $recentReports = Report::with('user', 'category')
            ->latest()
            ->limit(5)
            ->get();

        // Category stats for chart
        $categoryStats = \App\Models\Category::withCount('reports')->get();

        return view('admin.dashboard', compact('stats', 'recentReports', 'categoryStats'));
    }

    /**
     * Kelola Semua Laporan
     */
    public function reports(Request $request)
    {
        $query = Report::with('user', 'category');

        // Filter by status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Filter by category
        if ($request->has('category') && $request->category != '') {
            $query->where('category_id', $request->category);
        }

        // Search
        if ($request->has('search') && $request->search != '') {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%')
                  ->orWhere('location', 'like', '%' . $request->search . '%');
            });
        }

        $reports = $query->latest()->paginate(20);

        return view('admin.reports', compact('reports'));
    }

    /**
     * Update Status Laporan + Kirim Notifikasi
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Baru,Dalam Pengerjaan,Selesai,Ditolak',
            'admin_note' => 'nullable|string|max:500',
            'solution_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $report = Report::findOrFail($id);
        $oldStatus = $report->status;
        $newStatus = $request->status;

        // Update status
        $report->status = $newStatus;
        if ($request->admin_note) {
            $report->admin_note = $request->admin_note;
        }
        $report->save();

        // Jika status "Selesai" dan ada image bukti, simpan ke Solution table
        if ($newStatus === 'Selesai' && $request->hasFile('solution_image')) {
            $filename = time() . '_' . $request->file('solution_image')->getClientOriginalName();
            
            if (!file_exists(public_path('images/solutions'))) {
                mkdir(public_path('images/solutions'), 0777, true);
            }

            $request->file('solution_image')->move(public_path('images/solutions'), $filename);
            $imagePath = 'images/solutions/' . $filename;

            // Simpan ke Solution table
            \App\Models\Solution::create([
                'report_id' => $report->id,
                'user_id' => session('user.id'),
                'description' => $request->admin_note ?? 'Laporan telah diselesaikan',
                'image' => $imagePath,
                'is_accepted' => true
            ]);
        }

        // Kirim notifikasi ke user
        $this->sendStatusNotification($report, $oldStatus, $newStatus);

        return redirect()->back()->with('success', '✅ Status laporan berhasil diperbarui! Notifikasi telah dikirim ke user.');
    }

    /**
     * Kirim Notifikasi ke User
     */
    private function sendStatusNotification($report, $oldStatus, $newStatus)
    {
        $statusMessages = [
            'Baru' => [
                'title' => '📝 Laporan Anda Terdaftar',
                'message' => 'Laporan Anda telah terdaftar di sistem dan akan segera ditinjau oleh tim kami.',
                'icon' => 'sparkles'
            ],
            'Dalam Pengerjaan' => [
                'title' => '⚙️ Laporan Sedang Diproses',
                'message' => 'Kabar baik! Laporan Anda sedang dalam proses penanganan oleh tim kami.',
                'icon' => 'sync'
            ],
            'Selesai' => [
                'title' => '✅ Laporan Selesai Ditangani',
                'message' => 'Terima kasih! Laporan Anda telah selesai ditangani. Kami sangat menghargai partisipasi Anda.',
                'icon' => 'check-double'
            ],
            'Ditolak' => [
                'title' => '❌ Laporan Ditolak',
                'message' => 'Maaf, laporan Anda ditolak. Silakan periksa catatan admin untuk informasi lebih lanjut.',
                'icon' => 'times'
            ]
        ];

        $statusInfo = $statusMessages[$newStatus] ?? $statusMessages['Baru'];

        Notification::create([
            'user_id' => $report->user_id,
            'report_id' => $report->id,
            'type' => 'status_update',
            'title' => $statusInfo['title'],
            'message' => $statusInfo['message'] . ' - Laporan: "' . $report->title . '"',
            'data' => [
                'old_status' => $oldStatus,
                'new_status' => $newStatus,
                'icon' => $statusInfo['icon'],
                'report_title' => $report->title,
                'updated_by' => session('user.name')
            ],
            'read' => false
        ]);
    }
}