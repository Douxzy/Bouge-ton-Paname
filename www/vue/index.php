<?php
session_start();

require "../controller/db.php";
require "header/header.php";

// Formulaire commentaire avec image
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['record_id'], $_POST['commentaire']) && isset($_SESSION['user'])) {
  $recordId = $_POST['record_id'];
  $userId = $_SESSION['user']['id'];
  $pseudo = $_SESSION['user']['pseudo'];
  $commentaire = htmlspecialchars($_POST['commentaire']);
  $imagePath = null;

  // Gestion de l'image si elle est uploadée
  if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    $uploadDir = '../uploads/';
    if (!is_dir($uploadDir)) {
      mkdir($uploadDir, 0777, true);
    }

    $tmpName = $_FILES['image']['tmp_name'];
    $fileName = uniqid() . '_' . basename($_FILES['image']['name']);
    $destination = $uploadDir . $fileName;

    if (move_uploaded_file($tmpName, $destination)) {
      $imagePath = 'uploads/' . $fileName;
    }
  }

  $stmt = $pdo->prepare("INSERT INTO commentaires (record_id, user_id, pseudo, commentaire, image_path) VALUES (?, ?, ?, ?, ?)");
  $stmt->execute([$recordId, $userId, $pseudo, $commentaire, $imagePath]);

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
    <div class="relative w-full max-w-4xl px-4">
      <form action="" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <!-- Champ de recherche -->
        <div class="relative col-span-1 md:col-span-2">
          <input type="text" name="q" placeholder="Rechercher une sortie à Paris..."
            class="w-full pl-14 pr-4 py-5 text-lg rounded-2xl shadow-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all duration-300 bg-white bg-opacity-90 text-gray-800" />
          <i class="fas fa-search absolute left-5 top-1/2 transform -translate-y-1/2 text-gray-400 text-xl"></i>
        </div>

        <!-- Filtre catégorie -->
        <div>
          <select name="categorie"
            class="w-full py-5 px-4 text-lg rounded-2xl shadow-lg bg-white bg-opacity-90 text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-300">
            <option value="">Toutes les catégories</option>
            <option value="concert">Concert</option>
            <option value="expo">Exposition</option>
            <option value="theatre">Théâtre</option>
            <option value="sport">Sport</option>
          </select>
        </div>
        <!-- Filtre prix -->
        <div>
          <select name="prix"
            class="w-full py-5 px-4 text-lg rounded-2xl shadow-lg bg-white bg-opacity-90 text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-300">
            <option value="">Tous les prix</option>
            <option value="gratuit">Gratuit</option>
            <option value="payant">Payant</option>
          </select>
        </div>

        <!-- Filtre accessibilité -->
        <div>
          <select name="accessibilite"
            class="w-full py-5 px-4 text-lg rounded-2xl shadow-lg bg-white bg-opacity-90 text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-300">
            <option value="">Accessibilité</option>
            <option value="oui">Accessible PMR</option>
            <option value="non">Non accessible</option>
          </select>
        </div>

        <!-- Filtre quartier -->
        <div>
          <select name="quartier"
            class="w-full py-5 px-4 text-lg rounded-2xl shadow-lg bg-white bg-opacity-90 text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-300">
            <option value="">Tous les quartiers</option>
            <option value="1er">1er arrondissement</option>
            <option value="2e">2e arrondissement</option>
            <!-- Ajoute tous les arrondissements ici -->
          </select>
        </div>


        <!-- Filtre date -->
        <div>
          <input type="date" name="date"
            class="w-full py-5 px-4 text-lg rounded-2xl shadow-lg bg-white bg-opacity-90 text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-300" />
        </div>
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
  <div class="swiper swiper-<?= $recordId ?>">
          <div class="swiper-wrapper">
            <?php if (!empty($e['cover_url'])): ?>
              <div class="swiper-slide">
                <img src="<?= $e['cover_url'] ?>" class="w-full h-48 object-cover" alt="Image événement">
              </div>
            <?php endif; ?>
      
            <?php foreach ($comments as $com): ?>
              <?php if (!empty($com['image_path'])): ?>
                <div class="swiper-slide">
                  <img src="<?= '../' . htmlspecialchars($com['image_path']) ?>" class="w-full h-48 object-cover" alt="Image commentaire">
                </div>
              <?php endif; ?>
            <?php endforeach; ?>
          </div>
      
          <!-- Pagination & navigation -->
          <div class="swiper-pagination"></div>
          <div class="swiper-button-prev"></div>
          <div class="swiper-button-next"></div>
        </div>

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
            <a href="<?= htmlspecialchars($e['url']) ?>" target="_blank"
              class="inline-block mt-2 text-blue-600 hover:underline text-sm">Voir plus d'infos</a>
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
              <form method="POST" enctype="multipart/form-data" class="mt-4 space-y-2">
                <input type="hidden" name="record_id" value="<?= $recordId ?>">
                <textarea name="commentaire" placeholder="Votre commentaire" required
                  class="w-full border rounded px-2 py-1"></textarea>
                <input type="file" name="image" accept="image/*" class="text-sm">
                <button type="submit"
                  class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm">Envoyer</button>
              </form>

            <?php else: ?>
              <p class="text-sm text-gray-500 mt-4">Vous devez <a href="/vue/login.php" class="text-blue-600 underline">vous
                  connecter</a> pour commenter.</p>
            <?php endif; ?>

          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
<?php endif; ?>

<?php require "footer/footer.php"; ?>