<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Category;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Show create report form
     */
    public function create()
    {
        if (!session()->has('user')) {
            session(['intended_url' => route('reports.create')]);
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu untuk membuat laporan.');
        }

        $categories = Category::all();
        return view('create_report', ['categories' => $categories]);
    }

    /**
     * Store report to database
     */
    public function store(Request $request)
    {
        if (!session()->has('user')) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'location'    => 'nullable|string|max:255',
            'category_id' => 'nullable|exists:categories,id',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        try {
            $imagePath = null;

            if ($request->hasFile('image')) {
                $filename = time() . '_' . $request->file('image')->getClientOriginalName();
                
                if (!file_exists(public_path('images/reports'))) {
                    mkdir(public_path('images/reports'), 0777, true);
                }

                $request->file('image')->move(public_path('images/reports'), $filename);
                $imagePath = 'images/reports/' . $filename;
            }

            $report = Report::create([
                'user_id' => session('user.id'),
                'category_id' => $data['category_id'] ?? null,
                'title' => $data['title'],
                'description' => $data['description'],
                'location' => $data['location'],
                'image' => $imagePath,
                'status' => 'pending',
            ]);

            return redirect()->route('reports.show', $report->id)->with('success', 'Laporan berhasil dikirim!');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Show all reports
     */
    public function index()
    {
        $reports = Report::with('user', 'category')->latest()->paginate(10);
        return view('reports', ['reports' => $reports]);
    }

    /**
     * Show single report detail
     */
    public function show($id)
    {
        $report = Report::with('user', 'category', 'comments.user', 'solutions', 'votes')->findOrFail($id);
        return view('detail_reports', ['report' => $report]);
    }

    /**
     * Show my reports
     */
    public function myReports()
    {
        if (!session()->has('user')) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $reports = Report::where('user_id', session('user.id'))
                        ->with('category')
                        ->latest()
                        ->paginate(10);
        
        return view('my-reports', ['reports' => $reports]);
    }

    /**
     * Edit report form
     */
    public function edit($id)
    {
        $report = Report::findOrFail($id);

        if ($report->user_id !== session('user.id')) {
            return redirect()->back()->with('error', 'Anda tidak bisa mengedit laporan orang lain.');
        }

        $categories = Category::all();
        return view('edit_report', ['report' => $report, 'categories' => $categories]);
    }

    /**
     * Update report
     */
    public function update(Request $request, $id)
    {
        $report = Report::findOrFail($id);

        if ($report->user_id !== session('user.id')) {
            return redirect()->back()->with('error', 'Anda tidak bisa mengedit laporan orang lain.');
        }

        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'location'    => 'nullable|string|max:255',
            'category_id' => 'nullable|exists:categories,id',
            'status'      => 'nullable|in:pending,in_progress,resolved,rejected',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        try {
            if ($request->hasFile('image')) {
                // Delete old image
                if ($report->image && file_exists(public_path($report->image))) {
                    unlink(public_path($report->image));
                }

                $filename = time() . '_' . $request->file('image')->getClientOriginalName();
                $request->file('image')->move(public_path('images/reports'), $filename);
                $data['image'] = 'images/reports/' . $filename;
            }

            $report->update($data);

            return redirect()->route('reports.show', $report->id)->with('success', 'Laporan berhasil diperbarui!');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Delete report
     */
    public function destroy($id)
    {
        $report = Report::findOrFail($id);

        if ($report->user_id !== session('user.id')) {
            return redirect()->back()->with('error', 'Anda tidak bisa menghapus laporan orang lain.');
        }

        try {
            if ($report->image && file_exists(public_path($report->image))) {
                unlink(public_path($report->image));
            }

            $report->delete();

            return redirect()->route('my-reports')->with('success', 'Laporan berhasil dihapus!');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
