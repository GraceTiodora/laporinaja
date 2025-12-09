@extends('layouts.app')

@section('title', 'Messages - LaporinAja')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/messages.css') }}">
<style>
    .typing-indicator span {
        animation: typing 1.4s infinite;
        opacity: 0.3;
    }
    .typing-indicator span:nth-child(2) { animation-delay: 0.2s; }
    .typing-indicator span:nth-child(3) { animation-delay: 0.4s; }
    @keyframes typing {
        0%, 60%, 100% { opacity: 0.3; }
        30% { opacity: 1; }
    }
    .message-bubble {
        animation: slideIn 0.3s ease-out;
    }
    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    .animate-slideUp {
        animation: slideUp 0.3s ease-out;
    }
    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(20px) scale(0.95);
        }
        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }
</style>
@endpush

@section('content')
<div class="flex h-screen max-w-[1920px] mx-auto bg-gradient-to-br from-slate-50 via-gray-50 to-zinc-50">

    <!-- 📱 LEFT SIDEBAR -->
    <aside class="w-[270px] bg-white border-r border-gray-200 p-6 flex flex-col justify-between shadow-lg">

        <div>
            <h2 class="text-2xl font-extrabold text-blue-600 mb-8 tracking-tight hover:scale-105 transition-transform cursor-pointer">
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
                       class="group flex items-center gap-4 px-4 py-3 rounded-xl font-medium transition-all duration-300
                              {{ $isActive 
                                  ? 'bg-gradient-to-r from-blue-500 to-blue-600 text-white shadow-lg shadow-blue-200 scale-105' 
                                  : 'text-gray-600 hover:bg-blue-50 hover:text-blue-600 hover:translate-x-1' }}">
                        <i class="{{ $icon }} text-lg {{ $isActive ? '' : 'group-hover:scale-125' }} transition-transform"></i>
                        <span class="font-semibold">{{ $name }}</span>
                        @if($isActive)
                            <i class="fa-solid fa-circle text-xs ml-auto animate-pulse"></i>
                        @endif
                    </a>
                @endforeach
            </nav>

            <button onclick="window.location.href='{{ route('reports.create') }}'"
                    class="mt-6 w-full flex items-center justify-center gap-2 
                           bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800
                           text-white py-3.5 rounded-full shadow-lg hover:shadow-xl
                           transition-all duration-300 font-bold transform hover:scale-105 group">
                <i class="fa-solid fa-plus-circle text-lg group-hover:rotate-90 transition-transform"></i> 
                <span>Laporan Baru</span>
            </button>
        </div>

        <!-- Profile Bottom -->
        <div>
            <div class="flex items-center gap-3 border-t border-gray-200 pt-4 mb-3 hover:bg-blue-50 p-3 rounded-xl transition-all cursor-pointer group">
                <div class="relative">
                    <img src="{{ asset('images/profile-user.jpg') }}" class="w-11 h-11 rounded-full object-cover ring-2 ring-blue-100 group-hover:ring-4 group-hover:ring-blue-300 transition-all">
                    <div class="absolute -bottom-0.5 -right-0.5 w-3.5 h-3.5 bg-green-500 rounded-full border-2 border-white animate-pulse"></div>
                </div>
                <div class="flex-1">
                    <p class="text-sm font-bold text-gray-800 group-hover:text-blue-600 transition-colors">{{ session('user.name', 'Guest') }}</p>
                    <p class="text-xs text-gray-500">{{ session('user.email', 'user@mail.com') }}</p>
                </div>
                <i class="fa-solid fa-chevron-right text-gray-400 group-hover:text-blue-600 group-hover:translate-x-1 transition-all"></i>
            </div>
            
            <form action="{{ route('logout') }}" method="POST" class="w-full">
                @csrf
                <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-3 rounded-xl text-red-600 font-bold bg-white hover:bg-gradient-to-r hover:from-red-50 hover:to-rose-50 transition-all duration-300 group border-2 border-red-200 hover:border-red-400 hover:shadow-lg transform hover:scale-105">
                    <i class="fa-solid fa-right-from-bracket group-hover:translate-x-2 transition-transform text-lg"></i>
                    <span>Logout</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- 💬 CHAT LAYOUT -->
    <div class="flex flex-1 overflow-hidden">

        <!-- LEFT CHAT LIST -->
        <div class="w-[380px] border-r border-gray-200 bg-gradient-to-b from-gray-50 to-white flex flex-col shadow-sm">
            
            <div class="p-5 bg-gradient-to-br from-indigo-600 via-purple-600 to-violet-600 text-white shadow-lg relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full blur-2xl"></div>
                <div class="absolute bottom-0 left-0 w-24 h-24 bg-white/10 rounded-full blur-2xl"></div>
                
                <div class="relative z-10">
                    <h3 class="text-xl font-bold mb-3 flex items-center gap-2">
                        <i class="fa-solid fa-comments text-yellow-300"></i>
                        Percakapan
                    </h3>
                    <div class="relative">
                        <i class="fa-solid fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                        <input type="text" id="searchChat" placeholder="Cari percakapan..." 
                            class="w-full bg-white/95 backdrop-blur-sm px-10 py-3 rounded-2xl outline-none text-sm text-gray-700 placeholder-gray-400 focus:ring-2 focus:ring-yellow-300 focus:bg-white transition shadow-md"
                            onkeyup="searchChats()">
                    </div>
                </div>
            </div>

            <div id="chatList" class="overflow-y-auto p-3 space-y-1.5">

                <!-- CHAT LIST ITEMS WITH ENHANCED DESIGN -->
                @foreach([
                    ['Jennie Kim', 'Online', 'Setuju. Thanks ya udah laporin, aku ju...', 'images/user1.jpg', true, 'online'],
                    ['Sabrina Carpenter', null, 'Eh aku juga lewat jalan itu..', 'images/user2.jpg', false, 'offline'],
                    ['Admin Kota', 'Online', 'Terimakasih atas laporan anda...', 'images/user3.jpg', false, 'online'],
                    ['Lara Raj', null, 'Malam tadi aku hampir jatuh gara2...', 'images/user4.jpg', false, 'offline'],
                    ['Kim Mingyu', null, 'Thanks.', 'images/user5.jpg', true, 'offline'],
                ] as $index => $c)

                <div class="chat-item flex items-center gap-2.5 p-2.5 rounded-xl cursor-pointer transition hover:bg-blue-50 {{ $c[4] ? 'bg-blue-50' : 'bg-white' }}" 
                     data-name="{{ strtolower($c[0]) }}"
                     onclick="openChat('{{ $c[0] }}', '{{ asset($c[3]) }}', '{{ $c[5] }}', {{ $index }})">
                    
                    <div class="relative">
                        <img src="{{ asset($c[3]) }}" class="w-11 h-11 rounded-full object-cover">
                        @if($c[5] == 'online')
                            <span class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 border-2 border-white rounded-full"></span>
                        @endif
                    </div>

                    <div class="flex-1 min-w-0">
                        <div class="flex items-center justify-between">
                            <p class="font-semibold text-gray-900 text-sm truncate {{ $c[4] ? 'text-indigo-900' : '' }}">
                                {{ $c[0] }}
                                @if($c[5] == 'online')
                                    <span class="w-1.5 h-1.5 bg-blue-600 rounded-full inline-block ml-1"></span>
                                @endif
                            </p>
                        </div>
                        <p class="text-xs text-gray-500 truncate">{{ $c[2] }}</p>
                        @if($c[1])
                            <p class="text-xs text-green-600 font-medium mt-0.5">● {{ $c[1] }}</p>
                        @endif
                    </div>

                    @if($c[4])
                        <span class="chat-badge-{{ $index }} flex-shrink-0 w-5 h-5 bg-purple-600 text-white text-xs font-bold flex items-center justify-center rounded-full">1</span>
                    @endif
                </div>

                @endforeach

            </div>

        </div>

        <!-- 💭 CHAT ROOM -->
        <div id="chatRoom" class="flex-1 bg-gradient-to-br from-gray-50 via-white to-blue-50/30 flex flex-col h-screen">

            <!-- CHAT HEADER -->
            <div class="p-3 bg-white flex items-center justify-between border-b border-gray-200 flex-shrink-0">
                <div class="flex items-center gap-2.5">
                    <div class="relative">
                        <img id="chatAvatar" src="{{ asset('images/user1.jpg') }}" class="w-10 h-10 rounded-full object-cover">
                        <span id="chatOnlineIndicator" class="absolute bottom-0 right-0 w-2.5 h-2.5 bg-green-500 border-2 border-white rounded-full"></span>
                    </div>
                    <div>
                        <p id="chatName" class="font-semibold text-gray-900 text-sm">Jennie Kim</p>
                        <div id="chatStatus" class="flex items-center gap-1">
                            <span class="w-1.5 h-1.5 bg-green-500 rounded-full"></span>
                            <p class="text-green-600 text-xs">Online</p>
                        </div>
                    </div>
                </div>

                <div class="flex gap-2 text-gray-500">
                    <button class="w-10 h-10 rounded-full hover:bg-gray-100 flex items-center justify-center transition-all duration-300 hover:text-indigo-600 hover:scale-110">
                        <i class="fa-solid fa-phone text-lg"></i>
                    </button>
                    <button class="w-10 h-10 rounded-full hover:bg-purple-100 flex items-center justify-center transition-all duration-300 hover:text-purple-600 hover:scale-110">
                        <i class="fa-solid fa-video text-lg"></i>
                    </button>
                    <button class="w-9 h-9 rounded-full hover:bg-gray-100 flex items-center justify-center transition">
                        <i class="fa-solid fa-circle-info"></i>
                    </button>
                </div>
            </div>

            <!-- CHAT MESSAGES -->
            <div id="chatMessages" class="flex-1 overflow-y-auto p-4 space-y-4 bg-gray-50">

                <div class="text-center">
                    <span class="inline-block bg-white px-3 py-1.5 rounded-full text-gray-500 text-xs shadow-sm">
                        <i class="fa-regular fa-clock mr-1"></i>
                        Kamis 22:46
                    </span>
                </div>

                <!-- LEFT MESSAGE (RECEIVED) -->
                <div class="flex gap-1.5 message-bubble items-end">
                    <img src="{{ asset('images/user1.jpg') }}" class="w-7 h-7 rounded-full object-cover flex-shrink-0">
                    <div class="bg-white text-gray-900 px-3 py-2 rounded-2xl rounded-bl-sm shadow-sm">
                        <p class="text-sm">Aku tadi baca lapormu tentang jalan berlubang deket sekolah itu.</p>
                    </div>
                    <span class="text-xs text-gray-400 self-end mb-0.5">22:46</span>
                </div>

                <!-- RIGHT MESSAGE (SENT) -->
                <div class="flex justify-end message-bubble items-end gap-1.5">
                    <span class="text-xs text-gray-400 self-end mb-0.5 flex items-center gap-1">
                        <span>22:48</span>
                        <i class="fa-solid fa-check-double text-blue-500"></i>
                    </span>
                    <div class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-3 py-2 rounded-2xl rounded-br-sm shadow-sm">
                        <p class="text-sm">Iya, udah beberapa minggu nggak diperbaiki. Banyak motor yang hampir jatuh</p>
                    </div>
                </div>

                <div class="text-center">
                    <span class="inline-block bg-white px-3 py-1.5 rounded-full text-gray-500 text-xs shadow-sm">
                        <i class="fa-regular fa-clock mr-1"></i>
                        Jumat 13:35
                    </span>
                </div>

                <div class="flex gap-1.5 message-bubble items-end">
                    <img src="{{ asset('images/user1.jpg') }}" class="w-7 h-7 rounded-full object-cover flex-shrink-0">
                    <div class="bg-white text-gray-900 px-3 py-2 rounded-2xl rounded-bl-sm shadow-sm">
                        <p class="text-sm">Aku juga pernah hampir kepeleset pas hujan 😅. Emang harus cepat diperbaiki.</p>
                    </div>
                    <span class="text-xs text-gray-400 self-end mb-0.5">13:35</span>
                </div>

                <div class="flex justify-end message-bubble items-end gap-1.5">
                    <span class="text-xs text-gray-400 self-end mb-0.5 flex items-center gap-1">
                        <span>13:37</span>
                        <i class="fa-solid fa-check-double text-blue-500"></i>
                    </span>
                    <div class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-3 py-2 rounded-2xl rounded-br-sm shadow-sm">
                        <p class="text-sm">Makanya aku laporin di sini, biar banyak yang lihat dan kasih vote</p>
                    </div>
                </div>

                <!-- TYPING INDICATOR -->
                <div class="flex gap-1.5 message-bubble items-end">
                    <img src="{{ asset('images/user1.jpg') }}" class="w-7 h-7 rounded-full object-cover flex-shrink-0">
                    <div class="bg-white px-3 py-2.5 rounded-2xl rounded-bl-sm shadow-sm">
                        <div class="typing-indicator flex gap-1">
                            <span class="w-2 h-2 bg-gray-400 rounded-full"></span>
                            <span class="w-2 h-2 bg-gray-400 rounded-full"></span>
                            <span class="w-2 h-2 bg-gray-400 rounded-full"></span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- MESSAGE INPUT -->
            <div class="p-5 bg-white/95 backdrop-blur-md border-t-2 border-gray-100 shadow-lg flex-shrink-0">
                <!-- Hidden file input -->
                <input type="file" id="photoInput" accept="image/*,video/*" multiple class="hidden" onchange="handlePhotoSelect(event)">
                
                <div class="flex items-center gap-3">
                    <button onclick="document.getElementById('photoInput').click()" class="w-12 h-12 rounded-2xl bg-gradient-to-br from-yellow-400 via-orange-500 to-red-500 flex items-center justify-center text-white hover:scale-110 active:scale-95 transition-transform shadow-lg hover:shadow-xl">
                        <i class="fa-solid fa-plus text-lg"></i>
                    </button>
                    
                    <div class="flex-1 flex items-center gap-4 bg-gradient-to-r from-gray-50 to-blue-50/50 rounded-2xl px-5 py-3.5 border-2 border-gray-200 focus-within:border-indigo-400 focus-within:ring-4 focus-within:ring-indigo-100 focus-within:from-white focus-within:to-indigo-50/30 transition-all shadow-sm hover:shadow-md">
                        <button class="hover:scale-125 active:scale-95 transition-transform">
                            <i class="fa-regular fa-face-smile text-xl text-gray-400 hover:text-yellow-500 transition-colors"></i>
                        </button>
                        <input type="text" id="messageInput" placeholder="Ketik pesan..." 
                            class="flex-1 bg-transparent outline-none text-sm placeholder-gray-400 font-medium"
                            onkeypress="if(event.key === 'Enter') sendMessage()">
                        <button class="hover:scale-125 active:scale-95 transition-transform">
                            <i class="fa-solid fa-paperclip text-lg text-gray-400 hover:text-indigo-600 transition-colors"></i>
                        </button>
                        <button class="hover:scale-125 active:scale-95 transition-transform">
                            <i class="fa-solid fa-image text-lg text-gray-400 hover:text-purple-600 transition-colors"></i>
                        </button>
                    </div>
                    
                    <button onclick="sendMessage()" class="w-12 h-12 rounded-2xl bg-gradient-to-br from-indigo-600 via-purple-600 to-violet-600 flex items-center justify-center text-white hover:scale-110 active:scale-95 transition-all duration-300 shadow-lg hover:shadow-xl group relative overflow-hidden">
                        <div class="absolute inset-0 bg-white/20 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                        <i class="fa-solid fa-paper-plane relative z-10 group-hover:translate-x-0.5 group-hover:-translate-y-0.5 transition-transform"></i>
                    </button>
                </div>
            </div>

        </div>

    </div>
