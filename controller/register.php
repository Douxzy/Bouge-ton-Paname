<?php
session_start();
require_once 'db.php'; // Assure-toi d'avoir un fichier de connexion à la BDD

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupération et nettoyage des données
    $pseudo = trim($_POST['pseudo'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirm-password'] ?? '';
    $postalCode = trim($_POST['postal-code'] ?? '');

    // Validation basique
    if (empty($pseudo) || empty($email) || empty($password) || empty($confirmPassword) || empty($postalCode)) {
        $_SESSION['error'] = "Tous les champs sont obligatoires.";
        header("Location: ../vue/register.php");

        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = "Adresse email invalide.";
        header("Location: ../vue/register.php");

        exit;
    }

    if ($password !== $confirmPassword) {
        $_SESSION['error'] = "Les mots de passe ne correspondent pas.";
        header("Location: ../vue/register.php");

        exit;
    }

    if (!preg_match('/^\d{5}$/', $postalCode)) {
        $_SESSION['error'] = "Le code postal doit contenir 5 chiffres.";
        header("Location: ../vue/register.php");

        exit;
    }

    // Hachage du mot de passe
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    try {
        // Vérifie si l'email existe déjà
        $checkStmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $checkStmt->execute([$email]);
        if ($checkStmt->rowCount() > 0) {
            $_SESSION['error'] = "Un compte existe déjà avec cet email.";
            header("Location: ../vue/register.php");

            exit;
        }

        // Insertion du nouvel utilisateur
        $stmt = $pdo->prepare("INSERT INTO users (pseudo, email, password, postal_code) VALUES (?, ?, ?, ?)");
        $stmt->execute([$pseudo, $email, $hashedPassword, $postalCode]);

        $_SESSION['success'] = "Inscription réussie. Connecte-toi maintenant.";
        header("Location: ../login.php");
        exit;
    } catch (PDOException $e) {
        $_SESSION['error'] = "Erreur lors de l'inscription : " . $e->getMessage();
        header("Location: ../vue/register.php");

        exit;
    }
} else {
    header("Location: ../vue/register.php");

    exit;
}
