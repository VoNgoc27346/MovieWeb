<?php
require_once 'Database.php';

class MovieModel {
    private $apiKey = "9be884418bf4e79829b5014c71b06b52";

    private $conn;
    

    public function __construct() {
        $this->conn = Database::getConnection();
    }

    public function insertMovie($data) {
        $stmt = $this->conn->prepare("INSERT INTO movies 
        (title, original_title, slug, description, poster, background, trailer_url, release_year, duration, quality, views, rating, status, premium, country_id)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        $stmt->bind_param("sssssssiiisdsii",
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
        );

        $stmt->execute();
        $stmt->close();
    }

    public function getMovieBySlug($slug) {
        $stmt = $this->conn->prepare("SELECT * FROM movies WHERE slug = ?");
        $stmt->bind_param("s", $slug);
        $stmt->execute();
        $result = $stmt->get_result();
        $movie = $result->fetch_assoc();
        $stmt->close();
        return $movie;
    }

    public function getPopularMovies()
    {
        // Lấy 10 phim có view_count cao nhất
        $sql = "SELECT * FROM movies ORDER BY views DESC LIMIT 10";
        $result = $this->conn->query($sql);

        $movies = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $movies[] = $row;
            }
        }
        return $movies;
    }

    // Lấy phim mới
    public function getNewMovies($language = "vi-VN") {
        $url = "https://api.themoviedb.org/3/movie/now_playing?api_key={$this->apiKey}&language={$language}";

        $response = file_get_contents($url);
        $data = json_decode($response, true);
        return isset($data['results']) ? $data['results'] : [];
    }

    // Lấy phim sắp chiếu
    public function getUpcomingMovies($language = "vi-VN") {
        $url = "https://api.themoviedb.org/3/movie/upcoming?api_key={$this->apiKey}&language={$language}";

        $response = file_get_contents($url);
        $data = json_decode($response, true);
        return isset($data['results']) ? $data['results'] : [];
    }

    public function checkMovieExists($slug) {
        $stmt = $this->conn->prepare("SELECT id FROM movies WHERE slug = ?");
        $stmt->bind_param("s", $slug);
        $stmt->execute();
        $stmt->store_result();
        $exists = $stmt->num_rows > 0;
        $stmt->close();
        return $exists;
    }
    
}

class CountryModel {
    private $conn;

    public function __construct() {
        $this->conn = new mysqli('localhost', 'root', '', 'movie_online');
    }

    public function getOrCreateCountryByName($name) {
        $slug = strtolower(str_replace(' ', '-', $name));
        $stmt = $this->conn->prepare("SELECT country_id FROM countries WHERE slug = ?");
        $stmt->bind_param("s", $slug);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            return $row['country_id'];
        } else {
            $insert = $this->conn->prepare("INSERT INTO countries (name, slug) VALUES (?, ?)");
            $insert->bind_param("ss", $name, $slug);
            $insert->execute();
            return $insert->insert_id;
        }
    }
}
