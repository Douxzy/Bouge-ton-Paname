<?php
require_once "header.php";
require_once "controller/db.php";
require_once "controller/functions.php";
require_once "controller/index.php";
?>

<div class="relative w-full h-100 bg-cover bg-center">
  <div class="absolute inset-0 bg-opacity-40 backdrop-blur-sm"></div>
  <div class="relative z-10 flex items-center justify-center h-full py-10 bg-cover bg-center"
    style="background-image: url('assets/image/bar-recheche-image.jpg');">
    <div class="relative w-full max-w-4xl px-4">
      <form method="GET" class="flex items-center justify-center w-full space-x-4">
        <!-- Recherche texte -->
        <div class="relative flex-1">
          <input type="text" name="q" value="<?= htmlspecialchars($query) ?>"
            placeholder="Rechercher une sortie à Paris..."
            class="w-full pl-12 pr-4 py-3 text-base rounded-xl shadow focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white text-gray-800" />
          <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400 text-lg"></i>
        </div>
        <!-- Bouton -->
        <div>
          <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition">
            Rechercher
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- AFFICHAGE EVENEMENTS -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 p-6">
  <?php foreach ($events as $event): ?>
    <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition">
      <?php if (!empty($event['cover_url'])): ?>
        <img src="<?= htmlspecialchars($event['cover_url']) ?>" alt="<?= htmlspecialchars($event['titre']) ?>"
          class="w-full h-48 object-cover">
      <?php endif; ?>

      <div class="px-6 py-4">
        <h2 class="text-xl font-semibold text-gray-800 mb-2"><?= htmlspecialchars($event['titre']) ?></h2>
        <p class="text-gray-600 mb-3"><?= htmlspecialchars(mb_strimwidth($event['description'], 0, 150, '...')) ?></p>
        <div class="text-sm text-gray-500">
          <p><span class="font-medium">Début :</span> <?= htmlspecialchars($event['date_debut']) ?></p>
          <p><span class="font-medium">Fin :</span> <?= htmlspecialchars($event['date_fin']) ?></p>
          <p><span class="font-medium">Adresse :</span> <?= htmlspecialchars($event['adresse']) ?>
            <?= htmlspecialchars($event['quartier']) ?></p>
          <a href="<?= $event['url'] ?>" class="text-blue-500 hover:underline ml-2">En savoir plus</a>
        </div>

        <?php
        $comments = getCommentsByEvent($pdo, $event['record_id']);
        if ($comments):
          ?>
          <h3 class="text-lg font-semibold text-gray-700 mt-5 mb-3">Commentaires :</h3>
          <ul class="space-y-3">
            <?php foreach ($comments as $comment): ?>
              <li class="bg-gray-50 p-3 rounded-lg shadow-sm">
                <strong class="text-gray-800"><?= htmlspecialchars($comment['pseudo']) ?> :</strong>
                <span class="text-gray-700"><?= htmlspecialchars($comment['commentaire']) ?></span>
                <em class="block text-xs text-gray-400 mt-1"><?= htmlspecialchars($comment['created_at']) ?></em>

                <?php if (!empty($comment['image_path'])): ?>
                  <img src="<?= htmlspecialchars($comment['image_path']) ?>" alt="Image du commentaire"
                    class="mt-2 max-h-48 w-auto object-cover rounded border">
                <?php endif; ?>
              </li>
            <?php endforeach; ?>
          </ul>
        <?php else: ?>
          <p class="text-sm text-gray-500 italic mt-4">Aucun commentaire pour le moment.</p>
        <?php endif; ?>
        <?php if (isset($_SESSION['user'])): ?>
          <form method="POST" action="controller/commentaire.php" enctype="multipart/form-data">
            <input type="hidden" name="record_id" value="<?= htmlspecialchars($event['record_id']) ?>">
            <textarea name="commentaire" rows="3" required placeholder="Laisse ton commentaire..."
              class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
            <div class="flex items-center justify-between">
              <input type="file" name="image" accept="image/*" class="text-sm">
              <button type="submit"
                class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">Envoyer</button>
            </div>
          </form>
        <?php else: ?>
          <p class="text-sm text-gray-400 mt-3 italic"><a href="login.php" class="text-blue-600">Connecte-toi</a> pour laisser un commentaire.</p>
        <?php endif; ?>
      </div>
    </div>
  <?php endforeach; ?>
</div>

<!-- PAGINATION -->
<?php if ($total_pages > 1): ?>
  <div class="mt-8 flex justify-center space-x-2">
    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
      <a href="?<?= http_build_query(array_merge($_GET, ['page' => $i])) ?>"
        class="px-4 py-2 rounded-lg <?= $i == $page ? 'bg-blue-600 text-white' : 'bg-white text-gray-800 border' ?>">
        <?= $i ?>
      </a>
    <?php endfor; ?>
  </div>
  <br />
<?php endif; ?>

<?php
require_once "footer.php";
?>