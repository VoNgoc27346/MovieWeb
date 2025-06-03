<?php
require_once 'helpers.php';
require_once 'models/User.php';

class UserController {
    private $userModel;
    
    public function __construct() {
        $this->userModel = new User();
    }
    
    public function login() {
        // Lấy URL cần redirect sau đăng nhập
        $redirectUrl = isset($_GET['redirect']) ? $_GET['redirect'] : 'index.php';

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = trim($_POST['username']);
            $password = $_POST['password'];
            
            $user = $this->userModel->login($username, $password);
            
            if ($user) {
                // Thiết lập session
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['is_logged_in'] = true;
                
                $_SESSION['success'] = 'Đăng nhập thành công!';
                redirect('index.php');
            } else {
                $_SESSION['error'] = 'Tên đăng nhập hoặc mật khẩu không đúng';
                //redirect('login.php');
                require_once 'views/auth/login.php';
            }
        } else {
            // Hiển thị form đăng nhập
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

            // Validate
            if (empty($username) || empty($email) || empty($password)) {
                $_SESSION['error'] = 'Vui lòng điền đầy đủ thông tin';
                redirect('index.php?controller=user&action=register');
                return;
            }

            if ($password !== $confirmPassword) {
                $_SESSION['error'] = 'Mật khẩu xác nhận không khớp';
                redirect('index.php?controller=user&action=register');
                return;
            }

            $result = $this->userModel->register($username, $email, $password, $role);

            if ($result) {
                $_SESSION['success'] = 'Đăng ký thành công! Vui lòng đăng nhập';
                redirect('index.php?controller=user&action=login');
            } else {
                $_SESSION['error'] = 'Tên đăng nhập hoặc email đã tồn tại';
                redirect('index.php?controller=user&action=register');
            }
        } else {
            require_once 'views/auth/register.php';
        }
    }

    
    public function logout() {
        // Xóa session
        unset($_SESSION['user_id']);
        unset($_SESSION['username']);
        unset($_SESSION['is_logged_in']);
        
        session_destroy();
        redirect('index.php');
    }
}
?>