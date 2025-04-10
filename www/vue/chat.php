<?php
require "../controller/db.php";
?>
<script>
    function fetchMessages() {
        fetch('../controller/get_messages.php')
            .then(response => response.text())
            .then(data => {
                const container = document.getElementById('chat-messages');
                container.innerHTML = data;
                container.scrollTop = container.scrollHeight;
            });
    }

    function sendMessage() {
        const message = document.getElementById('message-input').value;
        if (message.trim() === '') return;

        fetch('../controller/send_message.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: 'message=' + encodeURIComponent(message)
        }).then(() => {
            document.getElementById('message-input').value = '';
            fetchMessages();
        });
    }

    setInterval(fetchMessages, 2000);
    window.onload = fetchMessages;
</script>
</head>

<body class="bg-gray-100">
    <!-- Bouton flottant -->
    <div class="fixed bottom-6 right-6 z-50">
        <button onclick="document.getElementById('chat-box').classList.toggle('hidden')"
            class="bg-blue-600 text-white p-3 rounded-full shadow-lg hover:bg-blue-700">
            💬
        </button>
    </div>

    <!-- Chat box -->
    <div id="chat-box"
        class="hidden fixed bottom-20 right-6 w-96 bg-white shadow-xl rounded-lg flex flex-col h-96 z-50">
        <div class="bg-blue-600 text-white text-center py-2 rounded-t-lg font-semibold">
            Chat Global
        </div>

        <div id="chat-messages" class="flex-1 overflow-y-auto p-4 space-y-2 text-sm">
            <!-- Messages dynamiques -->
        </div>

        <div class="flex p-2 border-t">
            <input type="text" id="message-input" class="flex-1 p-2 border rounded-l focus:outline-none"
                placeholder="Ton message...">
            <button onclick="sendMessage()"
                class="bg-blue-600 text-white px-4 rounded-r hover:bg-blue-700">Envoyer</button>
        </div>
    </div>