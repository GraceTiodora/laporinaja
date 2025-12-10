@extends('layouts.app')

@section('title', 'Detail Laporan')

@section('content')
<div class="flex h-screen max-w-[1920px] mx-auto bg-gray-50">

    {{-- SIDEBAR --}} 
    <aside class="w-[260px] bg-white border-r border-gray-200 p-6 flex flex-col justify-between">
        
        <div>
            <h2 class="text-2xl font-extrabold text-blue-600 mb-8 tracking-tight">
                Laporin<span class="text-gray-900">Aja</span>
                <p class="text-xs font-normal text-gray-600 mt-1">Admin Dashboard</p>
            </h2>

            {{-- Menu --}}
            <nav class="space-y-2 text-sm">
                @php
                    $menu = [
                        ['Dashboard', 'admin.dashboard', 'fa-solid fa-house'],
                        ['Verifikasi & Penanganan', 'admin.verifikasi', 'fa-solid fa-check-circle'],
                        ['Monitoring & Statistik', 'admin.monitoring', 'fa-solid fa-chart-line'],
                        ['Voting Publik', 'admin.voting', 'fa-solid fa-vote-yea'],
                        ['Pengaturan Akun', 'admin.pengaturan', 'fa-solid fa-gear'],
                    ];
                @endphp

                @foreach ($menu as [$name, $route, $icon])
                    <a href="{{ route($route) }}"
                       class="group flex items-center gap-3 px-4 py-3 rounded-xl 
                              {{ request()->routeIs($route) ? 'bg-blue-100 text-blue-700 font-semibold' : 'text-gray-600' }}
                              hover:bg-blue-50 hover:text-blue-600 transition-all">
                        <i class="{{ $icon }} text-lg"></i>
                        <span>{{ $name }}</span>
                    </a>
                @endforeach
            </nav>
        </div>

        {{-- Profile --}}
        <div class="mt-6 border-t border-gray-200 pt-4">
            <div class="flex items-center gap-3 mb-4">
                <img src="{{ auth()->user()->avatar ? asset('storage/' . auth()->user()->avatar) : asset('images/profile-user.jpg') }}" class="w-10 h-10 rounded-full object-cover">

                <div>
                    <p class="text-sm font-semibold">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-gray-500">@{{ strtolower(str_replace(' ', '', auth()->user()->name)) }}</p>
                </div>
            </div>

            <form action="#" method="POST">
                @csrf
                <button class="text-red-500 text-sm font-semibold hover:underline flex items-center gap-2">
                    <i class="fa-solid fa-right-from-bracket"></i> Logout
                </button>
            </form>
        </div>
    </aside>

    {{-- MAIN CONTENT --}}
    <main class="flex-1 p-8 overflow-y-auto relative">

        {{-- Header --}}
        <div class="mb-8">
            <h1 class="text-3xl font-extrabold text-gray-900 mb-2">Verifikasi & Penanganan</h1>
            <p class="text-base text-gray-600">Selamat datang di sistem manajemen laporan masyarakat</p>
        </div>

        {{-- Top Statistic Cards --}}
        <div class="grid grid-cols-3 gap-6 mb-10">

            <div class="bg-white rounded-xl border border-gray-200 p-5 shadow-sm">
                <div class="flex items-start justify-between mb-3">
                    <p class="text-sm font-semibold text-gray-700">Menunggu Verifikasi</p>
                    <div class="w-12 h-12 bg-blue-50 rounded-lg flex items-center justify-center">
                        <i class="fa-solid fa-file-lines text-blue-600 text-xl"></i>
                    </div>
                </div>
                <h2 class="text-3xl font-extrabold text-gray-900 mb-1">4</h2>
                <p class="text-xs text-gray-500">Laporan baru yang perlu ditinjau</p>
            </div>

            <div class="bg-white rounded-xl border border-gray-200 p-5 shadow-sm">
                <div class="flex items-start justify-between mb-3">
                    <p class="text-sm font-semibold text-gray-700">Sedang Diproses</p>
                    <div class="w-12 h-12 bg-yellow-50 rounded-lg flex items-center justify-center">
                        <i class="fa-solid fa-clock text-yellow-600 text-xl"></i>
                    </div>
                </div>
                <h2 class="text-3xl font-extrabold text-gray-900 mb-1">1</h2>
                <p class="text-xs text-gray-500">Laporan yang valid dan sedang ditangani</p>
            </div>

            <div class="bg-white rounded-xl border border-gray-200 p-5 shadow-sm">
                <div class="flex items-start justify-between mb-3">
                    <p class="text-sm font-semibold text-gray-700">Total Hari Ini</p>
                    <div class="w-12 h-12 bg-green-50 rounded-lg flex items-center justify-center">
                        <i class="fa-solid fa-circle-check text-green-600 text-xl"></i>
                    </div>
                </div>
                <h2 class="text-3xl font-extrabold text-gray-900 mb-1">5</h2>
                <p class="text-xs text-gray-500">Laporan yang masuk hari ini</p>
            </div>

        </div>

        {{-- Reports Table (blurred background) --}}
        <div class="bg-white rounded-xl border border-gray-200 p-6 shadow-sm blur-sm">
            <h3 class="font-semibold text-sm text-gray-700 mb-1">Daftar Laporan Baru</h3>
            <p class="text-xs text-gray-500 mb-4">Kelola dan verifikasi laporan masyarakat yang masuk ke sistem</p>
            <div class="h-64 bg-gray-100 rounded"></div>
        </div>

        {{-- MODAL DETAIL LAPORAN --}}
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
            <div class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
                
                {{-- Modal Header --}}
                <div class="sticky top-0 bg-white border-b border-gray-200 p-6 rounded-t-2xl">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <h2 class="text-xl font-bold text-gray-900">Detail Laporan #{{ $report->id }}</h2>
                            <p class="text-sm text-gray-500 mt-1">Informasi lengkap tentang laporan dari masyarakat</p>
                        </div>
                        <a href="{{ route('admin.verifikasi') }}" class="text-gray-400 hover:text-gray-600 transition-colors ml-4">
                            <i class="fa-solid fa-times text-xl"></i>
                        </a>
                    </div>
                </div>

                {{-- Modal Body --}}
                <div class="p-6 space-y-6">

                    {{-- Status Badges --}}
                    <div class="flex gap-2">
                        @php
                            $statusColors = [
                                'Baru' => 'bg-yellow-100 text-yellow-700',
                                'Dalam Pengerjaan' => 'bg-gray-100 text-gray-700',
                                'Selesai' => 'bg-green-100 text-green-700',
                                'Ditolak' => 'bg-red-100 text-red-700',
                            ];
                            $statusLabels = [
                                'Baru' => 'Menunggu Verifikasi',
                                'Dalam Pengerjaan' => 'Valid - Diproses',
                                'Selesai' => 'Selesai',
                                'Ditolak' => 'Ditolak',
                            ];
                            $categoryColors = [
                                'Infrastruktur' => 'bg-blue-100 text-blue-700',
                                'Safety' => 'bg-yellow-100 text-yellow-700',
                                'Sanitasi' => 'bg-green-100 text-green-700',
                            ];
                            $statusClass = $statusColors[$report->status] ?? 'bg-gray-100 text-gray-700';
                            $statusLabel = $statusLabels[$report->status] ?? ucfirst($report->status);
                            $categoryName = $report->category->name ?? 'Umum';
                            $categoryClass = $categoryColors[$categoryName] ?? 'bg-gray-100 text-gray-700';
                        @endphp
                        <span class="inline-block px-4 py-1.5 text-sm font-medium {{ $statusClass }} rounded-full">
                            {{ $statusLabel }}
                        </span>
                        <span class="inline-block px-4 py-1.5 text-sm font-medium {{ $categoryClass }} rounded-full">
                            {{ $categoryName }}
                        </span>
                    </div>

                    {{-- Informasi Pelapor --}}
                    <div>
                        <h3 class="text-sm font-semibold text-blue-600 mb-3">Informasi Pelapor</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="bg-gray-50 rounded-lg p-4">
                                <p class="text-xs text-gray-500 mb-1">Nama</p>
                                <p class="text-sm font-semibold text-gray-900">{{ $report->user->name ?? 'Anonymous' }}</p>
                            </div>
                            <div class="bg-gray-50 rounded-lg p-4">
                                <p class="text-xs text-gray-500 mb-1">Email</p>
                                <p class="text-sm font-semibold text-gray-900">{{ $report->user->email ?? '-' }}</p>
                            </div>
                            <div class="bg-gray-50 rounded-lg p-4">
                                <p class="text-xs text-gray-500 mb-1">Telepon</p>
                                <p class="text-sm font-semibold text-gray-900">{{ $report->user->phone ?? 'Tidak ada' }}</p>
                            </div>
                            <div class="bg-gray-50 rounded-lg p-4">
                                <p class="text-xs text-gray-500 mb-1">Tanggal Laporan</p>
                                <p class="text-sm font-semibold text-gray-900">{{ $report->created_at ? $report->created_at->format('d/m/Y') : '-' }}</p>
                            </div>
                        </div>
                    </div>

                    {{-- Lokasi Kejadian --}}
                    <div>
                        <h3 class="text-sm font-semibold text-blue-600 mb-3">Lokasi Kejadian</h3>
                        <div class="bg-blue-50 rounded-lg p-4 flex items-center gap-3">
                            <i class="fa-solid fa-location-dot text-blue-600 text-lg"></i>
                            <p class="text-sm font-medium text-gray-900">{{ $report->location ?? '-' }}</p>
                        </div>
                    </div>

                    {{-- Deskripsi Masalah --}}
                    <div>
                        <h3 class="text-sm font-semibold text-blue-600 mb-3">Deskripsi Masalah</h3>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <p class="text-sm text-gray-700 leading-relaxed">
                                {{ $report->description ?? '-' }}
                            </p>
                        </div>
                    </div>

                    {{-- Foto/Video Bukti --}}
                    <div>
                        <h3 class="text-sm font-semibold text-blue-600 mb-3 flex items-center gap-2">
                            <i class="fa-solid fa-image text-blue-600"></i>
                            Foto/Video Bukti
                        </h3>
                        @if($report->image)
                            <div class="rounded-lg overflow-hidden border border-gray-200">
                                <img src="{{ asset($report->image) }}" alt="Bukti" class="w-full h-64 object-cover">
                            </div>
                        @else
                            <div class="bg-gray-100 rounded-lg p-8 text-center">
                                <i class="fa-solid fa-image text-gray-400 text-3xl mb-2"></i>
                                <p class="text-sm text-gray-500">Tidak ada gambar</p>
                            </div>
                        @endif
                    </div>

                    {{-- Voting & Comments Section --}}
                    <div class="border-t border-gray-200 pt-6">
                        <h3 class="font-semibold text-gray-900 mb-4">Tanggapan Publik</h3>
                        
                        @php
                            try {
                                $upvotes = $report->votes()->where('is_upvote', true)->count() ?? 0;
                                $downvotes = $report->votes()->where('is_upvote', false)->count() ?? 0;
                            } catch (\Exception $e) {
                                $upvotes = 0;
                                $downvotes = 0;
                            }
                            $totalVotes = $upvotes + $downvotes;
                            $upvotePercentage = $totalVotes > 0 ? round(($upvotes / $totalVotes) * 100) : 0;
                        @endphp

                        {{-- Voting --}}
                        <div class="mb-4 p-4 bg-blue-50 rounded-lg">
                            <p class="text-sm font-medium text-gray-700 mb-2">Tingkat Kepentingan</p>
                            <div class="flex items-center gap-4">
                                <div class="flex-1">
                                    <div class="w-full bg-gray-300 rounded-full h-2">
                                        <div class="bg-green-500 h-2 rounded-full" style="width: {!! $upvotePercentage !!}%"></div>
                                    </div>
                                </div>
                                <span class="text-sm font-semibold text-gray-700">{{ $upvotePercentage }}%</span>
                            </div>
                            <p class="text-xs text-gray-600 mt-2">{{ $upvotes }} orang pilih penting · {{ $downvotes }} orang pilih kurang penting</p>
                        </div>
                        
                        {{-- Comments --}}
                        <div class="p-4 bg-gray-50 rounded-lg">
                            <p class="text-sm font-medium text-gray-700 mb-3">Komentar ({{ $report->comments()->count() }})</p>
                            <div class="space-y-3 max-h-48 overflow-y-auto">
                                @forelse($report->comments()->latest()->take(5)->get() as $comment)
                                    <div class="bg-white p-3 rounded border border-gray-200">
                                        <p class="text-sm font-semibold text-gray-900">{{ $comment->user->name ?? 'Anonim' }}</p>
                                        <p class="text-sm text-gray-700 mt-1">{{ $comment->content }}</p>
                                        <p class="text-xs text-gray-500 mt-2">{{ $comment->created_at->diffForHumans() }}</p>
                                    </div>
                                @empty
                                    <p class="text-sm text-gray-500">Belum ada komentar dari publik</p>
                                @endforelse
                            </div>
                        </div>
                    </div>

                </div>

                {{-- Modal Footer with Actions --}}
                <div class="sticky bottom-0 bg-white border-t border-gray-200 p-6 rounded-b-2xl">
                    <div class="flex items-center gap-3">
                        @if($report->status === 'Baru')
                            <a href="{{ route('admin.verifikasi.validasi', $report->id) }}" class="flex-1 bg-green-600 hover:bg-green-700 text-white font-semibold py-3 px-4 rounded-lg transition-all flex items-center justify-center gap-2 no-underline">
                                <i class="fa-solid fa-check"></i>
                                Valid & Proses
                            </a>
                            <a href="{{ route('admin.verifikasi.tolak', $report->id) }}" class="flex-1 bg-red-600 hover:bg-red-700 text-white font-semibold py-3 px-4 rounded-lg transition-all flex items-center justify-center gap-2 no-underline">
                                <i class="fa-solid fa-times"></i>
                                Tolak
                            </a>
                        @elseif($report->status === 'Dalam Pengerjaan')
                            <a href="{{ route('admin.verifikasi.update_status', $report->id) }}" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-4 rounded-lg transition-all flex items-center justify-center gap-2 no-underline">
                                <i class="fa-solid fa-rotate"></i>
                                Update Status
                            </a>
                        @elseif($report->status === 'Selesai')
                            <div class="flex-1 bg-green-100 text-green-700 font-semibold py-3 px-4 rounded-lg flex items-center justify-center gap-2">
                                <i class="fa-solid fa-check-circle"></i>
                                Laporan Selesai
                            </div>
                        @elseif($report->status === 'Ditolak')
                            <div class="flex-1 bg-red-100 text-red-700 font-semibold py-3 px-4 rounded-lg flex items-center justify-center gap-2">
                                <i class="fa-solid fa-ban"></i>
                                Laporan Ditolak
                            </div>
                        @endif
                    </div>
                </div>

            </div>
        </div>

    </main>
</div>
@endsection
