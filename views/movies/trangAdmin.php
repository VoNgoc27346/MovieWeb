<?php
session_start();

// Kết nối cơ sở dữ liệu
$host = 'localhost';
$dbname = 'movie_online';
$username = 'root';
$password = '';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Kết nối thất bại: " . $e->getMessage());
}

// Hàm tạo slug
function createSlug($string) {
    $slug = preg_replace('/[^a-zA-Z0-9\s]/', '', $string);
    $slug = strtolower(trim($slug));
    $slug = preg_replace('/\s+/', '-', $slug);
    return $slug;
}

// Thông báo
$alert = ['type' => '', 'message' => ''];
if (isset($_SESSION['alert'])) {
    $alert = $_SESSION['alert'];
    unset($_SESSION['alert']);
}

// Xử lý các section
$section = isset($_GET['section']) ? filter_var($_GET['section'], FILTER_SANITIZE_STRING) : 'films';
$perPage = 10;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$offset = ($page - 1) * $perPage;
$search = isset($_GET['search']) ? filter_var($_GET['search'], FILTER_SANITIZE_STRING) : '';

// Xử lý cho từng section
if ($section === 'films') {
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
        $action = $_POST['action'];
        $title = filter_var(trim($_POST['title']), FILTER_SANITIZE_STRING);
        $slug = createSlug($title);
        $description = filter_var(trim($_POST['description']), FILTER_SANITIZE_STRING);
        $poster = filter_var(trim($_POST['poster']), FILTER_SANITIZE_URL);
        $trailer_url = filter_var(trim($_POST['trailer_url']), FILTER_SANITIZE_URL);
        $video_url = filter_var(trim($_POST['video_url']), FILTER_SANITIZE_URL);
        $duration = filter_var(trim($_POST['duration']), FILTER_SANITIZE_STRING);
        $release_year = filter_var(trim($_POST['release_year']), FILTER_SANITIZE_STRING);
        $quality = filter_var(trim($_POST['quality']), FILTER_SANITIZE_STRING);
        $language = filter_var(trim($_POST['language']), FILTER_SANITIZE_STRING);
        $subtitle = filter_var(trim($_POST['subtitle']), FILTER_SANITIZE_STRING);
        $view = filter_var(trim($_POST['view']), FILTER_SANITIZE_NUMBER_INT);
        $status = filter_var(trim($_POST['status']), FILTER_SANITIZE_STRING);

        if (empty($title)) {
            $alert = ['type' => 'danger', 'message' => 'Vui lòng điền tiêu đề.'];
        } else {
            if ($action === 'add') {
                $stmtCheck = $conn->prepare("SELECT COUNT(*) FROM movies WHERE slug = :slug");
                $stmtCheck->execute(['slug' => $slug]);
                if ($stmtCheck->fetchColumn() > 0) {
                    $alert = ['type' => 'danger', 'message' => 'Phim đã tồn tại.'];
                } else {
                    $stmt = $conn->prepare("INSERT INTO movies (title, slug, description, poster, trailer_url, video_url, duration, release_year, quality, language, subtitle, view, status, created_at) VALUES (:title, :slug, :description, :poster, :trailer_url, :video_url, :duration, :release_year, :quality, :language, :subtitle, :view, :status, NOW())");
                    $stmt->execute([
                        'title' => $title, 'slug' => $slug, 'description' => $description, 'poster' => $poster,
                        'trailer_url' => $trailer_url, 'video_url' => $video_url, 'duration' => $duration, 'release_year' => $release_year,
                        'quality' => $quality, 'language' => $language, 'subtitle' => $subtitle, 'view' => $view, 'status' => $status
                    ]);
                    $alert = ['type' => 'success', 'message' => 'Thêm phim thành công.'];
                }
            } elseif ($action === 'edit') {
                $id = filter_var(trim($_POST['id']), FILTER_SANITIZE_NUMBER_INT);
                $stmtCheck = $conn->prepare("SELECT COUNT(*) FROM movies WHERE slug = :slug AND movie_id != :id");
                $stmtCheck->execute(['slug' => $slug, 'id' => $id]);
                if ($stmtCheck->fetchColumn() > 0) {
                    $alert = ['type' => 'danger', 'message' => 'Phim đã tồn tại.'];
                } else {
                    $stmt = $conn->prepare("UPDATE movies SET title = :title, slug = :slug, description = :description, poster = :poster, trailer_url = :trailer_url, video_url = :video_url, duration = :duration, release_year = :release_year, quality = :quality, language = :language, subtitle = :subtitle, view = :view, status = :status, updated_at = NOW() WHERE movie_id = :id");
                    $stmt->execute([
                        'id' => $id, 'title' => $title, 'slug' => $slug, 'description' => $description, 'poster' => $poster,
                        'trailer_url' => $trailer_url, 'video_url' => $video_url, 'duration' => $duration, 'release_year' => $release_year,
                        'quality' => $quality, 'language' => $language, 'subtitle' => $subtitle, 'view' => $view, 'status' => $status
                    ]);
                    $alert = ['type' => 'success', 'message' => 'Cập nhật phim thành công.'];
                }
            }
        }
        $_SESSION['alert'] = $alert;
        header('Location: trangAdmin.php?section=films');
        exit;
    }

    if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
        $id = filter_var(trim($_GET['id']), FILTER_SANITIZE_NUMBER_INT);
        $stmt = $conn->prepare("DELETE FROM movies WHERE movie_id = :id");
        $stmt->execute(['id' => $id]);
        $alert = ['type' => 'success', 'message' => 'Xóa phim thành công.'];
        $_SESSION['alert'] = $alert;
        header('Location: trangAdmin.php?section=films');
        exit;
    }

    $query = "SELECT movie_id, title, description, poster, status, created_at FROM movies";
    $countQuery = "SELECT COUNT(*) FROM movies";
    if ($search) {
        $query .= " WHERE title LIKE :search";
        $countQuery .= " WHERE title LIKE :search";
    }
    $query .= " ORDER BY movie_id DESC LIMIT :offset, :perPage";
    
    $stmt = $conn->prepare($query);
    if ($search) $stmt->bindValue(':search', "%$search%", PDO::PARAM_STR);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->bindValue(':perPage', $perPage, PDO::PARAM_INT);
    $stmt->execute();
    $films = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $totalStmt = $conn->prepare($countQuery);
    if ($search) $totalStmt->bindValue(':search', "%$search%", PDO::PARAM_STR);
    $totalStmt->execute();
    $totalItems = $totalStmt->fetchColumn();
    $totalPages = ceil($totalItems / $perPage);

    $editItem = null;
    if (isset($_GET['action']) && $_GET['action'] === 'edit' && isset($_GET['id'])) {
        $id = filter_var(trim($_GET['id']), FILTER_SANITIZE_NUMBER_INT);
        $stmt = $conn->prepare("SELECT * FROM movies WHERE movie_id = :id");
        $stmt->execute(['id' => $id]);
        $editItem = $stmt->fetch(PDO::FETCH_ASSOC);
    }
} elseif ($section === 'users') {
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] === 'add') {
        $username = filter_var(trim($_POST['username']), FILTER_SANITIZE_STRING);
        $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
        $password = trim($_POST['password']);
        $role = filter_var(trim($_POST['role']), FILTER_SANITIZE_STRING);

        if (!empty($username) && !empty($email) && !empty($password) && !empty($role)) {
            $stmtCheck = $conn->prepare("SELECT COUNT(*) FROM users WHERE username = :username OR email = :email");
            $stmtCheck->execute(['username' => $username, 'email' => $email]);
            if ($stmtCheck->fetchColumn() > 0) {
                $alert = ['type' => 'danger', 'message' => 'Username hoặc email đã tồn tại.'];
            } else {
                $password = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $conn->prepare("INSERT INTO users (username, email, password, role, created_at, updated_at) VALUES (:username, :email, :password, :role, NOW(), NOW())");
                $stmt->execute(['username' => $username, 'email' => $email, 'password' => $password, 'role' => $role]);
                $alert = ['type' => 'success', 'message' => 'Thêm người dùng thành công.'];
            }
        } else {
            $alert = ['type' => 'danger', 'message' => 'Vui lòng điền đầy đủ thông tin.'];
        }
        $_SESSION['alert'] = $alert;
        header('Location: trangAdmin.php?section=users');
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] === 'edit') {
        $id = filter_var(trim($_POST['id']), FILTER_SANITIZE_NUMBER_INT);
        $username = filter_var(trim($_POST['username']), FILTER_SANITIZE_STRING);
        $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
        $password = !empty($_POST['password']) ? password_hash(trim($_POST['password']), PASSWORD_DEFAULT) : null;
        $role = filter_var(trim($_POST['role']), FILTER_SANITIZE_STRING);

        if (!empty($id) && !empty($username) && !empty($email) && !empty($role)) {
            $stmtCheck = $conn->prepare("SELECT COUNT(*) FROM users WHERE (username = :username OR email = :email) AND user_id != :id");
            $stmtCheck->execute(['username' => $username, 'email' => $email, 'id' => $id]);
            if ($stmtCheck->fetchColumn() > 0) {
                $alert = ['type' => 'danger', 'message' => 'Username hoặc email đã tồn tại.'];
            } else {
                $stmt = $conn->prepare("UPDATE users SET username = :username, email = :email, role = :role, updated_at = NOW() WHERE user_id = :id");
                $params = ['id' => $id, 'username' => $username, 'email' => $email, 'role' => $role];
                if ($password) {
                    $stmt = $conn->prepare("UPDATE users SET username = :username, email = :email, password = :password, role = :role, updated_at = NOW() WHERE user_id = :id");
                    $params['password'] = $password;
                }
                $stmt->execute($params);
                $alert = ['type' => 'success', 'message' => 'Cập nhật người dùng thành công.'];
            }
        } else {
            $alert = ['type' => 'danger', 'message' => 'Vui lòng điền đầy đủ thông tin.'];
        }
        $_SESSION['alert'] = $alert;
        header('Location: trangAdmin.php?section=users');
        exit;
    }

    if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
        $id = filter_var(trim($_GET['id']), FILTER_SANITIZE_NUMBER_INT);
        $stmt = $conn->prepare("DELETE FROM users WHERE user_id = :id");
        $stmt->execute(['id' => $id]);
        $alert = ['type' => 'success', 'message' => 'Xóa người dùng thành công.'];
        $_SESSION['alert'] = $alert;
        header('Location: trangAdmin.php?section=users');
        exit;
    }

    $query = "SELECT user_id, username, email, role, created_at, updated_at FROM users";
    $countQuery = "SELECT COUNT(*) FROM users";
    if ($search) {
        $query .= " WHERE username LIKE :search OR email LIKE :search";
        $countQuery .= " WHERE username LIKE :search OR email LIKE :search";
    }
    $query .= " ORDER BY user_id DESC LIMIT :offset, :perPage";
    
    $stmt = $conn->prepare($query);
    if ($search) $stmt->bindValue(':search', "%$search%", PDO::PARAM_STR);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->bindValue(':perPage', $perPage, PDO::PARAM_INT);
    $stmt->execute();
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $totalStmt = $conn->prepare($countQuery);
    if ($search) $totalStmt->bindValue(':search', "%$search%", PDO::PARAM_STR);
    $totalStmt->execute();
    $totalItems = $totalStmt->fetchColumn();
    $totalPages = ceil($totalItems / $perPage);

    $editItem = null;
    if (isset($_GET['action']) && $_GET['action'] === 'edit' && isset($_GET['id'])) {
        $id = filter_var(trim($_GET['id']), FILTER_SANITIZE_NUMBER_INT);
        $stmt = $conn->prepare("SELECT * FROM users WHERE user_id = :id");
        $stmt->execute(['id' => $id]);
        $editItem = $stmt->fetch(PDO::FETCH_ASSOC);
    }
} elseif ($section === 'orders') {
    // Xử lý xác nhận hoặc không xác nhận đơn hàng
    if (isset($_GET['action']) && isset($_GET['id'])) {
        $id = filter_var(trim($_GET['id']), FILTER_SANITIZE_NUMBER_INT);
        $action = $_GET['action'];

        if ($action === 'confirm') {
            $stmt = $conn->prepare("UPDATE orders SET status = 'completed', updated_at = NOW() WHERE order_id = :id");
            $stmt->execute(['id' => $id]);
            $alert = ['type' => 'success', 'message' => 'Đơn hàng đã được xác nhận.'];
        } elseif ($action === 'cancel') {
            $stmt = $conn->prepare("UPDATE orders SET status = 'cancelled', updated_at = NOW() WHERE order_id = :id");
            $stmt->execute(['id' => $id]);
            $alert = ['type' => 'success', 'message' => 'Đơn hàng đã bị hủy.'];
        }

        $_SESSION['alert'] = $alert;
        header('Location: trangAdmin.php?section=orders');
        exit;
    }

    // Lấy danh sách đơn hàng
    $query = "SELECT order_id, user_id, order_date, status, created_at FROM orders";
    $countQuery = "SELECT COUNT(*) FROM orders";
    $query .= " ORDER BY order_id DESC LIMIT :offset, :perPage";
    
    $stmt = $conn->prepare($query);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->bindValue(':perPage', $perPage, PDO::PARAM_INT);
    $stmt->execute();
    $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $totalStmt = $conn->prepare($countQuery);
    $totalStmt->execute();
    $totalItems = $totalStmt->fetchColumn();
    $totalPages = ceil($totalItems / $perPage);
} elseif ($section === 'categories') {
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] === 'add') {
        $name = filter_var(trim($_POST['name']), FILTER_SANITIZE_STRING);
        $description = filter_var(trim($_POST['description']), FILTER_SANITIZE_STRING);

        if (!empty($name)) {
            $stmt = $conn->prepare("INSERT INTO categories (name, description, created_at) VALUES (:name, :description, NOW())");
            $stmt->execute(['name' => $name, 'description' => $description]);
            $alert = ['type' => 'success', 'message' => 'Thêm danh mục thành công.'];
        } else {
            $alert = ['type' => 'danger', 'message' => 'Vui lòng điền tên danh mục.'];
        }
        $_SESSION['alert'] = $alert;
        header('Location: trangAdmin.php?section=categories');
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] === 'edit') {
        $id = filter_var(trim($_POST['id']), FILTER_SANITIZE_NUMBER_INT);
        $name = filter_var(trim($_POST['name']), FILTER_SANITIZE_STRING);
        $description = filter_var(trim($_POST['description']), FILTER_SANITIZE_STRING);

        if (!empty($id) && !empty($name)) {
            $stmt = $conn->prepare("UPDATE categories SET name = :name, description = :description, updated_at = NOW() WHERE category_id = :id");
            $stmt->execute(['id' => $id, 'name' => $name, 'description' => $description]);
            $alert = ['type' => 'success', 'message' => 'Cập nhật danh mục thành công.'];
        } else {
            $alert = ['type' => 'danger', 'message' => 'Vui lòng điền tên danh mục.'];
        }
        $_SESSION['alert'] = $alert;
        header('Location: trangAdmin.php?section=categories');
        exit;
    }

    if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
        $id = filter_var(trim($_GET['id']), FILTER_SANITIZE_NUMBER_INT);
        $stmt = $conn->prepare("DELETE FROM categories WHERE category_id = :id");
        $stmt->execute(['id' => $id]);
        $alert = ['type' => 'success', 'message' => 'Xóa danh mục thành công.'];
        $_SESSION['alert'] = $alert;
        header('Location: trangAdmin.php?section=categories');
        exit;
    }

    $query = "SELECT category_id, name, description, created_at FROM categories";
    $countQuery = "SELECT COUNT(*) FROM categories";
    if ($search) {
        $query .= " WHERE name LIKE :search";
        $countQuery .= " WHERE name LIKE :search";
    }
    $query .= " ORDER BY category_id DESC LIMIT :offset, :perPage";
    
    $stmt = $conn->prepare($query);
    if ($search) $stmt->bindValue(':search', "%$search%", PDO::PARAM_STR);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->bindValue(':perPage', $perPage, PDO::PARAM_INT);
    $stmt->execute();
    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $totalStmt = $conn->prepare($countQuery);
    if ($search) $totalStmt->bindValue(':search', "%$search%", PDO::PARAM_STR);
    $totalStmt->execute();
    $totalItems = $totalStmt->fetchColumn();
    $totalPages = ceil($totalItems / $perPage);

    $editItem = null;
    if (isset($_GET['action']) && $_GET['action'] === 'edit' && isset($_GET['id'])) {
        $id = filter_var(trim($_GET['id']), FILTER_SANITIZE_NUMBER_INT);
        $stmt = $conn->prepare("SELECT * FROM categories WHERE category_id = :id");
        $stmt->execute(['id' => $id]);
        $editItem = $stmt->fetch(PDO::FETCH_ASSOC);
    }
} elseif ($section === 'contents') {
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] === 'add') {
        $title = filter_var(trim($_POST['title']), FILTER_SANITIZE_STRING);
        $content = filter_var(trim($_POST['content']), FILTER_SANITIZE_STRING);

        if (!empty($title) && !empty($content)) {
            $stmt = $conn->prepare("INSERT INTO contents (title, content, created_at) VALUES (:title, :content, NOW())");
            $stmt->execute(['title' => $title, 'content' => $content]);
            $alert = ['type' => 'success', 'message' => 'Thêm nội dung thành công.'];
        } else {
            $alert = ['type' => 'danger', 'message' => 'Vui lòng điền đầy đủ thông tin.'];
        }
        $_SESSION['alert'] = $alert;
        header('Location: trangAdmin.php?section=contents');
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] === 'edit') {
        $id = filter_var(trim($_POST['id']), FILTER_SANITIZE_NUMBER_INT);
        $title = filter_var(trim($_POST['title']), FILTER_SANITIZE_STRING);
        $content = filter_var(trim($_POST['content']), FILTER_SANITIZE_STRING);

        if (!empty($id) && !empty($title) && !empty($content)) {
            $stmt = $conn->prepare("UPDATE contents SET title = :title, content = :content, updated_at = NOW() WHERE content_id = :id");
            $stmt->execute(['id' => $id, 'title' => $title, 'content' => $content]);
            $alert = ['type' => 'success', 'message' => 'Cập nhật nội dung thành công.'];
        } else {
            $alert = ['type' => 'danger', 'message' => 'Vui lòng điền đầy đủ thông tin.'];
        }
        $_SESSION['alert'] = $alert;
        header('Location: trangAdmin.php?section=contents');
        exit;
    }

    if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
        $id = filter_var(trim($_GET['id']), FILTER_SANITIZE_NUMBER_INT);
        $stmt = $conn->prepare("DELETE FROM contents WHERE content_id = :id");
        $stmt->execute(['id' => $id]);
        $alert = ['type' => 'success', 'message' => 'Xóa nội dung thành công.'];
        $_SESSION['alert'] = $alert;
        header('Location: trangAdmin.php?section=contents');
        exit;
    }

    $query = "SELECT content_id, title, content, created_at FROM contents";
    $countQuery = "SELECT COUNT(*) FROM contents";
    if ($search) {
        $query .= " WHERE title LIKE :search";
        $countQuery .= " WHERE title LIKE :search";
    }
    $query .= " ORDER BY content_id DESC LIMIT :offset, :perPage";
    
    $stmt = $conn->prepare($query);
    if ($search) $stmt->bindValue(':search', "%$search%", PDO::PARAM_STR);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->bindValue(':perPage', $perPage, PDO::PARAM_INT);
    $stmt->execute();
    $contents = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $totalStmt = $conn->prepare($countQuery);
    if ($search) $totalStmt->bindValue(':search', "%$search%", PDO::PARAM_STR);
    $totalStmt->execute();
    $totalItems = $totalStmt->fetchColumn();
    $totalPages = ceil($totalItems / $perPage);

    $editItem = null;
    if (isset($_GET['action']) && $_GET['action'] === 'edit' && isset($_GET['id'])) {
        $id = filter_var(trim($_GET['id']), FILTER_SANITIZE_NUMBER_INT);
        $stmt = $conn->prepare("SELECT * FROM contents WHERE content_id = :id");
        $stmt->execute(['id' => $id]);
        $editItem = $stmt->fetch(PDO::FETCH_ASSOC);
    }
}

