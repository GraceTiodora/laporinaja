<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Report;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $query = Report::with('user', 'category');

        // Filter by status
        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }

        // Filter by category
        if ($request->has('category_id') && $request->category_id !== '') {
            $query->where('category_id', $request->category_id);
        }

        // Search by title
        if ($request->has('search') && $request->search !== '') {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $reports = $query->latest()->paginate(15);
        $categories = \App\Models\Category::all();

        return view('admin.reports.index', compact('reports', 'categories'));
    }

    public function updateStatus(Report $report, Request $request)
    {
        $status = $request->input('status');

        if (!in_array($status, ['pending', 'in_progress', 'resolved', 'rejected'])) {
            return back()->with('error', 'Status tidak valid');
        }

        $report->update(['status' => $status]);

        return back()->with('success', 'Status laporan berhasil diperbarui!');
    }
}
