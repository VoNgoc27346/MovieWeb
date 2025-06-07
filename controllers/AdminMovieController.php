
<?php
require_once __DIR__ . '/../models/admin/AdminMovie.php';

class AdminMovieController {
    public function dashboard() {
        
    }
    public function index() {
        $keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
        $year = isset($_GET['year']) ? $_GET['year'] : '';
        $page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit = 5;
        $offset = ($page - 1) * $limit;

        $movies = AdminMovie::searchFilterPaginate($keyword, $year, $limit, $offset);
        $total = AdminMovie::countFiltered($keyword, $year);
        $totalPages = ceil($total / $limit);

        include __DIR__ . '/../views/admin/admin.php';
    }

    public function create() {
        include __DIR__ . '/../views/admin/movie/create.php';
    }

    public function store() {
        AdminMovie::create($_POST);
        header("Location: admin.php");
        exit();
    }

    public function edit($id) {
        $movie = AdminMovie::find($id);
        include __DIR__ . '/../views/admin/movie/edit.php';
    }

    public function update($id) {
        AdminMovie::update($id, $_POST);
        header("Location: admin.php");
        exit();
    }

    public function delete($id) {
        AdminMovie::delete($id);
        header("Location: admin.php");
        exit();
    }
}
