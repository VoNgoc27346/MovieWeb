<?php
require_once 'models/Rating.php';
require_once 'helpers.php';

class RatingController {
    private $ratingModel;

    public function __construct() {
        $this->ratingModel = new Rating();
    }

    public function submit() {
        header('Content-Type: application/json');

        if (!isLoggedIn()) {
            echo json_encode(['status' => 'error', 'message' => 'Vui lòng đăng nhập để đánh giá.']);
            return;
        }

        $data = json_decode(file_get_contents('php://input'), true);
        $movie_id = (int)$data['movie_id'];
        $score = (int)$data['score'];
        $user_id = $_SESSION['user_id'];

        if ($score < 1 || $score > 10) {
            echo json_encode(['status' => 'error', 'message' => 'Điểm không hợp lệ.']);
            return;
        }

        // ✅ Giờ bạn đã có các biến, dùng được ở đây
        if ($this->ratingModel->saveRating($user_id, $movie_id, $score)) {
            echo json_encode(['status' => 'success', 'message' => 'Đã ghi nhận đánh giá.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Lỗi khi ghi đánh giá.']);
        }
    }

}
