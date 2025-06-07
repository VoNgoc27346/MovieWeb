<?php
require_once 'Database.php';

class Favorite {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    /**
     * Thêm phim vào danh sách yêu thích
     */
    public function addFavorite($userId, $movieId) {
        // Kiểm tra xem phim đã được yêu thích chưa
        if ($this->isFavorite($userId, $movieId)) {
            return false; // Đã yêu thích rồi
        }
        
        $sql = "INSERT INTO favorites (user_id, movie_id, created_at) VALUES (?, ?, NOW())";
        return $this->db->execute($sql, [$userId, $movieId]);
    }
    
    /**
     * Xóa phim khỏi danh sách yêu thích
     */
    public function removeFavorite($userId, $movieId) {
        $sql = "DELETE FROM favorites WHERE user_id = ? AND movie_id = ?";
        return $this->db->execute($sql, [$userId, $movieId]);
    }
    
    /**
     * Kiểm tra xem phim có trong danh sách yêu thích không
     */
    public function isFavorite($userId, $movieId) {
        $sql = "SELECT COUNT(*) as count FROM favorites WHERE user_id = ? AND movie_id = ?";
        $result = $this->db->querySingle($sql, [$userId, $movieId]);
        
        if (isset($result['count'])) {
            return $result['count'] > 0;
        }
        
        return false;
    }
    
    /**
     * Lấy danh sách phim yêu thích của người dùng
     */
    public function getUserFavorites($userId, $limit = 10, $offset = 0) {
        // Convert to integers to ensure correct types
        $limit = (int) $limit;
        $offset = (int) $offset;
        
        $sql = "SELECT m.* FROM favorites f
                JOIN movies m ON f.movie_id = m.movie_id
                WHERE f.user_id = ?
                ORDER BY f.created_at DESC
                LIMIT $limit OFFSET $offset";
                
        return $this->db->query($sql, [$userId]);
    }
    
    /**
     * Đếm số lượng phim yêu thích của người dùng
     */
    public function countUserFavorites($userId) {
        $sql = "SELECT COUNT(*) as count FROM favorites WHERE user_id = ?";
        $result = $this->db->querySingle($sql, [$userId]);
        
        if (isset($result['count'])) {
            return $result['count'];
        }
        
        return 0;
    }
    
    /**
     * Lấy số lượng lượt thích của một phim
     */
    public function getMovieFavoritesCount($movieId) {
        $sql = "SELECT COUNT(*) as count FROM favorites WHERE movie_id = ?";
        $result = $this->db->querySingle($sql, [$movieId]);
        
        if (isset($result['count'])) {
            return $result['count'];
        }
        
        return 0;
    }
    
    /**
     * Toggle yêu thích (thêm nếu chưa có, xóa nếu đã có)
     */
    public function toggleFavorite($userId, $movieId) {
        try {
            if ($this->isFavorite($userId, $movieId)) {
                // Nếu đã yêu thích, xóa khỏi danh sách
                $result = $this->removeFavorite($userId, $movieId);
                return $result ? 'removed' : false;
            } else {
                // Nếu chưa yêu thích, thêm vào danh sách
                $result = $this->addFavorite($userId, $movieId);
                return $result ? 'added' : false;
            }
        } catch (Exception $e) {
            // Ghi log lỗi nếu cần
            error_log("Lỗi toggle favorite: " . $e->getMessage());
            return false;
        }
    }
} 