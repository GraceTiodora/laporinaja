// File ini dihapus karena fitur pesan sudah tidak digunakan.
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
            <a href="{{ route('profile') }}" class="block bg-gray-50 rounded-2xl p-4 border border-gray-200 hover:border-blue-400 transition-all cursor-pointer group ring-2 ring-gray-200 hover:ring-blue-400">
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-12 h-12 bg-gray-200 rounded-full flex items-center justify-center text-gray-600 font-bold text-lg">
                        {{ strtoupper(collect(explode(' ', session('user')["name"] ?? 'U'))->map(fn($w) => $w[0] ?? 'U')->join('')) }}
                    </div>
                    <div class="relative">
                        <span class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 rounded-full border-2 border-white"></span>
                    </div>
                </div>
                <p class="font-semibold text-gray-800 text-sm group-hover:text-blue-600 transition-colors">{{ session('user')['name'] ?? 'User' }}</p>
                <p class="text-xs text-gray-500">{{ session('user')['username'] ?? 'username' }}</p>
            </a>

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
// ========== CHAT API INTEGRATION ==========
let selectedUserId = null;
let pollingInterval = null;
let typingPolling = null;
let isTyping = false;

// Ambil daftar user untuk chat
function loadConversations() {
    fetch('/api/conversations')
        .then(res => res.json())
        .then(users => {
            const chatList = document.getElementById('chatList');
            chatList.innerHTML = '';
            users.forEach(user => {
                const item = document.createElement('div');
                item.className = 'chat-item flex items-center gap-2 p-2.5 rounded-lg cursor-pointer hover:bg-gradient-to-r hover:from-blue-50 hover:to-indigo-50 transition-all duration-300 border border-transparent hover:border-blue-200 group';
                item.setAttribute('data-name', user.name.toLowerCase());
                item.onclick = () => selectChat(user);
                item.innerHTML = `
                    <div class="relative">
                        <img src="${user.avatar || '/images/profile-user.jpg'}" class="w-11 h-11 rounded-full object-cover ring-2 ring-gray-200 group-hover:ring-blue-400 transition-all">
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center justify-between mb-0.5">
                            <p class="text-sm font-semibold text-gray-900 truncate group-hover:text-blue-600 transition-colors">${user.name}</p>
                        </div>
                        <p class="text-xs text-gray-600 truncate group-hover:text-gray-900">@${user.username}</p>
                    </div>`;
                chatList.appendChild(item);
            });
        });
}

