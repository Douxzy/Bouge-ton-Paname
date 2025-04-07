<?php
session_start();

require "../controller/db.php";
require "header/header.php";


// Formulaire commentaire
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['record_id'], $_POST['commentaire']) && isset($_SESSION['user'])) {
  $recordId = $_POST['record_id'];
  $userId = $_SESSION['user']['id'];
  $pseudo = $_SESSION['user']['pseudo'];
  $commentaire = htmlspecialchars($_POST['commentaire']);

  $stmt = $pdo->prepare("INSERT INTO commentaires (record_id, user_id, pseudo, commentaire) VALUES (?, ?, ?, ?)");
  $stmt->execute([$recordId, $userId, $pseudo, $commentaire]);

  header("Location: " . $_SERVER['REQUEST_URI']);
  exit;
}

$query = $_GET['q'] ?? null;
$results = [];

$encodedQuery = urlencode($query ?? '');
$apiUrl = "https://opendata.paris.fr/api/v2/catalog/datasets/que-faire-a-paris-/records?limit=12";

if (!empty($query)) {
  $apiUrl .= "&search={$encodedQuery}";
}

$response = @file_get_contents($apiUrl);
if ($response !== false) {
  $data = json_decode($response, true);
  $results = $data['records'] ?? [];
}
?>

<div class="relative w-full h-100 bg-cover bg-center">
  <div class="absolute inset-0 bg-black bg-opacity-40 backdrop-blur-sm"></div>
  <div class="relative z-10 flex items-center justify-center h-full">
    <div class="relative w-full max-w-2xl">
      <form action="" method="GET">
        <input type="text" name="q" placeholder="Rechercher une sortie à Paris..." class="w-full pl-14 pr-4 py-5 text-lg rounded-2xl shadow-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all duration-300 bg-white bg-opacity-90 text-gray-800" />
        <i class="fas fa-search absolute left-5 top-1/2 transform -translate-y-1/2 text-gray-400 text-xl"></i>
      </form>
    </div>
  </div>
</div>

<?php if (!empty($query)): ?>
  <h2 class="text-2xl font-bold text-center mb-6">Résultats pour : "<?= htmlspecialchars($query) ?>"</h2>
<?php else: ?>
  <h2 class="text-2xl font-bold text-center mb-6">Toutes les sorties à Paris</h2>
<?php endif; ?>

<?php if (empty($results)): ?>
  <p class="text-center text-gray-600">Aucun résultat trouvé.</p>
<?php else: ?>
  <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 max-w-7xl mx-auto">
    <?php foreach ($results as $event):
      $e = $event['record']['fields'];
      $recordId = $event['record']['id'] ?? null;

      // Récupération des commentaires pour cet event
      $stmt = $pdo->prepare("SELECT * FROM commentaires WHERE record_id = ? ORDER BY created_at DESC");
      $stmt->execute([$recordId]);
      $comments = $stmt->fetchAll();
    ?>
      <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition">
        <?php if (!empty($e['cover_url'])): ?>
          <img src="<?= $e['cover_url'] ?>" alt="<?= htmlspecialchars($e['title']) ?>" class="w-full h-48 object-cover">
        <?php endif; ?>
        <div class="p-4">
          <h3 class="text-lg font-semibold mb-2"><?= htmlspecialchars($e['title'] ?? 'Sans titre') ?></h3>
          <p class="text-sm text-gray-600 mb-2"><?= htmlspecialchars($e['lead_text'] ?? 'Pas de description.') ?></p>
          <?php if (!empty($e['address_street'])): ?>
            <p class="text-xs text-gray-500">📍 <?= htmlspecialchars($e['address_street']) ?></p>
          <?php endif; ?>
          <?php if (!empty($e['date_description'])): ?>
            <p class="text-xs text-gray-500">📅 <?= htmlspecialchars($e['date_description']) ?></p>
          <?php endif; ?>
          <?php if (!empty($e['url'])): ?>
            <a href="<?= htmlspecialchars($e['url']) ?>" target="_blank" class="inline-block mt-2 text-blue-600 hover:underline text-sm">Voir plus d'infos</a>
          <?php endif; ?>

          <!-- Commentaires -->
          <div class="mt-4 border-t pt-4">
            <h4 class="font-semibold mb-2">Commentaires :</h4>

            <?php if (empty($comments)): ?>
              <p class="text-sm text-gray-500">Aucun commentaire encore.</p>
            <?php else: ?>
              <?php foreach ($comments as $com): ?>
                <div class="mb-2">
                  <p class="text-sm text-gray-800 font-semibold"><?= htmlspecialchars($com['pseudo']) ?> :</p>
                  <p class="text-sm text-gray-600"><?= htmlspecialchars($com['commentaire']) ?></p>
                </div>
              <?php endforeach; ?>
            <?php endif; ?>

            <!-- Formulaire -->
            <?php if (isset($_SESSION['user'])): ?>
              <form method="POST" class="mt-4 space-y-2">
                <input type="hidden" name="record_id" value="<?= $recordId ?>">
                <textarea name="commentaire" placeholder="Votre commentaire" required class="w-full border rounded px-2 py-1"></textarea>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm">Envoyer</button>
              </form>
            <?php else: ?>
              <p class="text-sm text-gray-500 mt-4">Vous devez <a href="/vue/login.php" class="text-blue-600 underline">vous connecter</a> pour commenter.</p>
            <?php endif; ?>

          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
<?php endif; ?>

<?php require "footer/footer.php"; ?>