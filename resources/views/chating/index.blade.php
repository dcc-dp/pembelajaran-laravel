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

        @media (max-width: 640px) {
            .input-area {
                flex-direction: column;
                padding: 12px;
            }

            .input-area button {
                width: 100%;
            }

            .input-area input[type="file"] {
                width: 100%;
            }
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
                    {{-- <div class="input-area">
                        <input type="file" id="imageInput" accept="image/*">
                        <button id="sendImageBtn" onclick="sendImage()">Kirim</button>
                    </div> --}}
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
        } from "https://www.gstatic.com/firebasejs/10.7.1/firebase-app.js";

        import {
            getFirestore,
            collection,
            addDoc,
            onSnapshot,
            query,
            orderBy,
            deleteDoc,
            doc,
            serverTimestamp
        } from "https://www.gstatic.com/firebasejs/10.7.1/firebase-firestore.js";

        function setButtonLoading(button, loading, textLoading = 'Loading...') {
            if (!button) return;

            if (loading) {
                button.dataset.originalText = button.innerHTML;
                button.innerHTML = textLoading;
                button.disabled = true;
                button.style.opacity = '0.7';
                button.style.cursor = 'not-allowed';
            } else {
                button.innerHTML = button.dataset.originalText;
                button.disabled = false;
                button.style.opacity = '1';
                button.style.cursor = 'pointer';
            }
        }


        async function uploadImage(file) {
            const formData = new FormData();
            formData.append('image', file);

            const response = await fetch('/upload-chat-image', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: formData
            });

            return response.json();
        }

        const firebaseConfig = {
            apiKey: "{{ config('services.firebase.api_key') }}",
            authDomain: "{{ config('services.firebase.auth_domain') }}",
            databaseURL: "{{ config('services.firebase.database_url') }}",
            projectId: "{{ config('services.firebase.project_id') }}",
            storageBucket: "{{ config('services.firebase.storage_bucket') }}",
            messagingSenderId: "{{ config('services.firebase.messaging_sender_id') }}",
            appId: "{{ config('services.firebase.app_id') }}"
        };

        const app = initializeApp(firebaseConfig);
        const db = getFirestore(app);
        const chatRef = collection(db, "chats");

        window.sendMessage = async function() {
            const input = document.getElementById('messageInput');
            const message = input.value.trim();

            if (!message) return;

            await addDoc(chatRef, {
                userId: currentUserId,
                userName: currentUserName,
                type: 'text',
                message: message,
                createdAt: serverTimestamp()
            });

            input.value = '';
        };


        window.sendImage = async function() {
            const input = document.getElementById('imageInput');
            const button = document.getElementById('sendImageBtn');
            const file = input.files[0];

            if (!file) return alert('Pilih gambar dulu');

            try {
                setButtonLoading(button, true, 'Mengirim...');

                const uploaded = await uploadImage(file);

                await addDoc(chatRef, {
                    userId: currentUserId,
                    userName: currentUserName,
                    type: 'image',
                    imageUrl: uploaded.url,
                    publicId: uploaded.public_id,
                    createdAt: serverTimestamp()
                });

                input.value = '';
            } catch (error) {
                alert('Gagal mengirim gambar');
                console.error(error);
            } finally {
                setButtonLoading(button, false);
            }
        };


        window.deleteMessage = function(messageKey) {
            if (!confirm('Hapus pesan ini?')) return;

            const messageRef = ref(database, 'chats/' + messageKey);
            remove(messageRef);
        };


        const messagesDiv = document.getElementById('messages');

        const q = query(chatRef, orderBy("createdAt"));

        onSnapshot(q, (snapshot) => {
            snapshot.docChanges().forEach((change) => {

                if (change.type === "added") {
                    const data = change.doc.data();
                    const messageKey = change.doc.id;

                    const localTime = data.createdAt ?
                        data.createdAt.toDate().toLocaleString('id-ID', {
                            dateStyle: 'short',
                            timeStyle: 'medium'
                        }) :
                        '';

                    const messageDiv = document.createElement('div');
                    messageDiv.id = messageKey;
                    messageDiv.classList.add(
                        'message',
                        data.userId === currentUserId ? 'my-message' : 'other-message'
                    );

                    let content = '';

                    if (data.type === 'text') {
                        content = `<span class="text">${data.message}</span>`;
                    }

                    if (data.type === 'image') {
                        content = `
                    <img src="${data.imageUrl}"
                        style="max-width:200px;border-radius:8px;cursor:pointer"
                        onclick="window.open('${data.imageUrl}', '_blank')">
                `;
                    }

                    messageDiv.innerHTML = `
                    <span class="username">${data.userName}:</span>
                    ${content}
                    <div class="time">${localTime}</div>
                    ${
                        data.userId === currentUserId
                        ? `<button class="delete-btn"
                                        onclick="deleteMessage('${messageKey}', '${data.publicId ?? ''}', this)">
                                        Hapus
                                    </button>`
                        : ''
                    }
                `;

                    messagesDiv.appendChild(messageDiv);
                    messagesDiv.scrollTop = messagesDiv.scrollHeight;
                }

                if (change.type === "removed") {
                    document.getElementById(change.doc.id)?.remove();
                }
            });
        });


        window.deleteMessage = async function(messageId, publicId = null, button = null) {
            if (!confirm('Hapus pesan ini?')) return;

            try {
                setButtonLoading(button, true, 'Menghapus...');

                if (publicId) {
                    await fetch('/chat/delete-image', {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            public_id: publicId
                        })
                    });
                }

                await deleteDoc(doc(db, "chats", messageId));
            } catch (error) {
                alert('Gagal menghapus pesan');
                console.error(error);
                setButtonLoading(button, false);
            }
        };
    </script>
</x-app-layout>
