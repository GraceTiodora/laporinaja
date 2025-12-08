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
        return view('warga.create_report', ['categories' => $categories]);
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
            $userId = session('user.id');
            
            // Debug: check if user_id exists
            if (!$userId) {
                return back()->withInput()->with('error', 'User ID tidak ditemukan. Silakan login ulang.');
            }

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
                'user_id' => $userId,
                'category_id' => $data['category_id'] ?? null,
                'title' => $data['title'],
                'description' => $data['description'],
                'location' => $data['location'],
                'image' => $imagePath,
                'status' => 'Baru',
            ]);

            return redirect()->route('home')->with('success', 'Laporan berhasil dikirim!');
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
        return view('explore', ['reports' => $reports]);
    }

    /**
     * Show single report detail
     */
    public function show($id)
    {
        $reportModel = Report::with('user', 'category', 'comments.user', 'solutions', 'votes')->findOrFail($id);
        
        // Transform to array format for view compatibility
        $report = [
            'id' => $reportModel->id,
            'title' => $reportModel->title,
            'description' => $reportModel->description,
            'location' => $reportModel->location,
            'status' => $reportModel->status ?? 'Baru',
            'image' => $reportModel->image,
            'created_at' => $reportModel->created_at->diffForHumans(),
            'votes' => $reportModel->votes()->where('is_upvote', 1)->count(),
            'downvotes' => $reportModel->votes()->where('is_upvote', 0)->count(),
            'comments' => $reportModel->comments->count(),
            'user' => [
                'id' => $reportModel->user->id,
                'name' => $reportModel->user->name,
                'username' => $reportModel->user->email,
            ],
            'category' => $reportModel->category->name ?? 'Umum',
        ];
        
        return view('detail_reports', ['report' => $report, 'reportModel' => $reportModel]);
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
        
        return view('warga.my_reports', ['reports' => $reports]);
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
        return view('warga.edit_report', ['report' => $report, 'categories' => $categories]);
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
            'status'      => 'nullable|in:Baru,Dalam Pengerjaan,Selesai',
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

    /**
     * Vote on report (upvote/downvote)
     */
    public function vote($id, Request $request)
    {
        if (!session()->has('user')) {
            return response()->json(['error' => 'Silakan login terlebih dahulu'], 401);
        }

        $report = Report::findOrFail($id);
        $isUpvote = $request->input('upvote', true);

        // Check if already voted
        $existingVote = $report->votes()->where('user_id', session('user.id'))->first();

        if ($existingVote) {
            if ($existingVote->is_upvote == $isUpvote) {
                // Remove vote if same
                $existingVote->delete();
            } else {
                // Update vote
                $existingVote->update(['is_upvote' => $isUpvote]);
            }
        } else {
            // Create new vote
            $report->votes()->create([
                'user_id' => session('user.id'),
                'votable_id' => $report->id,
                'votable_type' => 'App\\Models\\Report',
                'is_upvote' => $isUpvote,
            ]);
        }

        return response()->json([
            'upvotes' => $report->votes()->where('is_upvote', 1)->count(),
            'downvotes' => $report->votes()->where('is_upvote', 0)->count(),
        ]);
    }

    /**
     * Add comment on report
     */
    public function addComment($id, Request $request)
    {
        if (!session()->has('user')) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu');
        }

        $request->validate([
            'content' => 'required|min:1|max:500',
        ]);

        $report = Report::findOrFail($id);

        $report->comments()->create([
            'user_id' => session('user.id'),
            'content' => $request->input('content'),
        ]);

        return redirect()->route('reports.show', $id)->with('success', 'Komentar berhasil ditambahkan!');
    }
}
