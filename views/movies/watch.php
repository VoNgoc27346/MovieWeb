<?php
require_once 'helpers.php';
require_once 'models/Comment.php';
require_once 'controllers/CommentController.php';
require_once 'controllers/MovieController.php';
require_once 'models/MovieModel.php';
?>

<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Trang Xem Phim</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" rel="stylesheet">
  <script>
    function toggleTab(tabName) {
      // Ẩn tất cả các tab content
      document.querySelectorAll('.tab-content').forEach(tab => {
        tab.classList.add('hidden');
      });
      
      // Hiển thị tab được chọn
      document.getElementById(tabName).classList.remove('hidden');
      
      // Cập nhật trạng thái active của các tab button
      document.querySelectorAll('.tab-button').forEach(button => {
        button.classList.remove('text-green-500', 'border-b-2', 'border-green-500');
        button.classList.add('text-gray-400');
      });
      
      // Đặt trạng thái active cho tab button được chọn
      document.getElementById(`${tabName}-btn`).classList.remove('text-gray-400');
      document.getElementById(`${tabName}-btn`).classList.add('text-green-500', 'border-b-2', 'border-green-500');
    }
    
    function toggleMovieType(type) {
      // Ẩn tất cả các phần phim
      document.getElementById('series-content').classList.add('hidden');
      document.getElementById('movie-content').classList.add('hidden');
      
      // Hiển thị phần được chọn
      document.getElementById(`${type}-content`).classList.remove('hidden');
      
      // Cập nhật trạng thái active của các button
      document.querySelectorAll('.type-button').forEach(button => {
        button.classList.remove('bg-green-600', 'text-white');
        button.classList.add('bg-gray-700', 'text-gray-300');
      });
      
      // Đặt trạng thái active cho button được chọn
      document.getElementById(`${type}-btn`).classList.remove('bg-gray-700', 'text-gray-300');
      document.getElementById(`${type}-btn`).classList.add('bg-green-600', 'text-white');
    }
    
    function setActiveEpisode(index) {
      // Cập nhật trạng thái active của các episode
      document.querySelectorAll('.episode-item').forEach(episode => {
        episode.classList.remove('bg-green-600');
        episode.classList.add('bg-gray-700', 'hover:bg-gray-600');
      });
      
      // Đặt trạng thái active cho episode được chọn
      document.getElementById(`episode-${index}`).classList.remove('bg-gray-700', 'hover:bg-gray-600');
      document.getElementById(`episode-${index}`).classList.add('bg-green-600');
    }
  </script>
