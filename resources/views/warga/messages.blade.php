@extends('layouts.app')

@section('title', 'Messages - LaporinAja')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/messages.css') }}">
@endpush

@section('content')
<div class="flex h-screen max-w-[1920px] mx-auto bg-gray-50">

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
                        ['Laporan Saya', 'my-reports', 'fa-solid fa-clipboard-list'],
                        ['Komunitas', 'communities', 'fa-solid fa-users'],
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
                @endphp
                <a href="{{ $href }}"
                    class="group flex items-center gap-4 px-4 py-3 rounded-xl font-medium transition-all
                    {{ request()->routeIs($route) 
                        ? 'bg-blue-50 text-blue-600' 
                        : 'text-gray-600 hover:bg-blue-50 hover:text-blue-600' }}">
                    <i class="{{ $icon }} text-lg"></i>
                    <span>{{ $name }}</span>
                </a>
                @endforeach
            </nav>

            <button onclick="window.location.href='{{ route('reports.create') }}'"
                class="mt-6 w-full flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-full shadow-md transition font-semibold">
                <i class="fa-solid fa-plus-circle"></i> Laporan Baru
            </button>
        </div>

<<<<<<< Updated upstream
        <div class="flex items-center gap-3 border-t border-gray-200 pt-4">
            <img src="{{ asset('images/profile-user.jpg') }}" class="w-10 h-10 rounded-full object-cover">
            <div>
                <p class="text-sm font-medium text-gray-800">{{ session('user.name','Guest') }}</p>
                <p class="text-xs text-gray-500">{{ session('user.email','user@mail.com') }}</p>
            </div>
=======
        <div class="space-y-3">
            <a href="{{ route('profile') }}" class="block bg-gray-50 rounded-2xl p-4 border border-gray-200 hover:bg-blue-50 transition cursor-pointer">
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-12 h-12 bg-gray-200 rounded-full flex items-center justify-center text-gray-600 font-bold text-lg">
                        {{ strtoupper(substr(session('user.name', 'U'), 0, 2)) }}
                    </div>
                    <div class="relative">
                        <span class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 rounded-full border-2 border-white"></span>
                    </div>
                </div>
                <p class="font-semibold text-gray-800 text-sm">{{ session('user.name', 'User') }}</p>
                <p class="text-xs text-gray-500">{{ session('user.username', 'username') }}</p>
            </a>

            <button onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                    class="w-full flex items-center justify-center gap-2 border-2 border-red-500 text-red-500 py-3 rounded-2xl hover:bg-red-50 transition-all font-semibold">
                <i class="fa-solid fa-right-from-bracket"></i> Logout
            </button>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                @csrf
            </form>
>>>>>>> Stashed changes
        </div>
    </aside>

    <!-- CHAT LAYOUT -->
    <div class="flex flex-1 overflow-hidden">

        <!-- LEFT CHAT LIST -->
        <div class="w-[380px] border-r border-gray-200 bg-white flex flex-col">
            
            <div class="p-4">
                <input type="text" placeholder="Search conversations..."
                    class="w-full bg-gray-100 px-4 py-2.5 rounded-xl outline-none text-sm">
            </div>

