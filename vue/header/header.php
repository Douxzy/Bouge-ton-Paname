<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bouge ton Paname</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
</head>

<body>
    <header>
        <nav class="bg-white shadow-lg px-6 py-4">
            <div class="container mx-auto flex items-center justify-between">
                <a href="<?php __dir__; ?>index.php" class="text-2xl font-bold text-gray-800">Bouge ton Paname</a>

                <ul class="hidden md:flex space-x-6 text-gray-700 font-medium">
                    <li><a href="<?php __dir__; ?>index.php" class="hover:text-blue-600 transition">Accueil</a></li>
                    <li><a href="#" class="hover:text-blue-600 transition">À propos</a></li>
                    <li><a href="#" class="hover:text-blue-600 transition">Contact</a></li>
                </ul>
                <div class="hidden md:flex items-center space-x-4">
                    <?php
                    // Exemple : initialisation de session (à faire en haut de ta page)
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
                            Bienvenue <span class="font-semibold text-blue-600"><?php echo htmlspecialchars($_SESSION['user']['pseudo']); ?></span> !
                        </p>
                        <form action="<?php __dir__; ?>../controller/logout.php" method="post">
                            <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-xl hover:bg-red-700 transition">
                                Déconnexion
                            </button>
                        </form>
                    <?php else: ?>
                        <a href="login.php" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-xl hover:bg-blue-700 transition">
                            Connexion
                        </a>
                        <a href="register.php" class="px-4 py-2 text-sm font-medium text-blue-600 border border-blue-600 rounded-xl hover:bg-blue-50 transition">
                            Inscription
                        </a>
                    <?php endif; ?>
                </div>
                <div class="md:hidden">
                    <button id="mobile-menu-button" class="text-gray-700 focus:outline-none">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>

            <div id="mobile-menu" class="hidden md:hidden px-4 pt-4 pb-2 space-y-2">
                <a href="<?php __dir__; ?> index.php" class="block text-gray-700 hover:text-blue-600">Accueil</a>
                <a href="#" class="block text-gray-700 hover:text-blue-600">À propos</a>
                <a href="#" class="block text-gray-700 hover:text-blue-600">Contact</a>
                <div class="pt-2">
                    <a href="#" class="block w-full text-center text-white bg-blue-600 px-4 py-2 rounded-xl hover:bg-blue-700">Connexion</a>
                    <a href="#" class="block w-full text-center text-blue-600 border border-blue-600 px-4 py-2 mt-2 rounded-xl hover:bg-blue-50">Inscription</a>
                </div>
            </div>
        </nav>

        <script>
            const btn = document.getElementById('mobile-menu-button');
            const menu = document.getElementById('mobile-menu');

            btn.addEventListener('click', () => {
                menu.classList.toggle('hidden');
            });
        </script>

    </header>