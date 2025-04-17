<?php
require_once "header.php";
require_once 'controller/db.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if (!empty($email) && !empty($password)) {
        $stmt = $pdo->prepare("SELECT id, password, role FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            if ($user['role'] === 'admin') {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['role'] = $user['role'];
                header('Location: dashboard.php');
                exit();
            } else {
                $error = "Accès refusé. Vous n'êtes pas administrateur.";
            }
        } else {
            $error = "Identifiants invalides.";
        }
    } else {
        $error = "Tous les champs sont obligatoires.";
    }
}
?>
<div class="w-full h-screen flex items-center justify-center px-4">
    <div class="bg-white w-full max-w-md p-10 rounded-2xl shadow-2xl">
        <h1 class="text-3xl font-bold text-center text-gray-800 mb-8">Connexion administrateur</h1>


        <?php if ($error): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>


        <form method="POST" class="space-y-6">
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
                    class="w-full bg-blue-600 text-white py-2 px-4 rounded-xl font-semibold hover:bg-blue-700 transition">Se
                    connecter</button>
            </div>
        </form>
    </div>
</div>

<?php
require_once "footer.php";

?>