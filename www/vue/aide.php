<?php
require __DIR__ . "/header/header.php";
require "../controller/db.php";
require "../controller/functions.php";

// Récupération des questions/réponses depuis la BDD
$stmt = $pdo->query("SELECT * FROM faq ORDER BY id ASC");
$faqs = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="max-w-4xl mx-auto px-4 py-10">
    <h1 class="text-3xl font-bold text-center mb-8">Foire Aux Questions (FAQ)</h1>

    <div class="space-y-4">
        <?php foreach ($faqs as $faq): ?>
            <div class="border rounded-lg p-4 bg-white shadow">
                <button onclick="toggleFaq(this)" class="w-full text-left flex justify-between items-center font-medium text-lg">
                    <?= htmlspecialchars($faq['question']) ?>
                    <i class="fas fa-chevron-down transition-transform duration-300"></i>
                </button>
                <div class="mt-2 text-gray-600 hidden">
                    <?= nl2br(htmlspecialchars($faq['reponse'])) ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<script>
    function toggleFaq(button) {
        const answer = button.nextElementSibling;
        const icon = button.querySelector('i');

        answer.classList.toggle('hidden');
        icon.classList.toggle('rotate-180');
    }
</script>

<?php
require __DIR__ . "/footer/footer.php";
?>
