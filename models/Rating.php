<?php
require_once 'models/Database.php';

class Rating {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function saveRating($user_id, $movie_id, $score) {
        $sql = "INSERT INTO ratings (user_id, movie_id, score)
                VALUES (?, ?, ?)
                ON DUPLICATE KEY UPDATE score = VALUES(score)";
        $result = $this->db->execute($sql, [$user_id, $movie_id, $score]);

        if ($result) {
            // Tính trung bình điểm và cập nhật vào bảng movies
            $updateSql = "UPDATE movies 
                        SET rating = (
                            SELECT ROUND(AVG(score), 1) 
                            FROM ratings 
                            WHERE movie_id = ?
                        )
                        WHERE movie_id = ?";
            $this->db->execute($updateSql, [$movie_id, $movie_id]);
        }

        return $result;
    }


}
?>
