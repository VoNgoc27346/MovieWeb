<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=1200" />
    <title>Phoenix's Gambit: Love or Crown – iQIYI Clone</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" type="image/png" href="https://ext.same-assets.com/3427629531/2793530229.png">
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
  </style>
  </head>
  
  <body class="bg-[#13141a] text-white font-sans min-h-screen text-lg">
    <!-- HEADER -->
    <header class="flex items-center h-[70px] px-10 bg-[#13141a] border-b border-[#23252e] text-lg">
      <img src="https://ext.same-assets.com/3427629531/2793530229.png" alt="iQIYI Logo" class="h-10 mr-10" />
      <nav class="flex gap-6 text-[#dbddcb] font-semibold">
        <a href="#" class="hover:text-[#27bd52] transition duration-200">Phim lẻ</a>
        <a href="#" class="hover:text-[#27bd52] transition duration-200">Phim bộ</a>
        <a href="views/movies/list.php" class="hover:text-[#27bd52] transition duration-200">Thể loại</a>
        <a href="#" class="hover:text-[#27bd52] transition duration-200">Quốc gia</a>
        <a href="#" class="hover:text-[#27bd52] transition duration-200">Năm phát hành</a>
      </nav>
      <div class="flex-1"></div>
      <div class="flex items-center gap-5">
        <input type="text" placeholder="Tìm kiếm" class="px-3 py-1 rounded bg-[#292f44] text-white placeholder:text-gray-400 text-sm focus:outline-none" />
        <button class="text-[#686b70] hover:text-[#27bd52] text-base">Lịch sử</button>
        <button class="w-9 h-9 bg-[#23252e] rounded-full flex items-center justify-center">
          <img src="https://ext.same-assets.com/3427629531/2457699613.png" alt="avatar" class="w-8 h-8 rounded-full" />
        </button>
        <a href="#" class="bg-[#ffc345] text-black text-sm font-semibold rounded px-5 py-1.5 ml-2 hover:bg-[#ff8c00]">VIP</a>
      </div>
    </header>



