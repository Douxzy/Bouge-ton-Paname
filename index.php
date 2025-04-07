<?php
require "vue/header/header.php";

?>

<div class="relative w-full h-100 bg-cover bg-center">
  <div class="absolute inset-0 bg-black bg-opacity-40 backdrop-blur-sm"></div>
  <div class="relative z-10 flex items-center justify-center h-full">
    <div class="relative w-full max-w-2xl">
      <input type="text" placeholder="Rechercher une sortie à Paris..." class="w-full pl-14 pr-4 py-5 text-lg rounded-2xl shadow-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all duration-300 bg-white bg-opacity-90 text-gray-800"/>
      <i class="fas fa-search absolute left-5 top-1/2 transform -translate-y-1/2 text-gray-400 text-xl"></i>
    </div>
  </div>
</div>

<?php
require "vue/footer/footer.php";

?>