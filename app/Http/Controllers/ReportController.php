<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function create()
    {
        if (! session()->has('user')) {
            // simpan intended URL lalu redirect ke login
            session(['intended_url' => route('reports.create')]);
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // tampilkan form create jika ada
        if (view()->exists('reports.create')) {
            return view('reports.create');
        }

        // fallback: simple page jika belum ada view
        return redirect()->route('home')->with('error', 'Halaman buat laporan belum tersedia.');
    }

    public function store(Request $request)
    {
        if (! session()->has('user')) {
            session(['intended_url' => route('reports.create')]);
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $data = $request->validate([
            'body' => 'required|string',
        ]);

        $reports = session('reports', []);
        $reports[] = [
            'user' => session('user'),
            'body' => $data['body'],
            'created_at' => now()->toDateTimeString(),
        ];
        session(['reports' => $reports]);

        return redirect()->route('home')->with('success', 'Laporan berhasil dibuat.');
    }
}