<?php
require __dir__ . "/header/header.php";

?>
  <div class="w-full h-screen flex items-center justify-center px-4">
    <div class="bg-white w-full max-w-2xl p-10 rounded-2xl shadow-2xl">
      <h1 class="text-3xl font-bold text-center text-gray-800 mb-8">Créer un compte</h1>

      <form action="../controller/register.php" method="POST">
        <!-- Pseudo -->
        <div>
          <label for="pseudo" class="block text-sm font-medium text-gray-700">Pseudo</label>
          <input type="text" id="pseudo" name="pseudo" required
            class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500" />
        </div>

        <!-- Email -->
        <div>
          <label for="email" class="block text-sm font-medium text-gray-700">Adresse email</label>
          <input type="email" id="email" name="email" required
            class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500" />
        </div>

        <!-- Mot de passe -->
        <div>
          <label for="password" class="block text-sm font-medium text-gray-700">Mot de passe</label>
          <input type="password" id="password" name="password" required
            class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500" />
        </div>

        <!-- Confirmer mot de passe -->
        <div>
          <label for="confirm-password" class="block text-sm font-medium text-gray-700">Confirmer le mot de passe</label>
          <input type="password" id="confirm-password" name="confirm-password" required
            class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500" />
        </div>

        <!-- Code postal -->
        <div>
          <label for="postal-code" class="block text-sm font-medium text-gray-700">Code postal</label>
          <input type="text" id="postal-code" name="postal-code" required maxlength="5"
            class="mt-1 w-full px-4 py-2 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500" />
        </div>

        <!-- Bouton -->
        <div>
          <button type="submit"
            class="w-full bg-blue-600 text-white py-2 px-4 rounded-xl font-semibold hover:bg-blue-700 transition">S'inscrire</button>
        </div>
      </form>

      <!-- Lien vers login -->
      <p class="mt-6 text-center text-sm text-gray-600">
        Déjà un compte ? <a href="#" class="text-blue-600 hover:underline">Connecte-toi ici</a>
      </p>
    </div>
  </div>
<?php
require __dir__ . "/footer/footer.php";

?>