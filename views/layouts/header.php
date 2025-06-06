<?php
require_once dirname(__DIR__, 2) . '/helpers.php';
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MoMoPhim - Xem phim HD online</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        /* Animation duration */
        .animate__animated {
            --animate-duration: 0.5s;
        }
        
        /* Custom animations */
        .animate__fadeOutRight {
            animation-name: fadeOutRight;
        }
        
        @keyframes fadeOutRight {
            from {
                opacity: 1;
                transform: translateX(0);
            }
            to {
                opacity: 0;
                transform: translateX(50px);
            }
        }
        
        /* VIP USER STYLES */
        .is-vip-user header {
            background: linear-gradient(to right, #13141a, #1c1e2a) !important;
            border-bottom: 1px solid #ffc345 !important;
        }
        
        .is-vip-user .bg-[#13141a] {
            background: linear-gradient(to right, #13141a, #1c1e2a) !important;
        }
        
        /* VIP Badge animation */
        @keyframes vipPulse {
            0% { box-shadow: 0 0 0 0 rgba(255, 195, 69, 0.7); }
            70% { box-shadow: 0 0 0 6px rgba(255, 195, 69, 0); }
            100% { box-shadow: 0 0 0 0 rgba(255, 195, 69, 0); }
        }
        
        .vip-badge {
            animation: vipPulse 2s infinite !important;
            border: 1px solid gold !important;
        }
        
        /* Thêm icon VIP cho các phim premium */
        .vip-user .premium-content-badge::before {
            content: "Đã mở khóa" !important;
            color: #ffc345 !important;
            font-weight: bold !important;
            font-size: 0.75rem !important;
        }
        
        /* Người dùng thường không được xem nội dung VIP */
        .premium-content-badge::before {
            content: "VIP" !important;
            color: #ffc345 !important;
            font-weight: bold !important;
            font-size: 0.75rem !important;
        }
        
        /* VIP Hover */
        .is-vip-user .nav-link:hover {
            text-shadow: 0 0 10px rgba(255, 195, 69, 0.5) !important;
        }
        
        /* Thêm mới: Hiệu ứng rõ ràng hơn cho người dùng VIP */
        .vip-user .text-white {
            color: #f8f8f8 !important;
        }
        
        .vip-user .text-gray-300 {
            color: #ffeeba !important;
        }
        
        .vip-user .bg-green-600 {
            background: linear-gradient(to right, #4caf50, #2e7d32) !important;
        }
        
        /* Thêm hào quang vip */
        .vip-badge {
            position: relative !important;
        }
        
        .vip-badge::after {
            content: "";
            position: absolute !important;
            top: -3px !important;
            left: -3px !important;
            right: -3px !important;
            bottom: -3px !important;
            border-radius: 8px !important;
            background: linear-gradient(45deg, gold, transparent, gold, transparent, gold) !important;
            background-size: 200% !important;
            animation: goldShine 3s linear infinite !important;
            z-index: -1 !important;
        }
        
        @keyframes goldShine {
            0% { background-position: 0% 0%; }
            100% { background-position: 200% 0%; }
        }
    </style>

    <?php
    // Kiểm tra và thêm CSS cho VIP ngay từ đầu
    if (isset($_SESSION['user_id'])) {
        $userId = $_SESSION['user_id'];
        $db = Database::getInstance();
        $user = $db->querySingle("SELECT is_vip, vip_expiry FROM users WHERE user_id = ?", [$userId]);
        
        if (is_array($user) && $user['is_vip'] && strtotime($user['vip_expiry']) > time()) {
            echo '<style>
                body, html {
                    background: linear-gradient(to right, #13141a, #1c1e2a) !important;
                }
                header {
                    background: linear-gradient(to right, #13141a, #1c1e2a) !important;
                    border-bottom: 2px solid #ffc345 !important;
                }
                .bg-red-600 {
                    background: linear-gradient(to right, #f44336, #d32f2f) !important;
                }
                .bg-green-600 {
                    background: linear-gradient(to right, #4caf50, #2e7d32) !important;
                }
                
                /* Thêm badge VIP cho các button */
                button:after {
                    content: "";
                    position: absolute;
                    border-radius: inherit;
                    top: -2px;
                    left: -2px;
                    right: -2px;
                    bottom: -2px;
                    background: linear-gradient(45deg, gold, transparent, gold) !important;
                    background-size: 200% !important;
                    animation: goldShine 3s linear infinite !important;
                    z-index: -1 !important;
                    opacity: 0.3;
                }
                
                /* Thêm VIP ribbon */
                .movie-card:before {
                    content: "VIP";
                    position: absolute;
                    top: 10px;
                    left: -20px;
                    background: gold;
                    color: black;
                    padding: 2px 10px;
                    transform: rotate(-45deg);
                    font-weight: bold;
                    font-size: 10px;
                    z-index: 10;
                }
            </style>';
        }
    }
    ?>
</head>

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
        <input type="text" placeholder="Tìm kiếm" class="px-3 py-1 rounded bg-[#292f44] text-white placeholder-gray-400 text-sm focus:outline-none" />
        <button class="text-[#686b70] hover:text-[#27bd52] text-base">Lịch sử</button>
        <button class="w-9 h-9 bg-[#23252e] rounded-full flex items-center justify-center">
            <img src="https://ext.same-assets.com/3427629531/2457699613.png" alt="avatar" class="w-8 h-8 rounded-full" />
        </button>
        <a href="index.php?view=vip.php" class="bg-gradient-to-r from-yellow-500 to-yellow-600 text-black text-sm font-bold rounded-md px-5 py-1.5 ml-2 hover:from-yellow-600 hover:to-yellow-700 shadow-lg flex items-center">
            <i class="fas fa-crown mr-1"></i> VIP
        </a>
    </div>

    <div class="flex items-center ml-auto">
        <?php if (isLoggedIn()): ?>
            <div class="mr-4 flex items-center">
                <img src="uploads/default-avatar.png" alt="User Avatar" class="w-8 h-8 rounded-full mr-2" />
                <span><?= h($_SESSION['username']) ?></span>
                <?php
                // Kiểm tra đăng nhập và truy vấn user
                if (isset($_SESSION['user_id'])) {
                  $userId = $_SESSION['user_id'];
                  $db = Database::getInstance();
                  $user = $db->querySingle("SELECT is_vip, vip_expiry FROM users WHERE user_id = ?", [$userId]);
                  
                  if (is_array($user) && $user['is_vip'] && strtotime($user['vip_expiry']) > time()) {
                      $expiryDate = date('d/m/Y', strtotime($user['vip_expiry']));
                      echo '<div class="ml-2 bg-gradient-to-r from-yellow-500 to-yellow-700 text-white text-xs font-bold py-1 px-2 rounded-md flex items-center vip-badge" style="animation: vipPulse 2s infinite; border: 1px solid gold;">';
                      echo '<i class="fas fa-crown mr-1"></i> VIP';
                      echo '<span class="ml-1 text-xs opacity-75">(' . $expiryDate . ')</span>';
                      echo '</div>';
                      
                      // Hiển thị trực tiếp CSS để đảm bảo áp dụng ngay
                      echo '<style>
                            body {
                                background: linear-gradient(to right, #13141a, #1c1e2a) !important;
                            }
                            header {
                                background: linear-gradient(to right, #13141a, #1c1e2a) !important;
                                border-bottom: 1px solid #ffc345 !important;
                            }
                            </style>';
                      
                      // Thêm script để đánh dấu user là VIP toàn cục
                      echo '<script>
                            document.documentElement.classList.add("is-vip-user");
                            document.body.classList.add("vip-user");
                            console.log("VIP Status Activated!");
                            
                            // Tạo badge VIP cho user
                            setTimeout(function() {
                                var vipBadges = document.querySelectorAll(".vip-badge");
                                vipBadges.forEach(function(badge) {
                                    badge.style.animation = "vipPulse 2s infinite";
                                    badge.style.border = "1px solid gold";
                                });
                                
                                // Thêm effects cho trang
                                document.body.style.background = "linear-gradient(to right, #13141a, #1c1e2a)";
                                document.querySelector("header").style.borderBottom = "1px solid #ffc345";
                                
                                // Thêm hiệu ứng cho các phim
                                var movieCards = document.querySelectorAll(".movie-grid > div");
                                movieCards.forEach(function(card) {
                                    if (Math.random() > 0.5) {
                                        var badge = document.createElement("div");
                                        badge.className = "absolute top-2 left-2 bg-gradient-to-r from-yellow-600 to-yellow-400 text-black font-bold px-2 py-1 rounded-full text-xs flex items-center premium-content-badge vip-badge";
                                        badge.innerHTML = "<i class=\\"fas fa-crown mr-1\\"></i>";
                                        badge.style.animation = "vipPulse 2s infinite";
                                        badge.style.zIndex = "10";
                                        
                                        var container = card.querySelector(".relative.rounded-lg");
                                        if (container) {
                                            container.appendChild(badge);
                                        }
                                    }
                                });
                            }, 100);
                            </script>';
                  }
              }
                ?>
            </div>
            <a href="index.php?controller=user&action=logout" class="bg-red-600 hover:bg-red-700 px-3 py-1 rounded-md text-sm">
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