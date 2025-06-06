<?php

class UserModel {
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

    public function login($username, $password) {
        $sql = "SELECT user_id, username, email, password, is_vip, vip_expiry FROM users WHERE username = ?";
        $user = $this->db->querySingle($sql, [$username]);
        
        if ($user && password_verify($password, $user['password'])) {
            // Lưu thông tin người dùng vào session
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['email'] = $user['email'];
            
            // Lưu thông tin VIP vào session
            $_SESSION['is_vip'] = $user['is_vip'];
            $_SESSION['vip_expiry'] = $user['vip_expiry'];
            
            // Kiểm tra nếu VIP hết hạn thì cập nhật
            if ($user['is_vip'] && strtotime($user['vip_expiry']) < time()) {
                $this->db->execute("UPDATE users SET is_vip = 0 WHERE user_id = ?", [$user['user_id']]);
                $_SESSION['is_vip'] = 0;
            }
            
            return true;
        }
        
        return false;
    }
} 