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
                <li><a href="#" class="hover:text-white transition">Accueil</a></li>
                <li><a href="#" class="hover:text-white transition">Événements</a></li>
                <li><a href="#" class="hover:text-white transition">À propos</a></li>
                <li><a href="#" class="hover:text-white transition">Contact</a></li>
            </ul>
        </div>

        <div>
            <h3 class="text-lg font-semibold text-white mb-4">Contact</h3>
            <ul class="text-sm space-y-2">
                <li>Email : <a href="mailto:contact@bougetonpaname.fr" class="hover:text-white">contact@bougetonpaname.fr</a></li>
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
  document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll('.swiper').forEach((el) => {
      new Swiper(el, {
        loop: true,
        slidesPerView: 1,
        pagination: {
          el: el.querySelector('.swiper-pagination'),
          clickable: true,
        },
        navigation: {
          nextEl: el.querySelector('.swiper-button-next'),
          prevEl: el.querySelector('.swiper-button-prev'),
        },
      });
    });
  });
</script>

<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
</body>

</html>