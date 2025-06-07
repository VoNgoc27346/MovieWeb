<?php
if (!isLoggedIn()) {
    redirect('index.php?controller=user&action=login');
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách yêu thích - MoMoPhim</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
</head>
<body class="bg-[#17171e] text-white min-h-screen">
    <!-- Header -->
    <?php include('./views/layouts/header.php'); ?>

    <main class="container mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold mb-6">Danh sách phim yêu thích của bạn</h1>
        
        <!-- Hiển thị thông báo lỗi nếu có -->
        <div id="error-message" class="hidden bg-red-500 text-white p-4 rounded-md mb-4 animate__animated animate__fadeIn">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-circle mr-2 text-xl"></i>
                    <span id="error-text">Đã xảy ra lỗi</span>
                </div>
                <button onclick="this.parentElement.parentElement.classList.add('hidden')" class="text-white focus:outline-none">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        
        <?php if (empty($favorites)): ?>
            <div class="bg-gray-800 rounded-lg p-8 text-center">
                <i class="fas fa-heart text-red-500 text-5xl mb-4"></i>
                <h2 class="text-xl font-semibold mb-2">Danh sách yêu thích trống</h2>
                <p class="text-gray-400 mb-4">Bạn chưa thêm phim nào vào danh sách yêu thích</p>
                <a href="index.php" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md inline-block">
                    Khám phá phim
                </a>
            </div>
        <?php else: ?>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">
                <?php foreach ($favorites as $movie): ?>
                    <div class="bg-[#1e1e2d] rounded-lg overflow-hidden shadow-lg group relative">
                        <!-- Poster phim -->
                        <div class="relative">
                            <img 
                                src="<?= !empty($movie['poster']) ? 'https://image.tmdb.org/t/p/w500' . $movie['poster'] : 'https://via.placeholder.com/300x450' ?>" 
                                alt="<?= h($movie['title']) ?>" 
                                class="w-full h-[300px] object-cover"
                            >
                            <!-- Nút xóa khỏi yêu thích -->
                            <button 
                                class="absolute top-2 right-2 bg-black bg-opacity-50 text-white p-2 rounded-full hover:bg-red-500 transition-colors"
                                onclick="toggleFavorite(this, <?= $movie['movie_id'] ?>, event)"
                                data-movie-id="<?= $movie['movie_id'] ?>"
                            >
                                <i class="fas fa-times"></i>
                            </button>
                            
                            <!-- Rating -->
                            <div class="absolute bottom-2 left-2 bg-yellow-500 text-black font-bold px-2 py-1 rounded-full text-xs flex items-center">
                                <span class="mr-1">★</span> <?= number_format($movie['rating'], 1) ?>
                            </div>
                        </div>
                        
                        <!-- Thông tin phim -->
                        <div class="p-4">
                            <h3 class="font-bold text-lg mb-1 truncate"><?= h($movie['title']) ?></h3>
                            <p class="text-gray-400 text-sm mb-2"><?= isset($movie['release_year']) ? $movie['release_year'] : 'N/A' ?></p>
                            <p class="text-gray-300 text-sm line-clamp-2 mb-3"><?= h(truncate($movie['description'], 100)) ?></p>
                            <a 
                                href="index.php?controller=movie&action=watch&slug=<?= $movie['slug'] ?>" 
                                class="bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-md block text-center"
                            >
                                Xem phim
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <!-- Phân trang -->
            <?php if ($totalPages > 1): ?>
                <div class="flex justify-center mt-8">
                    <nav class="flex space-x-2">
                        <?php if ($page > 1): ?>
                            <a 
                                href="index.php?controller=favorite&action=index&page=<?= $page - 1 ?>" 
                                class="px-4 py-2 bg-gray-800 rounded-md hover:bg-gray-700"
                            >
                                <i class="fas fa-chevron-left mr-1"></i> Trước
                            </a>
                        <?php endif; ?>
                        
                        <?php for ($i = max(1, $page - 2); $i <= min($totalPages, $page + 2); $i++): ?>
                            <a 
                                href="index.php?controller=favorite&action=index&page=<?= $i ?>" 
                                class="px-4 py-2 rounded-md <?= $i === $page ? 'bg-blue-600 text-white' : 'bg-gray-800 hover:bg-gray-700' ?>"
                            >
                                <?= $i ?>
                            </a>
                        <?php endfor; ?>
                        
                        <?php if ($page < $totalPages): ?>
                            <a 
                                href="index.php?controller=favorite&action=index&page=<?= $page + 1 ?>" 
                                class="px-4 py-2 bg-gray-800 rounded-md hover:bg-gray-700"
                            >
                                Sau <i class="fas fa-chevron-right ml-1"></i>
                            </a>
                        <?php endif; ?>
                    </nav>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </main>

    <!-- Footer -->
    <?php include('./views/layouts/footer.php'); ?>
    
    <script>
        // Thêm biến để theo dõi trạng thái gửi yêu cầu
        let isProcessing = false;
        
        // Thêm hàm debug để kiểm tra cấu trúc DOM
        function debugElement(element) {
            console.log('Element:', element);
            console.log('Tag name:', element.tagName);
            console.log('Classes:', element.className);
            console.log('Parent:', element.parentElement);
            if (element.parentElement) {
                console.log('Parent tag:', element.parentElement.tagName);
                console.log('Parent classes:', element.parentElement.className);
            }
        }
        
        function toggleFavorite(button, movieId, event) {
            // Debug thông tin về nút và cấu trúc DOM
            console.log('Button clicked:', button);
            debugElement(button);
            
            // Ngăn chặn sự kiện mặc định và lan truyền sự kiện
            if (event) {
                event.preventDefault();
                event.stopPropagation();
            }
            
            // Nếu đang xử lý một yêu cầu, không cho phép gửi yêu cầu khác
            if (isProcessing) {
                return;
            }
            
            // Đánh dấu đang xử lý
            isProcessing = true;
            
            // Vô hiệu hóa nút để tránh nhấp nhiều lần
            button.disabled = true;
            button.classList.add('opacity-50');
            
            // Tạo form data
            const formData = new FormData();
            formData.append('movie_id', movieId);
            
            // Gửi request AJAX
            fetch('index.php?controller=favorite&action=toggle', {
                method: 'POST',
                body: formData,
                credentials: 'same-origin',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Lỗi mạng hoặc máy chủ');
                }
                return response.json();
            })
            .then(data => {
                // Đánh dấu đã xử lý xong
                isProcessing = false;
                
                if (data.success && data.data && data.data.action === 'removed') {
                    try {
                        // Tìm phần tử phim để xóa - phương pháp đáng tin cậy hơn
                        // Đi lên từ button để tìm phần tử cha chứa phim
                        let movieCard = button;
                        
                        // Đi lên qua các phần tử cha cho đến khi tìm thấy phần tử div chứa phim
                        while (movieCard && 
                              (movieCard.tagName !== 'DIV' || 
                               !movieCard.className.includes('rounded-lg'))) {
                            movieCard = movieCard.parentElement;
                        }
                        
                        if (movieCard) {
                            movieCard.classList.add('animate__animated', 'animate__fadeOut');
                            
                            setTimeout(() => {
                                movieCard.remove();
                                
                                // Kiểm tra nếu không còn phim nào
                                const grid = document.querySelector('.grid');
                                if (grid && grid.children.length === 0) {
                                    // Hiển thị thông báo danh sách trống
                                    location.reload();
                                }
                            }, 500);
                            
                            // Hiển thị thông báo
                            showNotification('Đã xóa khỏi danh sách yêu thích', 'info');
                        } else {
                            throw new Error('Không tìm thấy phần tử phim');
                        }
                    } catch (error) {
                        console.error('Error removing movie card:', error);
                        showNotification('Không thể xóa phim: ' + error.message, 'error');
                        // Khôi phục nút
                        button.disabled = false;
                        button.classList.remove('opacity-50');
                    }
                } else {
                    // Hiển thị thông báo lỗi
                    showNotification(data.message || 'Đã xảy ra lỗi', 'error');
                    // Khôi phục nút
                    button.disabled = false;
                    button.classList.remove('opacity-50');
                }
            })
            .catch(error => {
                // Đánh dấu đã xử lý xong
                isProcessing = false;
                
                console.error('Error:', error);
                showNotification('Đã xảy ra lỗi khi xử lý yêu cầu: ' + error.message, 'error');
                // Khôi phục nút
                button.disabled = false;
                button.classList.remove('opacity-50');
            });
        }
        
        // Hàm hiển thị thông báo
        function showNotification(message, type = 'info') {
            // Nếu là lỗi, hiển thị trong phần tử error-message
            if (type === 'error') {
                const errorElement = document.getElementById('error-text');
                const errorContainer = document.getElementById('error-message');
                
                if (errorElement && errorContainer) {
                    errorElement.textContent = message;
                    errorContainer.classList.remove('hidden');
                    
                    // Cuộn lên đầu trang để hiển thị thông báo lỗi
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                    
                    // Tự động ẩn sau 5 giây
                    setTimeout(() => {
                        errorContainer.classList.add('hidden');
                    }, 5000);
                    
                    return;
                }
            }
            
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
</html> 