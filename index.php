<?php
session_start();

// Debug các file include
// var_dump(file_exists('helpers.php')); // Nên trả về true
// var_dump(file_exists('controllers/MovieController.php')); // Nên trả về true
// var_dump(file_exists('controllers/UserController.php')); // Nên trả về true
// var_dump(file_exists('controllers/CommentController.php')); // Nên trả về true
// var_dump(file_exists('controllers/RatingController.php')); // Nên trả về true
// die(); // Tạm thời comment dòng này sau khi debug xong

// Xử lý hiệu ứng đặc biệt khi người dùng vừa nâng cấp VIP
// Xử lý thông báo khi nâng cấp VIP hoặc đăng xuất
if (isset($_GET['vip_upgraded']) && $_GET['vip_upgraded'] === 'true') {
    $_SESSION['vip_just_upgraded'] = true;
    // Chuyển hướng để xóa tham số khỏi URL
    header("Location: index.php");
    exit();
}

// Xử lý thông báo từ URL (đặc biệt là sau khi đăng xuất)
if (isset($_GET['logout']) && $_GET['logout'] === 'success') {
    $_SESSION['success'] = isset($_GET['message']) ? urldecode($_GET['message']) : 'Đã đăng xuất thành công!';
    // Chuyển hướng để xóa tham số khỏi URL
    header("Location: index.php");
    exit();
}

// Xử lý thông báo lỗi nếu có
if (isset($_SESSION['error'])) {
    $error = $_SESSION['error'];
    unset($_SESSION['error']);
}

// Xử lý thông báo thành công nếu có
if (isset($_SESSION['success'])) {
    $success = $_SESSION['success'];
    unset($_SESSION['success']);
}

// Include các file hỗ trợ
require_once 'helpers.php';
require_once 'controllers/MovieController.php';
require_once 'controllers/UserController.php';
require_once 'controllers/CommentController.php';
require_once 'controllers/RatingController.php';
require_once 'controllers/FavoriteController.php';

$controllerName = isset($_GET['controller']) ? $_GET['controller'] : 'movie';
$action = isset($_GET['action']) ? $_GET['action'] : 'index';
$view = isset($_GET['view']) ? $_GET['view'] : null;
// ==== ROUTER LINH HOẠT ====
$controller = $_GET['controller'] ?? 'movie';
$action = $_GET['action'] ?? 'index';

// Kiểm tra nếu truy cập trang VIP
if ($view === 'vip.php') {
    $userController = new UserController();
    $userController->upgradeVip();
    exit();
}
$controllerFile = "controllers/" . ucfirst($controller) . "Controller.php";

// Kiểm tra nếu truy cập trang Payment
if ($view === 'payment.php') {
    // Đảm bảo plan được truyền
    if (!isset($_GET['plan'])) {
        redirect('index.php?view=vip.php');
    }
    // Include file payment.php trực tiếp
    require_once 'views/payment.php';
    exit();
}
if (file_exists($controllerFile)) {
    require_once $controllerFile;
    $className = ucfirst($controller) . "Controller";

    $movieController = new MovieController();
    $userController = new UserController();
    $commentController = new CommentController();
    $ratingController = new RatingController();
    $favoriteController = new FavoriteController();
        // Khởi tạo controller (nếu cần DB thì truyền $db)
        if ($className === 'SupportController') {
            $controllerObject = new $className($db ?? null);
        } else {
            $controllerObject = new $className();
        }

    switch ($controllerName) {
        case 'movie':
            if ($action === 'watch') {
                $slug = $_GET['slug'] ?? '';
                $movieController->watch($slug);
            } elseif ($action === 'fetch') {
                $movieController->fetchMoviesFromTMDB();
            } elseif ($action === 'topViewed') {
                $movieController->topViewed();
            }else {
                $movieController->index();
            }
            break;
        case 'user':
            if ($action === 'login') {
                $userController->login();
            } elseif ($action === 'register') {
                $userController->register();
            } elseif ($action === 'logout') {
                $userController->logout();
            } elseif ($action === 'upgradeVip') {
                $userController->upgradeVip();
            }
            break;
        case 'comment':
            if ($action === 'comment_post') {
                $commentController->postComment();
            } elseif ($action === 'delete') {
                $commentController->deleteComment();
            }
            break;
        case 'rating':
            if ($action === 'submit') {
                $ratingController->submit();
            }
            break;
        case 'favorite':
            if ($action === 'toggle') {
                $favoriteController->toggleFavorite();
            } elseif ($action === 'index') {
                $favoriteController->index();
            }
            break;
        default:
            $movieController->index();
        if (method_exists($controllerObject, $action)) {
            $controllerObject->$action();
        } else {
            echo "Không tìm thấy action $action trong controller $controller";
        }
    } 
}
    ?>