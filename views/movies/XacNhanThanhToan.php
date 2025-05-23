<?php
session_start();

// Kết nối cơ sở dữ liệu
$host = 'localhost';
$dbname = 'movie_online';
$username = 'root';
$password = '';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Kết nối thất bại: " . $e->getMessage());
}

// Xử lý giả lập thanh toán Momo
if (isset($_GET['callback']) && $_GET['callback'] === 'momo_fake') {
    $order_id = $_GET['order_id'];
    $result = $_GET['result'];

    if ($result === 'success') {
        // Chỉ cập nhật trạng thái đơn hàng thành 'completed'
        $stmt = $conn->prepare("UPDATE orders SET status = 'pending', updated_at = NOW() WHERE order_id = :order_id");
        $stmt->execute(['order_id' => $order_id]);
        $alert = ['type' => 'success', 'message' => 'Đã xác nhận thanh toán, đang chờ xử lý. Bạn có thể quay lại trang chủ.', 'show_return' => true];
    } else {
        $stmt = $conn->prepare("UPDATE orders SET status = 'failed', updated_at = NOW() WHERE order_id = :order_id");
        $stmt->execute(['order_id' => $order_id]);
        $alert = ['type' => 'danger', 'message' => 'Giả lập thanh toán Momo thất bại.'];
    }

    $_SESSION['alert'] = $alert;
    header('Location: NangVip.php');
    exit;
}

// Lấy thông tin đơn hàng từ URL
$order_id = isset($_GET['order_id']) ? $_GET['order_id'] : '';
$amount = isset($_GET['amount']) ? $_GET['amount'] : 0;
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giả Lập Thanh Toán Momo</title>
    <link rel="stylesheet" href="../../public/css/nangvip.css">
</head>
<body>
    <div class="container">
        <div class="fake-payment">
            <img src="https://www.momo.vn/images/logo.png" alt="Logo Momo" class="momo-logo">
            <h2>Giả Lập Thanh Toán Qua Momo</h2>
            <p>Đơn hàng: #<?php echo htmlspecialchars($order_id); ?></p>
            <p>Số tiền: <?php echo number_format($amount, 0, ',', '.') . ' VNĐ'; ?></p>
            <div class="qr-code">
                <p>Mã QR Momo:</p>
                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/d/d0/QR_code_for_mobile_English_Wikipedia.svg/1200px-QR_code_for_mobile_English_Wikipedia.svg.png" alt="Mã QR Giả Lập" class="fake-qr-image">
            </div>
            <p>Vui lòng "quét mã" bằng cách chọn một trong các tùy chọn dưới đây:</p>
            <div class="payment-actions">
                <a href="?callback=momo_fake&order_id=<?php echo $order_id; ?>&result=success" class="confirm-btn">Xác Nhận Thanh Toán</a>
                <a href="?callback=momo_fake&order_id=<?php echo $order_id; ?>&result=fail" class="cancel-btn">Thanh Toán Thất Bại</a>
            </div>
        </div>
    </div>
</body>
</html>