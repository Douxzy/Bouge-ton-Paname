<footer class="bg-gray-900 text-gray-300 py-10 px-6">
    <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-8">
        <div>
            <h2 class="text-2xl font-bold text-white mb-4">Bouge ton Paname</h2>
            <p class="text-sm leading-relaxed">
                Découvre les meilleures sorties à Paris : concerts, expos, festivals, et plus encore.
                On te fait bouger toute l'année !
            </p>
        </div>

        <div>
            <h3 class="text-lg font-semibold text-white mb-4">Liens utiles</h3>
            <ul class="space-y-2 text-sm">
                <li><a href="<?php __DIR__; ?>index.php" class="hover:text-white transition">Accueil</a></li>
                <li><a href="<?php __DIR__; ?>mentions-legales.php" class="hover:text-white transition">Mentions Legales</a></li>
                <li><a href="<?php __DIR__; ?>contact.php" class="hover:text-white transition">Contact</a></li>
                <li><a href="<?php __DIR__; ?>aide.php" class="hover:text-white transition">Aide</a></li>
                <br/>
                <li><a href="login.php" class="hover:text-white transition">Admin</a></li>
            </ul>
        </div>

        <div>
            <h3 class="text-lg font-semibold text-white mb-4">Contact</h3>
            <ul class="text-sm space-y-2">
                <li>Email : <a href="mailto:contact@bougetonpaname.fr"
                        class="hover:text-white">contact@bougetonpaname.fr</a></li>
                <li>Tél : <a href="tel:+33123456789" class="hover:text-white">01 23 45 67 89</a></li>
                <li>Adresse : Paris, France</li>
            </ul>
        </div>
    </div>

    <div class="border-t border-gray-700 mt-10 pt-6 text-center text-sm text-gray-500">
        © 2025 Bouge ton Paname. Tous droits réservés.
    </div>
</footer>

<script>
  const passwordInput = document.getElementById("password");
  const strengthBar = document.getElementById("password-strength-bar");
  const strengthText = document.getElementById("password-strength-text");

  passwordInput.addEventListener("input", () => {
    const value = passwordInput.value;
    let strength = 0;

    if (value.length >= 6) strength++;
    if (/[A-Z]/.test(value)) strength++;
    if (/[0-9]/.test(value)) strength++;
    if (/[^A-Za-z0-9]/.test(value)) strength++;

    // Reset classes
    strengthBar.className = "h-2 rounded-xl transition-all duration-300 ease-in-out";

    if (strength <= 1) {
      strengthBar.classList.add("w-1/3", "bg-red-500");
      strengthText.textContent = "Faible";
      strengthText.className = "text-sm mt-1 font-medium text-red-600";
    } else if (strength === 2 || strength === 3) {
      strengthBar.classList.add("w-2/3", "bg-yellow-400");
      strengthText.textContent = "Moyen";
      strengthText.className = "text-sm mt-1 font-medium text-yellow-500";
    } else if (strength >= 4) {
      strengthBar.classList.add("w-full", "bg-green-500");
      strengthText.textContent = "Fort";
      strengthText.className = "text-sm mt-1 font-medium text-green-600";
    }
  });
</script>

</body>

</html>