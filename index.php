<?php include('./views/layouts/header.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>iQIYI - Static Clone</title>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    body { font-family: 'Montserrat', 'sans-serif'; }
    .placeholder-img { background: #292f44; display: flex; align-items: center; justify-content: center; color: #cfc3c8; font-size: 1.5rem; }
    .card-hover {
      transition: box-shadow 0.3s, transform 0.3s;
    }
    .card-hover:hover {
      box-shadow: 0 12px 32px 0 #5547bb44, 0 1.5px 15px 0 #22223266;
      transform: translateY(-6px) scale(1.05);
    }
    .img-hover {
      transition: transform 0.5s cubic-bezier(.4,0,.2,1), filter 0.4s;
    }
    .card-hover:hover .img-hover {
      transform: scale(1.07);
      filter: brightness(1.07);
    }
    .overlay-play {
      transition: opacity 0.3s;
      opacity: 0;
    }
    .card-hover:hover .overlay-play {
      opacity: 1;
    }
    .celeb-hover {
      transition: transform 0.4s, border-color 0.4s;
    }
    .celeb-hover:hover {
      transform: scale(1.11);
      border-color: #51b17e !important;
    }
  </style>
</head>
<body class="bg-[#17171e] text-white min-h-screen">
  <!-- Hero Banner -->
  <section class="relative flex flex-col items-center justify-center pt-10 pb-16 bg-gradient-to-b from-[#5547bb] via-[#292f44] to-[#17171e] min-h-[340px]">
    <div class="text-center z-10">
      <p class="uppercase text-lg font-bold tracking-widest">Limited Offer Ends April 27</p>
      <h1 class="mt-2 text-[2.5rem] md:text-5xl font-extrabold leading-tight"><span class="text-[#51b17e]">4.22 ANNUAL VIP</span> <br>UP TO 40% OFF</h1>
      <p class="mt-1 text-base md:text-lg">iQIYI 15th Anniversary Sale!</p>
    </div>
    <img src="https://ext.same-assets.com/3286298510/2083158955.webp" alt="Character" class="absolute right-[20%] top-12 w-36 drop-shadow-xl hidden md:block" />
    <img src="https://ext.same-assets.com/3286298510/742710260.webp" alt="Gift Bubble" class="absolute left-[20%] top-20 w-32 drop-shadow-xl hidden md:block" />
    <div class="absolute bottom-6 w-full flex justify-center">
      <a href="#" class="bg-[#51b17e] text-[#17171e] px-5 py-2 rounded-full font-bold uppercase text-sm shadow-md hover:bg-[#39a36b]">Take The Deal</a>
    </div>
  </section>

  <!-- Section: What's New -->
  <section class="px-8 mt-6">
    <h2 class="text-xl font-bold mb-4">What’s New on iQIYI</h2>
    <div class="grid grid-cols-2 md:grid-cols-6 gap-6">
      <div class="rounded overflow-hidden bg-[#222232] shadow-lg card-hover relative group">
        <img src="https://ext.same-assets.com/3286298510/1468587741.webp" class="w-full h-36 object-cover img-hover" alt="The Demon Hunter's Romance">
        <div class="absolute inset-0 flex items-center justify-center bg-black/60 overlay-play">
          <button class="bg-[#51b17e] px-4 py-1 rounded-full text-xs font-bold uppercase text-[#17171e]">Xem ngay</button>
        </div>
        <div class="p-4">
          <span class="bg-[#51b17e] text-xs font-semibold px-2 py-1 rounded">TOP 10</span>
          <h3 class="mt-2 text-base font-semibold">The Demon Hunter's Romance</h3>
          <p class="text-xs text-gray-400 mt-1">New Episode</p>
        </div>
      </div>
      <div class="rounded overflow-hidden bg-[#222232] shadow-lg card-hover relative group">
        <img src="https://ext.same-assets.com/3286298510/611378790.jpeg" class="w-full h-36 object-cover img-hover" alt="A Moment But Forever">
        <div class="absolute inset-0 flex items-center justify-center bg-black/60 overlay-play">
          <button class="bg-[#51b17e] px-4 py-1 rounded-full text-xs font-bold uppercase text-[#17171e]">Xem ngay</button>
        </div>
        <div class="p-4">
          <span class="bg-[#5547bb] text-xs font-semibold px-2 py-1 rounded">IQIYI ONLY</span>
          <h3 class="mt-2 text-base font-semibold">A Moment But Forever</h3>
          <p class="text-xs text-gray-400 mt-1">36 Episodes</p>
        </div>
      </div>
      <div class="rounded overflow-hidden bg-[#222232] shadow-lg card-hover relative group">
        <img src="https://ext.same-assets.com/3286298510/1397154317.png" class="w-full h-36 object-cover img-hover" alt="Your Sky of Us">
        <div class="absolute inset-0 flex items-center justify-center bg-black/60 overlay-play">
          <button class="bg-[#51b17e] px-4 py-1 rounded-full text-xs font-bold uppercase text-[#17171e]">Xem ngay</button>
        </div>
        <div class="p-4">
          <span class="bg-[#ad4561] text-xs font-semibold px-2 py-1 rounded">NEW</span>
          <h3 class="mt-2 text-base font-semibold">Your Sky of Us</h3>
          <p class="text-xs text-gray-400 mt-1">3 Episodes</p>
        </div>
      </div>
      <div class="rounded overflow-hidden bg-[#222232] shadow-lg card-hover relative group">
        <div class="w-full h-36 placeholder-img img-hover">Image</div>
        <div class="absolute inset-0 flex items-center justify-center bg-black/60 overlay-play">
          <button class="bg-[#51b17e] px-4 py-1 rounded-full text-xs font-bold uppercase text-[#17171e]">Xem ngay</button>
        </div>
        <div class="p-4">
          <span class="bg-[#51b17e] text-xs font-semibold px-2 py-1 rounded">TOP 10</span>
          <h3 class="mt-2 text-base font-semibold">Lost In The Stars</h3>
          <p class="text-xs text-gray-400 mt-1">12 Episodes</p>
        </div>
      </div>
      <div class="rounded overflow-hidden bg-[#222232] shadow-lg card-hover relative group">
        <div class="w-full h-36 placeholder-img img-hover">Image</div>
        <div class="absolute inset-0 flex items-center justify-center bg-black/60 overlay-play">
          <button class="bg-[#51b17e] px-4 py-1 rounded-full text-xs font-bold uppercase text-[#17171e]">Xem ngay</button>
        </div>
        <div class="p-4">
          <span class="bg-[#5547bb] text-xs font-semibold px-2 py-1 rounded">IQIYI ONLY</span>
          <h3 class="mt-2 text-base font-semibold">Green Snake</h3>
          <p class="text-xs text-gray-400 mt-1">24 Episodes</p>
        </div>
      </div>
      <div class="rounded overflow-hidden bg-[#222232] shadow-lg card-hover relative group">
        <div class="w-full h-36 placeholder-img img-hover">Image</div>
        <div class="absolute inset-0 flex items-center justify-center bg-black/60 overlay-play">
          <button class="bg-[#51b17e] px-4 py-1 rounded-full text-xs font-bold uppercase text-[#17171e]">Xem ngay</button>
        </div>
        <div class="p-4">
          <span class="bg-[#ad4561] text-xs font-semibold px-2 py-1 rounded">NEW</span>
          <h3 class="mt-2 text-base font-semibold">Ode To Joy</h3>
          <p class="text-xs text-gray-400 mt-1">5 Episodes</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Section: Top Picks -->
  <section class="px-8 mt-10">
    <h2 class="text-xl font-bold mb-4">Top Picks for You</h2>
    <div class="grid grid-cols-2 md:grid-cols-6 gap-6">
      <div class="rounded overflow-hidden bg-[#222232] shadow-lg card-hover relative group">
        <img src="https://ext.same-assets.com/3286298510/891268374.png" class="w-full h-36 object-cover img-hover" alt="Golden Blood">
        <div class="absolute inset-0 flex items-center justify-center bg-black/60 overlay-play">
          <button class="bg-[#51b17e] px-4 py-1 rounded-full text-xs font-bold uppercase text-[#17171e]">Xem ngay</button>
        </div>
        <div class="p-4">
          <span class="bg-[#51b17e] text-xs font-semibold px-2 py-1 rounded">TOP 10</span>
          <h3 class="mt-2 text-base font-semibold">Golden Blood</h3>
          <p class="text-xs text-gray-400 mt-1">Updated to 6</p>
        </div>
      </div>
      <div class="rounded overflow-hidden bg-[#222232] shadow-lg card-hover relative group">
        <img src="https://ext.same-assets.com/3286298510/2652739004.png" class="w-full h-36 object-cover img-hover" alt="The Boy Next World">
        <div class="absolute inset-0 flex items-center justify-center bg-black/60 overlay-play">
          <button class="bg-[#51b17e] px-4 py-1 rounded-full text-xs font-bold uppercase text-[#17171e]">Xem ngay</button>
        </div>
        <div class="p-4">
          <span class="bg-[#5547bb] text-xs font-semibold px-2 py-1 rounded">IQIYI ONLY</span>
          <h3 class="mt-2 text-base font-semibold">The Boy Next World</h3>
          <p class="text-xs text-gray-400 mt-1">10 Episodes</p>
        </div>
      </div>
      <div class="rounded overflow-hidden bg-[#222232] shadow-lg card-hover relative group">
        <img src="https://ext.same-assets.com/3286298510/2083158955.webp" class="w-full h-36 object-cover img-hover" alt="Love of The Divine Tree">
        <div class="absolute inset-0 flex items-center justify-center bg-black/60 overlay-play">
          <button class="bg-[#51b17e] px-4 py-1 rounded-full text-xs font-bold uppercase text-[#17171e]">Xem ngay</button>
        </div>
        <div class="p-4">
          <span class="bg-[#ad4561] text-xs font-semibold px-2 py-1 rounded">NEW</span>
          <h3 class="mt-2 text-base font-semibold">Love of The Divine Tree</h3>
          <p class="text-xs text-gray-400 mt-1">40 Episodes</p>
        </div>
      </div>
      <div class="rounded overflow-hidden bg-[#222232] shadow-lg card-hover relative group">
        <div class="w-full h-36 placeholder-img img-hover">Image</div>
        <div class="absolute inset-0 flex items-center justify-center bg-black/60 overlay-play">
          <button class="bg-[#51b17e] px-4 py-1 rounded-full text-xs font-bold uppercase text-[#17171e]">Xem ngay</button>
        </div>
        <div class="p-4">
          <span class="bg-[#51b17e] text-xs font-semibold px-2 py-1 rounded">TOP 10</span>
          <h3 class="mt-2 text-base font-semibold">Moonlight Romance</h3>
          <p class="text-xs text-gray-400 mt-1">22 Episodes</p>
        </div>
      </div>
      <div class="rounded overflow-hidden bg-[#222232] shadow-lg card-hover relative group">
        <div class="w-full h-36 placeholder-img img-hover">Image</div>
        <div class="absolute inset-0 flex items-center justify-center bg-black/60 overlay-play">
          <button class="bg-[#51b17e] px-4 py-1 rounded-full text-xs font-bold uppercase text-[#17171e]">Xem ngay</button>
        </div>
        <div class="p-4">
          <span class="bg-[#5547bb] text-xs font-semibold px-2 py-1 rounded">IQIYI ONLY</span>
          <h3 class="mt-2 text-base font-semibold">Whisper of Silence</h3>
          <p class="text-xs text-gray-400 mt-1">14 Episodes</p>
        </div>
      </div>
      <div class="rounded overflow-hidden bg-[#222232] shadow-lg card-hover relative group">
        <div class="w-full h-36 placeholder-img img-hover">Image</div>
        <div class="absolute inset-0 flex items-center justify-center bg-black/60 overlay-play">
          <button class="bg-[#51b17e] px-4 py-1 rounded-full text-xs font-bold uppercase text-[#17171e]">Xem ngay</button>
        </div>
        <div class="p-4">
          <span class="bg-[#ad4561] text-xs font-semibold px-2 py-1 rounded">NEW</span>
          <h3 class="mt-2 text-base font-semibold">The Promise</h3>
          <p class="text-xs text-gray-400 mt-1">8 Episodes</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Section: iQIYI Collection -->
  <section class="px-8 mt-10">
    <h2 class="text-xl font-bold mb-4">iQIYI Collection</h2>
    <div class="grid grid-cols-2 md:grid-cols-6 gap-6">
      <div class="rounded overflow-hidden bg-[#222232] shadow-lg card-hover relative group">
        <img src="https://ext.same-assets.com/3286298510/2793530229.png" class="w-full h-36 object-cover img-hover" alt="C-Anime Collection">
        <div class="absolute inset-0 flex items-center justify-center bg-black/60 overlay-play">
          <button class="bg-[#51b17e] px-4 py-1 rounded-full text-xs font-bold uppercase text-[#17171e]">Xem ngay</button>
        </div>
        <div class="p-4">
          <span class="bg-[#51b17e] text-xs font-semibold px-2 py-1 rounded">Playlist</span>
          <h3 class="mt-2 text-base font-semibold">C-Anime Collection</h3>
          <p class="text-xs text-gray-400 mt-1">15</p>
        </div>
      </div>
      <div class="rounded overflow-hidden bg-[#222232] shadow-lg card-hover relative group">
        <img src="https://ext.same-assets.com/3286298510/3717234557.png" class="w-full h-36 object-cover img-hover" alt="2024 TOP IQIYI Review">
        <div class="absolute inset-0 flex items-center justify-center bg-black/60 overlay-play">
          <button class="bg-[#51b17e] px-4 py-1 rounded-full text-xs font-bold uppercase text-[#17171e]">Xem ngay</button>
        </div>
        <div class="p-4">
          <span class="bg-[#5547bb] text-xs font-semibold px-2 py-1 rounded">Playlist</span>
          <h3 class="mt-2 text-base font-semibold">2024 TOP IQIYI Review</h3>
          <p class="text-xs text-gray-400 mt-1">6</p>
        </div>
      </div>
      <div class="rounded overflow-hidden bg-[#222232] shadow-lg card-hover relative group">
        <img src="https://ext.same-assets.com/3286298510/3852928359.png" class="w-full h-36 object-cover img-hover" alt="Collection of Bai Lu">
        <div class="absolute inset-0 flex items-center justify-center bg-black/60 overlay-play">
          <button class="bg-[#51b17e] px-4 py-1 rounded-full text-xs font-bold uppercase text-[#17171e]">Xem ngay</button>
        </div>
        <div class="p-4">
          <span class="bg-[#ad4561] text-xs font-semibold px-2 py-1 rounded">Playlist</span>
          <h3 class="mt-2 text-base font-semibold">Collection of Bai Lu</h3>
          <p class="text-xs text-gray-400 mt-1">4</p>
        </div>
      </div>
      <div class="rounded overflow-hidden bg-[#222232] shadow-lg card-hover relative group">
        <div class="w-full h-36 placeholder-img img-hover">Image</div>
        <div class="absolute inset-0 flex items-center justify-center bg-black/60 overlay-play">
          <button class="bg-[#51b17e] px-4 py-1 rounded-full text-xs font-bold uppercase text-[#17171e]">Xem ngay</button>
        </div>
        <div class="p-4">
          <span class="bg-[#51b17e] text-xs font-semibold px-2 py-1 rounded">Playlist</span>
          <h3 class="mt-2 text-base font-semibold">Hot Summer Collection</h3>
          <p class="text-xs text-gray-400 mt-1">5</p>
        </div>
      </div>
      <div class="rounded overflow-hidden bg-[#222232] shadow-lg card-hover relative group">
        <div class="w-full h-36 placeholder-img img-hover">Image</div>
        <div class="absolute inset-0 flex items-center justify-center bg-black/60 overlay-play">
          <button class="bg-[#51b17e] px-4 py-1 rounded-full text-xs font-bold uppercase text-[#17171e]">Xem ngay</button>
        </div>
        <div class="p-4">
          <span class="bg-[#5547bb] text-xs font-semibold px-2 py-1 rounded">Playlist</span>
          <h3 class="mt-2 text-base font-semibold">Drama Master</h3>
          <p class="text-xs text-gray-400 mt-1">13</p>
        </div>
      </div>
      <div class="rounded overflow-hidden bg-[#222232] shadow-lg card-hover relative group">
        <div class="w-full h-36 placeholder-img img-hover">Image</div>
        <div class="absolute inset-0 flex items-center justify-center bg-black/60 overlay-play">
          <button class="bg-[#51b17e] px-4 py-1 rounded-full text-xs font-bold uppercase text-[#17171e]">Xem ngay</button>
        </div>
        <div class="p-4">
          <span class="bg-[#ad4561] text-xs font-semibold px-2 py-1 rounded">Playlist</span>
          <h3 class="mt-2 text-base font-semibold">Rising Star</h3>
          <p class="text-xs text-gray-400 mt-1">3</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Section: Coming Soon -->
  <section class="px-8 mt-10">
    <h2 class="text-xl font-bold mb-4">Coming Soon</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
      <div class="rounded overflow-hidden bg-[#222232] shadow-lg flex flex-col items-center justify-center h-64">
        <span class="bg-gradient-to-l from-[#292f44] via-[#5547bb] to-[#51b17e] py-2 px-8 text-lg font-bold rounded mb-6 mt-8">22/04</span>
        <span class="bg-[#51b17e] text-xs font-semibold px-2 py-1 rounded mb-2">IQIYI ONLY</span>
        <p class="text-center">Pit Babe 2</p>
        <button class="mt-6 px-5 py-2 rounded-full bg-[#292f44] text-sm font-bold hover:bg-[#5547bb]">Reserve</button>
      </div>
      <div class="rounded overflow-hidden bg-[#222232] shadow-lg flex flex-col items-center justify-center h-64">
        <span class="bg-gradient-to-l from-[#292f44] via-[#5547bb] to-[#51b17e] py-2 px-8 text-lg font-bold rounded mb-6 mt-8">05/03</span>
        <span class="bg-[#ad4561] text-xs font-semibold px-2 py-1 rounded mb-2">Original</span>
        <p class="text-center">FEUD</p>
        <button class="mt-6 px-5 py-2 rounded-full bg-[#292f44] text-sm font-bold hover:bg-[#5547bb]">Reserve</button>
      </div>
      <div class="rounded overflow-hidden bg-[#222232] shadow-lg flex flex-col items-center justify-center h-64">
        <span class="bg-gradient-to-l from-[#292f44] via-[#5547bb] to-[#51b17e] py-2 px-8 text-lg font-bold rounded mb-6 mt-8">Coming Soon</span>
        <span class="bg-[#51b17e] text-xs font-semibold px-2 py-1 rounded mb-2">IQIYI ONLY</span>
        <p class="text-center">Fox Spirit Matchmaker</p>
        <button class="mt-6 px-5 py-2 rounded-full bg-[#292f44] text-sm font-bold hover:bg-[#5547bb]">Reserve</button>
      </div>
    </div>
  </section>

  <!-- Section: Celebrities -->
  <section class="px-8 mt-10">
    <h2 class="text-xl font-bold mb-4">Popular Celebrities</h2>
    <div class="flex gap-6">
      <div class="flex flex-col items-center">
        <img src="https://ext.same-assets.com/3286298510/611378790.jpeg" alt="Allen Ren" class="w-16 h-16 rounded-full object-cover border-2 border-[#5547bb] celeb-hover" />
        <p class="mt-2 text-xs">Allen Ren</p>
      </div>
      <div class="flex flex-col items-center">
        <img src="https://ext.same-assets.com/3286298510/1397154317.png" alt="Bai Lu" class="w-16 h-16 rounded-full object-cover border-2 border-[#51b17e] celeb-hover" />
        <p class="mt-2 text-xs">Bai Lu</p>
      </div>
      <div class="flex flex-col items-center">
        <img src="https://ext.same-assets.com/3286298510/891268374.png" alt="Johnny Huang" class="w-16 h-16 rounded-full object-cover border-2 border-[#ad4561] celeb-hover" />
        <p class="mt-2 text-xs">Johnny Huang</p>
      </div>
    </div>
  </section>

<?php include('./views/layouts/footer.php'); ?>

