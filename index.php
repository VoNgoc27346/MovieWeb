<?php
session_start();
require_once 'controllers/MovieController.php';
require_once 'controllers/CommentController.php'; 
require_once 'controllers/UserController.php';    
require_once 'models/MovieModel.php';
require_once 'controllers/ProductController.php'; // Thêm ProductController
require_once 'models/ProductModel.php';          // Thêm ProductModel

// Bắt biến từ URL
$controller = $_GET['controller'] ?? 'movie';
$action = $_GET['action'] ?? 'index';
$slug = $_GET['slug'] ?? '';

switch ($controller) {
    case 'movie':
        $movieController = new MovieController();
        if ($action == 'watch' && !empty($slug)) {
            $movieController->watch($slug);
        } else {
            $movieController->index();
        }
        break;

    case 'comment':
        $commentController = new CommentController();
        if ($action == 'comment_post') {
            $commentController->postComment();
        }
        break;

    case 'user':
        $userController = new UserController();
        if ($action == 'login') {
            $userController->login();
        } elseif ($action == 'register') {
            $userController->register();
        } elseif ($action == 'logout') {
            $userController->logout();
        }
        break;

    case 'product':
        $productController = new ProductController();
        if ($action == 'list') {
            $productController->list();
        } elseif ($action == 'detail' && !empty($slug)) {
            $productController->detail($slug);
        } else {
            $productController->list(); // Mặc định hiển thị danh sách
        }
        break;

    default:
        echo "Controller không tồn tại!";
        break;
}
?>