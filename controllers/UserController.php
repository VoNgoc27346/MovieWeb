<?php
require_once 'helpers.php';
require_once 'models/User.php';

class UserController {
    private $userModel;
    
    public function __construct() {
        $this->userModel = new User();
    }
    
    public function login() {
        $redirectUrl = isset($_GET['redirect']) ? $_GET['redirect'] : 'index.php';

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = trim($_POST['username']);
            $password = $_POST['password'];
            
            $user = $this->userModel->login($username, $password);
            
            if ($user) {
                // Lưu thông tin người dùng vào session
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['is_logged_in'] = true;
                
                // Lưu thông tin VIP vào session
                $_SESSION['is_vip'] = isset($user['is_vip']) ? $user['is_vip'] : 0;
                $_SESSION['vip_expiry'] = isset($user['vip_expiry']) ? $user['vip_expiry'] : null;
                
                // Kiểm tra nếu VIP hết hạn thì cập nhật
                if (isset($user['is_vip']) && $user['is_vip'] && 
                    isset($user['vip_expiry']) && strtotime($user['vip_expiry']) < time()) {
                    $this->userModel->execute("UPDATE users SET is_vip = 0 WHERE user_id = ?", [$user['user_id']]);
                    $_SESSION['is_vip'] = 0;
                }
                
                $_SESSION['success'] = 'Đăng nhập thành công!';
                redirect('index.php');
            } else {
                $_SESSION['error'] = 'Tên đăng nhập hoặc mật khẩu không đúng';
                require_once 'views/auth/login.php';
            }
        } else {
            require_once 'views/auth/login.php';
        }
    }
    
    public function register() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = trim($_POST['username']);
            $email = trim($_POST['email']);
            $password = $_POST['password'];
            $confirmPassword = $_POST['confirm_password'];
            $role = 'member';

            if (empty($username) || empty($email) || empty($password)) {
                $_SESSION['error'] = 'Vui lòng điền đầy đủ thông tin';
                redirect('index.php?controller=user');
                return;
            }

            if ($password !== $confirmPassword) {
                $_SESSION['error'] = 'Mật khẩu xác nhận không khớp';
                redirect('index.php?controller=user');
                return;
            }

            $result = $this->userModel->register($username, $email, $password, $role);

            if ($result) {
                $_SESSION['success'] = 'Đăng ký thành công! Vui lòng đăng nhập';
                redirect('index.php');
            } else {
                $_SESSION['error'] = 'Tên đăng nhập hoặc email đã tồn tại';
                redirect('register.php');
            }
        } else {
            require_once 'views/auth/register.php';
        }

    }
    
    public function logout() {
        // Lưu thông báo trước khi xóa session
        $message = 'Đã đăng xuất thành công!';
        
        // Xóa tất cả các biến session
        $_SESSION = array();
        
        // Hủy session
        session_destroy();
        
        // Đảm bảo không có dữ liệu nào được lưu trữ trong cookie
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        
        // Bắt đầu session mới để hiển thị thông báo
        session_start();
        $_SESSION['success'] = $message;
        
        // Chuyển hướng về trang chủ
        redirect('index.php');
    }

    public function upgradeVip() {
        if (!isLoggedIn()) {
            redirect('index.php?controller=user&action=login');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user_id = $_SESSION['user_id'];
            $plan = $_POST['plan'];
            
            // Tính toán thời hạn VIP
            $currentDate = new DateTime();
            
            // Nếu đã là VIP, thêm thời gian vào ngày hết hạn hiện tại
            if (isset($_SESSION['is_vip']) && $_SESSION['is_vip'] && 
                isset($_SESSION['vip_expiry']) && strtotime($_SESSION['vip_expiry']) > time()) {
                $currentDate = new DateTime($_SESSION['vip_expiry']);
            }
            
            switch ($plan) {
                case '1month':
                    $currentDate->modify('+1 month');
                    break;
                case '3month':
                    $currentDate->modify('+3 months');
                    break;
                case '1year':
                    $currentDate->modify('+1 year');
                    break;
                default:
                    $_SESSION['error'] = 'Gói không hợp lệ';
                    redirect('index.php?view=vip.php');
                    return;
            }

            $expiryDate = $currentDate->format('Y-m-d H:i:s');

            // Cập nhật trạng thái VIP trong CSDL
            $sql = "UPDATE users SET is_vip = 1, vip_expiry = ? WHERE user_id = ?";
            $result = $this->userModel->execute($sql, [$expiryDate, $user_id]);

            if ($result) {
                // Cập nhật thông tin VIP trong session
                $_SESSION['is_vip'] = 1;
                $_SESSION['vip_expiry'] = $expiryDate;
                
                $_SESSION['success'] = 'Chúc mừng! Bạn đã nâng cấp tài khoản VIP thành công. Hãy tận hưởng các quyền lợi đặc biệt!';
                redirect('index.php');
            } else {
                $_SESSION['error'] = 'Đã có lỗi khi nâng cấp VIP. Vui lòng thử lại.';
                redirect('index.php?view=vip.php');
            }
        } else {
            require_once 'views/vip.php';
        }
    }
}
?>