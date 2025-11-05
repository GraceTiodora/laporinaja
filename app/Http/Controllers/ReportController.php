<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function create()
    {
        if (! session()->has('user')) {
            return redirect()->route('login');
        }
        return view('reports.create');
    }

    public function store(Request $request)
    {
        if (! session()->has('user')) {
            return redirect()->route('login');
        }

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'body'  => 'required|string',
        ]);

        $reports = session('reports', []);
        $reports[] = [
            'user' => session('user'),
            'title' => $data['title'],
            'body' => $data['body'],
            'created_at' => now()->toDateTimeString(),
        ];
        session(['reports' => $reports]);

        return redirect()->route('home')->with('success', 'Laporan berhasil dibuat.');
    }
}