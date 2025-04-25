<?php

require_once 'models/MovieModel.php';



class MovieController {
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
}
?>