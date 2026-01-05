<x-app-layout>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
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

        .my-message {
            background: #d1e7ff;
            text-align: right;
        }

        .other-message {
            background: #f8f9fa;
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

        .delete-btn {
            background: #dc3545;
            color: white;
            border: none;
            padding: 4px 8px;
            font-size: 0.8em;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 5px;
        }

        .delete-btn:hover {
            background: #b02a37;
        }
    </style>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 style="text-align: center; padding: 20px; margin: 0; border-bottom: 1px solid #eee;">Chat
                        Real-time</h2>
                    <div class="messages" id="messages">
                    </div>
                    <div class="input-area">
                        <textarea id="messageInput" placeholder="Ketik pesan..." rows="1"></textarea>
                        <button onclick="sendMessage()">Kirim</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const currentUserId = "{{ auth()->user()->id }}";
        const currentUserName = "{{ auth()->user()->name }}";
    </script>

    <script type="module">
        import {
            initializeApp
        }
        from "https://www.gstatic.com/firebasejs/10.7.1/firebase-app.js";

        import {
            getDatabase,
            ref,
            push,
            onChildAdded,
            onChildRemoved,
            remove
        } from "https://www.gstatic.com/firebasejs/10.7.1/firebase-database.js";


        const firebaseConfig = {
            apiKey: "AIzaSyCOHxrUDnezt5FjbkSSVDvTlVLQW32RT5c",
            authDomain: "pembelajaran-dcc-f6564.firebaseapp.com",
            databaseURL: "https://pembelajaran-dcc-f6564-default-rtdb.asia-southeast1.firebasedatabase.app",
            projectId: "pembelajaran-dcc-f6564",
            storageBucket: "pembelajaran-dcc-f6564.firebasestorage.app",
            messagingSenderId: "329893273978",
            appId: "1:329893273978:web:b5dd108d3f5f8a3332b6c3",
            measurementId: "G-N0HEW03BM4"
        };

        const app = initializeApp(firebaseConfig);
        const database = getDatabase(app);
        const chatRef = ref(database, 'chats');

        window.sendMessage = function() {
            const messageInput = document.getElementById('messageInput');
            const message = messageInput.value;

            if (message.trim() === '') return;

            push(chatRef, {
                userId: currentUserId,
                userName: currentUserName,
                message: message,
                time: new Date().toISOString()
            });

            messageInput.value = '';
        };

        window.deleteMessage = function(messageKey) {
            if (!confirm('Hapus pesan ini?')) return;

            const messageRef = ref(database, 'chats/' + messageKey);
            remove(messageRef);
        };


        const messagesDiv = document.getElementById('messages');

        onChildAdded(chatRef, (snapshot) => {
            const data = snapshot.val();
            const messageKey = snapshot.key;
            const localTime = new Date(data.time).toLocaleString('id-ID', {
                dateStyle: 'short',
                timeStyle: 'medium'
            });

            const messageDiv = document.createElement('div');
            messageDiv.id = messageKey;
            messageDiv.classList.add(
                'message',
                data.userId === currentUserId ? 'my-message' : 'other-message'
            );

            messageDiv.innerHTML = `
                <span class="username">${data.userName}:</span>
                <span class="text">${data.message}</span>
                <div class="time">${localTime}</div>
                ${
                    data.userId === currentUserId
                    ? `<button class="delete-btn" onclick="deleteMessage('${messageKey}')">Hapus</button>`
                    : ''
                }
            `;

            messagesDiv.appendChild(messageDiv);
            messagesDiv.scrollTop = messagesDiv.scrollHeight;

        });

        onChildRemoved(chatRef, (snapshot) => {
            const messageDiv = document.getElementById(snapshot.key);
            if (messageDiv) {
                messageDiv.remove();
            }
        });
    </script>
</x-app-layout>
