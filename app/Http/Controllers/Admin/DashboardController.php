<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Report;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        // Ensure default values are 0 for empty database
        $stats = [
            'total_reports' => Report::count() ?? 0,
            'pending' => Report::where('status', 'pending')->count() ?? 0,
            'in_progress' => Report::where('status', 'in_progress')->count() ?? 0,
            'resolved' => Report::where('status', 'resolved')->count() ?? 0,
            'rejected' => Report::where('status', 'rejected')->count() ?? 0,
            'total_users' => User::where('role', 'user')->count() ?? 0,
        ];

        $recentReports = Report::with('user')
            ->latest()
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentReports'));
    }
}
