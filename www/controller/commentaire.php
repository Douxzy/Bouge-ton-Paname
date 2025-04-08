<?php
require_once "db.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['record_id'], $_POST['pseudo'], $_POST['commentaire'])) {
    $recordId = $_POST['record_id'];
    $pseudo = htmlspecialchars($_POST['pseudo']);
    $commentaire = htmlspecialchars($_POST['commentaire']);

    $stmt = $pdo->prepare("INSERT INTO commentaires (record_id, pseudo, commentaire) VALUES (?, ?, ?)");
    $stmt->execute([$recordId, $pseudo, $commentaire]);

    // Pour éviter les doublons à l'actualisation
    header("Location: " . $_SERVER['REQUEST_URI']);
    exit;
}
