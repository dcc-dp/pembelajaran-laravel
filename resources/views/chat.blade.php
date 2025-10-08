<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat Real-time</title>

    <!-- Load Pusher dan Echo dari CDN yang berfungsi -->
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/laravel-echo@1.15.0/dist/echo.iife.js"></script>

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background: #f5f5f5;
        }

        .chat-container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .messages {
            height: 400px;
            overflow-y: auto;
            padding: 20px;
            border-bottom: 1px solid #eee;
        }

        .message {
            margin-bottom: 15px;
            padding: 10px;
            border-radius: 5px;
            background: #f8f9fa;
        }

        .message .username {
            font-weight: bold;
            color: #007bff;
        }

        .message .time {
            font-size: 0.8em;
            color: #666;
        }

        .input-area {
            padding: 20px;
            display: flex;
            gap: 10px;
        }

        input,
        textarea {
            flex: 1;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        button {
            padding: 10px 20px;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background: #0056b3;
        }
    </style>
</head>

<body>
    <div class="chat-container">
        <h2 style="text-align: center; padding: 20px; margin: 0; border-bottom: 1px solid #eee;">Chat Real-time</h2>
        <div class="messages" id="messages">
            @foreach ($messages as $message)
                <div class="message">
                    <span class="username">{{ $message->username }}:</span>
                    <span class="text">{{ $message->message }}</span>
                    <div class="time">{{ $message->created_at->format('H:i') }}</div>
                </div>
            @endforeach
        </div>
        <div class="input-area">
            <input type="text" id="username" placeholder="Nama Anda" value="{{ 'User' . rand(1000, 9999) }}">
            <textarea id="messageInput" placeholder="Ketik pesan..." rows="1"></textarea>
            <button onclick="sendMessage()">Kirim</button>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            initializeEcho();
        });

        function initializeEcho() {
            try {
                console.log('🚀 Initializing Echo with correct credentials...');

                window.Echo = new Echo({
                    broadcaster: 'pusher',
                    key: '{{ env('REVERB_APP_KEY') }}',
                    wsHost: '{{ env('REVERB_HOST') }}',
                    wsPort: {{ env('REVERB_PORT') }},
                    wssPort: {{ env('REVERB_PORT') }},
                    forceTLS: false,
                    cluster: 'mt1',
                    enabledTransports: ['ws', 'wss'],
                });

                console.log('✅ Echo instance created');

                // Connection events
                window.Echo.connector.pusher.connection.bind('connected', function() {
                    console.log('✅ ✅ ✅ CONNECTED to Reverb!');
                });

                window.Echo.connector.pusher.connection.bind('error', function(err) {
                    console.error('❌ Connection error:', err);
                });

                // Listen for messages
                window.Echo.channel('chat')
                    .listen('.new-message', (e) => {
                        console.log('📨 NEW MESSAGE RECEIVED:', e);
                        addMessageToChat(e.message);
                    });

            } catch (error) {
                console.error('❌ Error initializing Echo:', error);
            }
        }

        function addMessageToChat(message) {
            console.log('➕ Adding message to chat:', message);

            const messagesDiv = document.getElementById('messages');
            const messageDiv = document.createElement('div');
            messageDiv.className = 'message';
            messageDiv.innerHTML = `
                <span class="username">${message.username}:</span>
                <span class="text">${message.message}</span>
                <div class="time">${new Date(message.created_at).toLocaleTimeString('id-ID')}</div>
            `;
            messagesDiv.appendChild(messageDiv);
            messagesDiv.scrollTop = messagesDiv.scrollHeight;

            console.log('✅ Message added to UI');
        }

        function sendMessage() {
            const username = document.getElementById('username').value;
            const messageInput = document.getElementById('messageInput');
            const message = messageInput.value.trim();

            if (!username || !message) {
                alert('Harap isi nama dan pesan!');
                return;
            }

            console.log('📤 Sending message:', {
                username,
                message
            });

            fetch('/send-message', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        username: username,
                        message: message
                    })
                })
                .then(response => {
                    console.log('Response status:', response.status);
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('✅ Message sent successfully:', data);
                })
                .catch(error => {
                    console.error('❌ Error sending message:', error);
                    alert('Error sending message: ' + error.message);
                });
        }

        document.getElementById('messageInput').addEventListener('keypress', function(e) {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                sendMessage();
            }
        });

        const messagesDiv = document.getElementById('messages');
        if (messagesDiv) {
            messagesDiv.scrollTop = messagesDiv.scrollHeight;
        }
    </script>
</body>

</html>
