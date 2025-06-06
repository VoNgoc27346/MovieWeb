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
    <?php include 'views/layouts/header.php'; ?>

    <section class="container mx-auto px-8 py-12">
        <h1 class="text-3xl font-bold mb-8 text-center">Nâng cấp tài khoản VIP</h1>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="bg-red-500 text-white p-4 rounded mb-4">
                <?= $_SESSION['error']; unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['success'])): ?>
            <div class="bg-green-500 text-white p-4 rounded mb-4">
                <?= $_SESSION['success']; unset($_SESSION['success']); ?>
            </div>
        <?php endif; ?>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Gói 1 tháng -->
            <div class="bg-[#1e1e2d] p-6 rounded-lg shadow-lg text-center">
                <h2 class="text-xl font-bold mb-2">Gói 1 Tháng</h2>
                <p class="text-gray-400 mb-4">30.000 VNĐ</p>
                <p class="text-sm text-gray-300 mb-4">Truy cập không giới hạn tất cả nội dung VIP trong 1 tháng.</p>
                <form action="index.php" method="GET">
                    <input type="hidden" name="view" value="payment.php">
                    <input type="hidden" name="plan" value="1month">
                    <button type="submit" class="bg-[#ffc345] text-black font-bold py-2 px-6 rounded-full hover:bg-[#ff8c00] transition duration-200">
                        Mua Ngay
                    </button>
                </form>
            </div>

            <!-- Gói 3 tháng -->
            <div class="bg-[#1e1e2d] p-6 rounded-lg shadow-lg text-center">
                <h2 class="text-xl font-bold mb-2">Gói 3 Tháng</h2>
                <p class="text-gray-400 mb-4">80.000 VNĐ</p>
                <p class="text-sm text-gray-300 mb-4">Tiết kiệm 10%! Truy cập nội dung VIP trong 3 tháng.</p>
                <form action="index.php" method="GET">
                    <input type="hidden" name="view" value="payment.php">
                    <input type="hidden" name="plan" value="3month">
                    <button type="submit" class="bg-[#ffc345] text-black font-bold py-2 px-6 rounded-full hover:bg-[#ff8c00] transition duration-200">
                        Mua Ngay
                    </button>
                </form>
            </div>

            <!-- Gói 1 năm -->
            <div class="bg-[#1e1e2d] p-6 rounded-lg shadow-lg text-center">
                <h2 class="text-xl font-bold mb-2">Gói 1 Năm</h2>
                <p class="text-gray-400 mb-4">300.000 VNĐ</p>
                <p class="text-sm text-gray-300 mb-4">Tiết kiệm 20%! Truy cập nội dung VIP trong 1 năm.</p>
                <form action="index.php" method="GET">
                    <input type="hidden" name="view" value="payment.php">
                    <input type="hidden" name="plan" value="1year">
                    <button type="submit" class="bg-[#ffc345] text-black font-bold py-2 px-6 rounded-full hover:bg-[#ff8c00] transition duration-200">
                        Mua Ngay
                    </button>
                </form>
            </div>
        </div>
    </section>

    <?php include 'views/layouts/footer.php'; ?>
</body>
</html>