// Pilih user untuk chat
function selectChat(user) {
    selectedUserId = user.id;
    document.getElementById('chatHeaderName').textContent = user.name;
    document.getElementById('chatHeaderAvatar').src = user.avatar || '/images/profile-user.jpg';
    // Kosongkan pesan
    document.getElementById('messagesContainer').innerHTML = '';
    // Fetch pesan
    fetchMessages();
    // Mulai polling pesan baru
    if (pollingInterval) clearInterval(pollingInterval);
    pollingInterval = setInterval(fetchMessages, 2000);
    // ========== CHAT API INTEGRATION (FIXED) ==========
    let selectedUserId = null;
    let pollingInterval = null;
    let typingPolling = null;
    let isTyping = false;

    function loadConversations() {
        fetch('/api/conversations')
            .then(res => res.json())
            .then(users => {
                const chatList = document.getElementById('chatList');
                chatList.innerHTML = '';
                users.forEach(user => {
                    const item = document.createElement('div');
                    item.className = 'chat-item flex items-center gap-2 p-2.5 rounded-lg cursor-pointer hover:bg-gradient-to-r hover:from-blue-50 hover:to-indigo-50 transition-all duration-300 border border-transparent hover:border-blue-200 group';
                    item.setAttribute('data-name', user.name.toLowerCase());
                    item.onclick = () => selectChat(user);
                    item.innerHTML = `
                        <div class="relative">
                            <img src="${user.avatar || '/images/profile-user.jpg'}" class="w-11 h-11 rounded-full object-cover ring-2 ring-gray-200 group-hover:ring-blue-400 transition-all">
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between mb-0.5">
                                <p class="text-sm font-semibold text-gray-900 truncate group-hover:text-blue-600 transition-colors">${user.name}</p>
                            </div>
                            <p class="text-xs text-gray-600 truncate group-hover:text-gray-900">@${user.username}</p>
                        </div>`;
                    chatList.appendChild(item);
                });
            })
            .catch(err => { console.error('Error loadConversations:', err); });
    }

    function selectChat(user) {
        selectedUserId = user.id;
        document.getElementById('chatHeaderName').textContent = user.name;
        document.getElementById('chatHeaderAvatar').src = user.avatar || '/images/profile-user.jpg';
        document.getElementById('messagesContainer').innerHTML = '';
        fetchMessages();
        if (pollingInterval) clearInterval(pollingInterval);
        pollingInterval = setInterval(fetchMessages, 2000);
        if (typingPolling) clearInterval(typingPolling);
        typingPolling = setInterval(checkTyping, 1000);
    }

    function fetchMessages() {
        if (!selectedUserId) return;
        fetch(`/api/messages/${selectedUserId}`)
            .then(res => res.json())
            .then(messages => {
                const container = document.getElementById('messagesContainer');
                container.innerHTML = '';
                messages.forEach(msg => {
                    const isMe = msg.sender_id !== selectedUserId;
                    const align = isMe ? 'justify-end message-right' : 'message-left';
                    const bubble = isMe
                        ? `<div class="bg-gradient-to-r from-blue-600 to-blue-700 text-white px-3 py-2 rounded-xl rounded-tr-sm shadow-md hover:shadow-lg transition-shadow text-sm">${msg.content}</div>`
                        : `<div class="bg-white text-gray-900 px-3 py-2 rounded-xl rounded-tl-sm shadow-sm border border-gray-200 hover:shadow-md transition-shadow text-sm">${msg.content}</div>`;
                    container.innerHTML += `
                        <div class="flex ${align}">
                            <div class="flex gap-2 max-w-[70%] ${isMe ? 'flex-row-reverse' : ''}">
                                <img src="${isMe ? '/images/profile-user.jpg' : '/images/user1.jpg'}" class="w-7 h-7 rounded-full object-cover ring-2 ${isMe ? 'ring-blue-200' : 'ring-gray-200'} shrink-0">
                                <div>
                                    ${bubble}
                                    <span class="text-[10px] text-gray-500 ml-2 mt-0.5 block">${msg.created_at ? new Date(msg.created_at).toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' }) : ''}${msg.read_at ? ' 👁️' : ''}</span>
                                </div>
                            </div>
                        </div>`;
                });
                container.scrollTop = container.scrollHeight;
            })
            .catch(err => { console.error('Error fetchMessages:', err); });
    }

    function sendMessage() {
        const input = document.getElementById('messageInput');
        const message = input.value.trim();
        if (!message || !selectedUserId) return;
        fetch('/api/messages/send', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ receiver_id: selectedUserId, content: message })
        })
        .then(res => res.json())
        .then(() => {
            input.value = '';
            fetchMessages();
        })
        .catch(err => { console.error('Error sendMessage:', err); });
    }

    document.getElementById('messageInput').addEventListener('input', function() {
        this.style.height = 'auto';
        this.style.height = Math.min(this.scrollHeight, 150) + 'px';
        if (!selectedUserId) return;
        if (!isTyping) {
            isTyping = true;
            fetch('/api/messages/typing', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ receiver_id: selectedUserId, is_typing: true })
            })
            .then(() => { isTyping = false; })
            .catch(() => { isTyping = false; });
        }
    });

    function checkTyping() {
        if (!selectedUserId) return;
        fetch(`/api/messages/typing-status?sender_id=${selectedUserId}`)
            .then(res => res.json())
            .then(data => {
                let typingIndicator = document.getElementById('typingIndicator');
                if (!typingIndicator) {
                    typingIndicator = document.createElement('div');
                    typingIndicator.id = 'typingIndicator';
                    typingIndicator.className = 'text-xs text-gray-500 italic mb-2';
                    document.getElementById('messagesContainer').appendChild(typingIndicator);
                }
                typingIndicator.textContent = data.typing ? 'Sedang mengetik...' : '';
            })
            .catch(() => {});
    }

    function markAsRead(messageId) {
        fetch(`/api/messages/${messageId}/read`, { method: 'POST' });
    }

    document.addEventListener('DOMContentLoaded', function() {
        loadConversations();
    });
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
