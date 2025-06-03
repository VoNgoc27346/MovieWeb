<?php
require_once 'helpers.php';
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=1200" />
    <title>Phoenix's Gambit: Love or Crown – iQIYI Clone</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" type="image/png" href="https://ext.same-assets.com/3427629531/2793530229.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="public/css/style.css">
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
    <?php if (isset($_SESSION['success'])): ?>
      <div class="bg-green-500 text-white p-4 rounded mb-4 container mx-auto mt-4">
        <?= $_SESSION['success']; unset($_SESSION['success']); ?>
      </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
      <div class="bg-red-500 text-white p-4 rounded mb-4 container mx-auto mt-4">
        <?= $_SESSION['error']; unset($_SESSION['error']); ?>
      </div>
    <?php endif; ?>

    <!-- HEADER -->
    <header class="flex items-center h-[70px] px-10 bg-[#13141a] border-b border-[#23252e] text-lg">
      <a href="index.php" class="block text-3xl font-bold tracking-wide hover:text-green-700 transition mr-8">
        <span class="text-green-600">MoMo</span><span class="text-pink-500">Phim</span>
      </a>


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
      
      <div class="flex items-center ml-auto">
        <?php if (isLoggedIn()): ?>
          <div class="mr-4 flex items-center">
            <img src="uploads/default-avatar.png" alt="User Avatar" class="w-8 h-8 rounded-full mr-2" />
            <span><?= $_SESSION['username'] ?></span>
          </div>
          <a href="index.php?action=logout" class="bg-red-600 hover:bg-red-700 px-3 py-1 rounded-md text-sm">
            <i class="fas fa-sign-out-alt mr-1"></i> Đăng xuất
          </a>
        <?php else: ?>
          <a href="index.php?controller=user&action=login" class="bg-blue-600 hover:bg-blue-700 px-3 py-1 rounded-md text-sm mr-2">
            <i class="fas fa-sign-in-alt mr-1"></i> Đăng nhập
          </a>
          <a href="index.php?controller=user&action=register" class="bg-green-600 hover:bg-green-700 px-3 py-1 rounded-md text-sm">
            <i class="fas fa-user-plus mr-1"></i> Đăng ký
          </a>
        <?php endif; ?>
      </div>

    </header>