<<<<<<< Updated upstream
            <div class="overflow-y-auto p-2 space-y-2">

                <!-- SAMPLE CHAT LIST ITEM -->
                @foreach([
                    ['Jennie Kim', 'Online', 'Setuju. Thanks ya udah laporin, aku ju...', 'images/user1.jpg', true],
                    ['Sabrina Carpenter', null, 'Eh aku juga lewat jalan itu..', 'images/user2.jpg', false],
                    ['Admin Kota', 'Online', 'Terimakasih atas laporan anda...', 'images/user3.jpg', false],
                    ['Lara Raj', null, 'Malam tadi aku hampir jatuh gara2...', 'images/user4.jpg', false],
                    ['Kim Mingyu', null, 'Thanks.', 'images/user5.jpg', true],
                ] as $c)

                <div class="flex items-center gap-3 p-3 rounded-xl cursor-pointer hover:bg-gray-100 transition">
                    <img src="{{ asset($c[3]) }}" class="w-12 h-12 rounded-full object-cover">

                    <div class="flex-1">
                        <p class="font-semibold text-gray-900 flex items-center gap-2">
                            {{ $c[0] }}
                            @if($c[1])
                                <span class="text-green-500 text-xs">●</span>
                            @endif
                        </p>
                        <p class="text-sm text-gray-600 truncate">{{ $c[2] }}</p>
                    </div>

                    @if($c[4])
                        <span class="w-5 h-5 bg-blue-600 text-white text-xs flex items-center justify-center rounded-full">1</span>
                    @endif
=======
            <div class="overflow-y-auto p-2 space-y-1" id="chatList" data-receiver-id="{{ request('receiver_id') }}">

                <!-- SAMPLE CHAT LIST ITEM -->
                @foreach($chatUsers as $user)
                <div class="chat-item flex items-center gap-2 p-2.5 rounded-lg cursor-pointer hover:bg-gradient-to-r hover:from-blue-50 hover:to-indigo-50 transition-all duration-300 border border-transparent hover:border-blue-200 group"
                     onclick="selectChat('{{ $user->name }}', '{{ $user->is_online ? 'Online' : '' }}', '{{ $user->avatar ? asset($user->avatar) : asset('images/profile-user.jpg') }}', this)"
                     data-name="{{ strtolower($user->name) }}" data-user-id="{{ $user->id }}">
                    <div class="relative">
                        <img src="{{ $user->avatar ? asset($user->avatar) : asset('images/profile-user.jpg') }}" class="w-11 h-11 rounded-full object-cover ring-2 ring-gray-200 group-hover:ring-blue-400 transition-all">
                        @if(isset($user->is_online) && $user->is_online)
                            <div class="absolute -bottom-0.5 -right-0.5 w-2.5 h-2.5 bg-green-500 rounded-full border-2 border-white online-dot"></div>
                        @endif
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center justify-between mb-0.5">
                            <p class="text-sm font-semibold text-gray-900 truncate group-hover:text-blue-600 transition-colors">
                                {{ $user->name }}
                            </p>
                            <span class="text-[10px] text-gray-500 ml-2 shrink-0"></span>
                        </div>
                        <p class="text-xs text-gray-600 truncate group-hover:text-gray-900">{{ $user->username ?? $user->email }}</p>
                    </div>
