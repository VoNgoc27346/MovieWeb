<?php
class Comment {
    public static function getParentComments($movie_id, $episode_id = null) {
        global $conn;
        $sql = "SELECT c.*, u.username, u.avatar FROM comments c 
                JOIN users u ON c.user_id = u.user_id 
                WHERE c.movie_id = ? AND " . 
                ($episode_id ? "c.episode_id = ? AND " : "c.episode_id IS NULL AND ") . 
                "c.parent_id IS NULL ORDER BY c.created_at DESC";
        
        if ($episode_id) {
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ii", $movie_id, $episode_id);
        } else {
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $movie_id);
        }
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}
?>