</head>
<body class="bg-[#17171e] text-white min-h-screen">
    <!-- Header -->
    <?php include('./views/layouts/header.php'); ?>

  
  <main class="container mx-auto py-6 px-4">
    <div class="flex flex-col lg:flex-row gap-6">
      <!-- Left Section - Video Player -->
      <div class="w-full lg:w-5/6">

      <!-- Khung video -->
      <div id="videoContainer" class="bg-black relative aspect-video rounded-lg flex items-center justify-center overflow-hidden mb-6 w-full h-[600px]">
          <!-- Ảnh đại diện + nút play -->
          <div id="videoThumbnail" class="w-full h-full relative">
              <img src="https://via.placeholder.com/1280x720" alt="Movie Thumbnail"
                  class="w-full h-full object-cover opacity-50" />
              <div class="absolute inset-0 flex items-center justify-center">
                  <button onclick="playVideo('<?= htmlspecialchars($movie['trailer_url']); ?>')"
                          class="bg-green-600 hover:bg-green-700 text-white p-6 rounded-full flex items-center justify-center transform transition hover:scale-110 shadow-lg">
                      <i class="fas fa-play text-3xl"></i>
                  </button>
              </div>
          </div>

          <!-- Iframe video sẽ hiển thị ở đây -->
          <div id="videoFrame" class="absolute inset-0 w-full h-full hidden">
              <iframe id="youtubeIframe" class="w-full h-full" src="" frameborder="0"
                      allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                      allowfullscreen></iframe>
          </div>
      </div>


          <!-- Title and Actions -->
          <div class="mb-6">
            <div class="flex flex-col md:flex-row md:items-center justify-between mb-2">
              <h1 class="text-3xl font-bold"><?= $movie['title']; ?></h1>
              <div class="flex items-center space-x-4 mt-2 md:mt-0">
                <div class="flex items-center">
                  <i class="fas fa-star text-yellow-400 mr-1"></i>
                  <span class="text-lg font-semibold"><?= $movie['rating']; ?></span>
                  <span class="text-gray-400 text-sm ml-1">/10</span>
                </div>

                <!-- Rating -->
                <div class="flex items-center space-x-1 mt-1" id="star-rating">
                  <span class="text-sm text-gray-400 mr-2">Đánh giá của bạn:</span>
                  <i class="fa-regular fa-star text-yellow-400 text-xl cursor-pointer hover:scale-110 transition" data-value="2"></i>
                  <i class="fa-regular fa-star text-yellow-400 text-xl cursor-pointer hover:scale-110 transition" data-value="4"></i>
                  <i class="fa-regular fa-star text-yellow-400 text-xl cursor-pointer hover:scale-110 transition" data-value="6"></i>
                  <i class="fa-regular fa-star text-yellow-400 text-xl cursor-pointer hover:scale-110 transition" data-value="8"></i>
                  <i class="fa-regular fa-star text-yellow-400 text-xl cursor-pointer hover:scale-110 transition" data-value="10"></i>
                </div>
                <p id="rating-label" class="text-xs text-gray-400 mt-1 ml-[5.2rem]"></p>
                <p id="rating-error" class="text-sm mt-2 hidden transition-opacity duration-500"></p>


                <button class="p-2 rounded-full hover:bg-gray-700">
                  <i class="fas fa-share-alt"></i>
                </button>
                <button id="favorite-btn" 
                    class="p-2 rounded-full hover:bg-gray-700"
                    onclick="toggleFavorite(this, <?= $movie['movie_id'] ?>)"
                    data-movie-id="<?= $movie['movie_id'] ?>"
                >
                  <i class="fas fa-heart <?= (isset($movie['is_favorite']) && $movie['is_favorite']) ? 'text-red-500' : 'text-gray-400' ?>"></i>
                </button>
              </div>
            </div>
            
            <div class="flex flex-wrap gap-2 mb-2">
              <span class="bg-green-700 px-3 py-1 rounded-full text-sm"><?= $movie['release_year']; ?></span>
              <span class="bg-gray-700 px-3 py-1 rounded-full text-sm">Hành động</span>
              <span class="bg-gray-700 px-3 py-1 rounded-full text-sm">Kịch tính</span>
              <span class="bg-gray-700 px-3 py-1 rounded-full text-sm">Sinh tồn</span>
              <span class="bg-gray-700 px-3 py-1 rounded-full text-sm">45-60 phút/tập</span>
            </div>
          </div>
      
        <!-- Tab Navigation -->
        <div class="border-b border-gray-700 mb-6">
          <div class="flex space-x-6">
            <button 
              id="description-btn"
              class="tab-button py-3 px-1 font-medium text-green-500 border-b-2 border-green-500"
              onclick="toggleTab('description')"
            >
              Thông tin phim
            </button>
            <button 
              id="comments-btn"
              class="tab-button py-3 px-1 font-medium text-gray-400 hover:text-white"
              onclick="toggleTab('comments')"
            >
              Bình luận
            </button>
          </div>
        </div>
        
        <!-- Tab Content -->
        <div id="description" class="tab-content">
          <h2 class="text-xl font-semibold mb-2">Nội dung</h2>
          <p class="text-gray-300 mb-6"><?= $movie['description']; ?></p>
          
          <h2 class="text-xl font-semibold mb-2">Đạo diễn</h2>
          <p class="text-gray-300 mb-6">Hwang Dong-hyuk</p>
          
          <h2 class="text-xl font-semibold mb-2">Diễn viên</h2>
          <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-6">
            <div class="text-center">
              <div class="w-24 h-24 mx-auto bg-gray-700 rounded-full overflow-hidden mb-2">
                <img src="https://via.placeholder.com/96x96" alt="Lee Jung-jae" class="w-full h-full object-cover" />
              </div>
              <p class="font-medium">Lee Jung-jae</p>
            </div>
            <div class="text-center">
              <div class="w-24 h-24 mx-auto bg-gray-700 rounded-full overflow-hidden mb-2">
                <img src="https://via.placeholder.com/96x96" alt="Park Hae-soo" class="w-full h-full object-cover" />
              </div>
              <p class="font-medium">Park Hae-soo</p>
            </div>
            <div class="text-center">
              <div class="w-24 h-24 mx-auto bg-gray-700 rounded-full overflow-hidden mb-2">
                <img src="https://via.placeholder.com/96x96" alt="Wi Ha-jun" class="w-full h-full object-cover" />
              </div>
              <p class="font-medium">Wi Ha-jun</p>
            </div>
            <div class="text-center">
              <div class="w-24 h-24 mx-auto bg-gray-700 rounded-full overflow-hidden mb-2">
                <img src="https://via.placeholder.com/96x96" alt="Jung Ho-yeon" class="w-full h-full object-cover" />
              </div>
              <p class="font-medium">Jung Ho-yeon</p>
            </div>
          </div>
        </div>
        
        <div id="comments" class="tab-content hidden">
          <h2 class="text-xl font-semibold mb-4 flex items-center">
            <i class="fas fa-comments mr-2"></i>
            Bình luận
          </h2>
          
          <!-- Comment Input -->
          <div class="flex mb-6">
            <div class="w-10 h-10 rounded-full overflow-hidden flex-shrink-0">
              <img src="uploads/default-avatar.png" alt="User Avatar" class="w-full h-full object-cover" />
            </div>
            <div class="ml-3 flex-grow">

              <!-- Hiển thị thông báo -->
              <?php if ($msg = getFlash('success')): ?>
                <div class="text-green-500"><?= $msg ?></div>
              <?php endif; ?>
              <?php if ($msg = getFlash('error')): ?>
                <div class="text-red-500"><?= $msg ?></div>
              <?php endif; ?>
              <?php if (isLoggedIn()): ?>
                <form method="post" action="index.php?controller=comment&action=comment_post">
                  <input type="hidden" name="user_id" value="<?= $_SESSION['user_id'] ?>">
                  <input type="hidden" name="movie_id" value="<?= $movie['movie_id'] ?>">
                  <input type="hidden" name="episode_id" value="<?= $episode_id ?? '' ?>">
                  <div class="bg-gray-800 rounded-lg p-3">
                    <textarea 
                      name="content"
                      placeholder="Viết bình luận..." 
                      class="w-full bg-transparent focus:outline-none resize-none"
                      rows="2"
                      required
                    ></textarea>
                  </div>
                  <div class="flex justify-end mt-2">
                    <button type="submit" class="bg-green-600 hover:bg-green-700 px-4 py-2 rounded-md flex items-center">
                      <i class="fas fa-paper-plane mr-2"></i>
                      Gửi
                    </button>
                  </div>
                </form>
              <?php else: ?>
                <div class="bg-gray-800 rounded-lg p-4 text-center">
                  <p class="mb-2">Vui lòng đăng nhập để bình luận</p>
                  <a href="index.php?controller=user&action=login" class="bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-md inline-block">Đăng nhập</a>
                </div>
              <?php endif; ?>
            </div>
          </div>


          <?php if ($msg = getFlash('success')): ?>
              <div class="alert alert-success"><?= $msg ?></div>
          <?php endif; ?>

          <?php if ($msg = getFlash('error')): ?>
              <div class="alert alert-danger"><?= $msg ?></div>
          <?php endif; ?>
          
          <!-- Comment List -->
          <?php if (!empty($comments) && is_array($comments)): ?>
            
            <?php foreach ($comments as $c): ?>
              <div class="space-y-6">
                <div class="flex">
                  <div class="w-10 h-10 rounded-full overflow-hidden flex-shrink-0">
                    <img src="uploads/default-avatar.png" alt="<?= htmlspecialchars($c['username']) ?> Avatar" class="w-full h-full object-cover" />
                  </div>
                  <div class="ml-3 flex-grow">
                    <div class="flex items-center">
                      <h3 class="font-semibold"><?= htmlspecialchars($c['username']) ?></h3>
                      <span class="ml-2 text-xs text-gray-400"><?= $c['created_at'] ?></span>
                    </div>
                    <p class="text-gray-300 mt-1"><?= nl2br(htmlspecialchars($c['content'])) ?></p>
                    <div class="mt-2 flex items-center text-gray-400 text-sm">
                      <button class="flex items-center hover:text-white">
                        <i class="fas fa-thumbs-up mr-1"></i>
                        0
                      </button>
                      <button class="ml-4 hover:text-white" onclick="toggleReplyForm(<?= $c['comment_id'] ?>)">
                        Trả lời
                      </button>
                    </div>

                    <!-- Reply Form -->
                    <form method="post" action="index.php?controller=comment&action=comment_post" class="reply-form mt-2 hidden" id="reply-form-<?= $c['comment_id'] ?>">
                      <input type="hidden" name="user_id" value="1">
                      <input type="hidden" name="movie_id" value="<?= $movie['movie_id'] ?>">
                      <input type="hidden" name="episode_id" value="<?= $episode_id ?? '' ?>">
                      <input type="hidden" name="parent_id" value="<?= $c['comment_id'] ?>">
                      <textarea name="content" placeholder="Viết trả lời..." rows="1" class="w-full bg-gray-700 rounded-md p-2 mt-2 text-sm text-white" required></textarea>
                      <div class="flex justify-end mt-1">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 px-3 py-1 rounded-md text-sm flex items-center">
                          <i class="fas fa-reply mr-1"></i> Gửi
                        </button>
                      </div>
                    </form>

                    <!-- Reply List -->
                    <?php
                    $replies = Comment::getReplies($c['comment_id']);
                    foreach ($replies as $r):
                    ?>
                      <div class="flex mt-4 ml-10">
                        <div class="w-8 h-8 rounded-full overflow-hidden flex-shrink-0">
                          <img src="uploads/default-avatar.png" alt="<?= htmlspecialchars($r['username']) ?> Avatar" class="w-full h-full object-cover" />
                        </div>
                        <div class="ml-3 flex-grow">
                          <div class="flex items-center">
                            <h4 class="font-semibold text-sm"><?= htmlspecialchars($r['username']) ?></h4>
                            <span class="ml-2 text-xs text-gray-400"><?= $r['created_at'] ?></span>
                          </div>
                          <p class="text-gray-300 text-sm mt-1"><?= nl2br(htmlspecialchars($r['content'])) ?></p>
                        </div>
                      </div>
                    <?php endforeach; ?>

                  </div>
                </div>
              </div>
            <?php endforeach; ?>
          <?php else: ?>
              <p>Chưa có bình luận nào.</p>
          <?php endif; ?>
        </div>
      </div>
      <!-- Right Section - Episodes or Related Movies -->
      <div class="w-full lg:w-1/3">
        <div class="bg-gray-800 rounded-lg p-4">
          <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold">
              Danh sách tập
            </h2>
          </div>
          
          
          
          <?php if (!empty($movies)): ?>
            <div class="max-w-4xl w-full">
              <h1 class="text-3xl font-bold mb-6 text-center">Top phim được xem nhiều nhất</h1>
              <div class="grid md:grid-cols-2 gap-6">
                <?php foreach ($movies as $movie): ?>
                  <div class="flex bg-gray-800 rounded-lg overflow-hidden shadow-md hover:shadow-lg transition">
                    <div class="w-24 h-36 bg-gray-700 flex-shrink-0">
                      <img src="<?= $movie['poster'] ?? 'https://via.placeholder.com/96x144' ?>" alt="<?= htmlspecialchars($movie['title']) ?>" class="w-full h-full object-cover">
                    </div>
                    <div class="p-4 flex flex-col justify-between">
                      <div>
                        <h2 class="text-lg font-semibold"><?= htmlspecialchars($movie['title']) ?></h2>
                        <p class="text-sm text-gray-400 mt-1"><?= htmlspecialchars($movie['description']) ?></p>
                      </div>
                      <div class="mt-2 text-sm text-gray-300">👁️ <?= number_format($movie['views']) ?> lượt xem</div>
                    </div>
                  </div>
                <?php endforeach; ?>
              </div>
            </div>
          <?php else: ?>
            <p>Không có phim nào để hiển thị.</p>
          <?php endif; ?>


        </div>
      </div>
    </div>
  </main>


  <script>
    function openVideo(url) {
      // Mở modal và nhúng video YouTube vào iframe
      document.getElementById('videoModal').style.display = 'flex';
      document.getElementById('videoIframe').src = url;
    }

    function closeModal() {
      // Đóng modal và xóa video iframe
      document.getElementById('videoModal').style.display = 'none';
      document.getElementById('videoIframe').src = '';
    }

    function toggleReplyForm(commentId) {
      var form = document.getElementById('reply-form-' + commentId);
      form.classList.toggle('hidden');
    }


  </script>
  <script>
  function playVideo(url) {
    const embedUrl = convertYouTubeToEmbed(url);
    document.getElementById("youtubeIframe").src = embedUrl;
    document.getElementById("videoThumbnail").classList.add("hidden");
    document.getElementById("videoFrame").classList.remove("hidden");
  }

  function convertYouTubeToEmbed(url) {
    try {
      const urlObj = new URL(url);
      if (urlObj.hostname.includes('youtube.com') && urlObj.searchParams.get('v')) {
        const videoId = urlObj.searchParams.get('v');
        const t = urlObj.searchParams.get('t');
        const start = t ? `?start=${parseYouTubeTime(t)}` : '';
        return `https://www.youtube.com/embed/${videoId}${start}&autoplay=1`;
      }
      return url;
    } catch (e) {
      return url;
    }
  }

  function parseYouTubeTime(t) {
    if (!t) return 0;
    if (!isNaN(t)) return parseInt(t);
    const match = t.match(/(?:(\d+)h)?(?:(\d+)m)?(?:(\d+)s)?/);
    const h = parseInt(match[1]) || 0;
    const m = parseInt(match[2]) || 0;
    const s = parseInt(match[3]) || 0;
    return h * 3600 + m * 60 + s;
  }
