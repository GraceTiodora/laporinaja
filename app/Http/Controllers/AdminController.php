<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;
use App\Models\User;
use App\Models\Notification;

class AdminController extends Controller
{
    /**
     * Tampilkan halaman Monitoring & Statistik
     */
    public function monitoring(Request $request)
    {
        // Ambil filter dari request
        $kategori = $request->get('kategori');
        $status = $request->get('status');

        // Query dasar
        $query = Report::query();

        // Filter berdasarkan kategori
        if ($kategori) {
            $query->where('kategori', $kategori);
        }

        // Filter berdasarkan status
        if ($status) {
            $query->where('status', $status);
        }

        // Data untuk statistik
        $totalLaporan = $query->count();
        $laporanSelesai = (clone $query)->where('status', 'selesai')->count();
        $laporanDiproses = (clone $query)->where('status', 'diproses')->count();

        // Data tren bulanan (12 bulan terakhir)
        $trenBulanan = Report::selectRaw('MONTH(created_at) as bulan, COUNT(*) as total')
            ->whereYear('created_at', date('Y'))
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        // Data per kategori
        $dataKategori = Report::selectRaw('kategori, COUNT(*) as total, 
                                          SUM(CASE WHEN status = "selesai" THEN 1 ELSE 0 END) as selesai')
            ->groupBy('kategori')
            ->get();

        // Hitung persentase dan rata-rata waktu penyelesaian
        $categoryPerformance = $dataKategori->map(function ($item) {
            $persentase = $item->total > 0 ? round(($item->selesai / $item->total) * 100) : 0;
            
            // Hitung rata-rata waktu penyelesaian (dalam hari)
            $rataWaktu = Report::where('kategori', $item->kategori)
                ->where('status', 'selesai')
                ->whereNotNull('tanggal_selesai')
                ->selectRaw('AVG(DATEDIFF(tanggal_selesai, created_at)) as avg_days')
                ->value('avg_days');

            return [
                'kategori' => ucfirst($item->kategori),
                'total' => $item->total,
                'selesai' => $item->selesai,
                'persentase' => $persentase,
                'rata_waktu' => $rataWaktu ? round($rataWaktu, 1) : 0
            ];
        });

        return view('admin.monitoring', compact(
            'totalLaporan',
            'laporanSelesai',
            'laporanDiproses',
            'trenBulanan',
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
            ->limit(10)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentReports'));
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
            'admin_note' => 'nullable|string|max:500'
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