</div>

<script>
function handlePhotoSelect(event) {
    const files = event.target.files;
    if (files.length === 0) return;
    
    // Get current time
    const now = new Date();
    const time = now.getHours().toString().padStart(2, '0') + ':' + now.getMinutes().toString().padStart(2, '0');
    
    // Process each file
    Array.from(files).forEach((file, index) => {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            const messageId = 'msg-' + Date.now() + '-' + index;
            const messageDiv = document.createElement('div');
            messageDiv.className = 'flex justify-end message-bubble items-end gap-1.5 group';
            messageDiv.id = messageId;
            
            let content = '';
            if (file.type.startsWith('image/')) {
                content = `<img src="${e.target.result}" class="max-w-xs rounded-xl shadow-lg cursor-pointer" alt="${file.name}" onclick="window.open('${e.target.result}', '_blank')">`;
            } else if (file.type.startsWith('video/')) {
                content = `<video controls class="max-w-xs rounded-xl shadow-lg"><source src="${e.target.result}" type="${file.type}"></video>`;
            }
            
            messageDiv.innerHTML = `
                <div class="flex items-end gap-1.5 relative">
                    <div class="absolute -left-10 top-1/2 -translate-y-1/2 opacity-0 group-hover:opacity-100 transition-opacity flex gap-1">
                        <button onclick="deleteMessage('${messageId}')" class="w-7 h-7 bg-white hover:bg-red-50 rounded-full flex items-center justify-center shadow-md transition-all hover:scale-110" title="Hapus">
                            <i class="fa-solid fa-trash text-xs text-red-600"></i>
                        </button>
                    </div>
                    <span class="text-xs text-gray-400 self-end mb-0.5 flex items-center gap-1">
                        <span class="message-time">${time}</span>
                        <i class="fa-solid fa-check-double text-blue-500"></i>
                    </span>
                    <div class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white p-2 rounded-2xl rounded-br-sm shadow-sm">
                        ${content}
                    </div>
                </div>
            `;
            
            const chatMessages = document.getElementById('chatMessages');
            chatMessages.appendChild(messageDiv);
            chatMessages.scrollTop = chatMessages.scrollHeight;
            
            // Animation
            setTimeout(() => {
                messageDiv.style.opacity = '0';
                messageDiv.style.transform = 'translateY(10px)';
                setTimeout(() => {
                    messageDiv.style.transition = 'all 0.3s ease-out';
                    messageDiv.style.opacity = '1';
                    messageDiv.style.transform = 'translateY(0)';
                }, 10);
            }, 0);
        };
        
        reader.readAsDataURL(file);
    });
    
    // Reset file input
    event.target.value = '';
}

