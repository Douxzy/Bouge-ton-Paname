<?php
require "vue/header/header.php";

?>
<?php
$query = $_GET['q'] ?? null;
$results = [];

if ($query) {
    $encodedQuery = urlencode($query);
    $apiUrl = "https://opendata.paris.fr/api/v2/catalog/datasets/que-faire-a-paris-/records?limit=12&search={$encodedQuery}";

    // Appel API sécurisé
    $response = @file_get_contents($apiUrl);
    if ($response !== false) {
        $data = json_decode($response, true);
        $results = $data['records'] ?? [];
    }
}
?>
<div class="relative w-full h-100 bg-cover bg-center">
  <div class="absolute inset-0 bg-black bg-opacity-40 backdrop-blur-sm"></div>
  <div class="relative z-10 flex items-center justify-center h-full">
    <div class="relative w-full max-w-2xl">
    <form action="" method="GET">
      <input type="text" name="q" placeholder="Rechercher une sortie à Paris..." class="w-full pl-14 pr-4 py-5 text-lg rounded-2xl shadow-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all duration-300 bg-white bg-opacity-90 text-gray-800"/>
      <i class="fas fa-search absolute left-5 top-1/2 transform -translate-y-1/2 text-gray-400 text-xl"></i>
      </form>
    </div>
  </div>
</div>
  <!-- Résultats -->
  <?php if ($query): ?>
    <h2 class="text-2xl font-bold text-center mb-6">Résultats pour : "<?= htmlspecialchars($query) ?>"</h2>

    <?php if (empty($results)): ?>
      <p class="text-center text-gray-600">Aucun résultat trouvé.</p>
    <?php else: ?>
      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 max-w-7xl mx-auto">
        <?php foreach ($results as $event): 
          $e = $event['record']['fields'];
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
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  <?php endif; ?>
<?php
require "vue/footer/footer.php";

?>