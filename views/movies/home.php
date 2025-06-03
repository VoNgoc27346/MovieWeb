<?php include('./views/layouts/header.php'); ?>

<body class="bg-[#17171e] text-white min-h-screen">
    <!-- Banner phim nổi bật -->
    <div class="movie-banner relative w-full h-[500px] overflow-hidden">
        <!-- Backdrop phim với hiệu ứng gradient overlay -->
        <div class="absolute inset-0">
            <img 
                src="https://image.tmdb.org/t/p/original/xgGGinKRL8xeRkaAR9RMbtyk60y.jpg" 
                alt="Banner Movie" 
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
                    <span class="bg-red-600 text-white py-1 px-3 rounded-full text-xs font-medium">PHIM MỚI</span>
                    <span class="bg-blue-600 text-white py-1 px-3 rounded-full text-xs font-medium">ĐỘC QUYỀN</span>
                </div>
                
                <!-- Tiêu đề phim -->
                <h1 class="text-4xl md:text-5xl font-bold mb-2 leading-tight">The Godfather</h1>
                <h2 class="text-gray-300 text-lg mb-4 italic">Bố Già (1972)</h2>
                
                <!-- Thông tin cơ bản -->
                <div class="flex items-center gap-4 mb-4 text-sm">
                    <div class="flex items-center">
                        <span class="bg-yellow-500 text-black font-bold px-2 py-1 rounded flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                            9.2
                        </span>
                        <span class="ml-1 text-gray-400">IMDb</span>
                    </div>
                    <div class="flex items-center gap-1">
                        <span class="text-gray-300">175 phút</span>
                        <span class="w-1 h-1 bg-gray-500 rounded-full"></span>
                        <span class="text-gray-300">1972</span>
                        <span class="w-1 h-1 bg-gray-500 rounded-full"></span>
                        <span class="text-gray-300">18+</span>
                    </div>
                </div>
                
                <!-- Thể loại -->
                <div class="flex flex-wrap gap-2 mb-6">
                    <span class="bg-gray-800 text-gray-300 px-3 py-1 rounded-md text-sm">Tội phạm</span>
                    <span class="bg-gray-800 text-gray-300 px-3 py-1 rounded-md text-sm">Chính kịch</span>
                    <span class="bg-gray-800 text-gray-300 px-3 py-1 rounded-md text-sm">Hành động</span>
                </div>
                
                <!-- Mô tả -->
                <p class="text-gray-300 mb-8 line-clamp-3">
                    Bộ phim xoay quanh câu chuyện về gia đình mafia gốc Sicily Corleone ở New York do Don Vito Corleone, một người đàn ông khiến người khác phải kính nể và sợ hãi đứng đầu. Khi từ chối tham gia vào việc buôn bán ma túy của Sollozzo, Don Vito bị ám sát hụt, con trai cả của ông là Sonny bị giết chết trong một cuộc phục kích, buộc Michael - người con trai út phải lên kế nhiệm cầm đầu gia đình.
                </p>
                
                <!-- Nút hành động -->
                <div class="flex items-center gap-4">
                    <button class="bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-8 rounded-full flex items-center gap-2 transition-colors duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd" />
                        </svg>
                        XEM NGAY
                    </button>
                    <button class="bg-gray-800 hover:bg-gray-700 text-white font-bold py-3 px-6 rounded-full flex items-center gap-2 transition-colors duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                        </svg>
                        XEM SAU
                    </button>
                    <button class="bg-transparent hover:bg-gray-800 text-white font-bold p-3 rounded-full flex items-center transition-colors duration-300 border border-gray-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd" />
                        </svg>
                    </button>
                    <button class="bg-transparent hover:bg-gray-800 text-white font-bold p-3 rounded-full flex items-center transition-colors duration-300 border border-gray-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M15 8a3 3 0 10-2.977-2.63l-4.94 2.47a3 3 0 100 4.319l4.94 2.47a3 3 0 10.895-1.789l-4.94-2.47a3.027 3.027 0 000-.74l4.94-2.47C13.456 7.68 14.19 8 15 8z" />
                        </svg>
                    </button>
                </div>
            </div>
            
            <!-- Poster phim (hiển thị trên màn hình lớn) -->
            <div class="hidden lg:block absolute right-16 bottom-0 w-[250px] shadow-2xl">
                <div class="relative pb-[150%]">
                    <img 
                        src="https://image.tmdb.org/t/p/w500/3bhkrj58Vtu7enYsRolD1fZdja1.jpg" 
                        alt="The Godfather Poster" 
                        class="absolute inset-0 w-full h-full object-cover rounded-t-lg shadow-lg"
                    >
                </div>
            </div>
        </div>
        
        <!-- Điều hướng banner (nếu có nhiều banner) -->
        <div class="banner-navigation absolute bottom-6 left-1/2 transform -translate-x-1/2 flex gap-2">
            <button class="nav-dot w-3 h-3 rounded-full bg-white opacity-100" data-index="0"></button>
            <button class="nav-dot w-3 h-3 rounded-full bg-white opacity-50" data-index="1"></button>
            <button class="nav-dot w-3 h-3 rounded-full bg-white opacity-50" data-index="2"></button>
            <button class="nav-dot w-3 h-3 rounded-full bg-white opacity-50" data-index="3"></button>
        </div>
    </div>


    <!-- Phim Phổ Biến -->
    <section class="px-8 mt-6">
        <h2 class="text-2xl font-bold mb-6 text-white">Phim Phổ Biến</h2>
        <div class="movie-carousel overflow-visible relative"> <!-- Thay đổi overflow-hidden thành overflow-visible -->
            
            <!-- Left arrow button -->
            <button class="absolute top-1/2 left-0 transform -translate-y-1/2 bg-gray-800 text-white px-3 py-3 rounded-full opacity-60 hover:opacity-100 z-20 shadow-lg transition-all duration-300" id="prev-btn">
                <i class="fas fa-chevron-left"></i>
            </button>

            <!-- Movie Cards -->
            <div class="movie-grid flex gap-6 pb-16 pt-8 px-4 overflow-x-auto scroll-smooth" id="movie-grid">
            <?php foreach ($movies as $movie): ?>
                <!-- Thêm padding phía ngoài để tạo không gian cho overlay -->
                <div class="relative flex-shrink-0 group w-[290px]">
                    <!-- Container chính của phim -->
                    <div class="relative rounded-lg shadow-lg bg-[#1e1e2d] transition-all duration-300 w-full">
                        
                        <!-- Poster -->
                        <img 
                            src="https://image.tmdb.org/t/p/w300<?= $movie['poster'] ?>" 
                            alt="<?= $movie['title'] ?>" 
                            class="w-full h-[390px] object-cover rounded-lg"
                            loading="lazy"
                        >

                        <!-- Rating Badge -->
                        <div class="absolute top-2 right-2 bg-yellow-500 text-black font-bold px-2 py-1 rounded-full text-xs flex items-center">
                            <span class="mr-1">★</span> <?= $movie['rating'] ?>
                        </div>

                        <!-- Hover Overlay - Fixed to prevent being cut off -->
                        <div class="absolute opacity-0 group-hover:opacity-100 transition-all duration-300 
                                  bg-gradient-to-t from-black via-[#1e1e2de9] to-[#1e1e2dcc] 
                                  rounded-lg flex flex-col pointer-events-none
                                  group-hover:pointer-events-auto z-50
                                  w-[380px] -left-[30px] -top-[10px] h-[450px]">
                            
                            <!-- Backdrop -->
                            <img 
                                src="https://image.tmdb.org/t/p/w500<?= $movie['background'] ?>" 
                                alt="<?= $movie['title'] ?>" 
                                class="w-full h-[160px] object-cover rounded-t-lg"
                                loading="lazy"
                            >

                            <div class="p-4 flex-1 flex flex-col justify-between text-white">
                                <div>
                                    <h3 class="font-bold text-lg mb-1 line-clamp-2"><?= $movie['title'] ?></h3>
                                    <p class="text-gray-300 text-xs mb-3 italic"><?= $movie['original_title'] ?></p>
                                    
                                    <!-- Release Year and Genres -->
                                    <div class="flex flex-wrap gap-2 text-xs mb-3">
                                        <span class="bg-gray-700 px-2 py-0.5 rounded"><?= $movie['release_year'] ?? 'N/A' ?></span>
                                        <span class="bg-gray-700 px-2 py-0.5 rounded"><?= $movie['genres'] ?? 'Chưa rõ thể loại' ?></span>

                                    </div>
                                    <!-- THÊM MÔ TẢ PHIM Ở ĐÂY -->
                                    <p class="text-gray-300 text-sm mb-3 line-clamp-4 text-justify">
                                        <?= $movie['description'] ?? 'Không có mô tả.' ?>
                                    </p>
                                </div>

                                <!-- Action Buttons -->
                                <div class="flex gap-2 mt-2">
                                <a href="/MovieWeb/index.php?controller=movie&action=watch&slug=<?= $movie['slug'] ?>" class="bg-green-500 hover:bg-green-400 text-black font-semibold px-4 py-2 rounded-full flex items-center gap-1 text-lg transition-colors duration-200 flex-grow">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd" />
                                    </svg>
                                    Xem ngay
                                </a>
                                    <button class="bg-gray-800 hover:bg-gray-700 border border-gray-600 p-2 rounded-full text-lg flex items-center justify-center w-10 h-10 transition-colors duration-200 flex-grow">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd" />
                                        </svg>
                                        Thích
                                    </button>
                                    <button class="bg-gray-800 hover:bg-gray-700 border border-gray-600 p-2 rounded-full text-sm flex items-center justify-center w-10 h-10 transition-colors duration-200">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
            </div>

            <!-- Right arrow button -->
            <button class="absolute top-1/2 right-0 transform -translate-y-1/2 bg-gray-800 text-white px-3 py-3 rounded-full opacity-60 hover:opacity-100 z-20 shadow-lg transition-all duration-300" id="next-btn">
                <i class="fas fa-chevron-right"></i>
            </button>

        </div>
    </section>




    

    <!-- Section: Celebrities -->
    <section class="px-8 mt-10">
        <h2 class="text-xl font-bold mb-4">Popular Celebrities</h2>
        <div class="flex gap-6">
        <div class="flex flex-col items-center">
            <img src="https://ext.same-assets.com/3286298510/611378790.jpeg" alt="Allen Ren" class="w-16 h-16 rounded-full object-cover border-2 border-[#5547bb] celeb-hover" />
            <p class="mt-2 text-xs">Allen Ren</p>
        </div>
        <div class="flex flex-col items-center">
            <img src="https://ext.same-assets.com/3286298510/1397154317.png" alt="Bai Lu" class="w-16 h-16 rounded-full object-cover border-2 border-[#51b17e] celeb-hover" />
            <p class="mt-2 text-xs">Bai Lu</p>
        </div>
        <div class="flex flex-col items-center">
            <img src="https://ext.same-assets.com/3286298510/891268374.png" alt="Johnny Huang" class="w-16 h-16 rounded-full object-cover border-2 border-[#ad4561] celeb-hover" />
            <p class="mt-2 text-xs">Johnny Huang</p>
        </div>
        </div>
    </section>
                

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const movieGrid = document.getElementById('movie-grid');
            const prevBtn = document.getElementById('prev-btn');
            const nextBtn = document.getElementById('next-btn');
            
            // Scroll amount (adjust as needed)
            const scrollAmount = 620;
            
            nextBtn.addEventListener('click', function() {
                movieGrid.scrollBy({ left: scrollAmount, behavior: 'smooth' });
            });
            
            prevBtn.addEventListener('click', function() {
                movieGrid.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
            });
        });







        // Banner data - Replace with your actual content
        const banners = [
            {
                title: "The Godfather",
                subtitle: "Bố Già (1972)",
                backdrop: "https://image.tmdb.org/t/p/original/xgGGinKRL8xeRkaAR9RMbtyk60y.jpg",
                poster: "https://image.tmdb.org/t/p/w500/3bhkrj58Vtu7enYsRolD1fZdja1.jpg",
                rating: "9.2",
                duration: "175 phút",
                year: "1972",
                ageRating: "18+",
                genres: ["Tội phạm", "Chính kịch", "Hành động"],
                description: "Bộ phim xoay quanh câu chuyện về gia đình mafia gốc Sicily Corleone ở New York do Don Vito Corleone, một người đàn ông khiến người khác phải kính nể và sợ hãi đứng đầu. Khi từ chối tham gia vào việc buôn bán ma túy của Sollozzo, Don Vito bị ám sát hụt, con trai cả của ông là Sonny bị giết chết trong một cuộc phục kích, buộc Michael - người con trai út phải lên kế nhiệm cầm đầu gia đình."
            },
            {
                title: "The Shawshank Redemption",
                subtitle: "Nhà Tù Shawshank (1994)",
                backdrop: "https://image.tmdb.org/t/p/original/kXfqcdQKsToO0OUXHcrrNCHDBzO.jpg",
                poster: "https://image.tmdb.org/t/p/w500/q6y0Go1tsGEsmtFryDOJo3dEmqu.jpg",
                rating: "9.3",
                duration: "142 phút",
                year: "1994",
                ageRating: "16+",
                genres: ["Chính kịch", "Tội phạm"],
                description: "Bộ phim kể về Andy Dufresne, một nhân viên ngân hàng bị kết án tù chung thân vì tội giết vợ và người tình của cô, mặc dù anh khẳng định mình vô tội. Tại nhà tù Shawshank, anh kết bạn với Ellis Boyd 'Red' Redding và tìm thấy sự cứu rỗi qua những hành động ý nghĩa trong suốt 19 năm bị giam cầm."
            },
            {
                title: "The Dark Knight",
                subtitle: "Kỵ Sĩ Bóng Đêm (2008)",
                backdrop: "https://image.tmdb.org/t/p/original/nMKdUUepR0i5zn0y1T4CsSB5chy.jpg",
                poster: "https://image.tmdb.org/t/p/w500/qJ2tW6WMUDux911r6m7haRef0WH.jpg",
                rating: "9.0",
                duration: "152 phút",
                year: "2008",
                ageRating: "13+",
                genres: ["Hành động", "Tội phạm", "Chính kịch"],
                description: "Batman phải chấp nhận một trong những thử thách tâm lý và thể chất lớn nhất của mình khi phải đối đầu với một tên tội phạm mới nổi lên ở Gotham có biệt danh là Joker, người tạo ra hỗn loạn và hủy hoại trong thành phố."
            },
            {
                title: "Pulp Fiction",
                subtitle: "Chuyện Tào Lao (1994)",
                backdrop: "https://image.tmdb.org/t/p/original/suaEOtk1N1sgg2MTM7oZd2cfVp3.jpg",
                poster: "https://image.tmdb.org/t/p/w500/d5iIlFn5s0ImszYzBPb8JPIfbXD.jpg",
                rating: "8.9",
                duration: "154 phút",
                year: "1994",
                ageRating: "18+",
                genres: ["Tội phạm", "Hành động"],
                description: "Các câu chuyện về tội phạm ở Los Angeles đan xen vào nhau, bao gồm hai sát thủ triết lý, một võ sĩ quyền anh bị lừa dối, vợ của một ông trùm xã hội đen, và một cặp cướp nhà hàng."
            }
        ];

        // Variables
        let currentBannerIndex = 0;
        const autoSlideInterval = 5000; // 5 seconds
        let slideInterval;

        // Elements
        const bannerContainer = document.querySelector('.movie-banner');
        const backdropImg = bannerContainer.querySelector('.absolute.inset-0 img');
        const titleEl = bannerContainer.querySelector('h1');
        const subtitleEl = bannerContainer.querySelector('h2');
        const ratingEl = bannerContainer.querySelector('.bg-yellow-500');
        const durationEl = bannerContainer.querySelector('div.flex.items-center.gap-1').children[0];
        const yearEl = bannerContainer.querySelector('div.flex.items-center.gap-1').children[2];
        const ageRatingEl = bannerContainer.querySelector('div.flex.items-center.gap-1').children[4];
        const genresContainer = bannerContainer.querySelector('.flex.flex-wrap.gap-2');
        const descriptionEl = bannerContainer.querySelector('p.text-gray-300.mb-8');
        const posterImg = bannerContainer.querySelector('.hidden.lg\\:block img');
        const navDots = document.querySelectorAll('.nav-dot');

        // Functions
        function updateBanner(index) {
            const banner = banners[index];
            
            // Update content with smooth transition
            bannerContainer.style.opacity = '0';
            
            setTimeout(() => {
                // Update all elements
                backdropImg.src = banner.backdrop;
                titleEl.textContent = banner.title;
                subtitleEl.textContent = banner.subtitle;
                ratingEl.innerHTML = `
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                    </svg>
                    ${banner.rating}
                `;
                durationEl.textContent = banner.duration;
                yearEl.textContent = banner.year;
                ageRatingEl.textContent = banner.ageRating;
                
                // Update genres
                genresContainer.innerHTML = '';
                banner.genres.forEach(genre => {
                    const genreEl = document.createElement('span');
                    genreEl.className = 'bg-gray-800 text-gray-300 px-3 py-1 rounded-md text-sm';
                    genreEl.textContent = genre;
                    genresContainer.appendChild(genreEl);
                });
                
                descriptionEl.textContent = banner.description;
                posterImg.src = banner.poster;
                
                // Update navigation dots
                navDots.forEach((dot, idx) => {
                    dot.classList.toggle('opacity-100', idx === index);
                    dot.classList.toggle('opacity-50', idx !== index);
                });
                
                // Show banner with fade in
                bannerContainer.style.opacity = '1';
            }, 500); // Match this timing with the CSS transition
            
            currentBannerIndex = index;
        }

        // Start automatic slideshow
        function startAutoSlide() {
            stopAutoSlide(); // Clear any existing interval first
            slideInterval = setInterval(() => {
                const nextIndex = (currentBannerIndex + 1) % banners.length;
                updateBanner(nextIndex);
            }, autoSlideInterval);
        }

        // Stop automatic slideshow
        function stopAutoSlide() {
            if (slideInterval) {
                clearInterval(slideInterval);
            }
        }

        // Add click event listeners to navigation dots
        navDots.forEach(dot => {
            dot.addEventListener('click', () => {
                const index = parseInt(dot.getAttribute('data-index'));
                updateBanner(index);
                
                // Reset the timer when manually navigating
                startAutoSlide();
            });
        });

        // Add transition effect to banner
        bannerContainer.style.transition = 'opacity 0.5s ease';

        // Initialize slideshow
        startAutoSlide();

        // Pause slideshow when user hovers over banner
        bannerContainer.addEventListener('mouseenter', stopAutoSlide);
        bannerContainer.addEventListener('mouseleave', startAutoSlide);
    </script>

<?php include('./views/layouts/footer.php'); ?>

