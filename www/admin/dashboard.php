<?php
require __DIR__ . "/../vue/header/header.php";
require_once '../controller/db.php';

// Redirection si l'utilisateur n'est pas admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}
?>

<div class="flex min-h-screen">
    <!-- NAVBAR LATÉRALE -->
    <?php require __DIR__ . "/navbar.php"; ?>

    <!-- CONTENU PRINCIPAL -->
    <main class="flex-1 flex items-center justify-center p-10">
        <div class="text-center">
            <h1 class="text-4xl font-bold text-gray-800 mb-4">Bienvenue sur le tableau de bord👋</h1>
            <p class="text-lg text-gray-600">Utilisez le menu à gauche pour gérer votre site.</p>
        </div>
    </main>
</div>

<?php
require __DIR__ . "/../vue/footer/footer.php";
?>