<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once "header.php";
require_once 'controller/db.php';

// Récupérer les données si modification
$editEvent = null;
if (isset($_GET['edit'])) {
    $id = (int) $_GET['edit'];
    $stmt = $pdo->prepare("SELECT * FROM evenements WHERE id = ?");
    $stmt->execute([$id]);
    $editEvent = $stmt->fetch();
}

// Ajouter ou modifier un événement
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titre = $_POST['titre'] ?? '';
    $description = $_POST['description'] ?? '';
    $date_debut = $_POST['date_debut'] ?? '';
    $date_fin = $_POST['date_fin'] ?? '';
    $adresse = $_POST['adresse'] ?? '';
    $event_id = $_POST['event_id'] ?? null;

    if ($titre && $description && $date_debut && $date_fin && $adresse) {
        if ($event_id) {
            $stmt = $pdo->prepare("UPDATE evenements SET titre = ?, description = ?, date_debut = ?, date_fin = ?, adresse = ? WHERE id = ?");
            $stmt->execute([$titre, $description, $date_debut, $date_fin, $adresse, $event_id]);
        } else {
            $stmt = $pdo->prepare("INSERT INTO evenements (titre, description, date_debut, date_fin, adresse) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$titre, $description, $date_debut, $date_fin, $adresse]);
        }
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

// Récupérer les événements
$publications = $pdo->query("SELECT * FROM evenements ORDER BY date_debut DESC")->fetchAll();
?>
<h1 class="text-3xl font-bold mb-6 text-gray-800 tracking-tight">Événements personnalisés</h1>

<div class="flex min-h-screen">
    <?php require_once "navbar.php"; ?>

    <!-- Formulaire ajout / modification -->
    <div class="bg-white p-6 rounded-2xl shadow ring-1 ring-gray-200 mb-8">
        <h2 class="text-xl font-semibold mb-4 text-gray-800">
            <?= $editEvent ? "Modifier l'événement" : "Ajouter un événement" ?>
        </h2>
        <form method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <input type="hidden" name="event_id" value="<?= $editEvent['id'] ?? '' ?>">
            <input type="text" name="titre" placeholder="Titre" required
                   value="<?= $editEvent['titre'] ?? '' ?>"
                   class="p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            <input type="text" name="adresse" placeholder="Adresse" required
                   value="<?= $editEvent['adresse'] ?? '' ?>"
                   class="p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            <input type="datetime-local" name="date_debut" required
                   value="<?= isset($editEvent['date_debut']) ? date('Y-m-d\TH:i', strtotime($editEvent['date_debut'])) : '' ?>"
                   class="p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            <input type="datetime-local" name="date_fin" required
                   value="<?= isset($editEvent['date_fin']) ? date('Y-m-d\TH:i', strtotime($editEvent['date_fin'])) : '' ?>"
                   class="p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            <textarea name="description" placeholder="Description" required
                      class="col-span-1 md:col-span-2 p-3 border rounded-lg h-32 resize-none focus:outline-none focus:ring-2 focus:ring-blue-500"><?= $editEvent['description'] ?? '' ?></textarea>
            <div class="col-span-1 md:col-span-2 text-right">
                <button type="submit"
                        class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
                    <?= $editEvent ? "Mettre à jour" : "Ajouter" ?>
                </button>
            </div>
        </form>
    </div>

    <!-- Liste des événements -->
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
                        <th class="p-3">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($publications as $event): ?>
                        <tr class="border-t hover:bg-gray-50 transition">
                            <td class="p-3 font-medium"><?= htmlspecialchars($event['titre']) ?></td>
                            <td class="p-3"><?= $event['date_debut'] ?></td>
                            <td class="p-3"><?= $event['date_fin'] ?></td>
                            <td class="p-3"><?= htmlspecialchars($event['adresse']) ?></td>
                            <td class="p-3 flex gap-2">
                                <a href="?edit=<?= $event['id'] ?>"
                                   class="text-blue-600 hover:underline text-sm flex items-center gap-1">
                                    <i class="fas fa-edit"></i> Modifier
                                </a>
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

<?php require_once "footer.php"; ?>
