<?php
session_start();
header('Content-Type: text/html; charset=UTF-8');
mb_internal_encoding('UTF-8');

// Kết nối cơ sở dữ liệu
$host = 'localhost';
$dbname = 'movie_online';
$username = 'root';
$password = '';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->exec("SET NAMES utf8mb4");
    $conn->exec("SET CHARACTER SET utf8mb4");
} catch (PDOException $e) {
    die("Kết nối thất bại: " . $e->getMessage());
}

// Giả lập thông tin người dùng (trong thực tế, bạn cần lấy từ session đăng nhập)
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 1;
$user_role = isset($_SESSION['user_role']) ? $_SESSION['user_role'] : 'regular';

// Thông báo
$alert = [
    'type' => '',
    'message' => '',
    'show_return' => false
];

if (isset($_SESSION['alert'])) {
    $alert = array_merge($alert, $_SESSION['alert']);
    unset($_SESSION['alert']);
}

// Xử lý tạo yêu cầu thanh toán
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] === 'pay') {
    $package = filter_var(trim($_POST['package']), FILTER_SANITIZE_STRING);
    $payment_method = filter_var(trim($_POST['payment_method']), FILTER_SANITIZE_STRING);
    $amount = 0;

    // Xác định giá tiền dựa trên gói
    if ($package === 'monthly') {
        $amount = 50000; // 50,000 VNĐ/tháng
    } elseif ($package === 'yearly') {
        $amount = 500000; // 500,000 VNĐ/năm
    }

    try {
        // Lưu đơn hàng vào cơ sở dữ liệu với trạng thái 'pending'
        $stmt = $conn->prepare("INSERT INTO orders (user_id, package, amount, status, order_date, created_at) VALUES (:user_id, :package, :amount, 'pending', CURDATE(), NOW())");
        $stmt->execute([
            'user_id' => $user_id,
            'package' => $package,
            'amount' => $amount
        ]);
        $order_id = $conn->lastInsertId();

        if ($payment_method === 'momo') {
            // Giả lập thanh toán Momo
            $success = rand(0, 1); // 50% cơ hội thành công
            
            if ($success) {
                // Cập nhật trạng thái đơn hàng thành công
                $stmt = $conn->prepare("UPDATE orders SET status = 'completed' WHERE id = :order_id");
                $stmt->execute(['order_id' => $order_id]);
                
                $_SESSION['alert'] = [
                    'type' => 'success',
                    'message' => 'Thanh toán thành công! Tài khoản của bạn đã được nâng cấp VIP.',
                    'show_return' => true
                ];
            } else {
                // Cập nhật trạng thái đơn hàng thất bại
                $stmt = $conn->prepare("UPDATE orders SET status = 'failed' WHERE id = :order_id");
                $stmt->execute(['order_id' => $order_id]);
                
                $_SESSION['alert'] = [
                    'type' => 'error',
                    'message' => 'Thanh toán thất bại. Vui lòng thử lại sau.',
                    'show_return' => true
                ];
            }
            
            header("Location: NangVip.php");
            exit;
        }
    } catch (PDOException $e) {
        $_SESSION['alert'] = [
            'type' => 'error',
            'message' => 'Có lỗi xảy ra: ' . $e->getMessage(),
            'show_return' => true
        ];
        header("Location: NangVip.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nâng Cấp VIP - Movie Phim</title>
    <link rel="stylesheet" href="../../public/css/nangvip.css">
</head>
<body>
    <div class="container">
        <header class="vip-header">
            <h1>Nâng Cấp VIP - Movie Phim</h1>
            <nav class="vip-nav">
                <a class="nav-link" href="../../index.php">Trang Chủ</a>
                <?php if ($user_role === 'admin'): ?>
                    <a class="nav-link" href="trangAdmin.php?section=films">Quản Lý Phim</a>
                    <a class="nav-link" href="trangAdmin.php?section=users">Quản Lý Người Dùng</a>
                    <a class="nav-link" href="trangAdmin.php?section=orders">Quản Lý Nâng Cấp VIP</a>
                    <a class="nav-link" href="trangAdmin.php?section=categories">Quản Lý Danh Mục</a>
                    <a class="nav-link" href="trangAdmin.php?section=contents">Quản Lý Nội Dung</a>
                <?php endif; ?>
                <a class="nav-link active" href="NangVip.php">Nâng Cấp VIP</a>
                <a class="nav-link" href="logout.php">Đăng Xuất</a>
            </nav>
        </header>

        <?php if ($alert['message']): ?>
            <div class="alert alert-<?php echo $alert['type']; ?>">
                <p><?php echo htmlspecialchars($alert['message']); ?></p>
                <?php if ($alert['show_return']): ?>
                    <a href="home.php" class="return-btn">Quay lại Trang Chủ</a>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <section class="pricing-section">
            <h2>Chọn Gói Nâng Cấp VIP</h2>
            <div class="pricing-cards">
                <div class="pricing-card">
                    <h3>Gói Tháng</h3>
                    <p class="price">50,000 VNĐ</p>
                    <ul>
                        <li>Truy cập tất cả phim VIP</li>
                        <li>Không quảng cáo</li>
                        <li>Chất lượng video HD</li>
                    </ul>
                    <button onclick="openModal('monthly')">Nâng Cấp</button>
                </div>
                <div class="pricing-card">
                    <h3>Gói Năm</h3>
                    <p class="price">500,000 VNĐ</p>
                    <ul>
                        <li>Truy cập tất cả phim VIP</li>
                        <li>Không quảng cáo</li>
                        <li>Chất lượng video HD</li>
                        <li>Tiết kiệm 17% so với gói tháng</li>
                    </ul>
                    <button onclick="openModal('yearly')">Nâng Cấp</button>
                </div>
            </div>
        </section>

        <!-- Modal xác nhận thanh toán -->
        <div id="paymentModal" class="modal">
            <div class="modal-content">
                <span class="close-modal" onclick="closeModal()">×</span>
                <h3>Xác Nhận Thanh Toán</h3>
                <p id="modalPackage"></p>
                <p id="modalAmount"></p>
                <form id="paymentForm" method="POST">
                    <input type="hidden" name="action" value="pay">
                    <input type="hidden" name="package" id="packageInput">
                    <div class="payment-methods">
                        <label><input type="radio" name="payment_method" value="momo" required> Thanh toán qua Momo (Giả lập)</label>
                    </div>
                    <button type="submit" class="confirm-btn">Xác Nhận</button>
                    <button type="button" class="cancel-btn" onclick="closeModal()">Hủy</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openModal(package) {
            const modal = document.getElementById('paymentModal');
            const packageText = document.getElementById('modalPackage');
            const amountText = document.getElementById('modalAmount');
            const packageInput = document.getElementById('packageInput');

            packageInput.value = package;
            packageText.textContent = `Gói: ${package === 'monthly' ? 'Gói Tháng' : 'Gói Năm'}`;
            amountText.textContent = `Số tiền: ${package === 'monthly' ? '50,000 VNĐ' : '500,000 VNĐ'}`;
            modal.style.display = 'flex';
        }

        function closeModal() {
            const modal = document.getElementById('paymentModal');
            modal.style.display = 'none';
        }

        window.onclick = function(event) {
            const modal = document.getElementById('paymentModal');
            if (event.target == modal) {
                modal.style.display = 'none';
            }
        }
    </script>
</body>
</html>