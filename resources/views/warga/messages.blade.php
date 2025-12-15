// File ini dihapus karena fitur pesan sudah tidak digunakan.
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

            <div class="overflow-y-auto p-2 space-y-2">

<<<<<<< Updated upstream
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
                </div>

                @endforeach
=======
>>>>>>> Stashed changes

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
>>>>>>> Stashed changes
@endsection
