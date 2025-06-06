<?php
require_once 'models/MovieModel.php';
require_once 'models/Comment.php';

class MovieController {
    private $movieModel;
    private $commentModel;

    private function render($viewPath, $data = []) {
        extract($data); // chuyển mảng thành biến
        require_once 'views/' . $viewPath . '.php';
    }

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
        $this->commentModel = new Comment();
    }

    public function fetchMoviesFromTMDB() {
        $apiKey = '9be884418bf4e79829b5014c71b06b52';
        $url = "https://api.themoviedb.org/3/movie/popular?api_key=$apiKey&language=vi-VN&page=5";

        // Gửi yêu cầu GET
        $response = file_get_contents($url);
        $moviesData = json_decode($response, true);

        if (!empty($moviesData['results'])) {
            foreach ($moviesData['results'] as $movie) {
                $slug = $this->slugify($movie['title']);
            
                if ($this->movieModel->checkMovieExists($slug)) {
                    // Nếu phim đã tồn tại -> bỏ qua
                    continue;
                }
            
                // Lấy trailer URL
                $trailerUrl = $this->getTrailerUrl($movie['id'], $apiKey);
            
                // Map dữ liệu phim
                $data = [
                    'title' => $movie['title'],
                    'original_title' => $movie['original_title'],
                    'slug' => $slug,
                    'description' => $movie['overview'],
                    'poster' => 'https://image.tmdb.org/t/p/w500' . $movie['poster_path'],
                    'background' => 'https://image.tmdb.org/t/p/w500' . $movie['backdrop_path'],
                    'trailer_url' => $trailerUrl,
                    'release_year' => intval(substr($movie['release_date'], 0, 4)),
                    'duration' => 120,
                    'quality' => 'HD',
                    'views' => rand(1000, 100000),
                    'rating' => $movie['vote_average'],
                    'status' => 'completed',
                    'premium' => 0,
                    'country_id' => 1,
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
    
    public function home() {
        // Load tất cả phim hoặc danh sách trang chủ
        require_once 'views/home.php'; // File trang chủ
    }

    public function watch($slug) {
        // Tìm phim theo slug
        $movie = $this->movieModel->getMovieBySlug($slug);

        if ($movie && isset($movie['movie_id'])) {
            $movie_id = (int)$movie['movie_id'];
            $comments = $this->getComments($movie_id);

            $this->render('movies/watch', [
                'movie' => $movie,
                'comments' => $comments
            ]);
        } else {
            echo "Phim không tồn tại hoặc thiếu ID.";
        }
    }

    public function getComments($movie_id, $episode_id = null) {
        return $this->commentModel->getComments($movie_id, $episode_id);
    }

    public function popularMovies() {
        $movieModel = new MovieModel();
        $movies = $movieModel->getPopularMovies();

        // Truyền biến $movies vào View
        require_once 'views/movies/home.php';
    }

    public function show($movie_id, $episode_id = null) {
        $movie = $this->movieModel->getMovieById($movie_id);
        // Lấy thông tin phim, tập phim, ...
        
        // Lấy danh sách bình luận
        $comments = $this->getComments($movie_id, $episode_id);

        // Render view với dữ liệu bình luận
        $data = [
            'movie' => $movie,
            'episode' => $episode ?? null,
            'comments' => $comments,
            // Các dữ liệu khác...
        ];
        
        $this->render('movie/detail', $data);
    }
}
?>