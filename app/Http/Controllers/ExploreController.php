<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;

class ExploreController extends Controller
{
    /**
     * Display explore page with trending reports
     */
    public function index(Request $request)
    {
        try {
            // Get reports from database with relationships
            $allReports = Report::with('user', 'category', 'comments')
                ->latest()
                ->get()
                ->map(function ($r) {
                    return [
                        'id' => $r->id,
                        'title' => $r->title,
                        'description' => trim(str_replace(['\n', '\r', '\r\n'], ' ', $r->description)),
                        'location' => trim(str_replace(['\n', '\r', '\r\n'], ' ', $r->location)),
                        'category' => $r->category->name ?? 'Umum',
                        'status' => ucfirst($r->status ?? 'pending'),
                        'votes' => $r->votes()->where('is_upvote', 1)->count(),
                        'comments' => $r->comments->count(),
                        'image' => $r->image ? asset($r->image) : null,
                        'created_at' => $r->created_at->toDateTimeString(),
                        'user' => [
                            'name' => $r->user->name ?? 'Anonymous',
                            'username' => $r->user->email ?? 'user',
                        ]
                    ];
                })->toArray();
        } catch (\Exception $e) {
            $allReports = [];
        }

        // Koleksi untuk filtering / sorting
        $filteredReports = collect($allReports);

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
            'totalReports' => count($allReports),
        ]);
    }
}