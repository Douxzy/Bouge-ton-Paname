<?php
session_start();
require "db.php";

if (
    $_SERVER['REQUEST_METHOD'] === 'POST' &&
    isset($_POST['record_id'], $_POST['commentaire'], $_SESSION['user'])
) {
    $recordId = $_POST['record_id'];
    $userId = $_SESSION['user']['id'];
    $pseudo = $_SESSION['user']['pseudo'];
    $commentaire = htmlspecialchars($_POST['commentaire']);
    $imagePath = null;

    // Gestion de l'image
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = __DIR__ . '/../uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $fileName = uniqid() . '_' . basename($_FILES['image']['name']);
        $destination = $uploadDir . $fileName;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $destination)) {
            $imagePath = 'uploads/' . $fileName;
        }
    }

    // Insertion du commentaire
    $stmt = $pdo->prepare("INSERT INTO commentaires (record_id, user_id, pseudo, commentaire, image_path) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$recordId, $userId, $pseudo, $commentaire, $imagePath]);

    // ✅ Ajout de la notification personnalisée
    $notif = $pdo->prepare("INSERT INTO notifications (user_id, message) VALUES (?, ?)");
    $message = 'Commentaire posté par ' . htmlspecialchars($pseudo) . '💬';
    $notif->execute([$userId, $message]);

    // Retour à la page précédente
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit;
} else {
    echo "Formulaire invalide ou utilisateur non connecté.";
}
