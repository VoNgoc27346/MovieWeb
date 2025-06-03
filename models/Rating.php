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
        return $this->db->execute($sql, [$user_id, $movie_id, $score]);
    }
}
?>
