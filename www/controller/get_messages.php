<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['user_id'])) {
    exit("Utilisateur non connecté.");
}

if (!isset($_GET['user_id'])) {
    exit("Aucun destinataire spécifié.");
}

$sender_id = $_SESSION['user_id'];
$receiver_id = $_GET['user_id'];

// Préparation de la requête
$stmt = $pdo->prepare("
    SELECT * FROM private_messages 
    WHERE (sender_id = ? AND receiver_id = ?) 
       OR (sender_id = ? AND receiver_id = ?)
    ORDER BY created_at ASC
");
$stmt->execute([$sender_id, $receiver_id, $receiver_id, $sender_id]);

while ($row = $stmt->fetch()) {
    $is_sender = $row['sender_id'] == $sender_id;
    echo "<div class='" . ($is_sender ? "text-right" : "text-left") . "'>
            <span class='inline-block px-3 py-2 m-1 rounded " . ($is_sender ? "bg-blue-500 text-white" : "bg-gray-200") . "'>
                " . htmlspecialchars($row['message']) . "
            </span>
          </div>";
}

?>
