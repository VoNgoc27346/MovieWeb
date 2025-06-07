<?php
$controller = $_GET['controller'] ?? 'admin';
$action = $_GET['action'] ?? 'dashboard';

switch ($controller) {
    case 'admin':
        require_once '../../controllers/AdminMovieController.php';
        $controllerObj = new AdminMovieController();
        break;

 
    default:
        die("Controller không hợp lệ!");
}

if (method_exists($controllerObj, $action)) {
    if (isset($_GET['id'])) {
        $controllerObj->$action($_GET['id']);
    } else {
        $controllerObj->$action();
    }
} else {
    die("Action không tồn tại!");
}
?>

<style>
body {
    background: linear-gradient(135deg, #232526 0%, #414345 100%);
    color: #f3f3f3;
    font-family: 'Segoe UI', Arial, sans-serif;
    margin: 0;
    padding: 0;
    min-height: 100vh;
}

h1, h2 {
    text-align: center;
    letter-spacing: 2px;
    text-shadow: 0 2px 8px #000a;
}

h1 {
    margin-top: 40px;
    font-size: 2.5rem;
    color: #ff6f91;
}

h2 {
    margin-top: 30px;
    color: #f9d423;
}

a {
    color: #f9d423;
    text-decoration: none;
    font-weight: bold;
    transition: color 0.2s;
}

a:hover {
    color: white;
    text-shadow: 0 0 8px #fff3;
}

table {
    margin: 40px auto 0 auto;
    border-collapse: collapse;
    width: 90%;
    background: rgba(34, 34, 34, 0.95);
    box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
    border-radius: 12px;
    overflow: hidden;
}

th, td {
    padding: 16px 12px;
    text-align: center;
}

th {
    background: linear-gradient(90deg, #232526 0%,rgb(91, 79, 255) 100%);
    color: #fff;
    font-size: 1.1rem;
    letter-spacing: 1px;
}

tbody tr {
    transition: background 0.2s;
}

tbody tr:nth-child(even) {
    background: rgba(255, 255, 255, 0.03);
}

tbody tr:hover {
    background: rgba(249, 212, 35, 0.08);
}

img {
    border-radius: 8px;
    box-shadow: 0 2px 8px #0006;
    transition: transform 0.2s;
}

img:hover {
    transform: scale(1.1);
}

@media (max-width: 700px) {
    table, th, td {
        font-size: 0.95rem;
        padding: 8px 4px;
    }
    h1 {
        font-size: 1.5rem;
    }
    h2 {
        font-size: 1.1rem;
    }
    
}
.create_phim{
    display: inline-block;
    margin: 24px auto 0 auto;
    padding: 12px 28px;
    background: linear-gradient(90deg ,rgb(91, 79, 255) 100%);
    color: #232526;
    border: none;
    border-radius: 8px;
    font-size: 1.1rem;
    font-weight: bold;
    text-shadow: 0 1px 4px #fff6;
    box-shadow: 0 4px 16px #0002;
    cursor: pointer;
    transition: background 0.2s, color 0.2s, transform 0.15s;
    text-align: center;
    text-decoration: none;
    }
.filter-form {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 16px;
    margin: 32px auto 0 auto;
    padding: 16px 24px;
    background: rgba(34, 34, 34, 0.85);
    border-radius: 10px;
    box-shadow: 0 2px 12px #0002;
    width: fit-content;
}

.filter-input, .filter-select {
    padding: 10px 14px;
    border-radius: 6px;
    border: 1px solid #444;
    background: #232526;
    color: #f3f3f3;
    font-size: 1rem;
    outline: none;
    transition: border 0.2s, box-shadow 0.2s;
}

.filter-input:focus, .filter-select:focus {
    border: 1.5px solid #ff6f91;
    box-shadow: 0 0 6px #ff6f9155;
}

.filter-btn {
    padding: 10px 22px;
    border-radius: 6px;
    border: none;
    background: linear-gradient(90deg, #ff6f91 0%, #f9d423 100%);
    color: #232526;
    font-weight: bold;
    font-size: 1rem;
    cursor: pointer;
    box-shadow: 0 2px 8px #0002;
    transition: background 0.2s, color 0.2s, transform 0.15s;
}

.filter-btn:hover {
    background: linear-gradient(90deg, #f9d423 0%, #ff6f91 100%);
    color: #fff;
    transform: scale(1.05);
}

@media (max-width: 700px) {
    .filter-form {
        flex-direction: column;
        gap: 10px;
        padding: 12px 8px;
        width: 98%;
    }
    .filter-input, .filter-select, .filter-btn {
        width: 100%;
        font-size: 0.95rem;
    }
}
</style>
<h1>Trang Quản Trị Admin</h1>

<h2>Quản lý phim</h2>
<a class="create_phim" href="?controller=admin&action=create">
    Thêm phim mới
</a>
<?php
require_once '../../models/admin/AdminMovie.php';
$movies = AdminMovie::all();
// Pagination setup
$moviesPerPage = 7;
$totalMovies = count($movies);
$totalPages = ceil($totalMovies / $moviesPerPage);
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;
if ($page > $totalPages) $page = $totalPages;

// Calculate slice
$start = ($page - 1) * $moviesPerPage;
$moviesOnPage = array_slice($movies, $start, $moviesPerPage);
?>
<table border="1" cellpadding="6">
    <thead>
        <tr>
            <th>ID</th>
            <th>Tiêu đề</th>
            <th>Poster</th>
            <th>Năm</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($moviesOnPage as $movie): ?>
            <tr>
                <td><?= $movie['movie_id'] ?></td>
                <td><?= $movie['title'] ?></td>
                <td><img src="<?= $movie['poster'] ?>" width="60"></td>
                <td><?= $movie['release_year'] ?></td>
                <td>
                    <a href="?controller=admin&action=edit&id=<?= $movie['movie_id'] ?>">Sửa</a> |
                    <a href="?controller=admin&action=delete&id=<?= $movie['movie_id'] ?>" onclick="return confirm('Bạn chắc muốn xóa?')">Xóa</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<!-- Pagination links -->
<div style="text-align:center; margin: 24px 0;font-size: 1.5rem;">
    <?php if ($totalPages > 1): ?>
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <?php if ($i == $page): ?>
                <span style="margin:0 4px; font-weight:bold; color:#ff6f91;"><?= $i ?></span>
            <?php else: ?>
                <a href="?controller=admin&page=<?= $i ?>" style="margin:0 4px;"><?= $i ?></a>
            <?php endif; ?>
        <?php endfor; ?>
    <?php endif; ?>
</div>