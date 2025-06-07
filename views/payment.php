<?php
// Kiểm tra đăng nhập
if (!isLoggedIn()) {
    redirect('index.php?controller=user&action=login');
}

$plan = isset($_GET['plan']) ? $_GET['plan'] : '';
$plans = [
    '1month' => [
        'name' => 'Gói 1 Tháng',
        'price' => 50000,
        'description' => 'Truy cập tất cả tính năng VIP trong 1 tháng'
    ],
    '3month' => [
        'name' => 'Gói 3 Tháng',
        'price' => 120000,
        'description' => 'Truy cập tất cả tính năng VIP trong 3 tháng (Tiết kiệm 20%)'
    ],
    '1year' => [
        'name' => 'Gói 1 Năm',
        'price' => 400000,
        'description' => 'Truy cập tất cả tính năng VIP trong 1 năm (Tiết kiệm 33%)'
    ]
];

if (!isset($plans[$plan])) {
    redirect('index.php?view=vip.php');
}
$planInfo = $plans[$plan];
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thanh toán VIP - MoMoPhim</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { 
            font-family: 'Montserrat', sans-serif; 
            background: linear-gradient(to right, #13141a, #1c1e2a);
        }
        
        @keyframes pulse-border {
            0% { box-shadow: 0 0 0 0 rgba(255, 195, 0, 0.7); }
            70% { box-shadow: 0 0 0 10px rgba(255, 195, 0, 0); }
            100% { box-shadow: 0 0 0 0 rgba(255, 195, 0, 0); }
        }
        
        .payment-card {
            animation: pulse-border 2s infinite;
            border: 1px solid rgba(255, 195, 0, 0.3);
        }
        
        .gold-gradient {
            background: linear-gradient(to right, #ffd700, #f5a623, #ffd700);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
    </style>
</head>
<body class="bg-[#13141a] text-white min-h-screen">
    <?php require_once 'layouts/header.php'; ?>
    
    <main class="container mx-auto px-4 py-12">
        <div class="max-w-2xl mx-auto">
            <!-- Hiệu ứng ánh sáng -->
            <div class="relative">
                <div class="absolute inset-0 bg-gradient-to-r from-yellow-400 via-yellow-500 to-yellow-600 blur-xl opacity-10 rounded-full"></div>
                <div class="relative bg-[#1e1e2d] rounded-xl shadow-2xl overflow-hidden payment-card">
                    <div class="p-2 bg-gradient-to-r from-yellow-500 to-yellow-600"></div>
                    
                    <div class="p-8">
                        <div class="text-center mb-8">
                            <h1 class="text-3xl font-bold mb-2">
                                <i class="fas fa-crown text-yellow-500 mr-2"></i>
                                <span class="gold-gradient">Xác nhận thanh toán VIP</span>
                            </h1>
                            <p class="text-gray-400">Hoàn tất thanh toán để trở thành thành viên VIP</p>
                        </div>
                        
                        <div class="bg-[#13141a] p-6 rounded-lg mb-8 border border-gray-700">
                            <div class="flex justify-between items-center mb-4">
                                <span class="text-gray-300">Gói đã chọn:</span>
                                <span class="font-semibold text-yellow-400 text-lg"><?= $planInfo['name'] ?></span>
                            </div>
                            
                            <div class="flex justify-between items-center mb-4">
                                <span class="text-gray-300">Mô tả:</span>
                                <span class="text-gray-300"><?= $planInfo['description'] ?></span>
                            </div>
                            
                            <div class="flex justify-between items-center mb-4 pb-4 border-b border-gray-700">
                                <span class="text-gray-300">Thời hạn:</span>
                                <span class="text-white"><?= str_replace('Gói ', '', $planInfo['name']) ?></span>
                            </div>
                            
                            <div class="flex justify-between items-center">
                                <span class="text-gray-300">Tổng thanh toán:</span>
                                <span class="font-bold text-2xl text-green-400"><?= number_format($planInfo['price'], 0, ',', '.') ?> VNĐ</span>
                            </div>
                        </div>
                        
                        <div class="bg-[#13141a] p-6 rounded-lg mb-8 border border-gray-700">
                            <h3 class="font-bold mb-4 text-white">Phương thức thanh toán</h3>
                            
                            <div class="space-y-3">
                                <div class="flex items-center">
                                    <input type="radio" id="momo" name="payment" checked class="mr-3">
                                    <label for="momo" class="flex items-center cursor-pointer">
                                        <div class="w-10 h-10 bg-pink-500 rounded-md flex items-center justify-center mr-3">
                                            <i class="fas fa-wallet text-white"></i>
                                        </div>
                                        <span>Ví MoMo</span>
                                    </label>
                                </div>
                                
                                <div class="flex items-center">
                                    <input type="radio" id="bank" name="payment" class="mr-3">
                                    <label for="bank" class="flex items-center cursor-pointer">
                                        <div class="w-10 h-10 bg-blue-500 rounded-md flex items-center justify-center mr-3">
                                            <i class="fas fa-university text-white"></i>
                                        </div>
                                        <span>Chuyển khoản ngân hàng</span>
                                    </label>
                                </div>
                                
                                <div class="flex items-center">
                                    <input type="radio" id="card" name="payment" class="mr-3">
                                    <label for="card" class="flex items-center cursor-pointer">
                                        <div class="w-10 h-10 bg-gray-500 rounded-md flex items-center justify-center mr-3">
                                            <i class="fas fa-credit-card text-white"></i>
                                        </div>
                                        <span>Thẻ tín dụng/ghi nợ</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        
                        <form action="index.php" method="POST" class="text-center">
                            <input type="hidden" name="controller" value="user">
                            <input type="hidden" name="action" value="upgradeVip">
                            <input type="hidden" name="plan" value="<?= h($plan) ?>">
                            
                            <button type="submit" class="bg-gradient-to-r from-yellow-500 to-yellow-600 hover:from-yellow-600 hover:to-yellow-700 text-black font-bold py-3 px-8 rounded-lg text-lg transition duration-200 w-full flex items-center justify-center">
                                <i class="fas fa-lock mr-2"></i> Xác nhận thanh toán
                            </button>
                            
                            <a href="index.php?view=vip.php" class="block mt-6 text-gray-400 hover:text-white">
                                <i class="fas fa-arrow-left mr-1"></i> Quay lại trang VIP
                            </a>
                        </form>
                    </div>
                </div>
            </div>
            
            <div class="mt-8 text-center text-sm text-gray-500">
                <p>Bằng việc xác nhận thanh toán, bạn đồng ý với <a href="#" class="text-yellow-500 hover:underline">Điều khoản sử dụng</a> của chúng tôi.</p>
                <div class="flex justify-center space-x-4 mt-4">
                    <i class="fab fa-cc-visa text-2xl text-gray-400"></i>
                    <i class="fab fa-cc-mastercard text-2xl text-gray-400"></i>
                    <i class="fab fa-cc-paypal text-2xl text-gray-400"></i>
                    <i class="fab fa-cc-apple-pay text-2xl text-gray-400"></i>
                </div>
            </div>
        </div>
    </main>
    
    <?php require_once 'layouts/footer.php'; ?>
    
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Hiệu ứng khi chọn phương thức thanh toán
        const radioButtons = document.querySelectorAll('input[type="radio"]');
        radioButtons.forEach(radio => {
            radio.addEventListener('change', function() {
                // Reset all labels
                document.querySelectorAll('label').forEach(label => {
                    label.classList.remove('text-yellow-400');
                });
                
                // Highlight selected label
                if (this.checked) {
                    this.nextElementSibling.classList.add('text-yellow-400');
                }
            });
        });
        
        // Set default selected
        document.getElementById('momo').nextElementSibling.classList.add('text-yellow-400');
    });
    </script>
</body>
</html> 