?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - <?php echo $section === 'users' ? 'Quản Lý Người Dùng' : ($section === 'orders' ? 'Quản Lý Nâng Cấp VIP' : ($section === 'categories' ? 'Quản Lý Danh Mục' : ($section === 'contents' ? 'Quản Lý Nội Dung' : 'Quản Lý Phim'))); ?></title>
    <link rel="stylesheet" href="../../public/css/trangAdmin.css">
    <style>
        .admin-form form {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        .admin-form input, .admin-form textarea, .admin-form select {
            padding: 10px;
            background: #444;
            border: none;
            border-radius: 5px;
            color: #d3d3d3;
            font-size: 1em;
        }
        .admin-form textarea {
            height: 100px;
            resize: vertical;
        }
        .admin-table {
            overflow-x: auto;
        }
        .admin-table table {
            width: 100%;
            border-collapse: collapse;
            min-width: 1000px;
        }
        .admin-table th, .admin-table td {
            border-bottom: 1px solid #444;
            padding: 10px;
            text-align: left;
            white-space: nowrap;
        }
        .admin-table th {
            background-color: #444;
            color: #ffd700;
        }
        .thumbnail {
            max-width: 50px;
            height: auto;
            border-radius: 5px;
        }
        .edit-btn, .delete-btn, .view-pass-btn {
            padding: 5px 10px;
            text-decoration: none;
            color: white;
            border-radius: 5px;
            margin-right: 5px;
        }
        .edit-btn {
            background-color: #ffd700;
            color: #000;
        }
        .delete-btn {
            background-color: #ff4444;
        }
        .view-pass-btn {
            background-color: #2196F3;
        }
        .cancel-btn {
            display: inline-block;
            padding: 8px 16px;
            background-color: #ccc;
            color: black;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 10px;
        }
        .pagination {
            margin-top: 20px;
            text-align: center;
        }
        .pagination a {
            padding: 8px 12px;
            margin: 0 5px;
            text-decoration: none;
            color: #d3d3d3;
            background-color: #444;
            border-radius: 3px;
        }
        .pagination a.active {
            background-color: #ffd700;
            color: #000;
        }
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
        }
        .modal-content {
            background-color: #333;
            padding: 20px;
            border-radius: 5px;
            text-align: center;
            color: #d3d3d3;
        }
        .close-modal {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }
        .close-modal:hover {
            color: #fff;
        }
        .alert {
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
            color: #fff;
        }
        .alert-success {
            background-color: #4CAF50;
        }
        .alert-danger {
            background-color: #ff4444;
        }
        .search-form {
            margin-bottom: 20px;
        }
        .search-form input {
            width: 200px;
            display: inline-block;
        }
        .search-form button {
            padding: 10px;
            background: #ffd700;
            color: #000;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1em;
        }
    </style>
