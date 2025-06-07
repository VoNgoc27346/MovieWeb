<?php
require_once 'models/Favorite.php';
require_once 'helpers.php';

class FavoriteController {
    private $favoriteModel;
    
    public function __construct() {
        $this->favoriteModel = new Favorite();
    }
    
    /**
     * Xử lý yêu cầu thêm/xóa phim khỏi danh sách yêu thích (AJAX)
     */
    public function toggleFavorite() {
        // Kiểm tra đăng nhập
        if (!isLoggedIn()) {
            $this->ajaxResponse(false, 'Vui lòng đăng nhập để thêm phim vào danh sách yêu thích', 401);
            return;
        }
        
        // Kiểm tra phương thức POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->ajaxResponse(false, 'Phương thức không được hỗ trợ', 405);
            return;
        }
        
        // Lấy dữ liệu từ request
        $movieId = isset($_POST['movie_id']) ? (int)$_POST['movie_id'] : 0;
        
        if ($movieId <= 0) {
            $this->ajaxResponse(false, 'ID phim không hợp lệ', 400);
            return;
        }
        
        $userId = $_SESSION['user_id'];
        
        try {
            // Thực hiện toggle favorite
            $result = $this->favoriteModel->toggleFavorite($userId, $movieId);
            
            if ($result === 'added') {
                $this->ajaxResponse(true, 'Đã thêm phim vào danh sách yêu thích', 200, [
                    'action' => 'added',
                    'count' => $this->favoriteModel->getMovieFavoritesCount($movieId)
                ]);
            } else if ($result === 'removed') {
                $this->ajaxResponse(true, 'Đã xóa phim khỏi danh sách yêu thích', 200, [
                    'action' => 'removed',
                    'count' => $this->favoriteModel->getMovieFavoritesCount($movieId)
                ]);
            } else {
                $this->ajaxResponse(false, 'Có lỗi xảy ra khi thực hiện yêu cầu', 500);
            }
        } catch (Exception $e) {
            $this->ajaxResponse(false, 'Lỗi hệ thống: ' . $e->getMessage(), 500);
        }
    }
    
    /**
     * Hiển thị danh sách phim yêu thích của người dùng
     */
    public function index() {
        // Kiểm tra đăng nhập
        if (!isLoggedIn()) {
            redirect('index.php?controller=user&action=login');
            return;
        }
        
        $userId = $_SESSION['user_id'];
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit = 12; // Số phim trên mỗi trang
        $offset = ($page - 1) * $limit;
        
        // Lấy danh sách phim yêu thích
        $favorites = $this->favoriteModel->getUserFavorites($userId, $limit, $offset);
        $totalFavorites = $this->favoriteModel->countUserFavorites($userId);
        $totalPages = ceil($totalFavorites / $limit);
        
        // Hiển thị view
        require_once 'views/favorites/index.php';
    }
    
    /**
     * Trả về response dạng JSON cho AJAX request
     */
    private function ajaxResponse($success, $message, $statusCode = 200, $data = []) {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        
        $response = [
            'success' => $success,
            'message' => $message
        ];
        
        if (!empty($data)) {
            $response['data'] = $data;
        }
        
        echo json_encode($response);
        exit;
    }
} 