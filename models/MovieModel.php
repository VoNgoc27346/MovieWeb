<?php

class MovieModel {
    private $apiKey = "9be884418bf4e79829b5014c71b06b52";

    private $conn;

    public function __construct() {
        $this->conn = new mysqli('localhost', 'root', '', 'movie_online');
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
        $this->conn->set_charset("utf8mb4");
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

    

    public function getPopularMovies($language = "vi-VN", $page = 1) {
        $url = "https://api.themoviedb.org/3/movie/popular?api_key={$this->apiKey}&language={$language}&page={$page}";

        $response = file_get_contents($url);
        if ($response === FALSE) {
            return [];
        }

        $data = json_decode($response, true);
        return $data['results'] ?? [];
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
