<?php
require_once "header.php";
require_once 'controller/db.php';

// Vérification admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Ajouter un événement manuel
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titre = $_POST['titre'] ?? '';
    $description = $_POST['description'] ?? '';
    $date_debut = $_POST['date_debut'] ?? '';
    $date_fin = $_POST['date_fin'] ?? '';
    $adresse = $_POST['adresse'] ?? '';

    if ($titre && $description && $date_debut && $date_fin && $adresse) {
        $stmt = $pdo->prepare("INSERT INTO evenements (titre, description, date_debut, date_fin, adresse) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$titre, $description, $date_debut, $date_fin, $adresse]);
        header("Location: publications.php");
        exit();
    }
}

// Supprimer un événement
if (isset($_GET['delete'])) {
    $id = (int) $_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM evenements WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: publications.php");
    exit();
}

// Récupérer les événements personnalisés
$publications = $pdo->query("SELECT * FROM evenements ORDER BY date_debut DESC")->fetchAll();
?>

<a href="dashboard.php"
    class="inline-flex items-center gap-2 text-sm font-medium text-white bg-blue-600 px-4 py-2 rounded-lg shadow hover:bg-blue-700 transition">
    <i class="fas fa-arrow-left"></i>
    Retour au dashboard
</a>
<h1 class="text-3xl font-bold mb-6 text-gray-800 tracking-tight">Événements personnalisés</h1>

<div class="flex min-h-screen">
    <?php require_once "navbar.php"; ?>
    <!-- Formulaire d'ajout -->
    <div class="bg-white p-6 rounded-2xl shadow ring-1 ring-gray-200 mb-8">
        <h2 class="text-xl font-semibold mb-4 text-gray-800">Ajouter un événement</h2>
        <form method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <input type="text" name="titre" placeholder="Titre" required
                class="p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            <input type="text" name="adresse" placeholder="Adresse" required
                class="p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            <input type="datetime-local" name="date_debut" required
                class="p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            <input type="datetime-local" name="date_fin" required
                class="p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            <textarea name="description" placeholder="Description" required
                class="col-span-1 md:col-span-2 p-3 border rounded-lg h-32 resize-none focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
            <div class="col-span-1 md:col-span-2 text-right">
                <button type="submit"
                    class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">Ajouter</button>
            </div>
        </form>
    </div>

    <!-- Liste des publications -->
    <div class="bg-white p-6 rounded-2xl shadow ring-1 ring-gray-200">
        <h2 class="text-xl font-semibold mb-4 text-gray-800">Liste des événements manuels</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm text-left border-collapse">
                <thead class="bg-gray-100 text-gray-700 uppercase text-xs tracking-wider">
                    <tr>
                        <th class="p-3">Titre</th>
                        <th class="p-3">Début</th>
                        <th class="p-3">Fin</th>
                        <th class="p-3">Adresse</th>
                        <th class="p-3">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($publications as $event): ?>
                        <tr class="border-t hover:bg-gray-50 transition">
                            <td class="p-3 font-medium"><?= htmlspecialchars($event['titre']) ?></td>
                            <td class="p-3"><?= $event['date_debut'] ?></td>
                            <td class="p-3"><?= $event['date_fin'] ?></td>
                            <td class="p-3"><?= htmlspecialchars($event['adresse']) ?></td>
                            <td class="p-3">
                                <a href="?delete=<?= $event['id'] ?>" onclick="return confirm('Supprimer cet événement ?')"
                                    class="text-red-600 hover:underline text-sm flex items-center gap-1">
                                    <i class="fas fa-trash-alt"></i> Supprimer
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if (empty($publications)): ?>
                        <tr>
                            <td colspan="5" class="p-4 text-center text-gray-500">Aucun événement manuel trouvé.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
require_once "footer.php";

?>