<?php

class MovieModel {
    private $apiKey = "9be884418bf4e79829b5014c71b06b52";

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
