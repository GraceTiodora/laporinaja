@extends('layouts.app')

@section('title', 'Messages - LaporinAja')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/messages.css') }}">
<style>
    @keyframes slideInRight {
        from { opacity: 0; transform: translateX(20px); }
        to { opacity: 1; transform: translateX(0); }
    }
    @keyframes slideInLeft {
        from { opacity: 0; transform: translateX(-20px); }
        to { opacity: 1; transform: translateX(0); }
    }
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.5; }
    }
    .message-left { animation: slideInLeft 0.3s ease-out; }
    .message-right { animation: slideInRight 0.3s ease-out; }
    .chat-item:hover { transform: translateX(4px); }
    .online-dot { animation: pulse 2s infinite; }
    .search-input:focus { box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1); }
    .unread-badge { transition: opacity 0.3s ease, transform 0.3s ease; }
</style>
@endpush

@section('content')
<div class="flex h-screen max-w-[1920px] mx-auto bg-gradient-to-br from-gray-50 via-blue-50/30 to-gray-50">

    <!-- SIDEBAR -->
    <aside class="w-[270px] bg-white border-r border-gray-200 p-6 flex flex-col justify-between">
        <div>
            <h2 class="text-2xl font-extrabold text-blue-600 mb-8 tracking-tight">
                Laporin<span class="text-gray-900">Aja</span>
            </h2>

            <nav class="space-y-2">
                @php
                    $menu = [
                        ['Beranda', 'home', 'fa-solid fa-house'],
                        ['Pencarian', 'explore', 'fa-solid fa-hashtag'],
                        ['Notifikasi', 'notifications', 'fa-regular fa-bell'],
                        ['Pesan', 'messages', 'fa-regular fa-envelope'],
                        ['Laporan Saya', 'reports', 'fa-solid fa-clipboard-list'],
                        ['Profil', 'profile', 'fa-regular fa-user'],
                    ];
                @endphp

                @foreach ($menu as [$name, $route, $icon])
                    @php
                        $href = '#';
                        if ($route !== '#') {
                            try {
                                $href = route($route);
                            } catch (\Exception $e) {
                                $href = '#';
                            }
                        }
                        $isActive = request()->routeIs($route);
                    @endphp
                    <a href="{{ $href }}"
                       class="flex items-center gap-4 px-4 py-3 rounded-xl font-medium transition-all
                              {{ $isActive ? 'bg-blue-600 text-white shadow-lg' : 'text-gray-700 hover:bg-gray-100' }}">
                        <i class="{{ $icon }} text-lg"></i>
                        <span>{{ $name }}</span>
                        @if($isActive)
                            <span class="ml-auto w-2 h-2 bg-white rounded-full"></span>
                        @endif
                    </a>
                @endforeach
            </nav>

            <button onclick="window.location.href='{{ route('reports.create') }}'"
                    class="mt-6 w-full flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700
                           text-white py-3 rounded-full shadow-md transition-all font-semibold">
                <i class="fa-solid fa-plus-circle"></i> Laporan Baru
            </button>
        </div>

        <div class="space-y-3">
            <div class="bg-gray-50 rounded-2xl p-4 border border-gray-200">
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-12 h-12 bg-gray-200 rounded-full flex items-center justify-center text-gray-600 font-bold text-lg">
                        DM
                    </div>
                    <div class="relative">
                        <span class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 rounded-full border-2 border-white"></span>
                    </div>
                </div>
                <p class="font-semibold text-gray-800 text-sm">Diana Hevila Manurung</p>
                <p class="text-xs text-gray-500">{{ session('user')['username'] ?? 'username' }}</p>
            </div>

            <button onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                    class="w-full flex items-center justify-center gap-2 border-2 border-red-500 text-red-500 py-3 rounded-2xl hover:bg-red-50 transition-all font-semibold">
                <i class="fa-solid fa-right-from-bracket"></i> Logout
            </button>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                @csrf
            </form>
        </div>
    </aside>

    <!-- CHAT LAYOUT -->
    <div class="flex flex-1 overflow-hidden">

        <!-- LEFT CHAT LIST -->
        <div class="w-[320px] border-r border-gray-200 bg-white flex flex-col shadow-lg">
            
            <header class="sticky top-0 bg-white border-b border-gray-200 px-6 py-4 flex justify-between items-center z-10">
                <h1 class="text-xl font-bold text-blue-600 flex items-center gap-2">
                    <i class="fa-solid fa-house"></i>
                    Pesan
                </h1>
                <button class="text-gray-400 hover:text-blue-600 transition">
                    <i class="fa-solid fa-gear text-xl"></i>
                </button>
            </header>

            <div class="p-3">
                <div class="relative">
                    <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                    <input type="text" id="searchConversation" placeholder="Cari percakapan..." onkeyup="searchChats()"
                        class="search-input w-full bg-gradient-to-r from-gray-50 to-blue-50 pl-9 pr-3 py-2 rounded-lg outline-none text-xs border border-gray-200 focus:border-blue-400 transition-all">
                </div>
            </div>

            <div class="overflow-y-auto p-2 space-y-1" id="chatList">

                <!-- SAMPLE CHAT LIST ITEM -->
                @foreach([
                    ['Jennie Kim', 'Online', 'Setuju. Thanks ya udah laporin, aku ju...', 'images/user1.jpg', true, '14:30'],
                    ['Sabrina Carpenter', null, 'Eh aku juga lewat jalan itu..', 'images/user2.jpg', false, 'Kemarin'],
                    ['Admin Kota', 'Online', 'Terimakasih atas laporan anda...', 'images/user3.jpg', false, '10:15'],
                    ['Lara Raj', null, 'Malam tadi aku hampir jatuh gara2...', 'images/user4.jpg', false, '2 hari'],
                    ['Kim Mingyu', null, 'Thanks.', 'images/user5.jpg', true, 'Minggu lalu'],
                ] as $idx => $c)

                <div class="chat-item flex items-center gap-2 p-2.5 rounded-lg cursor-pointer hover:bg-gradient-to-r hover:from-blue-50 hover:to-indigo-50 transition-all duration-300 border border-transparent hover:border-blue-200 group" 
                     onclick="selectChat('{{ $c[0] }}', '{{ $c[1] }}', '{{ $c[3] }}', this)" 
                     data-name="{{ strtolower($c[0]) }}">
                    <div class="relative">
                        <img src="{{ asset($c[3]) }}" class="w-11 h-11 rounded-full object-cover ring-2 ring-gray-200 group-hover:ring-blue-400 transition-all">
                        @if($c[1])
                            <div class="absolute -bottom-0.5 -right-0.5 w-2.5 h-2.5 bg-green-500 rounded-full border-2 border-white online-dot"></div>
                        @endif
                    </div>

                    <div class="flex-1 min-w-0">
                        <div class="flex items-center justify-between mb-0.5">
                            <p class="text-sm font-semibold text-gray-900 truncate group-hover:text-blue-600 transition-colors">
                                {{ $c[0] }}
                            </p>
                            <span class="text-[10px] text-gray-500 ml-2 shrink-0">{{ $c[5] }}</span>
                        </div>
                        <p class="text-xs text-gray-600 truncate group-hover:text-gray-900">{{ $c[2] }}</p>
                    </div>

                    @if($c[4])
                        <div class="relative unread-badge">
                            <span class="w-5 h-5 bg-gradient-to-r from-blue-600 to-blue-700 text-white text-[10px] flex items-center justify-center rounded-full font-bold shadow-md animate-pulse">1</span>
                        </div>
                    @endif
                </div>

                @endforeach

            </div>

        </div>

        <!-- CHAT ROOM -->
        <div class="flex-1 bg-gradient-to-br from-gray-50 via-blue-50/20 to-gray-50 flex flex-col">

            <!-- CHAT HEADER -->
            <div class="p-3 bg-white/95 backdrop-blur-md flex items-center justify-between border-b border-gray-200 shadow-sm sticky top-0 z-10">
                <div class="flex items-center gap-3">
                    <div class="relative">
                        <img src="{{ asset('images/user1.jpg') }}" id="chatHeaderAvatar" class="w-10 h-10 rounded-full object-cover ring-2 ring-blue-100">
                        <div class="absolute -bottom-0.5 -right-0.5 w-2.5 h-2.5 bg-green-500 rounded-full border-2 border-white online-dot" id="chatHeaderStatus"></div>
                    </div>
                    <div>
                        <p class="font-bold text-gray-900 text-sm" id="chatHeaderName">Jennie Kim</p>
                        <p class="text-green-500 text-xs font-medium flex items-center gap-1" id="chatHeaderOnline">
                            <span class="w-1.5 h-1.5 bg-green-500 rounded-full online-dot"></span>
                            Online
                        </p>
                    </div>
                </div>

                <div class="flex gap-2">
                    <button class="p-2 rounded-full hover:bg-blue-50 text-gray-500 hover:text-blue-600 transition-all duration-300 hover:scale-110 group">
                        <i class="fa-solid fa-phone text-sm group-hover:rotate-12 transition-transform"></i>
                    </button>
                    <button class="p-2 rounded-full hover:bg-blue-50 text-gray-500 hover:text-blue-600 transition-all duration-300 hover:scale-110 group">
                        <i class="fa-solid fa-video text-sm group-hover:scale-125 transition-transform"></i>
                    </button>
                    <button class="p-2 rounded-full hover:bg-blue-50 text-gray-500 hover:text-blue-600 transition-all duration-300 hover:scale-110 group">
                        <i class="fa-solid fa-info-circle text-sm group-hover:rotate-180 transition-transform"></i>
                    </button>
                </div>
            </div>

            <!-- CHAT MESSAGES -->
            <div class="flex-1 overflow-y-auto p-4 space-y-3" id="messagesContainer">

                <div class="text-center">
                    <span class="bg-white px-3 py-1 rounded-full text-gray-500 text-[10px] font-medium shadow-sm border border-gray-200">
                        Kamis 22:46
                    </span>
                </div>

                <!-- LEFT MESSAGE -->
                <div class="flex message-left">
                    <div class="flex gap-2 max-w-[70%]">
                        <img src="{{ asset('images/user1.jpg') }}" class="w-7 h-7 rounded-full object-cover ring-2 ring-gray-200 shrink-0">
                        <div>
                            <div class="bg-white text-gray-900 px-3 py-2 rounded-xl rounded-tl-sm shadow-sm border border-gray-200 hover:shadow-md transition-shadow text-sm">
                                Aku tadi baca lapormu tentang jalan berlubang deket sekolah itu.
                            </div>
                            <span class="text-[10px] text-gray-500 ml-2 mt-0.5 block">22:46</span>
                        </div>
                    </div>
                </div>

                <!-- RIGHT MESSAGE -->
                <div class="flex justify-end message-right">
                    <div class="flex gap-2 max-w-[70%] flex-row-reverse">
                        <img src="{{ asset('images/profile-user.jpg') }}" class="w-7 h-7 rounded-full object-cover ring-2 ring-blue-200 shrink-0">
                        <div>
                            <div class="bg-gradient-to-r from-blue-600 to-blue-700 text-white px-3 py-2 rounded-xl rounded-tr-sm shadow-md hover:shadow-lg transition-shadow text-sm">
                                Iya, udah beberapa minggu nggak diperbaiki. Banyak motor yang hampir jatuh
                            </div>
                            <span class="text-[10px] text-gray-500 mr-2 mt-0.5 block text-right">22:47</span>
                        </div>
                    </div>
                </div>

                <div class="text-center">
                    <span class="bg-white px-3 py-1 rounded-full text-gray-500 text-[10px] font-medium shadow-sm border border-gray-200">
                        Jumat 13:35
                    </span>
                </div>

                <div class="flex message-left">
                    <div class="flex gap-2 max-w-[70%]">
                        <img src="{{ asset('images/user1.jpg') }}" class="w-7 h-7 rounded-full object-cover ring-2 ring-gray-200 shrink-0">
                        <div>
                            <div class="bg-white text-gray-900 px-3 py-2 rounded-xl rounded-tl-sm shadow-sm border border-gray-200 hover:shadow-md transition-shadow text-sm">
                                Aku juga pernah hampir kepeleset pas hujan 😅. Emang harus cepat diperbaiki.
                            </div>
                            <span class="text-[10px] text-gray-500 ml-2 mt-0.5 block">13:35</span>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end message-right">
                    <div class="flex gap-2 max-w-[70%] flex-row-reverse">
                        <img src="{{ asset('images/profile-user.jpg') }}" class="w-7 h-7 rounded-full object-cover ring-2 ring-blue-200 shrink-0">
                        <div>
                            <div class="bg-gradient-to-r from-blue-600 to-blue-700 text-white px-3 py-2 rounded-xl rounded-tr-sm shadow-md hover:shadow-lg transition-shadow text-sm">
                                Makanya aku laporin di sini, biar banyak yang lihat dan kasih vote
                            </div>
                            <span class="text-[10px] text-gray-500 mr-2 mt-0.5 block text-right">13:36</span>
                        </div>
                    </div>
                </div>

            </div>

            <!-- MESSAGE INPUT -->
            <div class="p-3 bg-white border-t border-gray-200 shadow-sm">
                <div class="flex items-end gap-2">
                    <!-- Emoji Button -->
                    <button onclick="document.getElementById('messageInput').value += '😊'" class="p-2 rounded-full hover:bg-gray-100 text-gray-500 hover:text-yellow-500 transition-all hover:scale-110 group shrink-0">
                        <i class="fa-regular fa-face-smile text-base group-hover:scale-125 transition-transform"></i>
                    </button>

                    <!-- Photo Attachment -->
                    <input type="file" id="photoInput" accept="image/*" class="hidden" onchange="handlePhotoSelect(event)">
                    <button onclick="document.getElementById('photoInput').click()" class="p-2 rounded-full hover:bg-gray-100 text-gray-500 hover:text-blue-600 transition-all hover:scale-110 group shrink-0">
                        <i class="fa-solid fa-image text-base group-hover:scale-125 transition-transform"></i>
                    </button>

                    <!-- Message Input Container -->
                    <div class="flex-1 bg-gradient-to-r from-gray-50 to-blue-50 rounded-xl border border-gray-200 focus-within:border-blue-400 transition-all p-2">
                        <div id="imagePreviewContainer" class="hidden mb-1 relative inline-block">
                            <img id="imagePreview" class="max-h-24 rounded-lg border border-blue-200">
                            <button onclick="removeImagePreview()" class="absolute -top-1 -right-1 bg-red-500 text-white w-5 h-5 rounded-full hover:bg-red-600 transition flex items-center justify-center">
                                <i class="fa-solid fa-times text-[10px]"></i>
                            </button>
                        </div>
                        <textarea 
                            id="messageInput" 
                            placeholder="Ketik pesan..." 
                            rows="1"
                            onkeypress="handleKeyPress(event)"
                            class="w-full bg-transparent outline-none resize-none px-2 py-1 text-sm text-gray-900 placeholder-gray-500"></textarea>
                    </div>

                    <!-- Send Button -->
                    <button onclick="sendMessage()" class="p-2.5 rounded-full bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white transition-all hover:scale-110 shadow-md hover:shadow-lg group shrink-0">
                        <i class="fa-solid fa-paper-plane text-sm group-hover:translate-x-1 transition-transform"></i>
                    </button>
                </div>
            </div>

        </div>

    </div>
