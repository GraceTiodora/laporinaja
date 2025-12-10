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
                        <p class="text-sm text-gray-500 mt-1">Perbarui status laporan. Foto bukti wajib jika status "Selesai".</p>
                    </div>
                    <a href="{{ route('admin.verifikasi') }}" class="text-gray-400 hover:text-gray-600 transition-colors ml-4">
                        <i class="fa-solid fa-times text-xl"></i>
                    </a>
                </div>

                {{-- Modal Body --}}
                <form action="{{ route('admin.verifikasi.update_status.submit', $report->id) }}" method="POST" id="updateStatusForm" enctype="multipart/form-data">
                    @csrf
                <div class="p-6 space-y-6">

                    {{-- Status Select --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Status Baru
                        </label>
                        <div class="relative">
                            <select name="status" id="statusSelect" class="w-full px-4 py-3 pr-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all appearance-none text-sm bg-white cursor-pointer">
                                <option value="">-- Pilih Status --</option>
                                <option value="Dalam Pengerjaan">Dalam Pengerjaan (Foto Opsional)</option>
                                <option value="Selesai">Selesai (Foto Wajib)</option>
                                <option value="Ditolak">Ditolak</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none">
                                <i class="fa-solid fa-chevron-down text-gray-400 text-sm"></i>
                            </div>
                        </div>
                    </div>

                    {{-- Admin Note --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Catatan Admin (Opsional)
                        </label>
                        <textarea name="admin_note" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all text-sm resize-none" rows="3" placeholder="Tambahkan catatan tentang proses penanganan..."></textarea>
                    </div>

                    {{-- Solution Image (conditional) --}}
                    <div id="solutionImageField" class="hidden">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            📸 Foto Bukti <span id="photoRequirement" class="text-gray-600">(Wajib)</span>
                        </label>
                        <div class="border-2 border-dashed border-green-300 rounded-lg p-6 text-center cursor-pointer hover:bg-green-50 transition-colors" id="uploadArea">
                            <input type="file" name="solution_image" id="solutionImage" class="hidden" accept="image/*">
                            <div class="space-y-2">
                                <i class="fa-solid fa-cloud-arrow-up text-green-500 text-3xl"></i>
                                <p class="text-sm font-medium text-gray-700">Klik atau drag foto bukti</p>
                                <p class="text-xs text-gray-500">PNG, JPG, GIF (Max 2MB)</p>
                                <p id="photoHint" class="text-xs text-green-600 font-medium mt-2">Wajib di-upload untuk menyelesaikan laporan</p>
                            </div>
                        </div>
                        <div id="imagePreview" class="mt-3 hidden">
                            <img id="previewImg" class="max-h-48 rounded-lg shadow-md" alt="Preview">
                            <button type="button" onclick="clearImage()" class="mt-2 text-xs text-red-600 hover:text-red-800">Ubah Gambar</button>
                        </div>
                    </div>

                </div>

                {{-- Modal Footer --}}
                <div class="bg-gray-50 border-t border-gray-200 p-6 rounded-b-2xl">
                    <div class="flex items-center gap-3">
                        <a href="{{ route('admin.verifikasi') }}" class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold py-3 px-4 rounded-lg transition-all text-center no-underline">
                            Batal
                        </a>
                        <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-4 rounded-lg transition-all">
                            Perbarui Status
                        </button>
                    </div>
                </div>
                </form>

            </div>
        </div>


        </main>
</div>

<script>
    // Show/hide solution image field based on status
    document.getElementById('statusSelect').addEventListener('change', function() {
        const solutionField = document.getElementById('solutionImageField');
        const photoRequirement = document.getElementById('photoRequirement');
        const photoHint = document.getElementById('photoHint');
        
        if (this.value === 'Selesai') {
            // Selesai: Foto wajib
            solutionField.classList.remove('hidden');
            photoRequirement.innerHTML = '(Wajib)';
            photoRequirement.className = 'text-red-500';
            photoHint.textContent = 'Wajib di-upload untuk menyelesaikan laporan';
            photoHint.className = 'text-xs text-red-600 font-medium mt-2';
        } else if (this.value === 'Dalam Pengerjaan') {
            // Dalam Pengerjaan: Foto opsional
            solutionField.classList.remove('hidden');
            photoRequirement.innerHTML = '(Opsional)';
            photoRequirement.className = 'text-gray-500';
            photoHint.textContent = 'Foto dokumentasi pekerjaan (opsional)';
            photoHint.className = 'text-xs text-gray-600 font-medium mt-2';
        } else {
            // Ditolak: Sembunyikan foto
            solutionField.classList.add('hidden');
            clearImage();
        }
    });

    // Handle file upload
    const uploadArea = document.getElementById('uploadArea');
    const fileInput = document.getElementById('solutionImage');
    const imagePreview = document.getElementById('imagePreview');
    const previewImg = document.getElementById('previewImg');

    if (uploadArea) {
        uploadArea.addEventListener('click', () => fileInput.click());

        uploadArea.addEventListener('dragover', (e) => {
            e.preventDefault();
            uploadArea.classList.add('bg-green-100', 'border-green-500');
        });

        uploadArea.addEventListener('dragleave', () => {
            uploadArea.classList.remove('bg-green-100', 'border-green-500');
        });

        uploadArea.addEventListener('drop', (e) => {
            e.preventDefault();
            uploadArea.classList.remove('bg-green-100', 'border-green-500');
            fileInput.files = e.dataTransfer.files;
            handleFileSelect();
        });

        fileInput.addEventListener('change', handleFileSelect);
    }

    function handleFileSelect() {
        if (fileInput.files && fileInput.files[0]) {
            const reader = new FileReader();
            reader.onload = (e) => {
                previewImg.src = e.target.result;
                imagePreview.classList.remove('hidden');
            };
            reader.readAsDataURL(fileInput.files[0]);
        }
    }

    function clearImage() {
        fileInput.value = '';
        imagePreview.classList.add('hidden');
    }

    // Form validation
    document.getElementById('updateStatusForm').addEventListener('submit', function(e) {
        const statusSelect = document.getElementById('statusSelect');
        
        if (!statusSelect.value) {
            e.preventDefault();
            alert('❌ Pilih status terlebih dahulu!');
            return;
        }

        // Jika status "Selesai", image WAJIB diupload
        if (statusSelect.value === 'Selesai') {
            if (!fileInput.files || !fileInput.files[0]) {
                e.preventDefault();
                alert('❌ Foto bukti HARUS diupload untuk menyelesaikan laporan!');
                return;
            }
        }
        // Jika status "Dalam Pengerjaan" atau "Ditolak", foto opsional/tidak perlu
    });
</script>

@endsection
