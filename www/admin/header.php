<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($pdo)) {
    require_once "controller/db.php";
}


$notifications = [];
if (isset($_SESSION['user']['id'])) {
    $stmt = $pdo->prepare("SELECT message, created_at FROM notifications WHERE user_id = ? ORDER BY created_at DESC LIMIT 10");
    $stmt->execute([$_SESSION['user']['id']]);
    $notifications = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bouge ton Paname</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="icon" href="../assets/image/Bouge-ton-Paname-icon.png" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
</head>

<body>
    <header>
        <nav class="bg-white shadow-lg px-6 py-4">
            <div class="container mx-auto flex items-center justify-between">
                <a href="index.php" class="text-2xl font-bold text-gray-800">Bouge ton Paname</a>

                <ul class="hidden md:flex space-x-6 text-gray-700 font-medium">
                    <li><a href="https://douxzy.alwaysdata.net/bouge-ton-paname/index.php" class="hover:text-blue-600 transition">Accueil</a></li>
                    <li><a href="https://douxzy.alwaysdata.net/bouge-ton-paname/mentions-legales.php" class="hover:text-blue-600 transition">Mentions Legales</a></li>
                    <li><a href="https://douxzy.alwaysdata.net/bouge-ton-paname/contact.php" class="hover:text-blue-600 transition">Contact</a></li>
                    <li><a href="https://douxzy.alwaysdata.net/bouge-ton-paname/aide.php" class="hover:text-blue-600 transition">Aide</a></li>
                </ul>
                </div>
                <div class="md:hidden">
                    <button id="mobile-menu-button" class="text-gray-700 focus:outline-none">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>

            <div id="mobile-menu" class="hidden md:hidden px-4 pt-4 pb-2 space-y-2">
                <a href="https://douxzy.alwaysdata.net/bouge-ton-paname/index.php" class="block text-gray-700 hover:text-blue-600">Accueil</a>
                <a href="https://douxzy.alwaysdata.net/bouge-ton-paname/mentions-legales.php" class="hover:text-blue-600 transition">Mentions Legales</a>
                <a href="https://douxzy.alwaysdata.net/bouge-ton-paname/contact.php" class="block text-gray-700 hover:text-blue-600">Contact</a>
                <a href="https://douxzy.alwaysdata.net/bouge-ton-paname/aide.php" class="hover:text-blue-600 transition">Aide</a>
            </div>
        </nav>
    </header>