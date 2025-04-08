<?php
require __DIR__ . "/../vue/header/header.php";
require_once '../controller/db.php'; // Connexion PDO

// Redirection si l'utilisateur n'est pas admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}
?>
<h2 class="text-3xl font-bold mb-8 text-gray-800 tracking-tight">Tableau de bord</h2>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
    <!-- Utilisateurs -->
    <a href="users.php"
        class="group block bg-white p-6 rounded-2xl shadow ring-1 ring-gray-200 hover:shadow-xl hover:ring-gray-300 transition duration-200">
        <div class="flex items-center mb-3">
            <i class="fas fa-users text-blue-500 text-xl group-hover:scale-110 transition duration-200"></i>
            <h3 class="ml-3 text-lg font-semibold text-gray-800">Gérer les utilisateurs</h3>
        </div>
        <p class="text-sm text-gray-600">Consulter, modifier les rôles, ou supprimer des comptes.</p>
    </a>

    <!-- Commentaires -->
    <a href="comments.php"
        class="group block bg-white p-6 rounded-2xl shadow ring-1 ring-gray-200 hover:shadow-xl hover:ring-gray-300 transition duration-200">
        <div class="flex items-center mb-3">
            <i class="fas fa-comments text-green-500 text-xl group-hover:scale-110 transition duration-200"></i>
            <h3 class="ml-3 text-lg font-semibold text-gray-800">Modérer les commentaires</h3>
        </div>
        <p class="text-sm text-gray-600">Supprimer les commentaires inappropriés.</p>
    </a>

    <!-- Publications personnalisées -->
    <a href="publications.php"
        class="group block bg-white p-6 rounded-2xl shadow ring-1 ring-gray-200 hover:shadow-xl hover:ring-gray-300 transition duration-200">
        <div class="flex items-center mb-3">
            <i class="fas fa-calendar-plus text-purple-500 text-xl group-hover:scale-110 transition duration-200"></i>
            <h3 class="ml-3 text-lg font-semibold text-gray-800">Gérer les publications</h3>
        </div>
        <p class="text-sm text-gray-600">Ajouter ou modifier des événements manuels.</p>
    </a>
</div>

<?php
require __DIR__ . "/../vue/footer/footer.php";

?>