<?php
require_once 'Database.php';

class MovieModel {
    private $apiKey = "9be884418bf4e79829b5014c71b06b52";
    private $conn;

    public function __construct() {
        $this->conn = Database::getInstance()->getConnection();
    }

    public function insertMovie($data) {
        $stmt = $this->conn->prepare("INSERT INTO movies 
        (title, original_title, slug, description, poster, background, trailer_url, release_year, duration, quality, views, rating, status, premium, country_id)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        $stmt->execute([
            $data['title'],
            $data['original_title'],
            $data['slug'],
            $data['description'],
            $data['poster'],
            $data['background'],
            $data['trailer_url'],
            $data['release_year'],
            $data['duration'],
            $data['quality'],
            $data['views'],
            $data['rating'],
            $data['status'],
            $data['premium'],
            $data['country_id']
        ]);
    }

    public function getMovieById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM movies WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getMovieBySlug($slug) {
        $sql = "SELECT * FROM movies WHERE slug = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$slug]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    public function getPopularMovies() {
        $stmt = $this->conn->query("SELECT * FROM movies ORDER BY views DESC LIMIT 10");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getNewMovies($language = "vi-VN") {
        $url = "https://api.themoviedb.org/3/movie/now_playing?api_key={$this->apiKey}&language={$language}";
        $response = file_get_contents($url);
        $data = json_decode($response, true);
        return isset($data['results']) ? $data['results'] : [];
    }

    public function getUpcomingMovies($language = "vi-VN") {
        $url = "https://api.themoviedb.org/3/movie/upcoming?api_key={$this->apiKey}&language={$language}";
        $response = file_get_contents($url);
        $data = json_decode($response, true);
        return isset($data['results']) ? $data['results'] : [];
    }

    public function checkMovieExists($slug) {
        $stmt = $this->conn->prepare("SELECT COUNT(*) FROM movies WHERE slug = ?");
        $stmt->execute([$slug]);
        return $stmt->fetchColumn() > 0;
    }

    public static function getTopViewedMovies($limit = 10)
    {
        $db = Database::getInstance();
        $sql = "SELECT * FROM movies ORDER BY views DESC LIMIT ?";
        
        $pdo = $db->getConnection();
        $stmt = $pdo->prepare("SELECT * FROM movies ORDER BY views DESC LIMIT :limit");
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

class CountryModel {
    private $conn;

    public function __construct() {
        $this->conn = Database::getInstance()->getConnection();
    }

    public function getOrCreateCountryByName($name) {
        $slug = strtolower(str_replace(' ', '-', $name));

        $stmt = $this->conn->prepare("SELECT country_id FROM countries WHERE slug = ?");
        $stmt->execute([$slug]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return $row['country_id'];
        } else {
            $insert = $this->conn->prepare("INSERT INTO countries (name, slug) VALUES (?, ?)");
            $insert->execute([$name, $slug]);
            return $this->conn->lastInsertId();
        }
    }
}
