<?php include('../layouts/header.php'); ?>

<body class="bg-[#17171e] text-white min-h-screen">
    <!-- Banner sản phẩm nổi bật -->
    <div class="movie-banner relative w-full h-[500px] overflow-hidden">
        <!-- Backdrop sản phẩm với hiệu ứng gradient overlay -->
        <div class="absolute inset-0">
            <img 
                src="<?= htmlspecialchars($product['backdrop']) ?>" 
                alt="Banner Product" 
                class="w-full h-full object-cover"
            >
            <!-- Gradient overlay -->
            <div class="absolute inset-0 bg-gradient-to-r from-black via-black/70 to-transparent"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-black via-black/50 to-transparent"></div>
        </div>

        <!-- Nội dung banner -->
        <div class="relative container mx-auto px-8 h-full flex items-center">
            <div class="w-full md:w-2/3 lg:w-1/2 text-white z-10">
                <!-- Tag nhãn -->
                <div class="flex gap-2 mb-4">
                    <span class="bg-red-600 text-white py-1 px-3 rounded-full text-xs font-medium"><?= htmlspecialchars($product['category']) ?></span>
                    <span class="bg-blue-600 text-white py-1 px-3 rounded-full text-xs font-medium"><?= htmlspecialchars($product['brand']) ?></span>
                </div>
                
                <!-- Tiêu đề sản phẩm -->
                <h1 class="text-4xl md:text-5xl font-bold mb-2 leading-tight"><?= htmlspecialchars($product['name']) ?></h1>
                <h2 class="text-gray-300 text-lg mb-4 italic"><?= htmlspecialchars($product['brand']) ?></h2>
                
                <!-- Thông tin cơ bản -->
                <div class="flex items-center gap-4 mb-4 text-sm">
                    <div class="flex items-center">
                        <span class="bg-yellow-500 text-black font-bold px-2 py-1 rounded flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                            <?= $product['rating'] ?>
                        </span>
                        <span class="ml-1 text-gray-400">Đánh giá</span>
                    </div>
                    <div class="flex items-center gap-1">
                        <span class="text-gray-300"><?= number_format($product['price'], 0, ',', '.') ?> VNĐ</span>
                        <span class="w-1 h-1 bg-gray-500 rounded-full"></span>
                        <span class="text-gray-300">Còn <?= $product['stock'] ?> sản phẩm</span>
                    </div>
                </div>
                
                <!-- Mô tả -->
                <p class="text-gray-300 mb-8 line-clamp-3">
                    <?= htmlspecialchars($product['description']) ?>
                </p>
                
                <!-- Nút hành động -->
                <div class="flex items-center gap-4">
                    <button class="bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-8 rounded-full flex items-center gap-2 transition-colors duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd" />
                        </svg>
                        Thêm vào giỏ hàng
                    </button>
                    <button class="bg-gray-800 hover:bg-gray-700 text-white font-bold py-3 px-6 rounded-full flex items-center gap-2 transition-colors duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd" />
                        </svg>
                        Yêu thích
                    </button>
                </div>
            </div>
            
            <!-- Hình ảnh sản phẩm (hiển thị trên màn hình lớn) -->
            <div class="hidden lg:block absolute right-16 bottom-0 w-[250px] shadow-2xl">
                <div class="relative pb-[150%]">
                    <img 
                        src="<?= htmlspecialchars($product['image']) ?>" 
                        alt="<?= htmlspecialchars($product['name']) ?>" 
                        class="absolute inset-0 w-full h-full object-cover rounded-t-lg shadow-lg"
                    >
                </div>
            </div>
        </div>
    </div>

<?php include('../layouts/footer.php'); ?>