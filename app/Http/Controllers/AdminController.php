<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;

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
}