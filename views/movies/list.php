<?php include('../layouts/header.php'); ?>

<!-- Section: Action Movies -->
<section class="px-8 mt-10">
  <h2 class="text-xl font-bold mb-4">Action Movies</h2>
  <div class="grid grid-cols-2 md:grid-cols-6 gap-6">
    <!-- Movie Card Example -->
    <div class="rounded overflow-hidden bg-[#222232] shadow-lg card-hover relative group">
      <img src="https://ext.same-assets.com/3286298510/1468587741.webp" class="w-full h-36 object-cover img-hover" alt="Action Movie 1">
      <div class="absolute inset-0 flex items-center justify-center bg-black/60 overlay-play">
        <button class="bg-[#51b17e] px-4 py-1 rounded-full text-xs font-bold uppercase text-[#17171e]">Xem ngay</button>
      </div>
      <div class="p-4">
        <span class="bg-[#51b17e] text-xs font-semibold px-2 py-1 rounded">TOP 10</span>
        <h3 class="mt-2 text-base font-semibold">Action Movie 1</h3>
        <p class="text-xs text-gray-400 mt-1">New Episode</p>
      </div>
    </div>
    <!-- Repeat similar blocks for other movies -->
  </div>
</section>

<!-- Section: Drama Movies -->
<section class="px-8 mt-10">
  <h2 class="text-xl font-bold mb-4">Drama Movies</h2>
  <div class="grid grid-cols-2 md:grid-cols-6 gap-6">
    <!-- Movie Card Example -->
    <div class="rounded overflow-hidden bg-[#222232] shadow-lg card-hover relative group">
      <img src="https://ext.same-assets.com/3286298510/611378790.jpeg" class="w-full h-36 object-cover img-hover" alt="Drama Movie 1">
      <div class="absolute inset-0 flex items-center justify-center bg-black/60 overlay-play">
        <button class="bg-[#51b17e] px-4 py-1 rounded-full text-xs font-bold uppercase text-[#17171e]">Xem ngay</button>
      </div>
      <div class="p-4">
        <span class="bg-[#5547bb] text-xs font-semibold px-2 py-1 rounded">IQIYI ONLY</span>
        <h3 class="mt-2 text-base font-semibold">Drama Movie 1</h3>
        <p class="text-xs text-gray-400 mt-1">36 Episodes</p>
      </div>
    </div>
    <!-- Repeat similar blocks for other movies -->
  </div>
</section>

<!-- Section: Romance Movies -->
<section class="px-8 mt-10">
  <h2 class="text-xl font-bold mb-4">Romance Movies</h2>
  <div class="grid grid-cols-2 md:grid-cols-6 gap-6">
    <!-- Movie Card Example -->
    <div class="rounded overflow-hidden bg-[#222232] shadow-lg card-hover relative group">
      <img src="https://ext.same-assets.com/3286298510/1397154317.png" class="w-full h-36 object-cover img-hover" alt="Romance Movie 1">
      <div class="absolute inset-0 flex items-center justify-center bg-black/60 overlay-play">
        <button class="bg-[#51b17e] px-4 py-1 rounded-full text-xs font-bold uppercase text-[#17171e]">Xem ngay</button>
      </div>
      <div class="p-4">
        <span class="bg-[#ad4561] text-xs font-semibold px-2 py-1 rounded">NEW</span>
        <h3 class="mt-2 text-base font-semibold">Romance Movie 1</h3>
        <p class="text-xs text-gray-400 mt-1">3 Episodes</p>
      </div>
    </div>
    <!-- Repeat similar blocks for other movies -->
  </div>
</section>

<?php include('../layouts/footer.php'); ?>
