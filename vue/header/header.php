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
                <a href="#" class="text-2xl font-bold text-gray-800">Bouge ton Paname</a>

                <ul class="hidden md:flex space-x-6 text-gray-700 font-medium">
                    <li><a href="#" class="hover:text-blue-600 transition">Accueil</a></li>
                    <li><a href="#" class="hover:text-blue-600 transition">Événements</a></li>
                    <li><a href="#" class="hover:text-blue-600 transition">À propos</a></li>
                    <li><a href="#" class="hover:text-blue-600 transition">Contact</a></li>
                </ul>

                <div class="hidden md:flex space-x-4">
                    <a href="vue\login.php" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-xl hover:bg-blue-700 transition">Connexion</a>
                    <a href="vue\register.php" class="px-4 py-2 text-sm font-medium text-blue-600 border border-blue-600 rounded-xl hover:bg-blue-50 transition">Inscription</a>
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
                <a href="#" class="block text-gray-700 hover:text-blue-600">Accueil</a>
                <a href="#" class="block text-gray-700 hover:text-blue-600">Événements</a>
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