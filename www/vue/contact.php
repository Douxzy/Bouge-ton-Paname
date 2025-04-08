<?php
require __dir__ . "/header/header.php";
?>
<div class="w-full h-screen flex items-center justify-center px-4">
    <div class="bg-white w-full max-w-md p-10 rounded-2xl shadow-2xl">
        <h1 class="text-3xl font-bold text-center text-gray-800 mb-8">Contact</h1>
        <form action="../controller/login.php" method="POST" class="space-y-6">
            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Adresse email</label>
                <input type="email" id="email" name="email" required
                    class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500" />
            </div>

            <!-- Nom -->
            <div>
                <label for="text" class="block text-sm font-medium text-gray-700">Nom</label>
                <input type="text" id="text" name="text" required
                    class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500" />
            </div>

            <!-- Message -->
            <div>
                <label for="text" class="block text-sm font-medium text-gray-700">Message</label>
                <input type="text" id="text" name="text" required
                    class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500" />
            </div>

            <!-- Bouton -->
            <div>
                <button type="submit"
                    class="w-full bg-blue-600 text-white py-2 px-4 rounded-xl font-semibold hover:bg-blue-700 transition">Envoyer</button>
            </div>
        </form>
    </div>
</div>
<?php
require __dir__ . "/footer/footer.php";

?>