</script>

  <script>
    console.log("JS loaded!");

    const ratingContainer = document.querySelector('#star-rating');
    const ratingMessage = document.getElementById('rating-error');

    function highlightStars(score) {
      ratingContainer.querySelectorAll('i').forEach(star => {
        const starValue = parseInt(star.getAttribute('data-value'));
        if (starValue <= score) {
          star.classList.remove('fa-regular');
          star.classList.add('fa-solid');
        } else {
          star.classList.remove('fa-solid');
          star.classList.add('fa-regular');
        }
      });
    }

    if (ratingContainer) {
      ratingContainer.querySelectorAll('i').forEach(star => {
        star.addEventListener('click', () => {
          const score = parseInt(star.getAttribute('data-value'));
          const movieId = <?= json_encode($movie['movie_id']) ?>;

          if (!score || !movieId) {
            console.warn("Thiếu dữ liệu để đánh giá.");
            return;
          }

          console.log("Bạn đã chọn sao: ", score, "cho phim ID:", movieId);

          // Tô màu sao ngay khi người dùng chọn
          highlightStars(score);

          fetch("index.php?controller=rating&action=submit", {
            method: "POST",
            headers: {
              "Content-Type": "application/json"
            },
            body: JSON.stringify({ score: score, movie_id: movieId })
          })
          .then(res => res.json())
          .then(data => {
            if (data.status === 'success') {
              ratingMessage.textContent = `✅ Đánh giá ${score / 2} sao thành công`;
              ratingMessage.classList.remove("hidden", "text-red-500");
              ratingMessage.classList.add("text-green-500");
            } else {
              ratingMessage.textContent = data.message || "❌ Có lỗi xảy ra.";
              ratingMessage.classList.remove("hidden", "text-green-500");
              ratingMessage.classList.add("text-red-500");
            }

            // Hiện thông báo và tự ẩn sau 3 giây
            ratingMessage.classList.add("opacity-100");
            setTimeout(() => {
              ratingMessage.classList.add("opacity-0");
              setTimeout(() => {
                ratingMessage.classList.add("hidden");
                ratingMessage.classList.remove("opacity-0");
              }, 500); // Chờ animation fade-out hoàn tất
            }, 3000);
          })
          .catch(error => {
            console.error("Lỗi khi gọi API: ", error);
            ratingMessage.textContent = "❌ Có lỗi xảy ra. Vui lòng thử lại sau.";
            ratingMessage.classList.remove("hidden", "text-green-500");
            ratingMessage.classList.add("text-red-500");

            // Tự ẩn thông báo sau 3 giây
            setTimeout(() => {
              ratingMessage.classList.add("hidden");
            }, 3000);
          });
        });
      });
    }
  </script>


  <script>
    // Hàm xử lý yêu thích phim
    function toggleFavorite(button, movieId) {
        <?php if (!isLoggedIn()): ?>
        // Nếu chưa đăng nhập, chuyển hướng đến trang đăng nhập
        window.location.href = 'index.php?controller=user&action=login';
        return;
        <?php endif; ?>
        
        // Tạo form data
        const formData = new FormData();
        formData.append('movie_id', movieId);
        
        // Gửi request AJAX
        fetch('index.php?controller=favorite&action=toggle', {
            method: 'POST',
            body: formData,
            credentials: 'same-origin'
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Cập nhật UI
                const heartIcon = button.querySelector('i.fas.fa-heart');
                
                if (data.data.action === 'added') {
                    heartIcon.classList.remove('text-gray-400');
                    heartIcon.classList.add('text-red-500');
                    
                    // Hiển thị thông báo
                    showNotification('Đã thêm vào danh sách yêu thích', 'success');
                } else {
                    heartIcon.classList.remove('text-red-500');
                    heartIcon.classList.add('text-gray-400');
                    
                    // Hiển thị thông báo
                    showNotification('Đã xóa khỏi danh sách yêu thích', 'info');
                }
            } else {
                // Hiển thị thông báo lỗi
                showNotification(data.message, 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Đã xảy ra lỗi khi xử lý yêu cầu', 'error');
        });
    }

    // Hàm hiển thị thông báo
    function showNotification(message, type = 'info') {
        // Tìm hoặc tạo container cho thông báo
        let notificationContainer = document.getElementById('notification-container');
        if (!notificationContainer) {
            notificationContainer = document.createElement('div');
            notificationContainer.id = 'notification-container';
            notificationContainer.className = 'fixed top-4 right-4 z-50 flex flex-col gap-2';
            document.body.appendChild(notificationContainer);
        }
        
        // Tạo thông báo
        const notification = document.createElement('div');
        notification.className = 'animate__animated animate__fadeInRight p-4 rounded-md shadow-lg flex items-center justify-between max-w-md';
        
        // Thiết lập màu sắc dựa trên loại thông báo
        if (type === 'success') {
            notification.classList.add('bg-green-500', 'text-white');
            notification.innerHTML = `
                <div class="flex items-center">
                    <i class="fas fa-check-circle mr-2 text-xl"></i>
                    ${message}
                </div>
                <button onclick="this.parentElement.remove()" class="text-white focus:outline-none ml-4">
                    <i class="fas fa-times"></i>
                </button>
            `;
        } else if (type === 'error') {
            notification.classList.add('bg-red-500', 'text-white');
            notification.innerHTML = `
                <div class="flex items-center">
                    <i class="fas fa-exclamation-circle mr-2 text-xl"></i>
                    ${message}
                </div>
                <button onclick="this.parentElement.remove()" class="text-white focus:outline-none ml-4">
                    <i class="fas fa-times"></i>
                </button>
            `;
        } else {
            notification.classList.add('bg-blue-500', 'text-white');
            notification.innerHTML = `
                <div class="flex items-center">
                    <i class="fas fa-info-circle mr-2 text-xl"></i>
                    ${message}
                </div>
                <button onclick="this.parentElement.remove()" class="text-white focus:outline-none ml-4">
                    <i class="fas fa-times"></i>
                </button>
            `;
        }
        
        // Thêm thông báo vào container
        notificationContainer.appendChild(notification);
        
        // Tự động xóa thông báo sau 3 giây
        setTimeout(() => {
            notification.classList.remove('animate__fadeInRight');
            notification.classList.add('animate__fadeOutRight');
            setTimeout(() => {
                notification.remove();
            }, 500);
        }, 3000);
    }
  </script>



</body>
<?php include('./views/layouts/footer.php'); ?>
</html>
