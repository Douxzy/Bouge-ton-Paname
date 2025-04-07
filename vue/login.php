<?php
require __dir__ . "/header/header.php";


$error = $_SESSION['error'] ?? null;
$success = $_SESSION['success'] ?? null;
unset($_SESSION['error'], $_SESSION['success']);
?>
<div class="w-full h-screen flex items-center justify-center px-4">
    <div class="bg-white w-full max-w-md p-10 rounded-2xl shadow-2xl">
        <h1 class="text-3xl font-bold text-center text-gray-800 mb-8">Connexion</h1>


        <?php if ($error): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                <?= htmlspecialchars($success) ?>
            </div>
        <?php endif; ?>

        <form action="../controller/login.php" method="POST" class="space-y-6">
            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Adresse email</label>
                <input type="email" id="email" name="email" required
                    class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500" />
            </div>

            <!-- Mot de passe -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Mot de passe</label>
                <input type="password" id="password" name="password" required
                    class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500" />
            </div>

            <!-- Bouton -->
            <div>
                <button type="submit"
                    class="w-full bg-blue-600 text-white py-2 px-4 rounded-xl font-semibold hover:bg-blue-700 transition">Se connecter</button>
            </div>
        </form>


        <!-- Lien vers inscription -->
        <p class="mt-6 text-center text-sm text-gray-600">
            Pas encore de compte ? <a href="#" class="text-blue-600 hover:underline">Créer un compte</a>
        </p>
    </div>
</div>
<?php
require __dir__ . "/footer/footer.php";

?>