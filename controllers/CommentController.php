<?php
class CommentController {
    private $commentModel;
    
    public function __construct() {
        $this->commentModel = new Comment();
    }
    
    // Xử lý đăng bình luận và phản hồi
    public function postComment() {
    if (!isLoggedIn()) {
        redirect('login.php');
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Lấy user_id từ session, KHÔNG lấy từ POST
        $user_id = $_SESSION['user_id'];

        // Sanitize input
        $content = htmlspecialchars(trim($_POST['content']));
        $movie_id = (int)$_POST['movie_id'];
        $episode_id = !empty($_POST['episode_id']) ? (int)$_POST['episode_id'] : null;
        $parent_id = !empty($_POST['parent_id']) ? (int)$_POST['parent_id'] : null;

        if (empty($content)) {
            setFlash('error', 'Nội dung bình luận không được để trống');
            redirect($_SERVER['HTTP_REFERER']);
        }

        // Thêm bình luận
        $result = $this->commentModel->addComment($content, $user_id, $movie_id, $episode_id, $parent_id);

        if ($result) {
            setFlash('success', 'Đã đăng bình luận thành công');
        } else {
            setFlash('error', 'Có lỗi xảy ra, vui lòng thử lại sau');
        }

        // Chuyển về trang trước đó
        redirect($_SERVER['HTTP_REFERER']);
    }
}

    
    // Xóa bình luận
    public function deleteComment() {
        if (!isLoggedIn()) {
            redirect('login.php');
        }
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $comment_id = (int)$_POST['comment_id'];
            $user_id = $_SESSION['user_id'];
            
            $result = $this->commentModel->deleteComment($comment_id, $user_id);
            
            if ($result) {
                setFlash('success', 'Đã xóa bình luận');
            } else {
                setFlash('error', 'Không thể xóa bình luận');
            }
            
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
    
    // Load comments cho View
    public function loadComments($movie_id, $episode_id = null) {
        return $this->commentModel->getComments($movie_id, $episode_id);
    }
}
?>