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

        $oldStatus = $report->status;
        $report->update(['status' => $status]);

        // Kirim notifikasi ke user jika status berubah
        if ($status !== $oldStatus) {
            $userId = $report->user_id;
            $title = 'Status laporan diperbarui';
            $message = 'Status laporan "' . $report->title . '" berubah dari "' . $oldStatus . '" menjadi "' . $status . '".';
            \App\Models\Notification::create([
                'user_id' => $userId,
                'report_id' => $report->id,
                'type' => 'status_update',
                'title' => $title,
                'message' => $message,
                'data' => json_encode(['old_status' => $oldStatus, 'new_status' => $status]),
                'read' => false,
            ]);
        }

        return back()->with('success', 'Status laporan berhasil diperbarui!');
    }
}
