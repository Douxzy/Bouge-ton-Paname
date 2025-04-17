<?php
session_start();
require_once 'db.php'; // Connexion à la BDD

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    // Validation
    if (empty($email) || empty($password)) {
        $_SESSION['error'] = "Veuillez remplir tous les champs.";
        header("Location: ../vue/login.php");
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = "Email invalide.";
        header("Location: ../vue/login.php");
        exit;
    }

    try {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            // Connexion réussie
            $_SESSION['user'] = [
                'id' => $user['id'],
                'pseudo' => $user['pseudo'],
                'email' => $user['email']
            ];
            $notif = $pdo->prepare("INSERT INTO notifications (user_id, message) VALUES (?, ?)");
            $message = "Connexion réussie ! Bienvenue " . $user['pseudo'] . " sur Bouge ton Paname 👋";
            $notif->execute([$user['id'], $message]);
            header("Location: ../vue/index.php");
            exit;
        } else {
            $_SESSION['error'] = "Identifiants incorrects.";
            header("Location: ../vue/login.php");
            exit;
        }

    } catch (PDOException $e) {
        $_SESSION['error'] = "Erreur lors de la connexion : " . $e->getMessage();
        header("Location: ../vue/login.php");
        exit;
    }
} else {
    exit;
}
