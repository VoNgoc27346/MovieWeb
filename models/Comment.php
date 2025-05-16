<?php

class Comment {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    // Lấy tất cả bình luận gốc (không phải reply) cho phim/tập phim
    public function getComments($movie_id, $episode_id = null) {
        $sql = "SELECT c.*, u.username 
                FROM comments c 
                JOIN users u ON c.user_id = u.user_id 
                WHERE c.movie_id = ? AND c.parent_id IS NULL";
        
        $params = [$movie_id];
        
        if ($episode_id) {
            $sql .= " AND c.episode_id = ?";
            $params[] = $episode_id;
        } else {
            $sql .= " AND c.episode_id IS NULL";
        }
        
        $sql .= " ORDER BY c.created_at DESC";
        
        return $this->db->query($sql, $params);
    }
    
    // Lấy các reply cho một comment
    public static function getReplies($parent_id) {
        $db = Database::getInstance();
        $sql = "SELECT c.*, u.username 
                FROM comments c 
                JOIN users u ON c.user_id = u.user_id 
                WHERE c.parent_id = ? 
                ORDER BY c.created_at ASC";
        
        return $db->query($sql, [$parent_id]);
    }
    
    // Thêm bình luận mới
    public function addComment($content, $user_id, $movie_id, $episode_id = null, $parent_id = null) {
        $sql = "INSERT INTO comments (content, user_id, movie_id, episode_id, parent_id) 
                VALUES (?, ?, ?, ?, ?)";
        
        return $this->db->execute($sql, [$content, $user_id, $movie_id, $episode_id, $parent_id]);
    }
    
    // Xóa bình luận
    public function deleteComment($comment_id, $user_id) {
        // Chỉ cho phép người dùng xóa comment của họ hoặc admin
        $sql = "DELETE FROM comments 
                WHERE comment_id = ? AND 
                (user_id = ? OR ? IN (SELECT user_id FROM users WHERE role = 'admin'))";
        
        return $this->db->execute($sql, [$comment_id, $user_id, $user_id]);
    }
}

?>