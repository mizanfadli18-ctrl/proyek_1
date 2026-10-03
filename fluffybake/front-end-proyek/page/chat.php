<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once "koneksi.php";

$id_user = $_SESSION['id_user'] ?? 0;
$id_pesanan = $_GET['id'] ?? 0;

$q = mysqli_query($conn,"
    SELECT * FROM pesanan 
    WHERE id_pesanan='$id_pesanan' AND id_user='$id_user'
");

if (!mysqli_num_rows($q)) {
    echo "<p style='text-align:center;color:red;margin-top:20px;'>Akses ditolak.</p>";
    exit;
}
?>

<link rel="stylesheet" href="assets/css/chat.css?=v1">

<a href="index.php?url=detail_pesanan&id=<?= $id_pesanan ?>" class="back-link">
    <img src="assets/img/back.png">
</a>

<div class="chat-container">

    <div class="chat-header">Chat dengan Penjual</div>

    <div id="chat-box" class="chat-box"></div>

    <div class="chat-input">
        <input type="text" id="msg" placeholder="Tulis pesan...">
        <button id="kirim">Kirim</button>
    </div>

</div>

<script>
function loadChat() {
    fetch("api/get_chat.php?id_pesanan=<?= $id_pesanan ?>")
    .then(r => r.json())
    .then(data => {
        let box = document.getElementById("chat-box");
        box.innerHTML = "";

        data.forEach(c => {
            let div = document.createElement("div");
            div.className = (c.sender === "pembeli") ? "chat-me" : "chat-other";
            div.innerHTML = `<p>${c.message}</p><span>${c.waktu}</span>`;
            box.appendChild(div);
        });

        box.scrollTop = box.scrollHeight;
    });
}

document.getElementById("kirim").onclick = function () {
    let msg = document.getElementById("msg").value.trim();
    if (!msg) return;

    fetch("api/send_chat.php", {
        method: "POST",
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: "id_pesanan=<?= $id_pesanan ?>&message=" + encodeURIComponent(msg)
    })
    .then(r => r.json())
    .then(res => {
        document.getElementById("msg").value = "";
        loadChat();
    });
};

loadChat();
setInterval(loadChat, 1000);
</script>