function openChat(name, avatar, status, index) {
    // Update chat header
    document.getElementById('chatName').textContent = name;
    document.getElementById('chatAvatar').src = avatar;
    
    // Update online status
    const chatStatus = document.getElementById('chatStatus');
    const onlineIndicator = document.getElementById('chatOnlineIndicator');
    
    if (status === 'online') {
        chatStatus.innerHTML = '<span class="w-1.5 h-1.5 bg-green-500 rounded-full"></span><p class="text-green-600 text-xs">Online</p>';
        onlineIndicator.classList.remove('hidden');
        onlineIndicator.classList.add('bg-green-500');
    } else {
        chatStatus.innerHTML = '<p class="text-gray-400 text-xs">Offline</p>';
        onlineIndicator.classList.add('hidden');
    }
    
    // Remove badge notification
    const badge = document.querySelector('.chat-badge-' + index);
    if (badge) {
        badge.remove();
    }
    
    // Update active state
    document.querySelectorAll('.chat-item').forEach(item => {
        item.classList.remove('bg-blue-50');
        item.classList.add('bg-white');
    });
    event.currentTarget.classList.remove('bg-white');
    event.currentTarget.classList.add('bg-blue-50');
    
    // Show chat room (in case it's hidden)
    document.getElementById('chatRoom').classList.remove('hidden');
}

