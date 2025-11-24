<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class ExploreController extends Controller
{
    /**
     * Display explore page with trending reports
     */
    public function index(Request $request)
    {
        // Ambil reports dari session (jika ada)
        $sessionReports = session('reports', []);

        // Gabungkan session reports (baru) dengan dummy reports
        $reports = array_merge($sessionReports, $this->getDummyReports());

        // Koleksi untuk filtering / sorting
        $filteredReports = collect($reports);

        // Get filter parameters
        $location = $request->query('location');
        $category = $request->query('category');
        $status = $request->query('status');
        $search = $request->query('search');

        // Filter reports
        if ($location) {
            $filteredReports = $filteredReports->filter(function($report) use ($location) {
                return isset($report['location']) && stripos($report['location'], $location) !== false;
            });
        }

        if ($category) {
            $filteredReports = $filteredReports->filter(function($report) use ($category) {
                return isset($report['category']) && $report['category'] === $category;
            });
        }

        if ($status) {
            $filteredReports = $filteredReports->filter(function($report) use ($status) {
                return isset($report['status']) && $report['status'] === $status;
            });
        }

        if ($search) {
            $searchLower = strtolower($search);
            $filteredReports = $filteredReports->filter(function($report) use ($searchLower) {
                return str_contains(strtolower($report['title'] ?? ''), $searchLower) ||
                       str_contains(strtolower($report['description'] ?? ''), $searchLower) ||
                       str_contains(strtolower($report['location'] ?? ''), $searchLower);
            });
        }

        // Sort by votes (trending) and reset keys
        $filteredReports = $filteredReports->sortByDesc('votes')->values();

        return view('explore', [
            'reports' => $filteredReports,
            'totalReports' => count($reports),
        ]);
    }

    /**
     * Get dummy reports for demo purposes
     */
    private function getDummyReports()
    {
        return [
            [
                'id' => 1,
                'title' => 'Jalan Berlubang Besar Dekat Sekolah...',
                'description' => 'Jalan berlubang besar dekat sekolah sangat berbahaya untuk dilewati',
                'location' => 'Jl. Melati',
                'category' => 'Infrastruktur',
                'status' => 'Baru',
                'votes' => 45,
                'comments' => 3,
                'created_at' => now()->subHours(2)->toDateTimeString(),
                'user' => [
                    'name' => 'Audrey Stark',
                    'username' => 'audreystark',
                ]
            ],
            [
                'id' => 2,
                'title' => 'Jembatan Rusak di Persimpangan Pasar',
                'description' => 'Jembatan di persimpangan pasar mengalami kerusakan struktural yang mengkhawatirkan',
                'location' => 'Jl. Gunung Kelud',
                'category' => 'Aksesibilitas',
                'status' => 'Baru',
                'votes' => 25,
                'comments' => 1,
                'created_at' => now()->subHours(5)->toDateTimeString(),
                'user' => [
                    'name' => 'David Blend',
                    'username' => 'davidblend',
                ]
            ],
            [
                'id' => 3,
                'title' => 'Sampah Menumpuk di Pasar Baru',
                'description' => 'Tumpukan sampah di area pasar menimbulkan bau tidak sedap',
                'location' => 'Pasar Baru',
                'category' => 'Sanitasi',
                'status' => 'Dalam Pengerjaan',
                'votes' => 96,
                'comments' => 8,
                'created_at' => now()->subDay()->toDateTimeString(),
                'user' => [
                    'name' => 'Sarah Johnson',
                    'username' => 'sarahjohnson',
                ]
            ],
            [
                'id' => 4,
                'title' => 'Lampu Jalan Mati di RT 05',
                'description' => 'Beberapa lampu jalan sudah mati sejak seminggu yang lalu',
                'location' => 'RT 05',
                'category' => 'Infrastruktur',
                'status' => 'Selesai',
                'votes' => 54,
                'comments' => 5,
                'created_at' => now()->subDays(2)->toDateTimeString(),
                'user' => [
                    'name' => 'Michael Chen',
                    'username' => 'michaelchen',
                ]
            ],
        ];
    }
}