<?php

namespace App\Http\Controllers;

use App\Services\ApiClient;
use App\Models\Category;
use App\Models\Report;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    protected $api;

    public function __construct(ApiClient $api)
    {
        $this->api = $api;
    }

    public function index(Request $request)
    {
        try {
            $params = [];
            if ($request->has('category')) {
                $params['category'] = $request->category;
            }
            if ($request->has('status')) {
                $params['status'] = $request->status;
            }
            if ($request->has('search')) {
                $params['search'] = $request->search;
            }

            $response = $this->api->get('reports', $params);
            
            if ($response->successful()) {
                $reports = $response->json()['data'];
                return view('reports.index', compact('reports'));
            }

            return redirect('/')->with('error', 'Gagal memuat laporan');
        } catch (\Exception $e) {
            return redirect('/')->with('error', 'Koneksi gagal');
        }
    }

    public function create()
    {
        if (!session('authenticated')) {
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu');
        }

        try {
            // Try to fetch from API first, fallback to local database
            $categories = [];
            $importantReports = [];
            $trendingReports = [];

            try {
                $categoriesResponse = $this->api->get('categories');
                if ($categoriesResponse->successful()) {
                    $categories = $categoriesResponse->json()['data'];
                }
            } catch (\Exception $e) {
                // Fallback: get from local database
            }

            // If API failed or no categories, use local database
            if (empty($categories)) {
                $categories = Category::all()->map(function($cat) {
                    return [
                        'id' => $cat->id,
                        'name' => $cat->name,
                    ];
                })->toArray();
            }

            // Fetch reports for sidebar
            try {
                $reportsResponse = $this->api->get('reports');
                if ($reportsResponse->successful()) {
                    $allReports = $reportsResponse->json()['data'];
                    $importantReports = array_slice($allReports, 0, 3);
                    $trendingReports = array_slice($allReports, 0, 3);
                }
            } catch (\Exception $e) {
                // Fallback to local database
            }

            if (empty($importantReports)) {
                $localReports = Report::with('user', 'category')
                    ->latest()
                    ->take(6)
                    ->get()
                    ->map(function($r) {
                        return [
                            'id' => $r->id,
                            'title' => $r->title,
                            'location' => $r->location,
                            'category' => $r->category->name ?? 'Umum',
                            'status' => $r->status ?? 'Baru',
                            'user' => ['name' => $r->user->name ?? 'Anonymous'],
                        ];
                    })->toArray();

                $importantReports = array_slice($localReports, 0, 3);
                $trendingReports = array_slice($localReports, 3, 3);
            }

            return view('create_report', compact('categories', 'importantReports', 'trendingReports'));
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memuat data: ' . $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        if (!session('authenticated')) {
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'category_id' => 'required|integer',
            'image' => 'nullable|max:2048'
        ]);

        try {
            $data = [
                'title' => $request->title,
                'description' => $request->description,
                'location' => $request->location,
                'category_id' => $request->category_id,
            ];

            $imagePath = null;
            if ($request->hasFile('image') && $request->file('image')->isValid()) {
                try {
                    $imagePath = $request->file('image')->store('reports', 'public');
                    $data['image'] = $imagePath;
                } catch (\Exception $fileError) {
                    // Skip image if upload fails
                }
            }

            // Try API first
            try {
                $response = $this->api->post('reports', $data);
                if ($response->successful()) {
                    return redirect('/')->with('success', '✅ Laporan berhasil dibuat!');
                }
            } catch (\Exception $apiError) {
                // Fallback to local database
            }

            // Fallback: Save to local database
            $report = Report::create([
                'user_id' => session('user.id'),
                'category_id' => $request->category_id,
                'title' => $request->title,
                'description' => $request->description,
                'location' => $request->location,
                'image' => $imagePath,
                'status' => 'Baru',
            ]);

            return redirect('/')->with('success', '✅ Laporan berhasil dibuat! Lihat di beranda.');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', '❌ Gagal membuat laporan: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $response = $this->api->get('reports/' . $id);
            
            if ($response->successful()) {
                $report = $response->json()['data'];
                
                // Debug: Log response structure
                \Log::info('Report Detail Response', [
                    'response_json' => $response->json(),
                    'report_data' => $report,
                    'report_keys' => array_keys($report ?? []),
                ]);
                
                return view('reports.show', compact('report'));
            }

            return redirect('/reports')->with('error', 'Laporan tidak ditemukan');
        } catch (\Exception $e) {
            return redirect('/reports')->with('error', 'Koneksi gagal');
        }
    }

    public function edit($id)
    {
        if (!session('authenticated')) {
            return redirect('/login');
        }

        try {
            $reportResponse = $this->api->get('reports/' . $id);
            $categoriesResponse = $this->api->get('categories');

            if (!$reportResponse->successful()) {
                return redirect('/reports')->with('error', 'Laporan tidak ditemukan');
            }

            $report = $reportResponse->json()['data'];
            $categories = $categoriesResponse->successful() ? $categoriesResponse->json()['data'] : [];

            return view('reports.edit', compact('report', 'categories'));
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memuat laporan');
        }
    }

    public function update(Request $request, $id)
    {
        if (!session('authenticated')) {
            return redirect('/login');
        }

        $request->validate([
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'location' => 'nullable|string|max:255',
            'category_id' => 'nullable|integer',
            'status' => 'nullable|in:open,investigating,resolved,rejected',
            'image' => 'nullable|max:2048'
        ]);

        try {
            $data = $request->only(['title', 'description', 'location', 'category_id', 'status']);

            if ($request->hasFile('image') && $request->file('image')->isValid()) {
                try {
                    $path = $request->file('image')->store('reports', 'public');
                    $data['image'] = $path;
                } catch (\Exception $fileError) {
                    // Skip image if upload fails
                }
            }

            $response = $this->api->put('reports/' . $id, $data);

            if ($response->successful()) {
                return redirect('/reports/' . $id)->with('success', 'Laporan berhasil diperbarui!');
            }

            return back()->with('error', 'Gagal memperbarui laporan');
        } catch (\Exception $e) {
            return back()->with('error', 'Koneksi gagal');
        }
    }

    public function destroy($id)
    {
        if (!session('authenticated')) {
            return redirect('/login');
        }

        try {
            $response = $this->api->delete('reports/' . $id);

            if ($response->successful()) {
                return redirect('/reports')->with('success', 'Laporan berhasil dihapus!');
            }

            return back()->with('error', 'Gagal menghapus laporan');
        } catch (\Exception $e) {
            return back()->with('error', 'Koneksi gagal');
        }
    }
}
