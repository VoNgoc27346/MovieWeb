<?php
// Đường dẫn đúng đến file Database.php
require_once __DIR__ . '/models/Database.php';

/**
 * Chuyển hướng đến một URL
 */
function redirect($url) {
    header("Location: $url");
    exit;
}

/**
 * Kiểm tra xem người dùng đã đăng nhập hay chưa
 */
function isLoggedIn() {
    return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
}

/**
 * Kiểm tra xem người dùng có quyền VIP hay không
 */
function isVIP() {
    if (!isLoggedIn()) {
        return false;
    }
    
    // Nếu thông tin VIP đã có trong session, sử dụng nó
    if (isset($_SESSION['is_vip']) && isset($_SESSION['vip_expiry'])) {
        return $_SESSION['is_vip'] && strtotime($_SESSION['vip_expiry']) > time();
    }
    
    // Nếu không, truy vấn từ database và cập nhật session
    return refreshVIPStatus();
}

/**
 * Làm mới trạng thái VIP từ database
 * Trả về true nếu người dùng có VIP, false nếu không
 */
function refreshVIPStatus() {
    if (!isLoggedIn()) {
        return false;
    }
    
    $db = Database::getInstance();
    $user = $db->querySingle("SELECT is_vip, vip_expiry FROM users WHERE user_id = ?", [$_SESSION['user_id']]);
    
    if (is_array($user)) {
        // Kiểm tra nếu VIP đã hết hạn
        $isVipActive = $user['is_vip'] && strtotime($user['vip_expiry']) > time();
        
        // Nếu hết hạn, cập nhật database
        if ($user['is_vip'] && !$isVipActive) {
            $db->execute("UPDATE users SET is_vip = 0 WHERE user_id = ?", [$_SESSION['user_id']]);
            $user['is_vip'] = 0;
        }
        
        // Lưu vào session để tránh truy vấn liên tục
        $_SESSION['is_vip'] = $isVipActive ? 1 : 0;
        $_SESSION['vip_expiry'] = $user['vip_expiry'];
        
        return $isVipActive;
    }
    
    // Mặc định không phải VIP nếu không tìm thấy thông tin
    $_SESSION['is_vip'] = 0;
    $_SESSION['vip_expiry'] = null;
    return false;
}

/**
 * Hàm escape HTML để ngăn XSS
 */
function h($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

/**
 * Tạo URL an toàn
 */
function slug($string) {
    $string = preg_replace('/[^\p{L}\p{N}]/u', '-', $string);
    $string = preg_replace('/-+/', '-', $string);
    $string = trim($string, '-');
    return strtolower($string);
}

/**
 * Debug helper
 */
function debug($data) {
    echo '<pre>';
    var_dump($data);
    echo '</pre>';
}

/**
 * Cắt chuỗi với độ dài xác định và thêm dấu ba chấm
 */
function truncate($string, $length = 100) {
    if (strlen($string) > $length) {
        return substr($string, 0, $length) . '...';
    }
    return $string;
}

/**
 * Format date
 */
function formatDate($date) {
    return date('d/m/Y', strtotime($date));
}

/**
 * Tạo flash message
 */
function setFlashMessage($type, $message) {
    $_SESSION[$type] = $message;
}

/**
 * Làm mới trang
 */
function refreshPage() {
    header("Refresh:0");
    exit;
}

/**
 * Đặt cookie với thời gian sống
 */
function setCustomCookie($name, $value, $days = 30) {
    setcookie($name, $value, time() + (86400 * $days), "/");
}

/**
 * Lấy giá trị cookie
 */
function getCookie($name) {
    return isset($_COOKIE[$name]) ? $_COOKIE[$name] : null;
}

/**
 * Xóa cookie
 */
function deleteCookie($name) {
    setcookie($name, "", time() - 3600, "/");
}

/**
 * Khởi tạo hoặc khôi phục session
 */
function initSession() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
}

// Đảm bảo session được khởi tạo
initSession();

// Lấy thông tin người dùng hiện tại
function getCurrentUser() {
    if (isLoggedIn()) {
        return [
            'user_id' => $_SESSION['user_id'],
            'username' => $_SESSION['username']
        ];
    }
    return null;
}

// Yêu cầu đăng nhập
function requireLogin() {
    if (!isLoggedIn()) {
        $_SESSION['error'] = 'Vui lòng đăng nhập để tiếp tục';
        redirect('index.php?action=login');
        exit;
    }
}

// Thiết lập thông báo flash
function setFlash($key, $message) {
    $_SESSION['flash'][$key] = $message;
}

// Lấy và xóa thông báo flash
function getFlash($key) {
    if (isset($_SESSION['flash'][$key])) {
        $message = $_SESSION['flash'][$key];
        unset($_SESSION['flash'][$key]);
        return $message;
    }
    return null;
}
?>