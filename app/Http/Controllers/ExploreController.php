<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;

class ExploreController extends Controller
{
    /**
     * Display explore page with trending reports
     */
    public function index(Request $request)
    {
        // Get filter parameters
        $location = $request->query('location');
        $category = $request->query('category');
        $status = $request->query('status');
        $search = $request->query('search');

        // Use Report model filter method
        $reports = Report::filter($location, $category, $status, $search);

        return view('warga.explorer', [
            'reports' => $reports,
            'totalReports' => Report::count(),
        ]);
    }
}