</head>
<body>
    <div class="admin-content">
        <header class="admin-header">
            <h1>Quản Lý - Movie Phim</h1>
            <nav class="admin-nav">
                <a class="nav-link <?php echo $section === 'films' ? 'active' : ''; ?>" href="?section=films">Quản lý phim</a>
                <a class="nav-link <?php echo $section === 'users' ? 'active' : ''; ?>" href="?section=users">Quản lý người dùng</a>
                <a class="nav-link <?php echo $section === 'orders' ? 'active' : ''; ?>" href="?section=orders">Quản lý nâng cấp VIP</a>
                <a class="nav-link <?php echo $section === 'categories' ? 'active' : ''; ?>" href="?section=categories">Quản lý danh mục</a>
                <a class="nav-link <?php echo $section === 'contents' ? 'active' : ''; ?>" href="?section=contents">Quản lý nội dung</a>
                <a class="nav-link" href="logout.php">Đăng xuất</a>
            </nav>
        </header>
        <div class="banner-304">
            <div class="banner-left">
                <img src="../../public/assets/gif/vn-flag-full.gif" class="flag-gif" alt="Lá cờ">
            </div>
            <div class="banner-center">
                <img src="../../public/assets/hero.jpg" class="person-img" alt="Người cầm cờ">
                <img src="../../public/assets/behind-hero.jpg" class="bg-img" alt="Background">
                <img src="../../public/assets/50y.jpg" class="text-img" alt="50 năm giải phóng">
                <button class="btn-info"><a href="TimHieuLichSu.php" style="text-decoration: none; color: black">Tìm hiểu về ngày 30/4</a></button>
            </div>
            <div class="banner-right">
                <button class="next-btn">❯</button>
            </div>
        </div>
        <section class="admin-section">
            <?php if ($alert['message']): ?>
                <div class="alert alert-<?php echo $alert['type']; ?>">
                    <?php echo htmlspecialchars($alert['message']); ?>
                </div>
            <?php endif; ?>

            <?php if ($section === 'users' || $section === 'categories' || $section === 'contents'): ?>
                <div class="search-form">
                    <form method="GET" action="?section=<?php echo $section; ?>">
                        <input type="text" name="search" placeholder="Tìm kiếm..." value="<?php echo htmlspecialchars($search); ?>">
                        <button type="submit">Tìm</button>
                    </form>
                </div>
            <?php endif; ?>

            <?php if ($section !== 'orders'): ?>
                <div class="admin-form">
                    <h2>
                        <?php 
                            if ($section === 'users') {
                                echo isset($editItem) ? 'Sửa Người Dùng (ID: ' . htmlspecialchars($editItem['user_id']) . ')' : 'Thêm Người Dùng Mới';
                            } elseif ($section === 'films') {
                                echo isset($editItem) ? 'Sửa Phim (ID: ' . htmlspecialchars($editItem['movie_id']) . ')' : 'Thêm Phim Mới';
                            } elseif ($section === 'categories') {
                                echo isset($editItem) ? 'Sửa Danh Mục (ID: ' . htmlspecialchars($editItem['category_id']) . ')' : 'Thêm Danh Mục Mới';
                            } elseif ($section === 'contents') {
                                echo isset($editItem) ? 'Sửa Nội Dung (ID: ' . htmlspecialchars($editItem['content_id']) . ')' : 'Thêm Nội Dung Mới';
                            }
                        ?>
                    </h2>
                    <form action="trangAdmin.php?section=<?php echo $section; ?>" method="POST">
                        <input type="hidden" name="action" value="<?php echo isset($editItem) ? 'edit' : 'add'; ?>">
                        <?php if (isset($editItem)): ?>
                            <input type="hidden" name="id" value="<?php echo htmlspecialchars($editItem[($section === 'users' ? 'user_id' : ($section === 'films' ? 'movie_id' : ($section === 'categories' ? 'category_id' : 'content_id')))]); ?>">
                        <?php endif; ?>
                        <?php if ($section === 'users'): ?>
                            <input type="text" name="username" placeholder="Username" value="<?php echo isset($editItem) ? htmlspecialchars($editItem['username']) : ''; ?>" required>
                            <input type="email" name="email" placeholder="Email" value="<?php echo isset($editItem) ? htmlspecialchars($editItem['email']) : ''; ?>" required>
                            <input type="password" name="password" placeholder="Password (để trống nếu không đổi)">
                            <select name="role" required>
                                <option value="">Chọn vai trò</option>
                                <option value="admin" <?php echo (isset($editItem) && $editItem['role'] === 'admin') ? 'selected' : ''; ?>>Admin</option>
                                <option value="member" <?php echo (isset($editItem) && $editItem['role'] === 'member') ? 'selected' : ''; ?>>Member</option>
                                <option value="premium" <?php echo (isset($editItem) && $editItem['role'] === 'premium') ? 'selected' : ''; ?>>Premium</option>
                            </select>
                        <?php elseif ($section === 'films'): ?>
                            <input type="text" name="title" placeholder="Tên phim" value="<?php echo isset($editItem) ? htmlspecialchars($editItem['title']) : ''; ?>" required>
                            <input type="text" name="original_title" placeholder="Tên gốc (Original Title)" value="<?php echo isset($editItem) ? htmlspecialchars($editItem['original_title']) : ''; ?>">
                            <input type="text" name="poster" placeholder="URL hình ảnh (Poster)" value="<?php echo isset($editItem) ? htmlspecialchars($editItem['poster']) : ''; ?>" required>
                            <textarea name="description" placeholder="Mô tả phim" required><?php echo isset($editItem) ? htmlspecialchars($editItem['description']) : ''; ?></textarea>
                            <input type="text" name="trailer_url" placeholder="URL trailer" value="<?php echo isset($editItem) ? htmlspecialchars($editItem['trailer_url']) : ''; ?>">
                            <input type="text" name="video_url" placeholder="URL video" value="<?php echo isset($editItem) ? htmlspecialchars($editItem['video_url']) : ''; ?>">
                            <select name="release_year" required>
                                <option value="">Chọn năm phát hành</option>
                                <?php for ($year = 1980; $year <= 2025; $year++): ?>
                                    <option value="<?php echo $year; ?>" <?php echo (isset($editItem) && $editItem['release_year'] == $year) ? 'selected' : ''; ?>>
                                        <?php echo $year; ?>
                                    </option>
                                <?php endfor; ?>
                            </select>
                            <input type="number" name="duration" placeholder="Thời lượng (phút)" value="<?php echo isset($editItem) ? htmlspecialchars($editItem['duration']) : ''; ?>" required>
                        <?php elseif ($section === 'categories'): ?>
                            <input type="text" name="name" placeholder="Tên danh mục" value="<?php echo isset($editItem) ? htmlspecialchars($editItem['name']) : ''; ?>" required>
                            <textarea name="description" placeholder="Mô tả"><?php echo isset($editItem) ? htmlspecialchars($editItem['description']) : ''; ?></textarea>
                        <?php elseif ($section === 'contents'): ?>
                            <input type="text" name="title" placeholder="Tiêu đề" value="<?php echo isset($editItem) ? htmlspecialchars($editItem['title']) : ''; ?>" required>
                            <textarea name="content" placeholder="Nội dung" required><?php echo isset($editItem) ? htmlspecialchars($editItem['content']) : ''; ?></textarea>
                        <?php endif; ?>
                        <button type="submit">
                            <?php 
                                if ($section === 'users') {
                                    echo isset($editItem) ? 'Cập Nhật Người Dùng' : 'Thêm Người Dùng';
                                } elseif ($section === 'films') {
                                    echo isset($editItem) ? 'Cập Nhật Phim' : 'Thêm Phim';
                                } elseif ($section === 'categories') {
                                    echo isset($editItem) ? 'Cập Nhật Danh Mục' : 'Thêm Danh Mục';
                                } elseif ($section === 'contents') {
                                    echo isset($editItem) ? 'Cập Nhật Nội Dung' : 'Thêm Nội Dung';
                                }
                            ?>
                        </button>
                        <?php if (isset($editItem)): ?>
                            <a href="trangAdmin.php?section=<?php echo $section; ?>" class="cancel-btn">Hủy</a>
                        <?php endif; ?>
                    </form>
                </div>
            <?php endif; ?>

            <!-- Danh sách -->
            <div class="admin-table">
                <h2>Danh Sách <?php echo $section === 'users' ? 'Người Dùng' : ($section === 'films' ? 'Phim' : ($section === 'orders' ? 'Đơn Hàng' : ($section === 'categories' ? 'Danh Mục' : 'Nội Dung'))); ?></h2>
                <table>
                    <thead>
                        <?php if ($section === 'users'): ?>
                            <tr>
                                <th>ID</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Password</th>
                                <th>Role</th>
                                <th>Created At</th>
                                <th>Updated At</th>
                                <th>Hành Động</th>
                            </tr>
                        <?php elseif ($section === 'films'): ?>
                            <tr>
                                <th>ID</th>
                                <th>Tên Phim</th>
                                <th>Tên Gốc</th>
                                <th>Poster</th>
                                <th>Mô Tả</th>
                                <th>Trailer URL</th>
                                <th>Video URL</th>
                                <th>Năm PH</th>
                                <th>Thời Lượng</th>
                                <th>Chất Lượng</th>
                                <th>Hành Động</th>
                            </tr>
                        <?php elseif ($section === 'orders'): ?>
                            <tr>
                                <th>ID</th>
                                <th>User ID</th>
                                <th>Ngày Đặt</th>
                                <th>Trạng Thái</th>
                                <th>Ngày Tạo</th>
                                <th>Hành Động</th>
                            </tr>
                        <?php elseif ($section === 'categories'): ?>
                            <tr>
                                <th>ID</th>
                                <th>Tên Danh Mục</th>
                                <th>Mô Tả</th>
                                <th>Ngày Tạo</th>
                                <th>Hành Động</th>
                            </tr>
                        <?php elseif ($section === 'contents'): ?>
                            <tr>
                                <th>ID</th>
                                <th>Tiêu Đề</th>
                                <th>Nội Dung</th>
                                <th>Ngày Tạo</th>
                                <th>Hành Động</th>
                            </tr>
                        <?php endif; ?>
                    </thead>
                    <tbody>
                        <?php if ($section === 'users' && !empty($users)): ?>
                            <?php foreach ($users as $user): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($user['user_id']); ?></td>
                                    <td><?php echo htmlspecialchars($user['username']); ?></td>
                                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                                    <td><?php echo htmlspecialchars($user['password']); ?></td>
                                    <td><?php echo htmlspecialchars($user['role']); ?></td>
                                    <td><?php echo htmlspecialchars($user['created_at']); ?></td>
                                    <td><?php echo htmlspecialchars($user['updated_at']); ?></td>
                                    <td>
                                        <a href="trangAdmin.php?section=users&action=edit&id=<?php echo htmlspecialchars($user['user_id']); ?>" class="edit-btn">Sửa</a>
                                        <a href="trangAdmin.php?section=users&action=delete&id=<?php echo htmlspecialchars($user['user_id']); ?>" class="delete-btn" onclick="return confirm('Bạn có chắc muốn xóa người dùng này?');">Xóa</a>
                                        <a href="#" class="view-pass-btn" onclick="openModal('<?php echo htmlspecialchars($user['password']); ?>'); return false;">Xem Pass</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php elseif ($section === 'films' && !empty($films)): ?>
                            <?php foreach ($films as $film): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($film['movie_id']); ?></td>
                                    <td><?php echo htmlspecialchars($film['title']); ?></td>
                                    <td><?php echo htmlspecialchars($film['original_title'] ?? ''); ?></td>
                                    <td><img src="<?php echo htmlspecialchars($film['poster']); ?>" alt="Poster" class="thumbnail"></td>
                                    <td style="max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                        <?php echo htmlspecialchars($film['description']); ?>
                                    </td>
                                    <td style="max-width: 150px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                        <?php echo htmlspecialchars($film['trailer_url'] ?? ''); ?>
                                    </td>
                                    <td style="max-width: 150px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                        <?php echo htmlspecialchars($film['video_url'] ?? ''); ?>
                                    </td>
                                    <td><?php echo htmlspecialchars($film['release_year'] ?? ''); ?></td>
                                    <td><?php echo htmlspecialchars($film['duration'] ?? ''); ?> phút</td>
                                    <td><?php echo htmlspecialchars($film['quality'] ?? ''); ?></td>
                                    <td>
                                        <a href="trangAdmin.php?section=films&action=edit&id=<?php echo htmlspecialchars($film['movie_id']); ?>" class="edit-btn">Sửa</a>
                                        <a href="trangAdmin.php?section=films&action=delete&id=<?php echo htmlspecialchars($film['movie_id']); ?>" class="delete-btn" onclick="return confirm('Bạn có chắc muốn xóa phim này?');">Xóa</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php elseif ($section === 'orders' && !empty($orders)): ?>
                            <?php foreach ($orders as $order): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($order['order_id']); ?></td>
                                    <td><?php echo htmlspecialchars($order['user_id']); ?></td>
                                    <td><?php echo htmlspecialchars($order['order_date']); ?></td>
                                    <td><?php echo htmlspecialchars($order['status']); ?></td>
                                    <td><?php echo htmlspecialchars($order['created_at']); ?></td>
                                    <td>
                                        <?php if ($order['status'] === 'pending'): ?>
                                            <a href="trangAdmin.php?section=orders&action=confirm&id=<?php echo htmlspecialchars($order['order_id']); ?>" class="edit-btn">Xác nhận</a>
                                            <a href="trangAdmin.php?section=orders&action=cancel&id=<?php echo htmlspecialchars($order['order_id']); ?>" class="delete-btn">Không xác nhận</a>
                                        <?php else: ?>
                                            <span>Đã xử lý</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php elseif ($section === 'categories' && !empty($categories)): ?>
                            <?php foreach ($categories as $category): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($category['category_id']); ?></td>
                                    <td><?php echo htmlspecialchars($category['name']); ?></td>
                                    <td style="max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                        <?php echo htmlspecialchars($category['description']); ?>
                                    </td>
                                    <td><?php echo htmlspecialchars($category['created_at']); ?></td>
                                    <td>
                                        <a href="trangAdmin.php?section=categories&action=edit&id=<?php echo htmlspecialchars($category['category_id']); ?>" class="edit-btn">Sửa</a>
                                        <a href="trangAdmin.php?section=categories&action=delete&id=<?php echo htmlspecialchars($category['category_id']); ?>" class="delete-btn" onclick="return confirm('Bạn có chắc muốn xóa danh mục này?');">Xóa</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php elseif ($section === 'contents' && !empty($contents)): ?>
                            <?php foreach ($contents as $content): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($content['content_id']); ?></td>
                                    <td><?php echo htmlspecialchars($content['title']); ?></td>
                                    <td style="max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                        <?php echo htmlspecialchars($content['content']); ?>
                                    </td>
                                    <td><?php echo htmlspecialchars($content['created_at']); ?></td>
                                    <td>
                                        <a href="trangAdmin.php?section=contents&action=edit&id=<?php echo htmlspecialchars($content['content_id']); ?>" class="edit-btn">Sửa</a>
                                        <a href="trangAdmin.php?section=contents&action=delete&id=<?php echo htmlspecialchars($content['content_id']); ?>" class="delete-btn" onclick="return confirm('Bạn có chắc muốn xóa nội dung này?');">Xóa</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="<?php echo $section === 'users' ? '8' : ($section === 'films' ? '11' : ($section === 'orders' ? '6' : ($section === 'categories' ? '5' : '5'))); ?>">Không có <?php echo $section === 'users' ? 'người dùng' : ($section === 'films' ? 'phim' : ($section === 'orders' ? 'đơn hàng' : ($section === 'categories' ? 'danh mục' : 'nội dung'))); ?> nào.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
                <!-- Phân trang -->
                <div class="pagination">
                    <?php if ($page > 1): ?>
                        <a href="trangAdmin.php?section=<?php echo $section; ?>&page=<?php echo $page - 1; ?><?php echo $search ? '&search=' . urlencode($search) : ''; ?>">Previous</a>
                    <?php endif; ?>
                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <a href="trangAdmin.php?section=<?php echo $section; ?>&page=<?php echo $i; ?><?php echo $search ? '&search=' . urlencode($search) : ''; ?>" class="<?php echo $page == $i ? 'active' : ''; ?>">
                            <?php echo $i; ?>
                        </a>
                    <?php endfor; ?>
                    <?php if ($page < $totalPages): ?>
                        <a href="trangAdmin.php?section=<?php echo $section; ?>&page=<?php echo $page + 1; ?><?php echo $search ? '&search=' . urlencode($search) : ''; ?>">Next</a>
                    <?php endif; ?>
                </div>
            </div>
        </section>

        <!-- Modal để xem mật khẩu -->
        <div id="passwordModal" class="modal">
            <div class="modal-content">
                <span class="close-modal" onclick="closeModal()">×</span>
                <h3>Mật khẩu (Hash)</h3>
                <p id="modalPassword"></p>
            </div>
        </div>

        <script src="public/script/admin.js"></script>
        <script>
            function openModal(password) {
                document.getElementById('modalPassword').textContent = password;
                document.getElementById('passwordModal').style.display = 'flex';
            }

            function closeModal() {
                document.getElementById('passwordModal').style.display = 'none';
            }

            window.onclick = function(event) {
                const modal = document.getElementById('passwordModal');
                if (event.target == modal) {
                    modal.style.display = 'none';
                }
            }
        </script>
    </div>
</body>
</html>