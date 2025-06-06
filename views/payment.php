<?php
// Kiểm tra đăng nhập
if (!isLoggedIn()) {
    redirect('index.php?controller=user&action=login');
}

$plan = isset($_GET['plan']) ? $_GET['plan'] : '';
$plans = [
    '1month' => [
        'name' => 'Gói 1 Tháng',
        'price' => 30000
    ],
    '3month' => [
        'name' => 'Gói 3 Tháng',
        'price' => 80000
    ],
    '1year' => [
        'name' => 'Gói 1 Năm',
        'price' => 300000
    ]
];

if (!isset($plans[$plan])) {
    echo '<p class="text-red-500 text-center mt-10">Gói không hợp lệ!</p>';
    exit;
}
$planInfo = $plans[$plan];
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thanh toán VIP</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Montserrat', sans-serif; }</style>
</head>
<body class="bg-[#13141a] text-white min-h-screen">
    <?php include 'views/layouts/header.php'; ?>
    <section class="container mx-auto px-8 py-12">
        <div class="max-w-lg mx-auto bg-[#1e1e2d] p-8 rounded-lg shadow-lg text-center">
            <h1 class="text-2xl font-bold mb-6">Xác nhận thanh toán</h1>
            <p class="mb-4 text-lg">Bạn đang chọn: <span class="font-semibold text-yellow-400"><?= $planInfo['name'] ?></span></p>
            <p class="mb-6 text-xl">Tổng tiền: <span class="font-bold text-green-400"><?= number_format($planInfo['price'], 0, ',', '.') ?> VNĐ</span></p>
            <form action="index.php" method="POST">
                <input type="hidden" name="controller" value="user">
                <input type="hidden" name="action" value="upgradeVip">
                <input type="hidden" name="plan" value="<?= h($plan) ?>">
                <button type="submit" class="bg-green-500 hover:bg-green-600 text-white font-bold py-3 px-8 rounded-full text-lg transition duration-200">
                    Xác nhận thanh toán
                </button>
            </form>
            <a href="index.php?view=vip.php" class="block mt-6 text-gray-400 hover:text-white underline">Quay lại trang VIP</a>
        </div>
    </section>
    <?php include 'views/layouts/footer.php'; ?>
</body>
</html> 