>>>>>>> Stashed changes
                </div>
                @endforeach

            </div>

        </div>

        <!-- CHAT ROOM -->
        <div class="flex-1 bg-gray-50 flex flex-col">

            <!-- CHAT HEADER -->
            <div class="p-5 bg-white flex items-center justify-between border-b border-gray-200">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('images/user1.jpg') }}" class="w-12 h-12 rounded-full object-cover">
                    <div>
                        <p class="font-semibold text-gray-900">Jennie Kim</p>
                        <p class="text-green-500 text-sm">Online</p>
                    </div>
                </div>

                <div class="flex gap-6 text-gray-500 text-xl">
                    <i class="fa-solid fa-phone cursor-pointer hover:text-blue-600"></i>
                    <i class="fa-solid fa-video cursor-pointer hover:text-blue-600"></i>
                    <i class="fa-solid fa-info-circle cursor-pointer hover:text-blue-600"></i>
                </div>
            </div>

            <!-- CHAT MESSAGES -->
            <div class="flex-1 overflow-y-auto p-6 space-y-6">

                <div class="text-center text-gray-400 text-sm">Kamis 22:46</div>

                <!-- LEFT MESSAGE -->
                <div class="flex">
                    <div class="bg-gray-200 text-gray-900 px-4 py-2 rounded-2xl max-w-[60%]">
                        Aku tadi baca lapormu tentang jalan berlubang deket sekolah itu.
                    </div>
                </div>

                <!-- RIGHT MESSAGE -->
                <div class="flex justify-end">
                    <div class="bg-blue-600 text-white px-4 py-2 rounded-2xl max-w-[60%]">
                        Iya, udah beberapa minggu nggak diperbaiki. Banyak motor yang hampir jatuh
                    </div>
                </div>

                <div class="text-center text-gray-400 text-sm">Jumat 13:35</div>

                <div class="flex">
                    <div class="bg-gray-200 text-gray-900 px-4 py-2 rounded-2xl max-w-[60%]">
                        Aku juga pernah hampir kepeleset pas hujan 😅. Emang harus cepat diperbaiki.
                    </div>
                </div>


                <div class="flex justify-end">
                    <div class="bg-blue-600 text-white px-4 py-2 rounded-2xl max-w-[60%]">
                        Makanya aku laporin di sini, biar banyak yang lihat dan kasih vote
                    </div>
                </div>

            </div>

            <!-- MESSAGE INPUT -->
            <div class="p-4 bg-white border-t border-gray-200">
                <div class="flex items-center gap-3 bg-gray-100 rounded-full px-4 py-2">
                    <i class="fa-regular fa-face-smile text-xl text-gray-500"></i>
                    <input type="text" placeholder="Pesan..." class="flex-1 bg-transparent outline-none">
                    <i class="fa-solid fa-paperclip text-gray-500"></i>
                    <i class="fa-solid fa-paper-plane text-blue-600 cursor-pointer"></i>
                </div>
            </div>

        </div>

    </div>
</div>
<<<<<<< Updated upstream
=======

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

// Scroll to bottom on load dan auto-select chat jika ada receiver_id
document.addEventListener('DOMContentLoaded', function() {
    const messagesContainer = document.getElementById('messagesContainer');
    messagesContainer.scrollTop = messagesContainer.scrollHeight;

    // Auto-select chat jika ada receiver_id di URL
    const chatList = document.getElementById('chatList');
    const receiverId = chatList.getAttribute('data-receiver-id');
    if (receiverId) {
        const chatItems = chatList.querySelectorAll('.chat-item');
        chatItems.forEach(item => {
            if (item.getAttribute('data-user-id') === receiverId) {
                item.click();
            }
        });
    }
});
// Inisialisasi realtime chat setelah DOM siap
document.addEventListener('DOMContentLoaded', function() {
    // ...existing code...

    // Ambil user id dari backend (pastikan variabel ini di-passing dari controller)
    const authUserId = {{ auth()->id() }};
    // Ambil receiver id dari chat yang sedang dibuka
    const chatList = document.getElementById('chatList');
    const receiverId = chatList.getAttribute('data-receiver-id');
    if (authUserId && receiverId) {
        window.initRealtimeChat(authUserId, receiverId);
    }
});

// Handler pesan baru dari realtime
window.onRealtimeMessage = function(e) {
    const messagesContainer = document.getElementById('messagesContainer');
    // Render pesan baru ke chat
    let messageHTML = `
        <div class="flex message-left">
            <div class="flex gap-2 max-w-[70%]">
                <img src="{{ asset('images/profile-user.jpg') }}" class="w-8 h-8 rounded-full object-cover ring-2 ring-gray-200 shrink-0">
                <div>
                    <div class="bg-white text-gray-900 px-5 py-3 rounded-2xl rounded-tl-sm shadow-md border border-gray-200 hover:shadow-lg transition-shadow">
                        ${e.content}
                    </div>
                    <span class="text-xs text-gray-500 ml-2 mt-1 block text-left">${new Date(e.created_at).toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' })}</span>
                </div>
            </div>
        </div>`;
    messagesContainer.insertAdjacentHTML('beforeend', messageHTML);
    messagesContainer.scrollTop = messagesContainer.scrollHeight;
};
</script>
>>>>>>> Stashed changes
@endsection
