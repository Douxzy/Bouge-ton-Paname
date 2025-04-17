<?php
require_once "../header.php";
require_once '../controller/db.php';

// Vérification admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Ajouter une question FAQ
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $question = $_POST['question'] ?? '';
    $reponse = $_POST['reponse'] ?? '';

    if ($question && $reponse) {
        $stmt = $pdo->prepare("INSERT INTO faq (question, reponse) VALUES (?, ?)");
        $stmt->execute([$question, $reponse]);
        header("Location: faq.php");
        exit();
    }
}

// Supprimer une question
if (isset($_GET['delete'])) {
    $id = (int) $_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM faq WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: faq.php");
    exit();
}

// Récupérer toutes les FAQ
$faqs = $pdo->query("SELECT * FROM faq ORDER BY id ASC")->fetchAll();
?>

<a href="dashboard.php"
    class="inline-flex items-center gap-2 text-sm font-medium text-white bg-blue-600 px-4 py-2 rounded-lg shadow hover:bg-blue-700 transition">
    <i class="fas fa-arrow-left"></i>
    Retour au dashboard
</a>

<h1 class="text-3xl font-bold mb-6 text-gray-800 tracking-tight">Gestion de la FAQ</h1>

<div class="flex min-h-screen">
    <?php require __DIR__ . "/navbar.php"; ?>

    <!-- Formulaire d'ajout FAQ -->
    <div class="bg-white p-6 rounded-2xl shadow ring-1 ring-gray-200 mb-8">
        <h2 class="text-xl font-semibold mb-4 text-gray-800">Ajouter une question</h2>
        <form method="POST" class="grid grid-cols-1 gap-4">
            <input type="text" name="question" placeholder="Question" required
                class="p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            <textarea name="reponse" placeholder="Réponse" required
                class="p-3 border rounded-lg h-32 resize-none focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
            <div class="text-right">
                <button type="submit"
                    class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">Ajouter</button>
            </div>
        </form>
    </div>

    <!-- Liste des FAQ -->
    <div class="bg-white p-6 rounded-2xl shadow ring-1 ring-gray-200">
        <h2 class="text-xl font-semibold mb-4 text-gray-800">Liste des questions</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm text-left border-collapse">
                <thead class="bg-gray-100 text-gray-700 uppercase text-xs tracking-wider">
                    <tr>
                        <th class="p-3">Question</th>
                        <th class="p-3">Réponse</th>
                        <th class="p-3">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($faqs as $faq): ?>
                        <tr class="border-t hover:bg-gray-50 transition">
                            <td class="p-3 font-medium"><?= htmlspecialchars($faq['question']) ?></td>
                            <td class="p-3"><?= nl2br(htmlspecialchars($faq['reponse'])) ?></td>
                            <td class="p-3">
                                <a href="?delete=<?= $faq['id'] ?>" onclick="return confirm('Supprimer cette entrée ?')"
                                    class="text-red-600 hover:underline text-sm flex items-center gap-1">
                                    <i class="fas fa-trash-alt"></i> Supprimer
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if (empty($faqs)): ?>
                        <tr>
                            <td colspan="3" class="p-4 text-center text-gray-500">Aucune question pour l’instant.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require __DIR__ . "/../vue/footer/footer.php"; ?>
