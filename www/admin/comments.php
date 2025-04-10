<?php
require __DIR__ . "/../vue/header/header.php";
require_once '../controller/db.php';

// Vérification admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Suppression de commentaire si demandé
if (isset($_GET['delete'])) {
    $id = (int) $_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM commentaires WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: commentaires.php");
    exit();
}

// Récupération des commentaires
$stmt = $pdo->query("SELECT commentaires.commentaire, commentaires.id,  commentaires.record_id, commentaires.created_at, utilisateurs.pseudo 
                     FROM commentaires 
                     JOIN users AS utilisateurs ON commentaires.user_id = utilisateurs.id 
                     ORDER BY commentaires.created_at DESC");
$commentaires = $stmt->fetchAll();
?>

<a href="dashboard.php" class="inline-flex items-center gap-2 text-sm font-medium text-white bg-blue-600 px-4 py-2 rounded-lg shadow hover:bg-blue-700 transition">
    <i class="fas fa-arrow-left"></i>
    Retour au dashboard
</a>
<h1 class="text-3xl font-bold mb-6 text-gray-800 tracking-tight">Modération des commentaires</h1>

<div class="flex min-h-screen">
    <?php require __DIR__ . "/navbar.php"; ?>
<div class="overflow-x-auto">
    <table class="min-w-full bg-white rounded-2xl shadow ring-1 ring-gray-200 overflow-hidden text-sm">
        <thead class="bg-gray-100 text-gray-700 uppercase text-xs tracking-wider">
            <tr>
                <th class="p-4">ID</th>
                <th class="p-4">Utilisateur</th>
                <th class="p-4">Événement API</th>
                <th class="p-4">Commentaire</th>
                <th class="p-4">Action</th>
            </tr>
        </thead>
        <tbody class="text-gray-800">
            <?php foreach ($commentaires as $comment): ?>
                <tr class="border-t hover:bg-gray-50 transition">
                    <td class="p-4 font-medium"><?= $comment['id'] ?></td>
                    <td class="p-4"><?= htmlspecialchars($comment['pseudo']) ?></td>
                    <td class="p-4"><?= htmlspecialchars($comment['commentaire']) ?></td>
                    
                    <td class="p-4">
                        <a href="?delete=<?= $comment['id'] ?>" onclick="return confirm('Supprimer ce commentaire ?')"
                            class="text-red-600 hover:underline flex items-center gap-1">
                            <i class="fas fa-trash-alt"></i> Supprimer
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if (empty($commentaires)): ?>
                <tr>
                    <td colspan="5" class="p-4 text-center text-gray-500">Aucun commentaire à modérer.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
</div>

<?php
require __DIR__ . "/../vue/footer/footer.php";

?>