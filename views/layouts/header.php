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
        
        /* Cải thiện hiệu ứng VIP Badge */
        @keyframes vipGlowing {
            0% { text-shadow: 0 0 5px gold, 0 0 10px gold; }
            50% { text-shadow: 0 0 20px gold, 0 0 30px gold; }
            100% { text-shadow: 0 0 5px gold, 0 0 10px gold; }
        }
        
        /* Hiệu ứng tên người dùng VIP */
        .vip-username {
            background: linear-gradient(to right, #ffd700, #ffcc00, #ffd700);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-weight: bold !important;
            animation: vipGlowing 2s infinite;
        }
        
        .vip-badge {
            animation: vipPulse 2s infinite !important;
            border: 2px solid gold !important;
            box-shadow: 0 0 10px rgba(255, 215, 0, 0.7) !important;
        }
        
        /* Viền avatar người dùng VIP */
        .vip-avatar-border {
            border: 2px solid gold !important;
            box-shadow: 0 0 10px rgba(255, 215, 0, 0.7) !important;
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
    
    <script>
    // Hàm để buộc trình duyệt tải lại trang và xóa cache
    function forceReload() {
        // Xóa cache và cookie trước khi chuyển hướng
        localStorage.clear(); // Xóa localStorage
        sessionStorage.clear(); // Xóa sessionStorage
        
        // Thêm timestamp để tránh cache
        window.location.href = "index.php?controller=user&action=logout&t=" + new Date().getTime();
        return false;
    }
    
    // Xóa cache khi trang được tải lại sau đăng xuất
    if (window.performance && window.performance.navigation.type === 1) {
        // Trang được tải lại (refresh)
        localStorage.removeItem('user_data');
        sessionStorage.removeItem('user_data');
    }
    
    // Kiểm tra thời hạn VIP và hiển thị thông báo khi sắp hết hạn
    document.addEventListener('DOMContentLoaded', function() {
        <?php if (isLoggedIn() && isset($_SESSION['is_vip']) && $_SESSION['is_vip'] && isset($_SESSION['vip_expiry'])): ?>
            const vipExpiry = new Date('<?php echo $_SESSION['vip_expiry']; ?>');
            const now = new Date();
            const daysLeft = Math.ceil((vipExpiry - now) / (1000 * 60 * 60 * 24));
            
            // Hiển thị thông báo khi còn dưới 3 ngày
            if (daysLeft <= 3 && daysLeft > 0) {
                setTimeout(function() {
                    const expiryNotice = document.createElement('div');
                    expiryNotice.className = 'fixed bottom-4 right-4 bg-yellow-700 text-white p-4 rounded-md shadow-lg z-50 animate__animated animate__fadeInUp max-w-xs';
                    expiryNotice.innerHTML = `
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <i class="fas fa-exclamation-triangle mr-2 text-yellow-300"></i>
                                <div>
                                    <p class="font-bold">Tài khoản VIP sắp hết hạn!</p>
                                    <p class="text-sm">Chỉ còn ${daysLeft} ngày nữa. Hãy gia hạn để tiếp tục tận hưởng đặc quyền.</p>
                                </div>
                            </div>
                            <button onclick="this.parentElement.parentElement.remove()" class="text-white ml-2">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        <a href="index.php?view=vip.php" class="block mt-2 bg-yellow-500 text-black text-center py-1 px-2 rounded hover:bg-yellow-400">
                            Gia hạn ngay
                        </a>
                    `;
                    document.body.appendChild(expiryNotice);
                    
                    // Tự động ẩn sau 10 giây
                    setTimeout(function() {
                        expiryNotice.classList.remove('animate__fadeInUp');
                        expiryNotice.classList.add('animate__fadeOutDown');
                        setTimeout(function() {
                            expiryNotice.remove();
                        }, 1000);
                    }, 10000);
                }, 3000);
            }
        <?php endif; ?>
    });
    </script>
    
    <?php if (isset($_SESSION['vip_just_upgraded'])): ?>
    <style>
        /* Hiệu ứng đặc biệt khi vừa nâng cấp VIP */
        @keyframes vipUpgraded {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        
        .vip-upgrade-effect {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(-45deg, rgba(255,215,0,0.3), rgba(255,223,0,0.2), rgba(255,215,0,0.3), rgba(255,215,0,0.1));
            background-size: 400% 400%;
            animation: vipUpgraded 3s ease infinite;
            pointer-events: none;
            z-index: 9999;
        }
    </style>
    <script>
        // Hiệu ứng đặc biệt khi vừa nâng cấp VIP
        document.addEventListener('DOMContentLoaded', function() {
            // Tạo hiệu ứng overlay
            const vipEffect = document.createElement('div');
            vipEffect.className = 'vip-upgrade-effect';
            document.body.appendChild(vipEffect);
            
            // Tạo hiệu ứng confetti
            const confettiColors = ['#FFD700', '#FFC000', '#FFDF00', '#F0E68C'];
            const confettiCount = 200;
            
            for (let i = 0; i < confettiCount; i++) {
                const confetti = document.createElement('div');
                confetti.style.position = 'fixed';
                confetti.style.width = Math.random() * 10 + 5 + 'px';
                confetti.style.height = Math.random() * 10 + 5 + 'px';
                confetti.style.backgroundColor = confettiColors[Math.floor(Math.random() * confettiColors.length)];
                confetti.style.borderRadius = '50%';
                confetti.style.opacity = Math.random() * 0.7 + 0.3;
                confetti.style.left = Math.random() * 100 + 'vw';
                confetti.style.top = -20 + 'px';
                confetti.style.zIndex = '10000';
                confetti.style.pointerEvents = 'none';
                
                const animationDuration = Math.random() * 3 + 2;
                confetti.style.animation = `fall ${animationDuration}s linear forwards`;
                
                document.body.appendChild(confetti);
                
                // Tạo keyframe animation cho confetti
                const style = document.createElement('style');
                style.innerHTML = `
                    @keyframes fall {
                        0% {
                            transform: translateY(-20px) rotate(0deg);
                        }
                        100% {
                            transform: translateY(100vh) rotate(${Math.random() * 360}deg);
                        }
                    }
                `;
                document.head.appendChild(style);
            }
            
            // Hiển thị thông báo VIP đặc biệt
            setTimeout(function() {
                const vipMessage = document.createElement('div');
                vipMessage.className = 'fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-black bg-opacity-80 p-8 rounded-lg text-center z-[10001] animate__animated animate__zoomIn';
                vipMessage.innerHTML = `
                    <div class="text-4xl font-bold mb-4" style="background: linear-gradient(to right, #ffd700, #f5a623, #ffd700); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                        <i class="fas fa-crown mr-2"></i> CHÚC MỪNG BẠN
                    </div>
                    <p class="text-white text-xl mb-6">Tài khoản của bạn đã được nâng cấp lên <span class="font-bold text-yellow-400">VIP</span>!</p>
                    <button class="bg-gradient-to-r from-yellow-500 to-yellow-600 text-black font-bold py-2 px-6 rounded-full hover:from-yellow-600 hover:to-yellow-700">
                        Tận hưởng đặc quyền ngay
                    </button>
                `;
                document.body.appendChild(vipMessage);
                
                // Xóa thông báo sau 5 giây
                setTimeout(function() {
                    vipMessage.classList.remove('animate__zoomIn');
                    vipMessage.classList.add('animate__zoomOut');
                    setTimeout(function() {
                        vipMessage.remove();
                        vipEffect.remove();
                    }, 1000);
                }, 5000);
            }, 500);
        });
    </script>
    <?php unset($_SESSION['vip_just_upgraded']); ?>
    <?php endif; ?>
</head>

<header class="flex items-center h-[70px] px-10 bg-[#13141a] border-b border-[#23252e] text-lg">
    <!-- Hiển thị thông báo thành công/lỗi -->
    <?php if (isset($_SESSION['success'])): ?>
        <div id="success-alert" class="fixed top-4 right-4 z-50 bg-green-500 text-white p-4 rounded-md shadow-lg flex items-center justify-between max-w-md animate__animated animate__fadeInRight">
            <div class="flex items-center">
                <i class="fas fa-check-circle mr-2 text-xl"></i>
                <?= $_SESSION['success']; ?>
            </div>
            <button onclick="this.parentElement.remove()" class="text-white focus:outline-none ml-4">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <script>
            setTimeout(() => {
                const alert = document.getElementById('success-alert');
                if (alert) alert.classList.add('animate__fadeOutRight');
                setTimeout(() => {
                    if (alert) alert.remove();
                }, 500);
            }, 5000);
        </script>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>
    
    <?php if (isset($_SESSION['error'])): ?>
        <div id="error-alert" class="fixed top-4 right-4 z-50 bg-red-500 text-white p-4 rounded-md shadow-lg flex items-center justify-between max-w-md animate__animated animate__fadeInRight">
            <div class="flex items-center">
                <i class="fas fa-exclamation-circle mr-2 text-xl"></i>
                <?= $_SESSION['error']; ?>
            </div>
            <button onclick="this.parentElement.remove()" class="text-white focus:outline-none ml-4">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <script>
            setTimeout(() => {
                const alert = document.getElementById('error-alert');
                if (alert) alert.classList.add('animate__fadeOutRight');
                setTimeout(() => {
                    if (alert) alert.remove();
                }, 500);
            }, 5000);
        </script>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>
    
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
        <a href="index.php?view=vip.php" class="bg-gradient-to-r from-yellow-500 to-yellow-600 text-black text-sm font-bold rounded-md px-5 py-1.5 ml-2 hover:from-yellow-600 hover:to-yellow-700 shadow-lg flex items-center">
            <i class="fas fa-crown mr-1"></i> VIP
        </a>
    </div>

    <div class="flex items-center ml-auto">
        <?php if (isLoggedIn()): ?>
            <div class="mr-4 flex items-center">
                <?php
                // Kiểm tra đăng nhập và truy vấn user
                if (isset($_SESSION['user_id'])) {
                  $userId = $_SESSION['user_id'];
                  $db = Database::getInstance();
                  $user = $db->querySingle("SELECT is_vip, vip_expiry FROM users WHERE user_id = ?", [$userId]);
                  
                  $isUserVip = is_array($user) && $user['is_vip'] && strtotime($user['vip_expiry']) > time();
                  
                  // Avatar với hiệu ứng VIP nếu là tài khoản VIP
                  if ($isUserVip) {
                    echo '<div class="relative mr-2">';
                    echo '<img src="uploads/default-avatar.png" alt="User Avatar" class="w-8 h-8 rounded-full vip-avatar-border" />';
                    echo '<div class="absolute -top-1 -right-1 w-4 h-4 flex items-center justify-center bg-yellow-500 rounded-full">';
                    echo '<i class="fas fa-crown text-[8px] text-black"></i>';
                    echo '</div>';
                    echo '</div>';
                    
                    // Tên người dùng với hiệu ứng VIP
                    echo '<span class="vip-username">' . h($_SESSION['username']) . '</span>';
                  } else {
                    // Hiển thị thông thường cho người dùng không phải VIP
                    echo '<img src="uploads/default-avatar.png" alt="User Avatar" class="w-8 h-8 rounded-full mr-2" />';
                    echo '<span>' . h($_SESSION['username']) . '</span>';
                  }
                  
                  if ($isUserVip) {
                      $expiryDate = date('d/m/Y', strtotime($user['vip_expiry']));
                      echo '<div class="ml-2 bg-gradient-to-r from-yellow-500 to-yellow-700 text-white text-xs font-bold py-1 px-2 rounded-md flex items-center vip-badge" style="animation: vipPulse 2s infinite; border: 2px solid gold; box-shadow: 0 0 10px rgba(255, 215, 0, 0.7);">';
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
                                    badge.style.border = "2px solid gold";
                                    badge.style.boxShadow = "0 0 10px rgba(255, 215, 0, 0.7)";
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
                                        badge.style.border = "2px solid gold";
                                        badge.style.boxShadow = "0 0 10px rgba(255, 215, 0, 0.7)";
                                        
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
            <!-- Thêm link đến trang yêu thích trước nút đăng xuất -->
            <a href="index.php?controller=favorite&action=index" class="bg-gray-800 hover:bg-gray-700 px-3 py-1 rounded-md text-sm mr-2 flex items-center">
                <i class="fas fa-heart text-red-500 mr-1"></i> Yêu thích
            </a>
            <a href="index.php?controller=user&action=logout" class="bg-red-600 hover:bg-red-700 px-3 py-1 rounded-md text-sm" onclick="return forceReload();">
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