<!DOCTYPE html>
<html>
<head>
    <title>School AI Chat Assistant (Gemini)</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header bg-success text-white">
         School AI Assistant (Gemini)
        </div>

        <div class="card-body" style="height:400px; overflow-y:auto" id="chatBox">
            <div class="text-muted">Ask anything about students, fees, attendance...</div>
        </div>

        <div class="card-footer">
            <div class="input-group">
                <input type="text" id="message" class="form-control" placeholder="Type your question...">
                <button class="btn btn-success" onclick="sendMessage()">Send</button>
            </div>
        </div>
    </div>
</div>

<script>
function sendMessage() {
    let msg = document.getElementById('message').value;
    if (!msg) return;

    let chatBox = document.getElementById('chatBox');

    chatBox.innerHTML += `
        <div class="text-end mb-2">
            <span class="badge bg-secondary">${msg}</span>
        </div>
    `;

    document.getElementById('message').value = '';

    fetch("/ai-gemini-chat/send", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ message: msg })
    })
    .then(res => res.json())
    .then(data => {
        chatBox.innerHTML += `
            <div class="text-start mb-2">
                <span class="badge bg-success">${data.reply}</span>
            </div>
        `;
        chatBox.scrollTop = chatBox.scrollHeight;
    });
}
</script>

</body>
</html>