</div>

<script>
// Auto-resize textarea
document.getElementById('messageInput').addEventListener('input', function() {
    this.style.height = 'auto';
    this.style.height = Math.min(this.scrollHeight, 150) + 'px';
});

// Search conversations
function searchChats() {
    const input = document.getElementById('searchConversation').value.toLowerCase();
    const chatItems = document.querySelectorAll('.chat-item');
    
    chatItems.forEach(item => {
        const name = item.getAttribute('data-name');
        if (name.includes(input)) {
            item.style.display = 'flex';
            item.style.animation = 'fadeIn 0.3s ease-out';
        } else {
            item.style.display = 'none';
        }
    });
}

// Select chat
function selectChat(name, status, avatar, element) {
    document.getElementById('chatHeaderName').textContent = name;
    document.getElementById('chatHeaderAvatar').src = '{{ asset("") }}' + avatar;
    
    const onlineElement = document.getElementById('chatHeaderOnline');
    const statusDot = document.getElementById('chatHeaderStatus');
    
    if (status === 'Online') {
        onlineElement.innerHTML = '<span class="w-1.5 h-1.5 bg-green-500 rounded-full online-dot"></span> Online';
        onlineElement.classList.remove('text-gray-400');
        onlineElement.classList.add('text-green-500');
        statusDot.classList.remove('hidden');
    } else {
        onlineElement.textContent = 'Offline';
        onlineElement.classList.remove('text-green-500');
        onlineElement.classList.add('text-gray-400');
        statusDot.classList.add('hidden');
    }
    
    // Remove unread badge when chat is clicked
    const badge = element.querySelector('.unread-badge');
    if (badge) {
        badge.style.opacity = '0';
        badge.style.transform = 'scale(0)';
        setTimeout(() => {
            badge.remove();
        }, 300);
    }
    
    // Remove active state from all chat items
    document.querySelectorAll('.chat-item').forEach(item => {
        item.classList.remove('bg-gradient-to-r', 'from-blue-50', 'to-indigo-50', 'border-blue-300');
    });
    
    // Add active state to clicked chat
    element.classList.add('bg-gradient-to-r', 'from-blue-50', 'to-indigo-50', 'border-blue-300');
}

