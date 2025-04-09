<div class="flex min-h-screen">
    <!-- NAVBAR LATÉRALE -->
    <nav class="w-64 bg-white shadow-lg p-6 space-y-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">Espace admin</h2>

        <!-- Utilisateurs -->
        <a href="users.php" class="flex items-center p-4 rounded-xl hover:bg-blue-100 transition">
            <i class="fas fa-users text-blue-500 text-xl mr-3"></i>
            <span class="text-gray-800 font-medium">Gérer les utilisateurs</span>
        </a>

        <!-- Commentaires -->
        <a href="comments.php" class="flex items-center p-4 rounded-xl hover:bg-green-100 transition">
            <i class="fas fa-comments text-green-500 text-xl mr-3"></i>
            <span class="text-gray-800 font-medium">Modérer les commentaires</span>
        </a>

        <!-- Publications personnalisées -->
        <a href="publications.php" class="flex items-center p-4 rounded-xl hover:bg-purple-100 transition">
            <i class="fas fa-calendar-plus text-purple-500 text-xl mr-3"></i>
            <span class="text-gray-800 font-medium">Gérer les publications</span>
        </a>
    </nav>
</div>