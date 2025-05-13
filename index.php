<?php
require_once 'controllers/MovieController.php';
require_once 'models/MovieModel.php';

// Bắt request
$controller = $_GET['controller'] ?? 'movie';
$action = $_GET['action'] ?? 'index';
$slug = $_GET['slug'] ?? '';

if ($controller == 'movie') {
    $movieController = new MovieController();

    if ($action == 'watch' && !empty($slug)) {
        $movieController->watch($slug); // Nếu action là watch thì chỉ chạy watch
    } else {
        // Nếu không có yêu cầu gì, thì mặc định là vào trang chủ
        //$movieController->fetchMoviesFromTMDB();
        $movieController->index();
    }
} else {
    echo "Controller không tồn tại!";
}
?>
