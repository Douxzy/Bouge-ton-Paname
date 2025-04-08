<?php
require_once 'db.php'; // Connexion PDO

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Honeypot anti-spam
    if (!empty($_POST['website'])) {
        die("Spam détecté.");
    }

    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $name = htmlspecialchars(trim($_POST['name']));
    $message = htmlspecialchars(trim($_POST['message']));

    if ($email && $name && $message) {
        try {
            $stmt = $pdo->prepare("INSERT INTO messages_contact (email, nom, message) VALUES (:email, :nom, :message)");
            $stmt->execute([
                ':email' => $email,
                ':nom' => $name,
                ':message' => $message
            ]);
            echo "Merci pour votre message ! Nous vous répondrons rapidement.";
            header("Location: ../vue/index.php");
        } catch (PDOException $e) {
            echo "Erreur lors de l'enregistrement du message : " . $e->getMessage();
        }
    } else {
        echo "Veuillez remplir tous les champs correctement.";
    }
}
