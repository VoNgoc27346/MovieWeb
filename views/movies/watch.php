<?php
require_once 'helpers.php';
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

    <!-- Thông báo lỗi -->
    <p id="rating-error" class="text-red-500 text-sm mt-2 hidden"></p>

  
  <main class="container mx-auto py-6 px-4">
    <div class="flex flex-col lg:flex-row gap-6">
      <!-- Left Section - Video Player -->
      <div class="w-full lg:w-2/3">
        <!-- Video Player -->
        <div class="bg-black relative aspect-video rounded-lg flex items-center justify-center overflow-hidden mb-6">
          <img src="https://via.placeholder.com/1280x720" alt="Movie Thumbnail" class="w-full h-full object-cover opacity-50" />
            <div class="absolute">
              <button class="bg-green-600 hover:bg-green-700 text-white p-6 rounded-full flex items-center justify-center transform transition hover:scale-110" onclick="openVideo('<?= $movie['video_url']; ?>')">
              <i class="fas fa-play text-3xl"></i>
              </button>
          </div>
        </div>

        <!-- Modal Video Display -->
        <div id="videoModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
          <div class="relative w-full h-full max-w-3xl">
              <button onclick="closeModal()" class="absolute top-2 right-2 text-white text-2xl">X</button>
              <iframe id="videoIframe" width="100%" height="100%" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
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

                <button class="p-2 rounded-full hover:bg-gray-700">
                  <i class="fas fa-share-alt"></i>
                </button>
                <button class="p-2 rounded-full hover:bg-gray-700">
                  <i class="fas fa-bookmark"></i>
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
            <div class="flex space-x-2">
              <button 
                id="series-btn"
                class="type-button px-3 py-1 rounded-md text-sm bg-green-600 text-white"
                onclick="toggleMovieType('series')"
              >
                Phim bộ
              </button>
              <button 
                id="movie-btn"
                class="type-button px-3 py-1 rounded-md text-sm bg-gray-700 text-gray-300"
                onclick="toggleMovieType('movie')"
              >
                Phim lẻ
              </button>
            </div>
          </div>
          
          <!-- Series Content -->
          <div id="series-content" class="space-y-2 max-h-[700px] overflow-y-auto">
            <div 
              id="episode-1"
              class="episode-item flex items-center p-3 rounded-lg cursor-pointer bg-green-600"
              onclick="setActiveEpisode(1)"
            >
              <div class="w-16 h-12 bg-gray-600 rounded overflow-hidden flex-shrink-0">
                <img src="https://via.placeholder.com/64x48" alt="Episode 1 Thumbnail" class="w-full h-full object-cover" />
              </div>
              <div class="ml-3">
                <h3 class="font-medium">Tập 1</h3>
                <p class="text-sm text-gray-300">45 phút</p>
              </div>
            </div>
            
            <div 
              id="episode-2"
              class="episode-item flex items-center p-3 rounded-lg cursor-pointer bg-gray-700 hover:bg-gray-600"
              onclick="setActiveEpisode(2)"
            >
              <div class="w-16 h-12 bg-gray-600 rounded overflow-hidden flex-shrink-0">
                <img src="https://via.placeholder.com/64x48" alt="Episode 2 Thumbnail" class="w-full h-full object-cover" />
              </div>
              <div class="ml-3">
                <h3 class="font-medium">Tập 2</h3>
                <p class="text-sm text-gray-300">45 phút</p>
              </div>
            </div>
            
            <div 
              id="episode-3"
              class="episode-item flex items-center p-3 rounded-lg cursor-pointer bg-gray-700 hover:bg-gray-600"
              onclick="setActiveEpisode(3)"
            >
              <div class="w-16 h-12 bg-gray-600 rounded overflow-hidden flex-shrink-0">
                <img src="https://via.placeholder.com/64x48" alt="Episode 3 Thumbnail" class="w-full h-full object-cover" />
              </div>
              <div class="ml-3">
                <h3 class="font-medium">Tập 3</h3>
                <p class="text-sm text-gray-300">45 phút</p>
              </div>
            </div>
            
            <div 
              id="episode-4"
              class="episode-item flex items-center p-3 rounded-lg cursor-pointer bg-gray-700 hover:bg-gray-600"
              onclick="setActiveEpisode(4)"
            >
              <div class="w-16 h-12 bg-gray-600 rounded overflow-hidden flex-shrink-0">
                <img src="https://via.placeholder.com/64x48" alt="Episode 4 Thumbnail" class="w-full h-full object-cover" />
              </div>
              <div class="ml-3">
                <h3 class="font-medium">Tập 4</h3>
                <p class="text-sm text-gray-300">45 phút</p>
              </div>
            </div>
            
            <div 
              id="episode-5"
              class="episode-item flex items-center p-3 rounded-lg cursor-pointer bg-gray-700 hover:bg-gray-600"
              onclick="setActiveEpisode(5)"
            >
              <div class="w-16 h-12 bg-gray-600 rounded overflow-hidden flex-shrink-0">
                <img src="https://via.placeholder.com/64x48" alt="Episode 5 Thumbnail" class="w-full h-full object-cover" />
              </div>
              <div class="ml-3">
                <h3 class="font-medium">Tập 5</h3>
                <p class="text-sm text-gray-300">45 phút</p>
              </div>
            </div>
            
            <div 
              id="episode-6"
              class="episode-item flex items-center p-3 rounded-lg cursor-pointer bg-gray-700 hover:bg-gray-600"
              onclick="setActiveEpisode(6)"
            >
              <div class="w-16 h-12 bg-gray-600 rounded overflow-hidden flex-shrink-0">
                <img src="https://via.placeholder.com/64x48" alt="Episode 6 Thumbnail" class="w-full h-full object-cover" />
              </div>
              <div class="ml-3">
                <h3 class="font-medium">Tập 6</h3>
                <p class="text-sm text-gray-300">45 phút</p>
              </div>
            </div>
            
            <div 
              id="episode-7"
              class="episode-item flex items-center p-3 rounded-lg cursor-pointer bg-gray-700 hover:bg-gray-600"
              onclick="setActiveEpisode(7)"
            >
              <div class="w-16 h-12 bg-gray-600 rounded overflow-hidden flex-shrink-0">
                <img src="https://via.placeholder.com/64x48" alt="Episode 7 Thumbnail" class="w-full h-full object-cover" />
              </div>
              <div class="ml-3">
                <h3 class="font-medium">Tập 7</h3>
                <p class="text-sm text-gray-300">45 phút</p>
              </div>
            </div>
            
            <div 
              id="episode-8"
              class="episode-item flex items-center p-3 rounded-lg cursor-pointer bg-gray-700 hover:bg-gray-600"
              onclick="setActiveEpisode(8)"
            >
              <div class="w-16 h-12 bg-gray-600 rounded overflow-hidden flex-shrink-0">
                <img src="https://via.placeholder.com/64x48" alt="Episode 8 Thumbnail" class="w-full h-full object-cover" />
              </div>
              <div class="ml-3">
                <h3 class="font-medium">Tập 8</h3>
                <p class="text-sm text-gray-300">45 phút</p>
              </div>
            </div>
            
            <div 
              id="episode-9"
              class="episode-item flex items-center p-3 rounded-lg cursor-pointer bg-gray-700 hover:bg-gray-600"
              onclick="setActiveEpisode(9)"
            >
              <div class="w-16 h-12 bg-gray-600 rounded overflow-hidden flex-shrink-0">
                <img src="https://via.placeholder.com/64x48" alt="Episode 9 Thumbnail" class="w-full h-full object-cover" />
              </div>
              <div class="ml-3">
                <h3 class="font-medium">Tập 9</h3>
                <p class="text-sm text-gray-300">45 phút</p>
              </div>
            </div>
          </div>
          
          <!-- Movie Content (Hidden by Default) -->
          <div id="movie-content" class="hidden grid grid-cols-1 gap-4 max-h-[700px] overflow-y-auto">
            <!-- Phim liên quan 1 -->
            <div class="flex bg-gray-700 rounded-lg overflow-hidden hover:bg-gray-600 cursor-pointer transition">
              <div class="w-16 h-24 bg-gray-600 flex-shrink-0">
                <img src="https://via.placeholder.com/64x96" alt="The Dark Knight Poster" class="w-full h-full object-cover" />
              </div>
              <div class="p-3">
                <h3 class="font-medium text-sm">The Dark Knight</h3>
                <div class="flex items-center mt-1">
                  <i class="fas fa-star text-yellow-400 text-xs"></i>
                  <span class="text-xs ml-1">9.0</span>
                </div>
                <div class="flex flex-wrap gap-1 mt-1">
                  <span class="text-xs text-gray-300">Hành động</span>,
                  <span class="text-xs text-gray-300">Tội phạm</span>
                </div>
                <p class="text-xs text-gray-400 mt-1">2008</p>
              </div>
            </div>
            
            <!-- Phim liên quan 2 -->
            <div class="flex bg-gray-700 rounded-lg overflow-hidden hover:bg-gray-600 cursor-pointer transition">
              <div class="w-16 h-24 bg-gray-600 flex-shrink-0">
                <img src="https://via.placeholder.com/64x96" alt="Interstellar Poster" class="w-full h-full object-cover" />
              </div>
              <div class="p-3">
                <h3 class="font-medium text-sm">Interstellar</h3>
                <div class="flex items-center mt-1">
                  <i class="fas fa-star text-yellow-400 text-xs"></i>
                  <span class="text-xs ml-1">8.6</span>
                </div>
                <div class="flex flex-wrap gap-1 mt-1">
                  <span class="text-xs text-gray-300">Khoa học viễn tưởng</span>,
                  <span class="text-xs text-gray-300">Phiêu lưu</span>
                </div>
                <p class="text-xs text-gray-400 mt-1">2014</p>
              </div>
            </div>
            
            <!-- Phim liên quan 3 -->
            <div class="flex bg-gray-700 rounded-lg overflow-hidden hover:bg-gray-600 cursor-pointer transition">
              <div class="w-16 h-24 bg-gray-600 flex-shrink-0">
                <img src="https://via.placeholder.com/64x96" alt="The Matrix Poster" class="w-full h-full object-cover" />
              </div>
              <div class="p-3">
                <h3 class="font-medium text-sm">The Matrix</h3>
                <div class="flex items-center mt-1">
                  <i class="fas fa-star text-yellow-400 text-xs"></i>
                  <span class="text-xs ml-1">8.7</span>
                </div>
                <div class="flex flex-wrap gap-1 mt-1">
                  <span class="text-xs text-gray-300">Hành động</span>,
                  <span class="text-xs text-gray-300">Khoa học viễn tưởng</span>
                </div>
                <p class="text-xs text-gray-400 mt-1">1999</p>
              </div>
            </div>
            
            <!-- Phim liên quan 4 -->
            <div class="flex bg-gray-700 rounded-lg overflow-hidden hover:bg-gray-600 cursor-pointer transition">
              <div class="w-16 h-24 bg-gray-600 flex-shrink-0">
                <img src="https://via.placeholder.com/64x96" alt="Parasite Poster" class="w-full h-full object-cover" />
              </div>
              <div class="p-3">
                <h3 class="font-medium text-sm">Parasite</h3>
                <div class="flex items-center mt-1">
                  <i class="fas fa-star text-yellow-400 text-xs"></i>
                  <span class="text-xs ml-1">8.5</span>
                </div>
                <div class="flex flex-wrap gap-1 mt-1">
                  <span class="text-xs text-gray-300">Kịch tính</span>,
                  <span class="text-xs text-gray-300">Hài đen</span>
                </div>
                <p class="text-xs text-gray-400 mt-1">2019</p>
              </div>
            </div>
            
            <!-- Phim liên quan 5 -->
            <div class="flex bg-gray-700 rounded-lg overflow-hidden hover:bg-gray-600 cursor-pointer transition">
              <div class="w-16 h-24 bg-gray-600 flex-shrink-0">
                <img src="https://via.placeholder.com/64x96" alt="Inception Poster" class="w-full h-full object-cover" />
              </div>
              <div class="p-3">
                <h3 class="font-medium text-sm">Inception</h3>
                <div class="flex items-center mt-1">
                  <i class="fas fa-star text-yellow-400 text-xs"></i>
                  <span class="text-xs ml-1">8.8</span>
                </div>
                <div class="flex flex-wrap gap-1 mt-1">
                  <span class="text-xs text-gray-300">Khoa học viễn tưởng</span>,
                  <span class="text-xs text-gray-300">Hành động</span>
                </div>
                <p class="text-xs text-gray-400 mt-1">2010</p>
              </div>
            </div>
          </div>
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
    console.log("JS loaded!");

    const ratingContainer = document.querySelector('#star-rating');
    if (ratingContainer) {
      ratingContainer.querySelectorAll('i').forEach((star, index) => {
        star.addEventListener('click', () => {
          const score = star.getAttribute('data-value');
          const movieId = <?= json_encode($movie['id']) ?>;

          if (!score || !movieId) {
            console.warn("Thiếu dữ liệu để đánh giá.");
            return;
          }

          console.log("Bạn đã chọn sao: ", score, "cho phim ID:", movieId);

          fetch("index.php?controller=rating&action=submit", {
            method: "POST",
            headers: {
              "Content-Type": "application/json"
            },
            body: JSON.stringify({ score: score, movie_id: movieId })
          })
          .then(res => res.json())
          .then(data => {
            console.log("Phản hồi từ server: ", data);
            const label = document.getElementById('rating-error');
            if (data.status === 'success') {
              label.textContent = `Đánh giá ${score / 2} sao thành công`;
              label.classList.remove("hidden", "text-red-500");
              label.classList.add("text-green-500");
            } else {
              label.textContent = data.message || "Có lỗi xảy ra.";
              label.classList.remove("hidden", "text-green-500");
              label.classList.add("text-red-500");
            }
          }).catch(error => {
            console.error("Lỗi khi gọi API: ", error);
            const label = document.getElementById('rating-error');
            label.textContent = "Có lỗi xảy ra. Vui lòng thử lại sau.";
            label.classList.remove("hidden", "text-green-500");
            label.classList.add("text-red-500");
          });
        });
      });
    }
  </script>



</body>
<?php include('./views/layouts/footer.php'); ?>
</html>
