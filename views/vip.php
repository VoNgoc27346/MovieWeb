<?php
if (!isLoggedIn()) {
    redirect('index.php?controller=user&action=login');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mua Gói VIP - MoMoPhim</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Montserrat', sans-serif; }
    </style>
</head>
<body class="bg-[#13141a] text-white min-h-screen">
    <?php require_once 'layouts/header.php'; ?>

    <main class="container mx-auto px-4 py-8">
        <div class="max-w-4xl mx-auto">
            <div class="text-center mb-10">
                <h1 class="text-4xl font-bold mb-4 text-white">
                    <i class="fas fa-crown text-yellow-500 mr-2"></i>
                    <span class="bg-clip-text text-transparent bg-gradient-to-r from-yellow-400 via-yellow-500 to-yellow-600">
                        Nâng cấp tài khoản VIP
                    </span>
                </h1>
                <p class="text-gray-300 text-xl">Trải nghiệm phim chất lượng cao không giới hạn</p>
                
                <!-- Hiệu ứng ánh sáng -->
                <div class="relative mt-6">
                    <div class="absolute inset-0 bg-gradient-to-r from-yellow-400 via-yellow-500 to-yellow-600 blur-xl opacity-20 rounded-full"></div>
                    <div class="relative bg-[#1e1e2d] border border-gray-700 rounded-lg p-6 shadow-xl">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                            <!-- Quyền lợi VIP -->
                            <div class="bg-[#13141a] p-6 rounded-lg border border-gray-700 transform transition-all duration-300 hover:scale-105 hover:shadow-yellow-500/20 hover:shadow-lg">
                                <div class="w-16 h-16 bg-yellow-500/10 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <i class="fas fa-film text-2xl text-yellow-500"></i>
                                </div>
                                <h3 class="text-xl font-bold text-white mb-3 text-center">Xem phim không giới hạn</h3>
                                <ul class="text-gray-400 space-y-2">
                                    <li class="flex items-center">
                                        <i class="fas fa-check text-green-500 mr-2"></i>
                                        Mở khóa tất cả phim premium
                                    </li>
                                    <li class="flex items-center">
                                        <i class="fas fa-check text-green-500 mr-2"></i>
                                        Không bị giới hạn thời gian xem
                                    </li>
                                    <li class="flex items-center">
                                        <i class="fas fa-check text-green-500 mr-2"></i>
                                        Xem trước phim mới nhất
                                    </li>
                                </ul>
                            </div>
                            
                            <!-- Chất lượng cao -->
                            <div class="bg-[#13141a] p-6 rounded-lg border border-gray-700 transform transition-all duration-300 hover:scale-105 hover:shadow-yellow-500/20 hover:shadow-lg">
                                <div class="w-16 h-16 bg-yellow-500/10 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <i class="fas fa-photo-video text-2xl text-yellow-500"></i>
                                </div>
                                <h3 class="text-xl font-bold text-white mb-3 text-center">Chất lượng cao</h3>
                                <ul class="text-gray-400 space-y-2">
                                    <li class="flex items-center">
                                        <i class="fas fa-check text-green-500 mr-2"></i>
                                        Xem phim chất lượng 4K
                                    </li>
                                    <li class="flex items-center">
                                        <i class="fas fa-check text-green-500 mr-2"></i>
                                        Âm thanh vòm 5.1
                                    </li>
                                    <li class="flex items-center">
                                        <i class="fas fa-check text-green-500 mr-2"></i>
                                        Không quảng cáo làm gián đoạn
                                    </li>
                                </ul>
                            </div>
                            
                            <!-- Đặc quyền khác -->
                            <div class="bg-[#13141a] p-6 rounded-lg border border-gray-700 transform transition-all duration-300 hover:scale-105 hover:shadow-yellow-500/20 hover:shadow-lg">
                                <div class="w-16 h-16 bg-yellow-500/10 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <i class="fas fa-star text-2xl text-yellow-500"></i>
                                </div>
                                <h3 class="text-xl font-bold text-white mb-3 text-center">Đặc quyền khác</h3>
                                <ul class="text-gray-400 space-y-2">
                                    <li class="flex items-center">
                                        <i class="fas fa-check text-green-500 mr-2"></i>
                                        Huy hiệu VIP độc quyền
                                    </li>
                                    <li class="flex items-center">
                                        <i class="fas fa-check text-green-500 mr-2"></i>
                                        Giao diện cao cấp
                                    </li>
                                    <li class="flex items-center">
                                        <i class="fas fa-check text-green-500 mr-2"></i>
                                        Hỗ trợ kỹ thuật ưu tiên
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-[#1e1e2d] border border-gray-700 rounded-lg p-8 shadow-lg">
                <h2 class="text-2xl font-bold mb-6 text-white text-center">Chọn gói VIP phù hợp với bạn</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Gói 1 tháng -->
                    <div class="bg-[#13141a] rounded-lg border border-gray-700 overflow-hidden transition-all duration-300 hover:shadow-yellow-500/20 hover:shadow-lg">
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-white mb-2">1 Tháng</h3>
                            <div class="flex items-baseline mb-4">
                                <span class="text-3xl font-bold text-white">50.000</span>
                                <span class="text-gray-400 ml-1">VNĐ</span>
                            </div>
                            <ul class="text-gray-400 space-y-2 mb-6">
                                <li class="flex items-center">
                                    <i class="fas fa-check text-green-500 mr-2"></i>
                                    Truy cập tất cả tính năng VIP
                                </li>
                                <li class="flex items-center">
                                    <i class="fas fa-check text-green-500 mr-2"></i>
                                    Hỗ trợ 24/7
                                </li>
                            </ul>
                        </div>
                        <div class="p-4 bg-[#1e1e2d]">
                            <form action="index.php?controller=user&action=upgradeVip" method="post">
                                <input type="hidden" name="plan" value="1month">
                                <button type="submit" class="w-full py-2 px-4 bg-gradient-to-r from-yellow-500 to-yellow-600 hover:from-yellow-600 hover:to-yellow-700 text-black font-bold rounded-md transition-all duration-300 flex items-center justify-center">
                                    <i class="fas fa-crown mr-2"></i> Chọn gói
                                </button>
                            </form>
                        </div>
                    </div>
                    
                    <!-- Gói 3 tháng (Phổ biến) -->
                    <div class="bg-[#13141a] rounded-lg border-2 border-yellow-500 overflow-hidden transform scale-105 shadow-yellow-500/20 shadow-lg relative">
                        <div class="absolute top-0 right-0 bg-yellow-500 text-black font-bold py-1 px-4 text-sm">
                            Phổ biến
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-white mb-2">3 Tháng</h3>
                            <div class="flex items-baseline mb-4">
                                <span class="text-3xl font-bold text-white">120.000</span>
                                <span class="text-gray-400 ml-1">VNĐ</span>
                            </div>
                            <div class="bg-green-900/30 text-green-400 text-sm py-1 px-2 rounded mb-4 inline-block">
                                Tiết kiệm 20%
                            </div>
                            <ul class="text-gray-400 space-y-2 mb-6">
                                <li class="flex items-center">
                                    <i class="fas fa-check text-green-500 mr-2"></i>
                                    Truy cập tất cả tính năng VIP
                                </li>
                                <li class="flex items-center">
                                    <i class="fas fa-check text-green-500 mr-2"></i>
                                    Hỗ trợ 24/7
                                </li>
                                <li class="flex items-center">
                                    <i class="fas fa-check text-green-500 mr-2"></i>
                                    Ưu đãi đặc biệt
                                </li>
                            </ul>
                        </div>
                        <div class="p-4 bg-[#1e1e2d]">
                            <form action="index.php?controller=user&action=upgradeVip" method="post">
                                <input type="hidden" name="plan" value="3month">
                                <button type="submit" class="w-full py-2 px-4 bg-gradient-to-r from-yellow-500 to-yellow-600 hover:from-yellow-600 hover:to-yellow-700 text-black font-bold rounded-md transition-all duration-300 flex items-center justify-center">
                                    <i class="fas fa-crown mr-2"></i> Chọn gói
                                </button>
                            </form>
                        </div>
                    </div>
                    
                    <!-- Gói 1 năm -->
                    <div class="bg-[#13141a] rounded-lg border border-gray-700 overflow-hidden transition-all duration-300 hover:shadow-yellow-500/20 hover:shadow-lg">
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-white mb-2">1 Năm</h3>
                            <div class="flex items-baseline mb-4">
                                <span class="text-3xl font-bold text-white">400.000</span>
                                <span class="text-gray-400 ml-1">VNĐ</span>
                            </div>
                            <div class="bg-green-900/30 text-green-400 text-sm py-1 px-2 rounded mb-4 inline-block">
                                Tiết kiệm 33%
                            </div>
                            <ul class="text-gray-400 space-y-2 mb-6">
                                <li class="flex items-center">
                                    <i class="fas fa-check text-green-500 mr-2"></i>
                                    Truy cập tất cả tính năng VIP
                                </li>
                                <li class="flex items-center">
                                    <i class="fas fa-check text-green-500 mr-2"></i>
                                    Hỗ trợ 24/7
                                </li>
                                <li class="flex items-center">
                                    <i class="fas fa-check text-green-500 mr-2"></i>
                                    Ưu đãi đặc biệt quanh năm
                                </li>
                            </ul>
                        </div>
                        <div class="p-4 bg-[#1e1e2d]">
                            <form action="index.php?controller=user&action=upgradeVip" method="post">
                                <input type="hidden" name="plan" value="1year">
                                <button type="submit" class="w-full py-2 px-4 bg-gradient-to-r from-yellow-500 to-yellow-600 hover:from-yellow-600 hover:to-yellow-700 text-black font-bold rounded-md transition-all duration-300 flex items-center justify-center">
                                    <i class="fas fa-crown mr-2"></i> Chọn gói
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                
                <div class="mt-8 text-center text-gray-400">
                    <p class="mb-2">Thanh toán an toàn và bảo mật</p>
                    <div class="flex justify-center space-x-4">
                        <i class="fab fa-cc-visa text-2xl"></i>
                        <i class="fab fa-cc-mastercard text-2xl"></i>
                        <i class="fab fa-cc-paypal text-2xl"></i>
                        <i class="fab fa-cc-apple-pay text-2xl"></i>
                    </div>
                </div>
            </div>
            
            <div class="mt-8 bg-[#1e1e2d] border border-gray-700 rounded-lg p-6 shadow-lg">
                <h3 class="text-xl font-bold text-white mb-4">Câu hỏi thường gặp</h3>
                
                <div class="space-y-4">
                    <div class="border-b border-gray-700 pb-4">
                        <h4 class="text-white font-bold mb-2">Làm thế nào để trở thành VIP?</h4>
                        <p class="text-gray-400">Chọn một trong các gói VIP phù hợp với bạn và thanh toán. Tài khoản của bạn sẽ được nâng cấp ngay lập tức.</p>
                    </div>
                    
                    <div class="border-b border-gray-700 pb-4">
                        <h4 class="text-white font-bold mb-2">Tôi có thể hủy gói VIP không?</h4>
                        <p class="text-gray-400">Bạn có thể hủy bất kỳ lúc nào, nhưng phí đã thanh toán sẽ không được hoàn lại.</p>
                    </div>
                    
                    <div class="border-b border-gray-700 pb-4">
                        <h4 class="text-white font-bold mb-2">Làm thế nào để gia hạn VIP?</h4>
                        <p class="text-gray-400">Bạn có thể gia hạn bằng cách chọn gói VIP mới trước khi gói hiện tại hết hạn. Thời gian sẽ được cộng dồn.</p>
                    </div>
                    
                    <div>
                        <h4 class="text-white font-bold mb-2">Tôi gặp vấn đề khi thanh toán?</h4>
                        <p class="text-gray-400">Vui lòng liên hệ với chúng tôi qua email support@momophim.com để được hỗ trợ.</p>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
    // Hiệu ứng ánh sáng cho các gói VIP
    document.addEventListener('DOMContentLoaded', function() {
        const vipPackages = document.querySelectorAll('.bg-[#13141a]');
        
        vipPackages.forEach(pkg => {
            pkg.addEventListener('mouseover', function() {
                this.style.transform = 'translateY(-5px)';
            });
            
            pkg.addEventListener('mouseout', function() {
                this.style.transform = '';
            });
        });
        
        // Hiệu ứng đặc biệt cho gói phổ biến
        const popularPackage = document.querySelector('.border-yellow-500');
        if (popularPackage) {
            setInterval(() => {
                popularPackage.classList.toggle('shadow-yellow-500/40');
                popularPackage.classList.toggle('shadow-yellow-500/20');
            }, 1000);
        }
    });
    </script>

    <?php require_once 'layouts/footer.php'; ?>
</body>
</html>