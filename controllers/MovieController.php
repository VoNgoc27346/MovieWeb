<?php

require_once 'models/MovieModel.php';



class MovieController {

    private $movieModel;

    public function index() {
        $apiKey = '9be884418bf4e79829b5014c71b06b52';
        
        $apiUrl = "https://api.themoviedb.org/3/movie/popular?api_key=$apiKey";

        $movieModel = new MovieModel();
        // Lấy dữ liệu phim phổ biến
        $movies = $movieModel->getPopularMovies();
        // Lấy dữ liệu phim mới và phim sắp chiếu
        $newMovies = $movieModel->getNewMovies();
        $upcomingMovies = $movieModel->getUpcomingMovies();

        

        $bannerData = $this->getBannerFromApi($apiUrl);

        // Gửi dữ liệu đến view
        require_once 'views/movies/home.php';
    }

    private function getBannerFromApi($url) {
        // Sử dụng cURL để lấy dữ liệu từ API
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($ch);
        curl_close($ch);

        // Chuyển đổi JSON thành mảng PHP
        $bannerData = json_decode($response, true);

        return $bannerData;
    }

    public function __construct() {
        $this->movieModel = new MovieModel();
    }

    public function fetchMoviesFromTMDB() {
        $apiKey = '9be884418bf4e79829b5014c71b06b52';
        $url = "https://api.themoviedb.org/3/movie/popular?api_key=$apiKey&language=vi-VN&page=1";

        // Gửi yêu cầu GET
        $response = file_get_contents($url);
        $moviesData = json_decode($response, true);

        if (!empty($moviesData['results'])) {
            foreach ($moviesData['results'] as $movie) {
                // Lấy trailer URL
                $trailerUrl = $this->getTrailerUrl($movie['id'], $apiKey);

                // Map dữ liệu phim
                $data = [
                    'title' => $movie['title'],
                    'original_title' => $movie['original_title'],
                    'slug' => $this->slugify($movie['title']),
                    'description' => $movie['overview'],
                    'poster' => 'https://image.tmdb.org/t/p/w500' . $movie['poster_path'],
                    'background' => 'https://image.tmdb.org/t/p/w500' . $movie['backdrop_path'],
                    'trailer_url' => $trailerUrl,
                    'release_year' => intval(substr($movie['release_date'], 0, 4)),
                    'duration' => 120, // TMDB popular API không trả về duration
                    'quality' => 'HD',
                    'views' => rand(1000, 100000),
                    'rating' => $movie['vote_average'],
                    'status' => 'completed',
                    'premium' => 0,
                    'country_id' => 1, // Tạm thời gán cứng
                ];

                $this->movieModel->insertMovie($data);
            }
            echo "Đã thêm phim và trailer thành công!";
        } else {
            echo "Không lấy được dữ liệu phim!";
        }
    }

    private function getTrailerUrl($movieId, $apiKey) {
        $url = "https://api.themoviedb.org/3/movie/$movieId/videos?api_key=$apiKey&language=vi-VN";
        $response = file_get_contents($url);
        $videosData = json_decode($response, true);

        if (!empty($videosData['results'])) {
            foreach ($videosData['results'] as $video) {
                if ($video['type'] === 'Trailer' && $video['site'] === 'YouTube') {
                    return 'https://www.youtube.com/watch?v=' . $video['key'];
                }
            }
        }
        return null; // Không có trailer
    }

    private function slugify($text) {
        $text = strtolower($text);
        $text = preg_replace('/[^a-z0-9]+/i', '-', $text);
        $text = trim($text, '-');
        return $text;
    }
    
}
?>