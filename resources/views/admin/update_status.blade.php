@extends('layouts.app')

@section('title', 'Update Status Laporan')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/update_status.css') }}">
@endpush

@section('content')
<div class="flex h-screen max-w-[1920px] mx-auto bg-gray-50">

    {{-- SIDEBAR --}}
    <aside class="w-[260px] bg-white border-r border-gray-200 p-6 flex flex-col justify-between">
        
        <div>
            <h2 class="text-xl font-extrabold text-blue-600 mb-8 tracking-tight">
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
                <img src="{{ asset('images/profile-user.jpg') }}" class="w-10 h-10 rounded-full">

                <div>
                    <p class="text-sm font-semibold">Justin Hubner</p>
                    <p class="text-xs text-gray-500">@adminhubner</p>
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

        <h1 class="text-xl font-bold text-gray-800 mb-1">Verifikasi & Penanganan</h1>
        <p class="text-sm text-gray-500 mb-6">Selamat datang di sistem manajemen laporan masyarakat</p>

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

        {{-- MODAL UPDATE STATUS LAPORAN --}}
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
            <div class="bg-white rounded-2xl shadow-2xl max-w-lg w-full">
                
                {{-- Modal Header --}}
                <div class="bg-white border-b border-gray-200 p-6 rounded-t-2xl flex items-start justify-between">
                    <div class="flex-1">
                        <h2 class="text-xl font-bold text-gray-900">Update Status Laporan</h2>
                        <p class="text-sm text-gray-500 mt-1">Perbarui status laporan dan notifikasi akan dikirim kepada pelapor.</p>
                    </div>
                    <a href="{{ route('admin.verifikasi.detail', $report->id_report) }}" class="text-gray-400 hover:text-gray-600 transition-colors ml-4">
                        <i class="fa-solid fa-times text-xl"></i>
                    </a>
                </div>

                {{-- Modal Body --}}
                <form action="{{ route('admin.verifikasi.update_status.submit', $report->id_report) }}" method="POST" id="updateStatusForm">
                    @csrf
                <div class="p-6">

                    {{-- Form Field --}}
                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Status Baru
                        </label>
                        <div class="relative">
                            <select name="status_baru" id="statusBaru" class="w-full px-4 py-3 pr-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all appearance-none text-sm bg-white cursor-pointer">
                                <option value="">Pilih status baru</option>
                                <option value="baru">Menunggu Verifikasi</option>
                                <option value="diproses">Sedang Diproses</option>
                                <option value="selesai">Selesai</option>
                                <option value="ditolak">Ditolak</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none">
                                <i class="fa-solid fa-chevron-down text-gray-400 text-sm"></i>
                            </div>
                        </div>
                        <p id="errorMessage" class="text-red-500 text-xs mt-2 hidden flex items-center gap-1">
                            <i class="fa-solid fa-circle-exclamation"></i>
                            Pilih status baru terlebih dahulu
                        </p>
                    </div>

                </div>

                {{-- Modal Footer --}}
                <div class="bg-gray-50 border-t border-gray-200 p-6 rounded-b-2xl">
                    <div class="flex items-center gap-3">
                        <a href="{{ route('admin.verifikasi.detail', $report->id_report) }}" class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold py-3 px-4 rounded-lg transition-all text-center">
                            Batal
                        </a>
                        <button type="button" onclick="validateAndUpdate()" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-4 rounded-lg transition-all">
                            Konfirmasi
                        </button>
                    </div>
                </div>
                </form>

            </div>
        </div>

        {{-- Success Notification --}}
        <div id="updateNotification" class="fixed top-4 right-4 bg-white rounded-lg shadow-2xl border border-blue-200 p-4 z-[60] transform translate-x-[500px] transition-transform duration-300 ease-in-out max-w-md">
            <div class="flex items-start gap-3">
                <div class="flex-shrink-0">
                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                        <i class="fa-solid fa-check-circle text-blue-600 text-lg"></i>
                    </div>
                </div>
                <div class="flex-1">
                    <h3 class="text-sm font-bold text-gray-900 mb-1">Status Berhasil Diperbarui</h3>
                    <p class="text-sm text-gray-600">Status laporan telah diperbarui dan notifikasi telah dikirim.</p>
                </div>
                <button onclick="hideSuccessNotification()" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <i class="fa-solid fa-times"></i>
                </button>
            </div>
        </div>

        <script>
            function validateAndUpdate() {
                const statusSelect = document.getElementById('statusBaru');
                const errorMessage = document.getElementById('errorMessage');
                
                if (!statusSelect.value || statusSelect.value === '') {
                    errorMessage.classList.remove('hidden');
                    statusSelect.classList.add('border-red-500', 'focus:ring-red-500', 'focus:border-red-500');
                    statusSelect.classList.remove('border-gray-300', 'focus:ring-blue-500', 'focus:border-blue-500');
                    return;
                }
                
                // If validation passes, hide error and show success notification
                errorMessage.classList.add('hidden');
                statusSelect.classList.remove('border-red-500', 'focus:ring-red-500', 'focus:border-red-500');
                statusSelect.classList.add('border-gray-300', 'focus:ring-blue-500', 'focus:border-blue-500');
                
                showSuccessNotification();
                
                // Submit form after delay
                setTimeout(() => {
                    document.getElementById('updateStatusForm').submit();
                }, 2000);
            }

            function showSuccessNotification() {
                const notification = document.getElementById('updateNotification');
                notification.classList.remove('translate-x-[500px]');
                notification.classList.add('translate-x-0');
                
                setTimeout(() => {
                    hideSuccessNotification();
                }, 5000);
            }

            function hideSuccessNotification() {
                const notification = document.getElementById('updateNotification');
                notification.classList.remove('translate-x-0');
                notification.classList.add('translate-x-[500px]');
            }

            // Clear error when user selects a status
            document.getElementById('statusBaru').addEventListener('change', function() {
                const errorMessage = document.getElementById('errorMessage');
                if (this.value !== '') {
                    errorMessage.classList.add('hidden');
                    this.classList.remove('border-red-500', 'focus:ring-red-500', 'focus:border-red-500');
                    this.classList.add('border-gray-300', 'focus:ring-blue-500', 'focus:border-blue-500');
                }
            });
        </script>

    </main>
</div>
@endsection
