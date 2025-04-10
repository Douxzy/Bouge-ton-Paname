<?php
require __DIR__ . "/../vue/header/header.php";
require_once '../controller/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Supprimer un utilisateur
if (isset($_GET['delete'])) {
    $idToDelete = intval($_GET['delete']);
    $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
    $stmt->execute([$idToDelete]);
    header("Location: users.php");
    exit();
}

// Modifier rôle
if (isset($_GET['toggleRole'])) {
    $idToToggle = intval($_GET['toggleRole']);
    $stmt = $pdo->prepare("SELECT role FROM users WHERE id = ?");
    $stmt->execute([$idToToggle]);
    $user = $stmt->fetch();

    if ($user) {
        $newRole = $user['role'] === 'admin' ? 'user' : 'admin';
        $update = $pdo->prepare("UPDATE users SET role = ? WHERE id = ?");
        $update->execute([$newRole, $idToToggle]);
    }

    header("Location: users.php");
    exit();
}

// Récupérer tous les utilisateurs
$users = $pdo->query("SELECT id, email, role, created_at FROM users ORDER BY created_at DESC")->fetchAll();
?>
<a href="dashboard.php" class="inline-flex items-center gap-2 text-sm font-medium text-white bg-blue-600 px-4 py-2 rounded-lg shadow hover:bg-blue-700 transition">
    <i class="fas fa-arrow-left"></i>
    Retour au dashboard
</a>
<h1 class="text-3xl font-bold mb-6 text-gray-800 tracking-tight">Liste des utilisateurs</h1>


    
<div class="flex min-h-screen">
    <?php require __DIR__ . "/navbar.php"; ?>

    <main class="flex-1 p-10">
        <div class="bg-white p-6 rounded-2xl shadow ring-1 ring-gray-200">
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm text-left border-collapse">
                    <thead class="bg-gray-100 text-gray-700 uppercase text-xs tracking-wider">
                        <tr>
                            <th class="py-3 px-4">ID</th>
                            <th class="py-3 px-4">Email</th>
                            <th class="py-3 px-4">Rôle</th>
                            <th class="py-3 px-4">Créé le</th>
                            <th class="py-3 px-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user): ?>
                            <tr class="border-t hover:bg-gray-50 transition">
                                <td class="py-3 px-4 font-medium"><?= $user['id'] ?></td>
                                <td class="py-3 px-4"><?= htmlspecialchars($user['email']) ?></td>
                                <td class="py-3 px-4 capitalize"><?= $user['role'] ?></td>
                                <td class="py-3 px-4"><?= date('d/m/Y', strtotime($user['created_at'])) ?></td>
                                <td class="py-3 px-4 flex gap-3 items-center">
                                    <a href="?toggleRole=<?= $user['id'] ?>"
                                        class="text-blue-600 hover:underline text-sm flex items-center gap-1">
                                        <i class="fas fa-user-cog"></i>
                                        <?= $user['role'] === 'admin' ? 'Rétrograder' : 'Promouvoir' ?>
                                    </a>
                                    <a href="?delete=<?= $user['id'] ?>"
                                        onclick="return confirm('Supprimer cet utilisateur ?')"
                                        class="text-red-600 hover:underline text-sm flex items-center gap-1">
                                        <i class="fas fa-trash-alt"></i> Supprimer
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <?php if (empty($users)): ?>
                            <tr>
                                <td colspan="5" class="p-4 text-center text-gray-500">Aucun utilisateur trouvé.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>

<?php
require __DIR__ . "/../vue/footer/footer.php";

?>