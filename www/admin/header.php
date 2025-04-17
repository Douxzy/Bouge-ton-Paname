<?php
if (!isset($pdo)) {
    require_once "controller/db.php";
}

if (session_status() === PHP_SESSION_NONE) {
    session_start();
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
                    <li><a href="index.php" class="hover:text-blue-600 transition">Accueil</a></li>
                    <li><a href="mentions-legales.php" class="hover:text-blue-600 transition">Mentions Legales</a></li>
                    <li><a href="contact.php" class="hover:text-blue-600 transition">Contact</a></li>
                    <li><a href="aide.php" class="hover:text-blue-600 transition">Aide</a></li>
                </ul>
                <div class="hidden md:flex items-center space-x-4">
                    <?php
                    if (session_status() === PHP_SESSION_NONE) {
                        session_start();
                    }

                    // Optionnel : si $user est récupéré et qu'on veut le mettre en session
                    if (isset($user) && is_array($user) && isset($user['pseudo'])) {
                        $_SESSION['user'] = [
                            'pseudo' => $user['pseudo']
                        ];
                    }
                    ?>

                    <?php if (isset($_SESSION['user'])): ?>
                        <p class="text-sm text-gray-700">
                            Bienvenue <span
                                class="font-semibold text-blue-600"><?php echo htmlspecialchars($_SESSION['user']['pseudo']); ?></span>
                            !
                        </p>
                        <form action="controller/logout.php" method="post">
                            <button type="submit"
                                class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-xl hover:bg-red-700 transition">
                                Déconnexion
                            </button>
                        </form>
                    <?php else: ?>
                        <a href="login.php"
                            class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-xl hover:bg-blue-700 transition">
                            Connexion
                        </a>
                        <a href="register.php"
                            class="px-4 py-2 text-sm font-medium text-blue-600 border border-blue-600 rounded-xl hover:bg-blue-50 transition">
                            Inscription
                        </a>
                    <?php endif; ?>
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
                <a href="index.php" class="block text-gray-700 hover:text-blue-600">Accueil</a>
                <a href="mentions-legales.php" class="hover:text-blue-600 transition">Mentions Legales</a>
                <a href="contact.php" class="block text-gray-700 hover:text-blue-600">Contact</a>
                <a href="aide.php" class="hover:text-blue-600 transition">Aide</a>
                <div class="pt-2">
                    <a href="#"
                        class="block w-full text-center text-white bg-blue-600 px-4 py-2 rounded-xl hover:bg-blue-700">Connexion</a>
                    <a href="#"
                        class="block w-full text-center text-blue-600 border border-blue-600 px-4 py-2 mt-2 rounded-xl hover:bg-blue-50">Inscription</a>
                </div>
            </div>
        </nav>
        <!-- Bouton pour ouvrir le panneau -->
        <button onclick="toggleNotifications()"
            class="fixed top-4 right-4 text-2xl text-blue-500 hover:text-blue-600 transition"><i
                class="fas fa-bell"></i></button>
        <!-- Panneau latéral -->
        <div id="notificationPanel"
            class="fixed top-0 right-0 h-full w-full max-w-sm bg-white shadow-lg transform translate-x-full transition-transform z-50">
            <div class="flex items-center justify-between p-4 border-b">
                <h2 class="text-lg font-semibold">Notifications</h2>
                <button onclick="toggleNotifications()" class="text-2xl text-gray-500 hover:text-red-500 transition"><i
                        class="fas fa-times"></i></button>
            </div>

            <?php if (!empty($notifications)): ?>
                <ul class="text-left space-y-2 p-4">
                    <?php foreach ($notifications as $notif): ?>
                        <li class="bg-gray-100 rounded p-2 text-sm">
                            <?= htmlspecialchars($notif['message']) ?><br>
                            <span class="text-xs text-gray-500"><?= date('d/m/Y H:i', strtotime($notif['created_at'])) ?></span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p class="text-center text-gray-500">Vous n'avez pas de notification pour l'instant</p>
            <?php endif; ?>
        </div>
    <script href="js/header.js"></script>
    </header>