function sendMessage() {
    const input = document.getElementById('messageInput');
    const message = input.value.trim();
    
    if (message === '') return;
    
    // Get current time
    const now = new Date();
    const time = now.getHours().toString().padStart(2, '0') + ':' + now.getMinutes().toString().padStart(2, '0');
    
    // Generate unique message ID
    const messageId = 'msg-' + Date.now();
    
    // Create message element
    const messageDiv = document.createElement('div');
    messageDiv.className = 'flex justify-end message-bubble items-end gap-1.5 group';
    messageDiv.id = messageId;
    messageDiv.innerHTML = `
        <div class="flex items-end gap-1.5 relative">
            <div class="absolute -left-10 top-1/2 -translate-y-1/2 opacity-0 group-hover:opacity-100 transition-opacity flex gap-1">
                <button onclick="editMessage('${messageId}')" class="w-7 h-7 bg-white hover:bg-blue-50 rounded-full flex items-center justify-center shadow-md transition-all hover:scale-110" title="Edit">
                    <i class="fa-solid fa-pen text-xs text-blue-600"></i>
                </button>
                <button onclick="deleteMessage('${messageId}')" class="w-7 h-7 bg-white hover:bg-red-50 rounded-full flex items-center justify-center shadow-md transition-all hover:scale-110" title="Hapus">
                    <i class="fa-solid fa-trash text-xs text-red-600"></i>
                </button>
            </div>
            <span class="text-xs text-gray-400 self-end mb-0.5 flex items-center gap-1">
                <span class="message-time">${time}</span>
                <i class="fa-solid fa-check-double text-blue-500"></i>
            </span>
            <div class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-3 py-2 rounded-2xl rounded-br-sm shadow-sm message-content">
                <p class="text-sm message-text">${message}</p>
            </div>
        </div>
    `;
    
    // Remove typing indicator if exists
    const typingIndicator = document.querySelector('.typing-indicator');
    if (typingIndicator) {
        typingIndicator.closest('.message-bubble').remove();
    }
    
    // Add message to chat
    const chatMessages = document.getElementById('chatMessages');
    chatMessages.appendChild(messageDiv);
    
    // Clear input
    input.value = '';
    
    // Scroll to bottom
    chatMessages.scrollTop = chatMessages.scrollHeight;
    
    // Trigger animation
    setTimeout(() => {
        messageDiv.style.opacity = '0';
        messageDiv.style.transform = 'translateY(10px)';
        setTimeout(() => {
            messageDiv.style.transition = 'all 0.3s ease-out';
            messageDiv.style.opacity = '1';
            messageDiv.style.transform = 'translateY(0)';
        }, 10);
    }, 0);
}