// Handle photo selection
function handlePhotoSelect(event) {
    const file = event.target.files[0];
    if (file && file.type.startsWith('image/')) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('imagePreview').src = e.target.result;
            document.getElementById('imagePreviewContainer').classList.remove('hidden');
        };
        reader.readAsDataURL(file);
    }
}

// Remove image preview
function removeImagePreview() {
    document.getElementById('imagePreviewContainer').classList.add('hidden');
    document.getElementById('photoInput').value = '';
}

// Handle Enter key
function handleKeyPress(event) {
    if (event.key === 'Enter' && !event.shiftKey) {
        event.preventDefault();
        sendMessage();
    }
}

// Send message
function sendMessage() {
    const input = document.getElementById('messageInput');
    const message = input.value.trim();
    const imagePreviewContainer = document.getElementById('imagePreviewContainer');
    const hasImage = !imagePreviewContainer.classList.contains('hidden');
    
    if (message || hasImage) {
        const messagesContainer = document.getElementById('messagesContainer');
        const time = new Date().toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
        
        let messageHTML = `
            <div class="flex justify-end message-right">
                <div class="flex gap-2 max-w-[70%] flex-row-reverse">
                    <img src="{{ asset('images/profile-user.jpg') }}" class="w-8 h-8 rounded-full object-cover ring-2 ring-blue-200 shrink-0">
                    <div>`;
        
        // Add image if present
        if (hasImage) {
            const imgSrc = document.getElementById('imagePreview').src;
            messageHTML += `
                        <div class="mb-2">
                            <img src="${imgSrc}" class="max-w-xs rounded-xl shadow-lg border-2 border-blue-200">
                        </div>`;
        }
        
        // Add text if present
        if (message) {
            messageHTML += `
                        <div class="bg-gradient-to-r from-blue-600 to-blue-700 text-white px-5 py-3 rounded-2xl rounded-tr-sm shadow-lg hover:shadow-xl transition-shadow">
                            ${message}
                        </div>`;
        }
        
        messageHTML += `
                        <span class="text-xs text-gray-500 mr-2 mt-1 block text-right">${time}</span>
                    </div>
                </div>
            </div>`;
        
        messagesContainer.insertAdjacentHTML('beforeend', messageHTML);
        messagesContainer.scrollTop = messagesContainer.scrollHeight;
        
        // Clear input
        input.value = '';
        input.style.height = 'auto';
        removeImagePreview();
        
        // Simulate reply (for demo)
        setTimeout(() => {
            const replyHTML = `
                <div class="flex message-left">
                    <div class="flex gap-2 max-w-[70%]">
                        <img src="${document.getElementById('chatHeaderAvatar').src}" class="w-8 h-8 rounded-full object-cover ring-2 ring-gray-200 shrink-0">
                        <div>
                            <div class="bg-white text-gray-900 px-5 py-3 rounded-2xl rounded-tl-sm shadow-md border border-gray-200 hover:shadow-lg transition-shadow">
                                <i class="fa-solid fa-circle-notch fa-spin text-gray-400"></i> Sedang mengetik...
                            </div>
                        </div>
                    </div>
                </div>`;
            messagesContainer.insertAdjacentHTML('beforeend', replyHTML);
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
        }, 1000);
    }
}

// Scroll to bottom on load
document.addEventListener('DOMContentLoaded', function() {
    const messagesContainer = document.getElementById('messagesContainer');
    messagesContainer.scrollTop = messagesContainer.scrollHeight;
});
</script>
@endsection
