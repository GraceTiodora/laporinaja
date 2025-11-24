<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\User;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function create()
    {
        if (!session()->has('user')) {
            session(['intended_url' => route('reports.create')]);
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu untuk membuat laporan.');
        }

        return view('create_report');
    }

    public function store(Request $request)
    {
        if (!session()->has('user')) {
            session(['intended_url' => route('reports.create')]);
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Validasi input
        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'location'    => 'nullable|string|max:255',
            'category'    => 'nullable|string|max:255',
            'status'      => 'nullable|string|max:255',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Upload gambar jika ada
        $imagePath = null;

        if ($request->hasFile('image')) {
            $filename = time() . '_' . $request->file('image')->getClientOriginalName();

            if (!file_exists(public_path('images/reports'))) {
                mkdir(public_path('images/reports'), 0777, true);
            }

            $request->file('image')->move(public_path('images/reports'), $filename);
            $imagePath = 'images/reports/' . $filename;
        }

        // Create report di database
        Report::create([
            'id_user'    => session('user.id_user'),
            'title'      => $data['title'],
            'description' => $data['description'],
            'location'   => $data['location'] ?? 'Tidak diketahui',
            'category'   => $data['category'] ?? 'Umum',
            'status'     => $data['status'] ?? 'Baru',
            'image'      => $imagePath,
            'votes'      => 0,
        ]);

        session()->forget('intended_url');
        return redirect()->route('home')->with('success', 'Laporan berhasil dikirim!');
    }

    public function index()
    {
        $reports = Report::all();
        return view('my_reports', compact('reports'));
    }

    public function show($id)
    {
        $report = Report::findOrFail($id);
        
        return view('detail_reports', compact('report'));
    }

    public function myReports()
    {
        if (!session()->has('user')) {
            return redirect()->route('login')->with('error', 'Silakan login untuk melihat laporan Anda.');
        }

        $myReports = Report::where('id_user', session('user.id_user'))
                           ->orderByDesc('created_at')
                           ->get();

        return view('my_reports', [
            'user'    => session('user'),
            'reports' => $myReports
        ]);
    }
}