function deleteMessage(messageId) {
    if (confirm('Hapus pesan ini?')) {
        const messageDiv = document.getElementById(messageId);
        messageDiv.style.transition = 'all 0.3s ease-out';
        messageDiv.style.opacity = '0';
        messageDiv.style.transform = 'translateX(100px)';
        setTimeout(() => {
            messageDiv.remove();
        }, 300);
    }
}

function editMessage(messageId) {
    const messageDiv = document.getElementById(messageId);
    const messageText = messageDiv.querySelector('.message-text');
    const currentText = messageText.textContent;
    
    // Create edit input
    const input = document.createElement('input');
    input.type = 'text';
    input.value = currentText;
    input.className = 'bg-white text-gray-900 px-2 py-1 rounded text-sm outline-none border-2 border-blue-400 w-full';
    
    // Replace text with input
    messageText.innerHTML = '';
    messageText.appendChild(input);
    input.focus();
    input.select();
    
    // Handle save on Enter
    input.addEventListener('keypress', (e) => {
        if (e.key === 'Enter') {
            const newText = input.value.trim();
            if (newText !== '') {
                messageText.textContent = newText;
                
                // Add edited indicator
                const editedSpan = messageDiv.querySelector('.edited-indicator');
                if (!editedSpan) {
                    const timeSpan = messageDiv.querySelector('.message-time');
                    timeSpan.insertAdjacentHTML('afterend', '<span class="edited-indicator text-xs ml-1">(diedit)</span>');
                }
            } else {
                messageText.textContent = currentText;
            }
        }
    });
    
    // Handle save on blur (click outside)
    input.addEventListener('blur', () => {
        const newText = input.value.trim();
        if (newText !== '' && newText !== currentText) {
            messageText.textContent = newText;
            
            // Add edited indicator
            const editedSpan = messageDiv.querySelector('.edited-indicator');
            if (!editedSpan) {
                const timeSpan = messageDiv.querySelector('.message-time');
                timeSpan.insertAdjacentHTML('afterend', '<span class="edited-indicator text-xs ml-1">(diedit)</span>');
            }
        } else {
            messageText.textContent = currentText;
        }
    });
}

function searchChats() {
    const searchInput = document.getElementById('searchChat');
    const searchTerm = searchInput.value.toLowerCase();
    const chatItems = document.querySelectorAll('.chat-item');
    
    chatItems.forEach(item => {
        const name = item.getAttribute('data-name');
        
        if (name.includes(searchTerm)) {
            item.style.display = 'flex';
        } else {
            item.style.display = 'none';
        }
    });
    
    // Show message if no results found
    const visibleChats = Array.from(chatItems).filter(item => item.style.display !== 'none');
    const chatList = document.getElementById('chatList');
    
    // Remove existing "no results" message if any
    const existingNoResults = document.getElementById('noResultsMessage');
    if (existingNoResults) {
        existingNoResults.remove();
    }
    
    if (visibleChats.length === 0 && searchTerm !== '') {
        const noResultsDiv = document.createElement('div');
        noResultsDiv.id = 'noResultsMessage';
        noResultsDiv.className = 'text-center py-8 text-gray-400';
        noResultsDiv.innerHTML = `
            <i class="fa-solid fa-search text-3xl mb-2"></i>
            <p class="text-sm">Tidak ada percakapan ditemukan</p>
        `;
        chatList.appendChild(noResultsDiv);
    }
}
</script>

@endsection
