<?php
class User {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    public function login($username, $password) {
        $sql = "SELECT * FROM users WHERE username = ?";
        $user = $this->db->querySingle($sql, [$username]);
        
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        
        return false;
    }
    
    public function register($username, $email, $password, $role) {
        // Kiểm tra username đã tồn tại chưa
        $sql = "SELECT COUNT(*) as count FROM users WHERE username = ? OR email = ?";
        $result = $this->db->querySingle($sql, [$username, $email]);
        
        if ($result['count'] > 0) {
            return false;
        }
        
        // Hash password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        
        // Thêm user mới
        $sql = "INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)";
        return $this->db->execute($sql, [$username, $email, $hashedPassword, $role]);
    }
}
?>