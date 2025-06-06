<?php
require_once 'Database.php';

class User {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    public function login($username, $password) {
        $sql = "SELECT user_id, username, email, password, is_vip, vip_expiry FROM users WHERE username = ?";
        $user = $this->db->querySingle($sql, [$username]);
        
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        
        return false;
    }
    
    public function register($username, $email, $password, $role = 'member') {
        // Kiểm tra xem username hoặc email đã tồn tại chưa
        $sql = "SELECT COUNT(*) as count FROM users WHERE username = ? OR email = ?";
        $result = $this->db->querySingle($sql, [$username, $email]);
        
        if ($result['count'] > 0) {
            return false;
        }
        
        // Mã hóa mật khẩu
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        
        // Thêm người dùng mới
        $sql = "INSERT INTO users (username, email, password, role, created_at) 
                VALUES (?, ?, ?, ?, NOW())";
        
        return $this->db->execute($sql, [$username, $email, $hashedPassword, $role]);
    }
    
    public function getUserById($userId) {
        $sql = "SELECT * FROM users WHERE user_id = ?";
        return $this->db->querySingle($sql, [$userId]);
    }
    
    public function updateUser($userId, $data) {
        $fields = [];
        $values = [];
        
        foreach ($data as $key => $value) {
            $fields[] = "$key = ?";
            $values[] = $value;
        }
        
        $values[] = $userId;
        
        $sql = "UPDATE users SET " . implode(', ', $fields) . " WHERE user_id = ?";
        return $this->db->execute($sql, $values);
    }
    
    public function execute($sql, $params = []) {
        return $this->db->execute($sql, $params);
    }
    
    public function upgradeVip($userId, $months = 1) {
        try {
            // Lấy thông tin người dùng hiện tại
            $user = $this->getUserById($userId);
            if (!$user) {
                return false;
            }

            // Tính toán ngày hết hạn mới
            $currentDate = new DateTime();
            
            // Nếu đã là VIP, thêm tháng vào ngày hết hạn hiện tại
            if ($user['is_vip'] && strtotime($user['vip_expiry']) > time()) {
                $expiryDate = new DateTime($user['vip_expiry']);
            } else {
                $expiryDate = $currentDate;
            }
            
            // Thêm số tháng đăng ký
            $expiryDate->modify("+{$months} months");
            $expiryDateStr = $expiryDate->format('Y-m-d H:i:s');

            // Cập nhật trạng thái VIP và ngày hết hạn
            $sql = "UPDATE users SET is_vip = 1, vip_expiry = ? WHERE user_id = ?";
            $result = $this->db->execute($sql, [$expiryDateStr, $userId]);
            
            if ($result) {
                // Cập nhật session với thông tin VIP mới
                $_SESSION['is_vip'] = 1;
                $_SESSION['vip_expiry'] = $expiryDateStr;
                return true;
            }
            
            return false;
        } catch (Exception $e) {
            error_log('Error upgrading VIP status: ' . $e->getMessage());
            return false;
        }
    }
}
?>