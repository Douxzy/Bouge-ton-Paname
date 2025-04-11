<?php
require __DIR__ . "/header/header.php";
require "../controller/db.php";
require "../controller/functions.php";
?>

<div class="max-w-4xl mx-auto px-4 py-10">
    <h1 class="text-3xl font-bold text-center mb-8">Foire Aux Questions (FAQ)</h1>

    <div class="space-y-4">
        <!-- Question 1 -->
        <div class="border rounded-lg p-4 bg-white shadow">
            <button onclick="toggleFaq(this)" class="w-full text-left flex justify-between items-center font-medium text-lg">
                Comment créer un compte ?
                <i class="fas fa-chevron-down transition-transform duration-300"></i>
            </button>
            <div class="mt-2 text-gray-600 hidden">
                Cliquez sur “S'inscrire” en haut à droite, puis remplissez le formulaire avec vos informations personnelles.
            </div>
        </div>

        <!-- Question 2 -->
        <div class="border rounded-lg p-4 bg-white shadow">
            <button onclick="toggleFaq(this)" class="w-full text-left flex justify-between items-center font-medium text-lg">
                Comment ajouter un commentaire sur un événement ?
                <i class="fas fa-chevron-down transition-transform duration-300"></i>
            </button>
            <div class="mt-2 text-gray-600 hidden">
                Vous devez être connecté. Une fois connecté, allez sur la page de l'événement et utilisez le formulaire en bas pour laisser un commentaire et une photo si vous le souhaitez.
            </div>
        </div>
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
