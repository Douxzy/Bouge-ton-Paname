<?php
session_start();
require_once '../db.php';

if (!empty($_POST['message']) && isset($_POST['receiver_id']) && isset($_SESSION['user_id'])) {
    $message = trim($_POST['message']);
    $sender_id = $_SESSION['user_id'];
    $receiver_id = intval($_POST['receiver_id']);

    $stmt = $pdo->prepare("INSERT INTO private_messages (sender_id, receiver_id, message) VALUES (?, ?, ?)");
    $stmt->execute([$sender_id, $receiver_id, $message]);
}
?>