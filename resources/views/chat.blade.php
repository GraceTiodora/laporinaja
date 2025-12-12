@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Chat dengan <span id="chat-with">User</span></h3>
    <div id="chat-box" style="height:300px; overflow-y:auto; border:1px solid #ccc; padding:10px; margin-bottom:10px;"></div>
    <form id="chat-form">
        <input type="hidden" id="receiver_id" value="8"> <!-- Set value ke 8 -->
        <div class="input-group">
            <input type="text" id="chat-input" class="form-control" placeholder="Ketik pesan..." autocomplete="off">
            <button type="submit" class="btn btn-primary">Kirim</button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    const userId = {{ auth()->id() }};
    let receiverId = document.getElementById('receiver_id').value; // Sekarang otomatis 8
    let lastId = 0;

    function fetchMessages() {
        fetch(`/api/messages?user_id=${receiverId}&last_id=${lastId}`, {
            headers: {
                'Accept': 'application/json'
            }
        })
        .then(res => res.json())
        .then(messages => {
            if (messages.length > 0) {
                const chatBox = document.getElementById('chat-box');
                messages.forEach(msg => {
                    const div = document.createElement('div');
                    div.innerHTML = `<b>${msg.sender_id == userId ? 'Saya' : 'Dia'}:</b> ${msg.content}`;
                    chatBox.appendChild(div);
                    lastId = msg.id;
                });
                chatBox.scrollTop = chatBox.scrollHeight;
            }
        });
    }

    setInterval(fetchMessages, 2000); // Polling setiap 2 detik

    document.getElementById('chat-form').addEventListener('submit', function(e) {
        e.preventDefault();
        const input = document.getElementById('chat-input');
        const content = input.value;
        if (!content.trim()) return;
        fetch('/api/messages', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ receiver_id: receiverId, content })
        })
        .then(res => res.json())
        .then(msg => {
            input.value = '';
            fetchMessages();
        });
    });
</script>
@endpush
