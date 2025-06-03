-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 17, 2025 at 03:01 AM
-- Server version: 10.6.15-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `movie_online`
--

-- --------------------------------------------------------

--
-- Table structure for table `actors`
--

CREATE TABLE `actors` (
  `actor_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `biography` text DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `slug` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `advertisements`
--

CREATE TABLE `advertisements` (
  `ad_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `redirect_url` varchar(255) DEFAULT NULL,
  `position` varchar(50) DEFAULT NULL,
  `start_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `end_date` timestamp NULL DEFAULT NULL,
  `active` tinyint(1) DEFAULT 1,
  `views` int(11) DEFAULT 0,
  `clicks` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `comment_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `movie_id` int(11) NOT NULL,
  `episode_id` int(11) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL COMMENT 'For reply comments',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`comment_id`, `content`, `user_id`, `movie_id`, `episode_id`, `parent_id`, `created_at`) VALUES
(5, 'hi', 6, 122, NULL, NULL, '2025-05-16 14:00:58'),
(6, 'woah', 6, 122, NULL, NULL, '2025-05-16 14:01:35'),
(7, 'ko', 1, 122, NULL, 6, '2025-05-16 15:09:36'),
(8, 'á', 1, 122, NULL, 6, '2025-05-16 15:11:02'),
(9, 'cúc', 6, 122, NULL, NULL, '2025-05-16 15:17:02');

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `country_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `slug` varchar(50) DEFAULT NULL,
  `iso_code` char(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`country_id`, `name`, `slug`, `iso_code`) VALUES
(1, 'Hoa Kỳ', 'hoa-ky', 'US'),
(2, 'Anh', 'anh', 'GB'),
(3, 'Nhật Bản', 'nhat-ban', 'JP'),
(4, 'Hàn Quốc', 'han-quoc', 'KR'),
(5, 'Trung Quốc', 'trung-quoc', 'CN'),
(6, 'Pháp', 'phap', 'FR'),
(7, 'Đức', 'duc', 'DE'),
(8, 'Ấn Độ', 'an-do', 'IN'),
(9, 'Ý', 'y', 'IT'),
(10, 'Canada', 'canada', 'CA'),
(11, 'Tây Ban Nha', 'tay-ban-nha', 'ES'),
(12, 'Úc', 'uc', 'AU'),
(13, 'Nga', 'nga', 'RU'),
(14, 'Mexico', 'mexico', 'MX'),
(15, 'Việt Nam', 'viet-nam', 'VN');

-- --------------------------------------------------------

--
-- Table structure for table `directors`
--

CREATE TABLE `directors` (
  `director_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `biography` text DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `slug` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `episodes`
--

CREATE TABLE `episodes` (
  `episode_id` int(11) NOT NULL,
  `movie_id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `episode_number` int(11) NOT NULL,
  `video_url` varchar(255) NOT NULL,
  `duration` int(11) DEFAULT NULL COMMENT 'Duration in minutes',
  `views` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `favorites`
--

CREATE TABLE `favorites` (
  `favorite_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `movie_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `genres`
--

CREATE TABLE `genres` (
  `genre_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` text DEFAULT NULL,
  `slug` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `genres`
--

INSERT INTO `genres` (`genre_id`, `name`, `description`, `slug`) VALUES
(12, 'Phiêu lưu', NULL, 'phieu-luu'),
(14, 'Giả tưởng', NULL, 'gia-tuong'),
(16, 'Hoạt hình', NULL, 'hoat-hinh'),
(18, 'Chính kịch', NULL, 'chinh-kich'),
(27, 'Kinh dị', NULL, 'kinh-di'),
(28, 'Hành động', NULL, 'hanh-dong'),
(35, 'Hài', NULL, 'hai'),
(36, 'Lịch sử', NULL, 'lich-su'),
(37, 'Viễn Tây', NULL, 'vien-tay'),
(53, 'Giật gân', NULL, 'giat-gan'),
(80, 'Tội phạm', NULL, 'toi-pham'),
(99, 'Tài liệu', NULL, 'tai-lieu'),
(878, 'Khoa học viễn tưởng', NULL, 'khoa-hoc-vien-tuong'),
(9648, 'Bí ẩn', NULL, 'bi-an'),
(10402, 'Âm nhạc', NULL, 'am-nhac'),
(10749, 'Lãng mạn', NULL, 'lang-man'),
(10751, 'Gia đình', NULL, 'gia-dinh'),
(10752, 'Chiến tranh', NULL, 'chien-tranh'),
(10770, 'Truyền hình', NULL, 'truyen-hinh');

-- --------------------------------------------------------

--
-- Table structure for table `movies`
--

CREATE TABLE `movies` (
  `movie_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `original_title` varchar(255) DEFAULT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `poster` varchar(255) DEFAULT NULL,
  `background` varchar(255) DEFAULT NULL,
  `trailer_url` varchar(255) DEFAULT NULL,
  `video_url` varchar(255) DEFAULT NULL,
  `release_year` int(11) DEFAULT NULL,
  `duration` int(11) DEFAULT NULL COMMENT 'Duration in minutes',
  `quality` varchar(20) DEFAULT 'HD',
  `views` int(11) DEFAULT 0,
  `rating` float DEFAULT 0,
  `status` enum('ongoing','completed') DEFAULT 'completed',
  `premium` tinyint(1) DEFAULT 0,
  `country_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `movies`
--

INSERT INTO `movies` (`movie_id`, `title`, `original_title`, `slug`, `description`, `poster`, `background`, `trailer_url`, `video_url`, `release_year`, `duration`, `quality`, `views`, `rating`, `status`, `premium`, `country_id`, `created_at`, `updated_at`) VALUES
(1, 'Mật Vụ Phụ Hồ', 'A Working Man', 'm-t-v-ph-h', 'Levon Cade - cựu biệt kích tinh nhuệ thuộc lực lượng Thủy quân Lục chiến Hoàng gia Anh. Sau khi nghỉ hưu, anh sống cuộc đời yên bình là một công nhân xây dựng tại Chicago (Mỹ). Levon có mối quan hệ rất tốt với gia đình ông chủ Joe Garcia (Michael Peña). Một ngày nọ, cô con gái tuổi teen Jenny (Arianna Rivas) của Joe bị bắt cóc khiến chàng cựu quân nhân phải sử dụng lại các kỹ năng giết chóc của mình để giúp đỡ.', 'https://image.tmdb.org/t/p/w500/qmVVc6ZVw9PEwkr4G0Obmlg7woC.jpg', 'https://image.tmdb.org/t/p/w500/fTrQsdMS2MUw00RnzH0r3JWHhts.jpg', NULL, 'https://www.youtube.com/watch?v=N1yeQ7Upw40', 2025, 120, '0', 82281, 6.307, 'completed', 0, 1, '2025-04-26 10:15:24', '2025-04-27 05:45:42'),
(2, 'Một bộ phim Minecraft', 'A Minecraft Movie', 'm-t-b-phim-minecraft', '', 'https://image.tmdb.org/t/p/w500/wRrGBv4uNofBVyShxfS0iugbcm8.jpg', 'https://image.tmdb.org/t/p/w500/2Nti3gYAX513wvhp8IiLL6ZDyOm.jpg', NULL, NULL, 2025, 120, '0', 30240, 6.19, 'completed', 0, 1, '2025-04-26 10:15:25', '2025-04-26 10:15:25'),
(3, 'Vùng Đất Bị Quên Lãng', 'In the Lost Lands', 'v-ng-t-b-qu-n-l-ng', 'Một nữ hoàng đã phái nữ phù thủy quyền năng và đáng sợ Gray Alys đến vùng đất ma quái Lost Lands để tìm kiếm sức mạnh ma thuật, nơi cô và người hướng dẫn của mình, kẻ lang thang Boyce, phải đánh bại cả con người và ác quỷ.', 'https://image.tmdb.org/t/p/w500/t6HJH3gXtUqVinyFKWi7Bjh73TM.jpg', 'https://image.tmdb.org/t/p/w500/op3qmNhvwEvyT7UFyPbIfQmKriB.jpg', NULL, NULL, 2025, 120, '0', 93371, 6.307, 'completed', 0, 1, '2025-04-26 10:15:25', '2025-04-26 10:15:25'),
(4, 'Chuyến tàu viên đạn kinh hoàng', '新幹線大爆破', 'chuy-n-t-u-vi-n-n-kinh-ho-ng', 'Các nhà chức trách phải chạy đua với thời gian để cứu hành khách đang hoảng loạn trên con tàu cao tốc hướng đến Tokyo khi tàu có nguy cơ phát nổ nếu tốc độ xuống dưới 100 km/giờ.', 'https://image.tmdb.org/t/p/w500/xzIt4P1rc0apYYnWswqUzR4kcX2.jpg', 'https://image.tmdb.org/t/p/w500/Zes06xI18u47pblwRGTtqRm0R8.jpg', NULL, NULL, 2025, 120, '0', 40543, 6.394, 'completed', 0, 1, '2025-04-26 10:15:25', '2025-04-26 10:15:25'),
(5, 'Captain America: Thế Giới Mới', 'Captain America: Brave New World', 'captain-america-th-gi-i-m-i', 'Sau khi gặp Tổng thống Hoa Kỳ mới đắc cử Thaddeus Ross, Sam Wilson thấy mình bị cuốn vào một sự cố . Anh phải khám phá lý do đằng sau một âm mưu cực kì xấu xa trước khi kẻ chủ mưu thật sự khiến cả thế giới phải hoảng sợ', 'https://image.tmdb.org/t/p/w500/fWTZk4Y7HTyTTGNJnXNaX3XTE0v.jpg', 'https://image.tmdb.org/t/p/w500/jhL4eTpccoZSVehhcR8DKLSBHZy.jpg', NULL, NULL, 2025, 120, '0', 58803, 6.147, 'completed', 0, 1, '2025-04-26 10:15:25', '2025-04-26 10:15:25'),
(6, 'Cuộc Bủa Vay', 'The Siege', 'cu-c-b-a-vay', 'Sát thủ quốc tế Walker bị xâm phạm trong một nhiệm vụ và được gửi đến một trung tâm phân công lại để lấy danh tính mới. Trong thời gian anh ta ở lại cơ sở, một đội tấn công tàn nhẫn đã xông vào khu nhà để tìm kiếm người mà ông chủ của họ đã mất. Walker miễn cưỡng rơi vào tay nữ sát thủ lành nghề Elda và phường Juliet bí ẩn của cô ta để sống sót qua đêm.', 'https://image.tmdb.org/t/p/w500/hVh4hMzkXNLnScudbid6hDvjMPk.jpg', 'https://image.tmdb.org/t/p/w500/4eC0tsU9OxR3Adlo1yRJYUDraW9.jpg', NULL, NULL, 2023, 120, '0', 45029, 5.432, 'completed', 0, 1, '2025-04-26 10:15:26', '2025-04-26 10:15:26'),
(7, 'Tàn phá', 'Havoc', 't-n-ph', 'Khi vụ cướp ma túy vượt ngoài tầm kiểm soát, một cảnh sát chán chường chiến đấu giữa thế giới tội phạm ngầm ở thành phố thối nát để cứu con trai của một chính trị gia.', 'https://image.tmdb.org/t/p/w500/r46leE6PSzLR3pnVzaxx5Q30yUF.jpg', 'https://image.tmdb.org/t/p/w500/segpvueoaTyzZcgTTNr4QMvefqe.jpg', NULL, NULL, 2025, 120, '0', 89320, 6.823, 'completed', 0, 1, '2025-04-26 10:15:26', '2025-04-26 10:15:26'),
(8, 'G20', 'G20', 'g20', 'Sau khi Hội nghị thượng đỉnh G20 bị bọn khủng bố chiếm giữ, Tổng thống Danielle Sutton phải vận dụng mọi tài năng chính trị và kinh nghiệm quân sự của mình để bảo vệ gia đình và các nhà lãnh đạo đồng nghiệp.', 'https://image.tmdb.org/t/p/w500/wv6oWAleCJZUk5htrGg413t3GCy.jpg', 'https://image.tmdb.org/t/p/w500/k32XKMjmXMGeydykD32jfER3BVI.jpg', NULL, NULL, 2025, 120, '0', 42179, 6.6, 'completed', 0, 1, '2025-04-26 10:15:26', '2025-04-26 10:15:26'),
(9, 'Tội Đồ', 'Sinners', 't-i', 'Cố gắng bỏ lại cuộc sống đầy rắc rối của mình, hai anh em sinh đôi trở về quê hương để bắt đầu lại, chỉ để phát hiện ra rằng một cái ác thậm chí còn lớn hơn đang chờ đợi để chào đón họ trở lại.', 'https://image.tmdb.org/t/p/w500/fWPgbnt2LSqkQ6cdQc0SZN9CpLm.jpg', 'https://image.tmdb.org/t/p/w500/oUgVgGaNqV9Y0Zdyjc1kCpzIe4G.jpg', NULL, NULL, 2025, 120, '0', 56438, 7.511, 'completed', 0, 1, '2025-04-26 10:15:27', '2025-04-26 10:15:27'),
(10, 'Anh Không Đau', 'Novocaine', 'anh-kh-ng-au', 'Một người đàn ông không thể cảm nhận nỗi đau thể xác đã biến căn bệnh hiếm gặp của mình thành lợi thế bất ngờ trong cuộc chiến sinh tử để giải cứu cô gái trong mơ.', 'https://image.tmdb.org/t/p/w500/l7KHxP9pxDxkpjMU1CcM8FjE5ON.jpg', 'https://image.tmdb.org/t/p/w500/sNx1A3822kEbqeUxvo5A08o4N7o.jpg', NULL, NULL, 2025, 120, '0', 79305, 6.897, 'completed', 0, 1, '2025-04-26 10:15:27', '2025-04-26 10:15:27'),
(11, 'Xạ Thủ Miền Viễn Tây: Cuộc Đọ Súng Ác Liệt', 'Gunslingers', 'x-th-mi-n-vi-n-t-y-cu-c-s-ng-c-li-t', 'Khi người đàn ông bị truy nã nhất ở Mỹ xuất hiện trong một thị trấn nhỏ ở Kentucky, lịch sử bạo lực của anh ta-và một đám đông đã tìm kiếm sự báo thù và một vị vua tiền chuộc-sớm theo sau. Khi anh em đối đầu với nhau và Bullets xé nát thị trấn để phá hủy, tay súng nhanh như chớp này khiến kẻ thù của anh ta phải trả giá cao cho lòng tham của họ.', 'https://image.tmdb.org/t/p/w500/O7REXWPANWXvX2jhQydHjAq2DV.jpg', 'https://image.tmdb.org/t/p/w500/zksO4lVnRKRoaSYzh2EDn2Z3Pel.jpg', NULL, NULL, 2025, 120, '0', 69761, 6.775, 'completed', 0, 1, '2025-04-26 10:15:27', '2025-04-26 10:15:27'),
(12, 'Người Đàn Bà Ngoài Sân', 'The Woman in the Yard', 'ng-i-n-b-ngo-i-s-n', '', 'https://image.tmdb.org/t/p/w500/n0WS2TsNcS6dtaZKzxipyO7LuCJ.jpg', 'https://image.tmdb.org/t/p/w500/3lEV4CoKoeT2cZ4fbKEJugZcw6Z.jpg', NULL, NULL, 2025, 120, '0', 9367, 5.989, 'completed', 0, 1, '2025-04-26 10:15:28', '2025-04-26 10:15:28'),
(13, 'Mật Nghị Vatican', 'Conclave', 'm-t-ngh-vatican', 'Khi Hồng y Lawrence được giao nhiệm vụ lãnh đạo một trong những sự kiện bí mật và lâu đời nhất thế giới, lựa chọn một Giáo hoàng mới, ông thấy mình ở trung tâm của một âm mưu có thể làm rung chuyển nền tảng của Giáo hội Công giáo.', 'https://image.tmdb.org/t/p/w500/xBMr0bRwyzEPPqU8l73SWu6kbp.jpg', 'https://image.tmdb.org/t/p/w500/1YMrOtrW7b4pL2lfD8UciZPOJGs.jpg', NULL, NULL, 2024, 120, '0', 29213, 7.195, 'completed', 0, 1, '2025-04-26 10:15:28', '2025-04-26 10:15:28'),
(14, 'Bí Ẩn Không Gian', 'Ash', 'b-n-kh-ng-gian', 'Trên một hành tinh xa xôi, nữ phi hành gia Riya tỉnh dậy và phát hiện toàn bộ phi hành đoàn của trạm vũ trụ đã bị sát hại dã man. Cô bị mất trí nhớ, chỉ còn những ký ức rời rạc về đồng đội và nhiệm vụ. Khi một người đàn ông tên Brion xuất hiện, tự nhận là người được cử đến cứu cô, Riya phải đối mặt với sự nghi ngờ và không biết liệu có thể tin tưởng anh ta hay không. Trong khi đó, nguồn cung cấp oxy của cô đang cạn kiệt, buộc cô phải đưa ra những quyết định sinh tử.', 'https://image.tmdb.org/t/p/w500/5Oz39iyRuztiA8XqCNVDBuy2Ut3.jpg', 'https://image.tmdb.org/t/p/w500/sQa299yggIkxfwKJFgzYwDdsC9t.jpg', NULL, NULL, 2025, 120, '0', 5305, 5.854, 'completed', 0, 1, '2025-04-26 10:15:28', '2025-04-26 10:15:28'),
(15, 'Locked', 'Locked', 'locked', '', 'https://image.tmdb.org/t/p/w500/hhkiqXpfpufwxVrdSftzeKIANl3.jpg', 'https://image.tmdb.org/t/p/w500/r4X2xRrWleVgx0kahP27xRmm3ia.jpg', NULL, NULL, 2025, 120, '0', 14940, 6, 'completed', 0, 1, '2025-04-26 10:15:28', '2025-04-26 10:15:28'),
(16, 'Hành Trình Của Moana 2', 'Moana 2', 'h-nh-tr-nh-c-a-moana-2', '“Hành Trình của Moana 2” là màn tái hợp của Moana và Maui sau 3 năm, trở lại trong chuyến phiêu lưu cùng với những thành viên mới. Theo tiếng gọi của tổ tiên, Moana sẽ tham gia cuộc hành trình đến những vùng biển xa xôi của Châu Đại Dương và sẽ đi tới vùng biển nguy hiểm, đã mất tích từ lâu. Cùng chờ đón cuộc phiêu lưu của Moana đầy chông gai sắp tới nhé.', 'https://image.tmdb.org/t/p/w500/g8ikn2lfi4R04U7BtXvHmYvnUTV.jpg', 'https://image.tmdb.org/t/p/w500/zo8CIjJ2nfNOevqNajwMRO6Hwka.jpg', NULL, NULL, 2024, 120, '0', 90421, 7.08, 'completed', 0, 1, '2025-04-26 10:15:29', '2025-04-26 10:15:29'),
(17, 'Mufasa: Vua Sư Tử', 'Mufasa: The Lion King', 'mufasa-vua-s-t', 'Mufasa: Vua Sư Tử là phần tiền truyện của bộ phim hoạt hình Vua Sư Tử trứ danh, kể về cuộc đời của Mufasa - cha của Simba. Phim là hành trình Mufasa từ một chú sư tử mồ côi lạc đàn trở thành vị vua sư tử huyền thoại của Xứ Vua (Pride Land). Ngoài ra, quá khứ về tên phản diện Scar và hành trình hắc hóa của hắn cũng sẽ được phơi bày trong phần phim này.', 'https://image.tmdb.org/t/p/w500/yTiVUcBeSUpmsPSbmzzK2JHeBjJ.jpg', 'https://image.tmdb.org/t/p/w500/1w8kutrRucTd3wlYyu5QlUDMiG1.jpg', NULL, NULL, 2024, 120, '0', 21483, 7.414, 'completed', 0, 1, '2025-04-26 10:15:29', '2025-04-26 10:15:29'),
(18, 'Nhím Sonic 3', 'Sonic the Hedgehog 3', 'nh-m-sonic-3', 'Sonic, Knuckles và Tails phải đối mặt với một kẻ thù mới cực kỳ mạnh mẽ là Shadow - một nhân vật phản diện bí ẩn với sức mạnh không giống bất kỳ đối thủ nào họ từng đối mặt trước đây. Bị áp đảo về năng lực, Sonic phải lên đường thành lập một liên minh to lớn hơn.', 'https://image.tmdb.org/t/p/w500/zRgxYzRu4s8smKMskdfMA2hOzyN.jpg', 'https://image.tmdb.org/t/p/w500/b85bJfrTOSJ7M5Ox0yp4lxIxdG1.jpg', NULL, NULL, 2024, 120, '0', 57490, 7.726, 'completed', 0, 1, '2025-04-26 10:15:29', '2025-04-26 10:15:29'),
(19, 'లైలా', 'లైలా', '', '', 'https://image.tmdb.org/t/p/w500/l4gsNxFPGpzbq0D6QK1a8vO1lBz.jpg', 'https://image.tmdb.org/t/p/w500/vNUwK5P42m81uG57kKI1WxSZwIQ.jpg', NULL, NULL, 2025, 120, '0', 67723, 5.5, 'completed', 0, 1, '2025-04-26 10:15:29', '2025-04-26 10:15:29'),
(20, 'The Codes of War', 'The Codes of War', 'the-codes-of-war', '', 'https://image.tmdb.org/t/p/w500/oXeiQAfRK90pxxhP5iKPXQqAIN1.jpg', 'https://image.tmdb.org/t/p/w500/ibF5XVxTzf1ayzZrmiJqgeQ39Qk.jpg', NULL, NULL, 2025, 120, '0', 57645, 6.2, 'completed', 0, 1, '2025-04-26 10:15:29', '2025-04-26 10:15:29'),
(121, 'Cõi Gián Đoạn: Tái Sinh', 'Home Sweet Home: Rebirth', 'c-i-gi-n-o-n-t-i-sinh', 'Khi một thành phố bị đám đông quỷ ám tràn ngập, một cảnh sát phải tìm ra nguồn gốc của cái ác để cứu gia đình mình.', 'https://image.tmdb.org/t/p/w500/9rCBCm9cyI4JfLEhx3EncyncMR3.jpg', 'https://image.tmdb.org/t/p/w500/wmqpE7p2dUCEgCnovuovoNXaCXr.jpg', NULL, NULL, 2025, 120, '0', 70389, 6.734, 'completed', 0, 1, '2025-04-26 13:27:38', '2025-04-26 13:27:38'),
(122, 'Đặc Vụ Lau Kính', 'Cleaner', 'c-v-lau-k-nh', 'Khi một nhóm các nhà hoạt động cấp tiến chiếm lấy buổi tiệc thường niên của một công ty năng lượng, bắt giữ 300 con tin, một cựu chiến binh chuyển sang làm người lau cửa sổ bị treo lơ lửng ở bên ngoài tòa nhà trên tầng 50 phải cứu những người bị mắc kẹt bên trong, bao gồm cả em trai của cô.', 'https://image.tmdb.org/t/p/w500/mwzDApMZAGeYCEVjhegKvCzDX0W.jpg', 'https://image.tmdb.org/t/p/w500/gsQJOfeW45KLiQeEIsom94QPQwb.jpg', NULL, 'https://www.youtube.com/watch?v=cy03zVrcLNI', 2025, 120, '0', 97294, 6.575, 'completed', 0, 1, '2025-04-26 13:27:39', '2025-04-27 05:51:09'),
(123, 'Cuộc Khổ Nạn Của Chúa Giêsu', 'The Passion of the Christ', 'cu-c-kh-n-n-c-a-ch-a-gi-su', 'Một bức chân dung đồ họa về mười hai giờ cuối cùng trong cuộc đời của Chúa Giê-xu thành Nazareth.', 'https://image.tmdb.org/t/p/w500/v9f9MMrq2nGQrN7cHnQRmEq9lSE.jpg', 'https://image.tmdb.org/t/p/w500/pulJ1iY7GVeppMRipiR7ZGDW7EW.jpg', NULL, NULL, 2004, 120, '0', 28579, 7.5, 'completed', 0, 1, '2025-04-26 13:27:39', '2025-04-26 13:27:39'),
(124, 'Mickey 17', 'Mickey 17', 'mickey-17', 'Được chuyển thể từ tiểu thuyết Mickey 7 của nhà văn Edward Ashton, Cuốn tiểu thuyết xoay quanh các phiên bản nhân bản vô tính mang tên “Mickey”, dùng để thay thế con người thực hiện cuộc chinh phạt nhằm thuộc địa hóa vương quốc băng giá Niflheim. Mỗi khi một Mickey chết đi, một Mickey mới sẽ được tạo ra, với phiên bản được đánh số 1, 2, 3 tiếp theo. Mickey số 7 được cho rằng đã chết, để rồi một ngày kia, hắn quay lại và bắt gặp phiên bản tiếp theo của mình.', 'https://image.tmdb.org/t/p/w500/XsKM62tGS8eRPm9sM9fYGEyZVn.jpg', 'https://image.tmdb.org/t/p/w500/hNA73rnG4PjSwgojaC2gbO1f8Rt.jpg', 'https://www.youtube.com/watch?v=VFjVjNhEq2A', NULL, 2025, 120, '0', 66498, 6.907, 'completed', 0, 1, '2025-04-26 13:27:40', '2025-04-26 13:27:40'),
(125, 'Cuộc Chiến Của Hiệp Sĩ', 'A Knight\'s War', 'cu-c-chi-n-c-a-hi-p-s', 'Nội dung phim Cuộc Chiến Của Hiệp Sĩ – A Knight’s War (2025) fshare: Nhân vật chính là Paladin Bhodie (do Jeremy Ninaber thủ vai), một hiệp sĩ dũng cảm được giao nhiệm vụ giải cứu Avalon (Kristen Kaster), một thiếu nữ tóc đỏ được tiên tri là “Người được chọn” có khả năng cứu rỗi nhân loại. Để thực hiện nhiệm vụ, Bhodie phải bước vào một vùng đất bị nguyền rủa, nơi anh phải đối mặt với những mối nguy …; Trên đây là nội dung phim Cuộc Chiến Của Hiệp Sĩ – A Knight’s War (2025)', 'https://image.tmdb.org/t/p/w500/janjdSMrTRGtPrI1p9uOX66jv7x.jpg', 'https://image.tmdb.org/t/p/w500/cJCW78MZsyyXBKHo4V25WctK00V.jpg', NULL, NULL, 2025, 120, '0', 74175, 5.4, 'completed', 0, 1, '2025-04-26 13:27:40', '2025-04-26 13:27:40'),
(126, 'Avengers 3: Cuộc Chiến Vô Cực', 'Avengers: Infinity War', 'avengers-3-cu-c-chi-n-v-c-c', 'Sau chuyến hành trình độc nhất vô nhị không ngừng mở rộng và phát triển vụ trũ điện ảnh Marvel, bộ phim Avengers: Cuộc Chiến Vô Cực sẽ mang đến màn ảnh trận chiến cuối cùng khốc liệt nhất mọi thời đại. Biệt đội Avengers và các đồng minh siêu anh hùng của họ phải chấp nhận hy sinh tất cả để có thể chống lại kẻ thù hùng mạnh Thanos trước tham vọng hủy diệt toàn bộ vũ trụ của hắn.', 'https://image.tmdb.org/t/p/w500/8gHc1cthgTOkmMiOREodCVZgJ7P.jpg', 'https://image.tmdb.org/t/p/w500/mDfJG3LC3Dqb67AZ52x3Z0jU0uB.jpg', 'https://www.youtube.com/watch?v=DKqu9qc-5f4', NULL, 2018, 120, '0', 47312, 8.235, 'completed', 0, 1, '2025-04-26 13:27:41', '2025-04-26 13:27:41'),
(127, 'Băng Cướp Siêu Xe', 'Carjackers', 'b-ng-c-p-si-u-xe', 'Ban ngày, họ là những giá trị, tiếp viên và người pha chế vô hình tại một khách sạn sang trọng. Vào ban đêm, họ là những kẻ lừa đảo, một nhóm tài xế lành nghề theo dõi và Rob giàu có trên đường. Khi họ lên kế hoạch cho vụ trộm cuối cùng của họ, giám đốc khách sạn thuê một người tấn công tàn nhẫn, để ngăn chặn họ bằng mọi giá. Với nguy cơ đóng cửa, Nora, Zoe, Steve và uy tín có thể rút được điểm số lớn nhất của họ chưa?', 'https://image.tmdb.org/t/p/w500/pc7m459EdwSFL35SaxudNyv9nL8.jpg', 'https://image.tmdb.org/t/p/w500/is9bmV6uYXu7LjZGJczxrjJDlv8.jpg', NULL, NULL, 2025, 120, '0', 10584, 6.119, 'completed', 0, 1, '2025-04-26 13:27:41', '2025-04-26 13:27:41'),
(128, 'Pídeme lo que quieras', 'Pídeme lo que quieras', 'p-deme-lo-que-quieras', '', 'https://image.tmdb.org/t/p/w500/76qnVxU2rPdVvipBN3DPQH6fVYB.jpg', 'https://image.tmdb.org/t/p/w500/qiVrapzgrDO7c6yQTSvn0dhwsn8.jpg', NULL, NULL, 2024, 120, '0', 87429, 5.917, 'completed', 0, 1, '2025-04-26 13:27:42', '2025-04-26 13:27:42'),
(129, 'iHostage', 'iHostage', 'ihostage', 'Khi một kẻ cầm súng xông vào một cửa hàng Apple ở trung tâm Amsterdam, cảnh sát đối mặt với thử thách gian truân để giải quyết tình huống căng thẳng.', 'https://image.tmdb.org/t/p/w500/h87bgIhs4keL005Ch5aeKhnaAIL.jpg', 'https://image.tmdb.org/t/p/w500/4mM7m9L3XlPLq4vNNy3P8yDSXNM.jpg', NULL, NULL, 2025, 120, '0', 16813, 6.149, 'completed', 0, 1, '2025-04-26 13:27:42', '2025-04-26 13:27:42'),
(130, 'The Hard Hit', 'The Hard Hit', 'the-hard-hit', '', 'https://image.tmdb.org/t/p/w500/whkFbOZTamHeugEG95jvQehSzAH.jpg', 'https://image.tmdb.org/t/p/w500/fzv87rT0jlAkh5Uf9PpIlUj6Nj8.jpg', NULL, NULL, 2023, 120, '0', 51719, 6.778, 'completed', 0, 1, '2025-04-26 13:27:43', '2025-04-26 13:27:43'),
(131, 'Cuộc Đào Tẩu Trên Không', 'Flight Risk', 'cu-c-o-t-u-tr-n-kh-ng', 'Một phi công chịu trách nhiệm đưa Thống chế Không quân đến áp giải một kẻ chạy trốn về hầu tòa. Khi cả ba bay qua địa phận Alaska, căng thẳng leo thang, niềm tin bị thử thách, bởi không phải ai trên máy bay cũng như họ nghĩ. https://justwatch.pro/movie/1126166/flight-risk', 'https://image.tmdb.org/t/p/w500/pOoz9qovz41fafz1DHP5TDcl0RZ.jpg', 'https://image.tmdb.org/t/p/w500/hwlyY7LJdEFbCPaGNXiskKKmJ5X.jpg', NULL, NULL, 2025, 120, '0', 56620, 6.118, 'completed', 0, 1, '2025-04-26 13:27:44', '2025-04-26 13:27:44'),
(132, 'Sugar Baby', 'Sugar Baby', 'sugar-baby', '', 'https://image.tmdb.org/t/p/w500/z7NyxmdJ1ypn3Y6BVizjGODuBdO.jpg', 'https://image.tmdb.org/t/p/w500/kYqEsUtilXXcb7FDfGIUaDq7j5F.jpg', NULL, NULL, 2024, 120, '0', 36261, 6.038, 'completed', 0, 1, '2025-04-26 13:27:44', '2025-04-26 13:27:44'),
(133, 'Hẻm Núi - The Gorge', 'The Gorge', 'h-m-n-i-the-gorge', 'Hai đặc vụ được huấn luyện bài bản dần trở nên thân thiết từ xa sau khi được cử đến canh gác hai bên hẻm núi bí ẩn. Khi thế lực tà ác ở bên dưới xuất hiện, họ phải hợp tác để sống sót trước những gì ẩn chứa bên trong.', 'https://image.tmdb.org/t/p/w500/7iMBZzVZtG0oBug4TfqDb9ZxAOa.jpg', 'https://image.tmdb.org/t/p/w500/9nhjGaFLKtddDPtPaX5EmKqsWdH.jpg', NULL, NULL, 2025, 120, '0', 3795, 7.735, 'completed', 0, 1, '2025-04-26 13:27:45', '2025-04-26 13:27:45'),
(134, 'Mật Danh: Kế Toán 2', 'The Accountant 2', 'm-t-danh-k-to-n-2', '', 'https://image.tmdb.org/t/p/w500/8fYCgQGO1lKDYHrUgejGB8sUdol.jpg', 'https://image.tmdb.org/t/p/w500/abznrQ6EAxV7vZglaS5umsrTNOS.jpg', NULL, NULL, 2025, 120, '0', 31279, 7.5, 'completed', 0, 1, '2025-04-26 13:27:45', '2025-04-26 13:27:45'),
(135, 'Deva', 'देवा', 'deva', 'Một cảnh sát thông minh nhưng nổi loạn đã phát hiện ra một mạng lưới lừa dối và phản bội trong khi điều tra một vụ án nghiêm trọng.', 'https://image.tmdb.org/t/p/w500/4wKpglgZYMYpISMdThgdqS1TSQc.jpg', 'https://image.tmdb.org/t/p/w500/lqHt4icP1GTaNBeVTxTrwTZdoAW.jpg', NULL, NULL, 2025, 120, '0', 98149, 6.1, 'completed', 0, 1, '2025-04-26 13:27:46', '2025-04-26 13:27:46'),
(136, 'Người Dơi Ninja Đối Đầu Liên Minh Yakuza', 'ニンジャバットマン対ヤクザリーグ', 'ng-i-d-i-ninja-i-u-li-n-minh-yakuza', 'Gia đình Batman trở về hiện tại và phát hiện Nhật Bản đã biến mất, thay vào đó là một hòn đảo khổng lồ tên Hinomoto lơ lửng trên bầu trời Gotham. Trên đỉnh quyền lực là Yakuza – một nhóm siêu nhân cai trị tàn bạo và trông rất giống Justice League. Giờ đây, Batman và đồng đội phải chiến đấu để cứu Gotham!', 'https://image.tmdb.org/t/p/w500/y2mQtPz6uDdw4CRpSdU5tlGB2MA.jpg', 'https://image.tmdb.org/t/p/w500/e807jDKiFcntZS32ze88X6I96OD.jpg', NULL, NULL, 2025, 120, '0', 19234, 6.615, 'completed', 0, 1, '2025-04-26 13:27:46', '2025-04-26 13:27:46'),
(137, 'Người Nhện: Trở Về Nhà', 'Spider-Man: Homecoming', 'ng-i-nh-n-tr-v-nh', 'Tạm biệt hai franchise về thời sinh viên, Spider-Man: Homecoming sẽ lần đầu tiên đưa các khán giả đến với cuộc sống trung học của Peter Paker – siêu anh hùng Người Nhện. Liệu một cậu bé chưa trưởng thành sẽ làm thế nào để cân bằng cuộc sống bình thường và trách nhiệm của một anh hùng giải cứu thế giới. Đây cũng là lần đầu tiên, series Người Nhện có sự tham gia sản xuất của Marvel Studio và sự xuất hiện của Iron Man – Robert Downey Jr.', 'https://image.tmdb.org/t/p/w500/tNm6pNf9Xe1gPKu4xqPEWj0issu.jpg', 'https://image.tmdb.org/t/p/w500/tPpYGm2mVecue7Bk3gNVoSPA5qn.jpg', NULL, NULL, 2017, 120, '0', 88966, 7.331, 'completed', 0, 1, '2025-04-26 13:27:47', '2025-04-26 13:27:47'),
(138, 'Easter Bloody Easter', 'Easter Bloody Easter', 'easter-bloody-easter', '', 'https://image.tmdb.org/t/p/w500/8tGYZlPttiOjEe61GvszRcrnpEi.jpg', 'https://image.tmdb.org/t/p/w500/lljZTHeXJ3mNt3IC5Kh7MPXVKeZ.jpg', NULL, NULL, 2024, 120, '0', 7136, 4.5, 'completed', 0, 1, '2025-04-26 13:27:47', '2025-04-26 13:27:47'),
(139, 'Phản công', 'Contraataque', 'ph-n-c-ng', 'Khi nhiệm vụ giải cứu con tin dẫn đến thêm kẻ thù mới, đại úy Guerrero cùng đội lính tinh nhuệ phải đối mặt với cuộc phục kích của một nhóm tội phạm.', 'https://image.tmdb.org/t/p/w500/kxnFdLJhi37ZVFDCL1ka0yeQVU5.jpg', 'https://image.tmdb.org/t/p/w500/deUWVEgNh2IGjShyymZhaYP40ye.jpg', NULL, NULL, 2025, 120, '0', 63193, 8.378, 'completed', 0, 1, '2025-04-26 13:27:48', '2025-04-26 13:27:48'),
(140, 'Cosmic Chaos', 'Cosmic Chaos', 'cosmic-chaos', '', 'https://image.tmdb.org/t/p/w500/mClzWv7gBqgXfjZXp49Enyoex1v.jpg', 'https://image.tmdb.org/t/p/w500/m2mzlsJjE3UAqeUB5fLUkpWg4Iq.jpg', NULL, NULL, 2023, 120, '0', 35164, 6.064, 'completed', 0, 1, '2025-04-26 13:27:48', '2025-04-26 13:27:48'),
(161, 'Nàng Bạch Tuyết', 'Snow White', 'n-ng-b-ch-tuy-t', 'Phiên bản live-action từ Disney với sự tham gia của Rachel Zegler và Gal Gadot, dự kiến khởi chiếu năm 2024.', 'https://image.tmdb.org/t/p/w500/24vmIaNTaXPXKdveylQ2C3hcWaD.jpg', 'https://image.tmdb.org/t/p/w500/xb9wpY31SeVZbfkevYuolhfV63w.jpg', NULL, NULL, 2025, 120, '0', 69075, 4.5, 'completed', 0, 1, '2025-04-26 13:29:47', '2025-04-26 13:29:47'),
(162, 'Vua Sư Tử', 'The Lion King', 'vua-s-t', 'Bộ phim Vua Sư Tử được đạo diễn bởi Jon Favreau sẽ đưa khán giả đến với xavan Châu Phi rộng lớn nơi vị vua tương lai Simba được sinh ra. Tuy là người kế vị ngai vàng chính thức nhưng Simba phải đương đầu với những âm mưu của Scar, người chú ruột luôn toan tính chiếm lấy ngôi báu.  Cuộc chiến ở Pride Rock trở nên khốc liệt hơn bao giờ hết và đỉnh điểm là việc chú sư tử Simba bị lưu đày khỏi quê hương. Với sự giúp đỡ của 2 người bạn mới Timon và Pumbaa, Simba dần học cách trưởng thành và quay trở về để giành lại những gì vốn dĩ thuộc về cậu. Bằng kĩ xảo đồ họa ấn tượng và âm nhạc sống động, Vua Sư Tử sẽ tái hiện lại những nhân vật mà khán giả yêu mến theo một cách hoàn toàn mới.', 'https://image.tmdb.org/t/p/w500/hNltEgOaOIONA6peqiIb9WR1lTG.jpg', 'https://image.tmdb.org/t/p/w500/1TUg5pO1VZ4B0Q1amk3OlXvlpXV.jpg', NULL, NULL, 2019, 120, '0', 62864, 7.111, 'completed', 0, 1, '2025-04-26 13:29:48', '2025-04-26 13:29:48'),
(163, 'Bộ Ba Quái Nhân', 'Glass', 'b-ba-qu-i-nh-n', 'Cuộc đụng độ của ba quái nhân. David Dunn - một người đàn ông bình thường sở hữu sức mạnh siêu phàm; \"Quý ngài Glass\" Elijah. \"Bộ Ba Quái Nhân\" và Kevin Wendell Crumb - một quái nhân với 24 tính cách tồn tại trong cùng một cơ thể.', 'https://image.tmdb.org/t/p/w500/zRQyBALCS8jHlI9Xr88PsgrmSrh.jpg', 'https://image.tmdb.org/t/p/w500/iRJnw5OpueLhrYMnCxdydogVHUg.jpg', NULL, NULL, 2019, 120, '0', 35968, 6.7, 'completed', 0, 1, '2025-04-26 13:29:48', '2025-04-26 13:29:48'),
(164, 'Star Wars 4: Niềm Hy Vọng Mới', 'Star Wars', 'star-wars-4-ni-m-hy-v-ng-m-i', 'Luke Skywalker sống trên một trang trại ở hành tinh Tatooine bụi bặm cùng với cô và chú của anh. Luke là một thanh niên gan dạ và rất nóng lòng được trở thành một chiến binh nổi lọan. Lúc này, tên Darth Vader tàn bạo đã thôn tính cả thiên hà và đang hoàn thành một vũ khí hủy diệt khủng khiếp, Death Star. Công chúa Leia, người dẫn đầu phong trào nổi lọan, biết được kế họach này và tìm cách báo cho Obi-Wan Kenobi, một nhà tu hành già nua sống ẩn dật có sức mạnh phi thường. Vô tình tìm thấy mẩu tin báo nguy của công chúa dấu trong người máy R2D2, Luke lên đường tìm kiếm Obi-Wan Kenobi để hợp sức cùng nhau cứu công chúa cũng như giải thóat cả thiên hà...', 'https://image.tmdb.org/t/p/w500/6FfCtAuVAW8XJjZ7eWeLibRLWTw.jpg', 'https://image.tmdb.org/t/p/w500/2w4xG178RpB4MDAIfTkqAuSJzec.jpg', NULL, NULL, 1977, 120, '0', 61462, 8.203, 'completed', 0, 1, '2025-04-26 13:29:49', '2025-04-26 13:29:49'),
(165, 'Người Đẹp và Quái Vật', 'Beauty and the Beast', 'ng-i-p-v-qu-i-v-t', 'Một chàng hoàng tử trẻ sống trong một tòa lâu đài nguy nga tráng lệ. Chàng có tất cả nhưng kiêu ngạo, tàn nhẫn và không biết đến tình yêu thương...  Chàng sẽ sống ra sao khi bị biến thành một con quái vật xấu xí?  Lời nguyền chỉ được hóa giải, khi chàng học được cách yêu ai đó, và cũng được người đó đáp lại trước khi cánh hoa hồng cuối cùng rơi xuống!', 'https://image.tmdb.org/t/p/w500/sGgWciqgbiKxmhBAJmhP9wegmCO.jpg', 'https://image.tmdb.org/t/p/w500/uU1Mt4JWhDvl4vKb3AfxNsorkoM.jpg', NULL, NULL, 2017, 120, '0', 25513, 6.971, 'completed', 0, 1, '2025-04-26 13:29:49', '2025-04-26 13:29:49'),
(166, 'Here After', 'Here After', 'here-after', '', 'https://image.tmdb.org/t/p/w500/by3EEDIVTdhNJolYK2Msn1RHRFH.jpg', 'https://image.tmdb.org/t/p/w500/gJduZE3cAmLVQknEfiR5t0vT4Ie.jpg', NULL, NULL, 2024, 120, '0', 25230, 5.059, 'completed', 0, 1, '2025-04-26 13:29:50', '2025-04-26 13:29:50'),
(167, 'Turno nocturno', 'Turno nocturno', 'turno-nocturno', '', 'https://image.tmdb.org/t/p/w500/iSSx9Bys64vlOkvkyKXtp19P7Re.jpg', 'https://image.tmdb.org/t/p/w500/o5vasl0xbZWWKQnAlaBTSgntHH2.jpg', NULL, NULL, 2024, 120, '0', 96320, 6.402, 'completed', 0, 1, '2025-04-26 13:29:50', '2025-04-26 13:29:50'),
(168, 'Batman Đại Chiến Superman: Ánh Sáng Công Lý', 'Batman v Superman: Dawn of Justice', 'batman-i-chi-n-superman-nh-s-ng-c-ng-l', 'Nội dung bộ phim sẽ xoay quanh cuộc đối đầu có 1-0-2 của vị hiệp sĩ mạnh mẽ, đáng gờm nhất của thành phố Gotham với biểu tượng được tôn sùng nhất của thành phố Metropolis. Nguyên nhân của “cuộc chiến” này bắt nguồn từ việc họ đang lo lắng vì không thể kiểm soát được siêu anh hùng mới có sức mạnh thần thánh. Tuy nhiên, trong lúc họ “mải miết” chiến đấu với nhau thì có một mối đe dọa khác đã nổi lên và đẩy nhân loại vào tình thế nguy hiểm hơn bao giờ hết.', 'https://image.tmdb.org/t/p/w500/aOqrz5D9Kl0ZRWoDjUj025o2os9.jpg', 'https://image.tmdb.org/t/p/w500/5fX1oSGuYdKgwWmUTAN5MNSQGzr.jpg', NULL, NULL, 2016, 120, '0', 12672, 5.977, 'completed', 0, 1, '2025-04-26 13:29:51', '2025-04-26 13:29:51'),
(169, 'Chuyện Tào Lao', 'Pulp Fiction', 'chuy-n-t-o-lao', 'Những câu chuyện tưởng chừng tầm phào về 2 gã găng tơ trên đường thực hiện mệnh lệnh của ông chủ với 1 võ sĩ quyền anh giết chết người phải chạy trốn có vẻ không liên quan nhưng khi ghép lại người xem sẽ có 1 bức tranh tổng thể, đặc trưng cho phong cách của đạo diễn Quentin Tarantino: đậm chất bạo lực, máu me.', 'https://image.tmdb.org/t/p/w500/vQWk5YBFWF4bZaofAbv0tShwBvQ.jpg', 'https://image.tmdb.org/t/p/w500/suaEOtk1N1sgg2MTM7oZd2cfVp3.jpg', NULL, NULL, 1994, 120, '0', 82290, 8.489, 'completed', 0, 1, '2025-04-26 13:29:51', '2025-04-26 13:29:51'),
(170, 'Star Wars 8: Jedi Cuối Cùng', 'Star Wars: The Last Jedi', 'star-wars-8-jedi-cu-i-c-ng', 'Sau khi bị người học trò Ben Solo/ Kylo Ren phản bội, toàn bộ nỗ lực tạo dựng lại đội quân những Hiệp sĩ Jedi của Luke Skywalker hoàn toàn sụp đổ. Luke biến mất khỏi vũ trụ và sống một cuộc đời ẩn sĩ trên hành tinh Ahch-To. Tuy nhiên,giờ đây người anh hùng huyền thoại buộc phải lộ mặt, khi phe Quân Kháng Chiến cần ông trở thành người lãnh đạo để chống lại sức mạnh của Tổ Chức Thứ Nhất.', 'https://image.tmdb.org/t/p/w500/5VhBECaiT2hRGHdCdGbwjSEAwR4.jpg', 'https://image.tmdb.org/t/p/w500/5Iw7zQTHVRBOYpA0V6z0yypOPZh.jpg', NULL, NULL, 2017, 120, '0', 57233, 6.8, 'completed', 0, 1, '2025-04-26 13:29:52', '2025-04-26 13:29:52'),
(171, 'De lydløse', 'De lydløse', 'de-lydl-se', '', 'https://image.tmdb.org/t/p/w500/63tvLp9pYygvAaqWpikjTq9FHy7.jpg', 'https://image.tmdb.org/t/p/w500/9OO6I25MHhCDd0XwNk4oZl0fpwB.jpg', NULL, NULL, 2024, 120, '0', 90075, 5.83, 'completed', 0, 1, '2025-04-26 13:29:53', '2025-04-26 13:29:53'),
(172, 'Chiến Binh Báo Đen', 'Black Panther', 'chi-n-binh-b-o-en', 'Vương quốc Wakanda, quê hương của Black Panther/ T\'Challa hiện ra qua lời kể của một nhân chứng sống sót trở về. Đây là quốc gia khá khép kín và sở hữu lượng Vibranium lớn nhất trên thế giới. Black Panther - người cầm quyền của Wakanda sở hữu bộ áo giáp chống đạn và móng vuốt sắc nhọn, anh được miêu tả là “người tốt với trái tim nhân hậu”.  Nhưng cũng chính vì những đức tính tốt này mà Black Panther gặp khó khăn khi kế thừa ngai vàng sau khi vua cha băng hà. Đối mặt với sự phản bội và hiểm nguy, vị vua trẻ phải tập hợp các đồng minh và phát huy toàn bộ sức mạnh của Black Panther để đánh bại kẻ thù, đem lại an bình cho nhân dân của mình.', 'https://image.tmdb.org/t/p/w500/9ZXDxPBesqJeQPbaA7xj0dZtClV.jpg', 'https://image.tmdb.org/t/p/w500/b6ZJZHUdMEFECvGiDpJjlfUWela.jpg', 'https://www.youtube.com/watch?v=9OEU1LM2wtA', NULL, 2018, 120, '0', 79879, 7.373, 'completed', 0, 1, '2025-04-26 13:29:53', '2025-04-26 13:29:53'),
(173, 'Tay Nghiệp Dư', 'The Amateur', 'tay-nghi-p-d', '', 'https://image.tmdb.org/t/p/w500/qRRBn1JAltEsY9yPXRHiAQS8ZYl.jpg', 'https://image.tmdb.org/t/p/w500/yMoEGh8kDEwqsoJumnQLwFJ9V6h.jpg', NULL, NULL, 2025, 120, '0', 95825, 6.706, 'completed', 0, 1, '2025-04-26 13:29:54', '2025-04-26 13:29:54'),
(174, 'Tội Lỗi', 'Culpa mía', 't-i-l-i', 'Cô nàng Noah buộc phải bỏ lại thị trấn, bạn trai và bạn bè thân để chuyển đến dinh thự của người cha dượng giàu có. Ở đó, cô gặp người anh kế mới Nick và tính cách của họ xung đột ngay từ đầu. Tuy nhiên, sự hấp dẫn của họ đối với nhau dần dần biến thành một mối tình bị cấm đoán!', 'https://image.tmdb.org/t/p/w500/gp31EwMH5D2bftOjscwkgTmoLAB.jpg', 'https://image.tmdb.org/t/p/w500/oz4U9eA6ilYf1tyiVuGmkftdLac.jpg', NULL, NULL, 2023, 120, '0', 7934, 7.816, 'completed', 0, 1, '2025-04-26 13:29:54', '2025-04-26 13:29:54'),
(175, 'Peter Pan\'s Neverland Nightmare', 'Peter Pan\'s Neverland Nightmare', 'peter-pan-s-neverland-nightmare', '', 'https://image.tmdb.org/t/p/w500/mOR1Ks0EcXocwMV4EPv4letz0F5.jpg', 'https://image.tmdb.org/t/p/w500/nhx0ttmAS2w8e6hyIcKoNvgHoix.jpg', NULL, NULL, 2025, 120, '0', 68297, 5, 'completed', 0, 1, '2025-04-26 13:29:55', '2025-04-26 13:29:55'),
(176, 'Kong: Đảo Đầu Lâu', 'Kong: Skull Island', 'kong-o-u-l-u', 'Phim \"Kong: Skull Island\" (\"Kong: Đảo Đầu Lâu\") tái hiện lại hình tượng King Kong (Chúa tể loài khỉ) trong một hành trình phiêu lưu, hấp dẫn dưới bàn tay đạo diễn tài ba Jordan Vogt-Robert. \"Kong: Skull Islands\" được quay ngoại cảnh ở Tràng An, Vân Long, Tam Cốc, Vịnh Hạ Long và Động Phong Nha-Kẻ Bàng cùng các địa danh quốc tế như Hawaii, Úc...  Trong phim, một nhóm các nhà thám hiểm liều lĩnh khám phá Đảo Đầu Lâu, nơi chưa có dấu chân người tại Thái Bình Dương. Hoang sơ, tuyệt đẹp nhưng nơi đây lại ẩn chứa rất nhiều cạm bẫy nguy hiểm. Và điều đáng sợ hơn là họ không hề hay biết rằng mình đang dấn thân vào lãnh địa của Kong huyền thoại.', 'https://image.tmdb.org/t/p/w500/ktotbBFrmO58kAKoPvpbChy53EB.jpg', 'https://image.tmdb.org/t/p/w500/jks6QgJjsaDC5iT6bxLsSS0eo6L.jpg', NULL, NULL, 2017, 120, '0', 43808, 6.544, 'completed', 0, 1, '2025-04-26 13:29:55', '2025-04-26 13:29:55'),
(177, 'Vệ Binh Dải Ngân Hà 2', 'Guardians of the Galaxy Vol. 2', 'v-binh-d-i-ng-n-h-2', 'Guardians Of The Galaxy - Vệ binh dải ngân hà Phần 2 tiếp tục câu chuyện về bộ tứ huyền thoại của thiên hà. Lần này, cả nhóm sẽ bắt đầu cuộc phiêu lưu mới nhằm tìm ra bí ẩn thân thế của Star Lord – Peter Quill và viên Power Infinity Gem sở hữu sức mạnh vô song. Nhân vật anti-hero Yondu sẽ có vai trò quan trọng hơn nữa trong phần này, bên cạnh đó cô em gái Nebula của Gamora cũng sẽ trở lại.', 'https://image.tmdb.org/t/p/w500/bqemb9J8lAfYWdNXOPoK1JkHt3x.jpg', 'https://image.tmdb.org/t/p/w500/aJn9XeesqsrSLKcHfHP4u5985hn.jpg', 'https://www.youtube.com/watch?v=TgkvytwAO2I', NULL, 2017, 120, '0', 57451, 7.612, 'completed', 0, 1, '2025-04-26 13:29:56', '2025-04-26 13:29:56'),
(178, 'Kẻ Hủy Diệt', 'The Terminator', 'k-h-y-di-t', 'Năm 2029, những kẻ cai trị Trái Đất quyết định gửi về quá khứ một robot sát thủ mang tên The Terminator - Kẻ Hủy Diệt để thay đổi quá khứ. Nhiệm vụ của tên robot này là giết chết Sarah Connor, người có vai trò quyết định trong cuộc kháng chiến của nhân loại sau này.', 'https://image.tmdb.org/t/p/w500/dFci3DJsm1hNZbhFJNJ5XvssE5v.jpg', 'https://image.tmdb.org/t/p/w500/ahUaAgnkFu7QlBh5h4LCNeaSurV.jpg', NULL, NULL, 1984, 120, '0', 34879, 7.664, 'completed', 0, 1, '2025-04-26 13:29:57', '2025-04-26 13:29:57'),
(179, 'Deadpool và Wolverine', 'Deadpool & Wolverine', 'deadpool-v-wolverine', 'Wade Wilson, chán nản, đang cố gắng sống cuộc đời bình thường sau những ngày làm lính đánh thuê không mấy lương thiện, Deadpool. Nhưng khi quê hương của anh đứng trước nguy cơ diệt vong, Wade buộc phải khoác lại bộ đồ một lần nữa, cùng với một Wolverine còn miễn cưỡng hơn.', 'https://image.tmdb.org/t/p/w500/lfY2CfmxyN9OvxmFuap6aejViJn.jpg', 'https://image.tmdb.org/t/p/w500/by8z9Fe8y7p4jo2YlW2SZDnptyT.jpg', NULL, NULL, 2024, 120, '0', 40967, 7.6, 'completed', 0, 1, '2025-04-26 13:29:57', '2025-04-26 13:29:57'),
(180, 'Venom: Kèo Cuối', 'Venom: The Last Dance', 'venom-k-o-cu-i', 'Đây là phần phim cuối cùng và hoành tráng nhất về cặp đôi Venom và Eddie Brock (Tom Hardy). Sau khi dịch chuyển từ Vũ trụ Marvel trong ‘Spider-man: No way home’ (2021) trở về thực tại, Eddie Brock giờ đây cùng Venom sẽ phải đối mặt với ác thần Knull hùng mạnh - kẻ tạo ra cả chủng tộc Symbiote và những thế lực đang rình rập khác. Cặp đôi Eddie và Venom sẽ phải đưa ra lựa quyết định khốc liệt để hạ màn kèo cuối này.', 'https://image.tmdb.org/t/p/w500/64hJDbJlLFJSRg4sG3njMCijIyF.jpg', 'https://image.tmdb.org/t/p/w500/3V4kLQg0kSqPLctI5ziYWabAZYF.jpg', NULL, NULL, 2024, 120, '0', 88096, 6.782, 'completed', 0, 1, '2025-04-26 13:29:58', '2025-04-26 13:29:58');

-- --------------------------------------------------------

--
-- Table structure for table `movie_actors`
--

CREATE TABLE `movie_actors` (
  `movie_id` int(11) NOT NULL,
  `actor_id` int(11) NOT NULL,
  `role` varchar(100) DEFAULT NULL COMMENT 'Role played in the movie'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `movie_directors`
--

CREATE TABLE `movie_directors` (
  `movie_id` int(11) NOT NULL,
  `director_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `movie_genres`
--

CREATE TABLE `movie_genres` (
  `movie_id` int(11) NOT NULL,
  `genre_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `notification_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ratings`
--

CREATE TABLE `ratings` (
  `rating_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `movie_id` int(11) NOT NULL,
  `score` tinyint(4) NOT NULL CHECK (`score` >= 1 and `score` <= 10),
  `review` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Triggers `ratings`
--
DELIMITER $$
CREATE TRIGGER `update_movie_rating` AFTER INSERT ON `ratings` FOR EACH ROW BEGIN
    UPDATE movies 
    SET rating = (SELECT AVG(score) FROM ratings WHERE movie_id = NEW.movie_id)
    WHERE movie_id = NEW.movie_id;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_movie_rating_on_update` AFTER UPDATE ON `ratings` FOR EACH ROW BEGIN
    UPDATE movies 
    SET rating = (SELECT AVG(score) FROM ratings WHERE movie_id = NEW.movie_id)
    WHERE movie_id = NEW.movie_id;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `subscriptions`
--

CREATE TABLE `subscriptions` (
  `subscription_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `plan_id` int(11) NOT NULL,
  `start_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `end_date` timestamp NULL DEFAULT NULL,
  `payment_status` enum('pending','completed','failed','canceled') DEFAULT 'pending',
  `payment_method` varchar(50) DEFAULT NULL,
  `transaction_id` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `subscription_plans`
--

CREATE TABLE `subscription_plans` (
  `plan_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `duration` int(11) NOT NULL COMMENT 'Duration in days',
  `description` text DEFAULT NULL,
  `features` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subscription_plans`
--

INSERT INTO `subscription_plans` (`plan_id`, `name`, `price`, `duration`, `description`, `features`) VALUES
(1, 'Basic', 99000.00, 30, 'Gói cơ bản', 'Xem phim không quảng cáo'),
(2, 'Standard', 199000.00, 30, 'Gói tiêu chuẩn', 'Xem phim không quảng cáo, chất lượng HD'),
(3, 'Premium', 299000.00, 30, 'Gói cao cấp', 'Xem phim không quảng cáo, chất lượng 4K, tải phim về máy');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','member','premium') DEFAULT 'member',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `email`, `password`, `role`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', '2025-04-26 10:15:10', '2025-04-26 10:15:10'),
(2, 'user1', 'user1@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'member', '2025-04-26 10:15:10', '2025-04-26 10:15:10'),
(3, 'premium1', 'premium1@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'premium', '2025-04-26 10:15:10', '2025-04-26 10:15:10'),
(4, 'testuser', '', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', 'member', '2025-05-15 08:20:03', '2025-05-15 08:20:03'),
(5, 'testuser1', 'vd234@gmail.com', '$2y$10$dK/mcx/gwVJPW2H/hGXWbuxV8BuG/s1DVxXDwR/kbiLiWH/dx75FK', 'member', '2025-05-16 09:16:12', '2025-05-16 09:16:12'),
(6, 'testuser2', 'ev234@gmail.com', '$2y$10$NslR/vVsxoFlVowwz6XjLOGqpNoI2Sud0S2lsU5j48VrQHvDtSTmK', 'member', '2025-05-16 10:15:55', '2025-05-16 10:15:55');

-- --------------------------------------------------------

--
-- Table structure for table `watch_history`
--

CREATE TABLE `watch_history` (
  `history_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `movie_id` int(11) NOT NULL,
  `episode_id` int(11) DEFAULT NULL,
  `watch_duration` int(11) DEFAULT NULL COMMENT 'Position in seconds where the user stopped watching',
  `last_watched` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `completed` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `actors`
--
ALTER TABLE `actors`
  ADD PRIMARY KEY (`actor_id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `advertisements`
--
ALTER TABLE `advertisements`
  ADD PRIMARY KEY (`ad_id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `movie_id` (`movie_id`),
  ADD KEY `episode_id` (`episode_id`),
  ADD KEY `parent_id` (`parent_id`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`country_id`),
  ADD UNIQUE KEY `iso_code` (`iso_code`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `directors`
--
ALTER TABLE `directors`
  ADD PRIMARY KEY (`director_id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `episodes`
--
ALTER TABLE `episodes`
  ADD PRIMARY KEY (`episode_id`),
  ADD KEY `movie_id` (`movie_id`);

--
-- Indexes for table `favorites`
--
ALTER TABLE `favorites`
  ADD PRIMARY KEY (`favorite_id`),
  ADD UNIQUE KEY `user_id` (`user_id`,`movie_id`),
  ADD KEY `movie_id` (`movie_id`);

--
-- Indexes for table `genres`
--
ALTER TABLE `genres`
  ADD PRIMARY KEY (`genre_id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `movies`
--
ALTER TABLE `movies`
  ADD PRIMARY KEY (`movie_id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `country_id` (`country_id`);

--
-- Indexes for table `movie_actors`
--
ALTER TABLE `movie_actors`
  ADD PRIMARY KEY (`movie_id`,`actor_id`),
  ADD KEY `actor_id` (`actor_id`);

--
-- Indexes for table `movie_directors`
--
ALTER TABLE `movie_directors`
  ADD PRIMARY KEY (`movie_id`,`director_id`),
  ADD KEY `director_id` (`director_id`);

--
-- Indexes for table `movie_genres`
--
ALTER TABLE `movie_genres`
  ADD PRIMARY KEY (`movie_id`,`genre_id`),
  ADD KEY `genre_id` (`genre_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`notification_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `ratings`
--
ALTER TABLE `ratings`
  ADD PRIMARY KEY (`rating_id`),
  ADD UNIQUE KEY `user_id` (`user_id`,`movie_id`),
  ADD KEY `movie_id` (`movie_id`);

--
-- Indexes for table `subscriptions`
--
ALTER TABLE `subscriptions`
  ADD PRIMARY KEY (`subscription_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `plan_id` (`plan_id`);

--
-- Indexes for table `subscription_plans`
--
ALTER TABLE `subscription_plans`
  ADD PRIMARY KEY (`plan_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `watch_history`
--
ALTER TABLE `watch_history`
  ADD PRIMARY KEY (`history_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `movie_id` (`movie_id`),
  ADD KEY `episode_id` (`episode_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `actors`
--
ALTER TABLE `actors`
  MODIFY `actor_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `advertisements`
--
ALTER TABLE `advertisements`
  MODIFY `ad_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `country_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `directors`
--
ALTER TABLE `directors`
  MODIFY `director_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `episodes`
--
ALTER TABLE `episodes`
  MODIFY `episode_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `favorites`
--
ALTER TABLE `favorites`
  MODIFY `favorite_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `genres`
--
ALTER TABLE `genres`
  MODIFY `genre_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10771;

--
-- AUTO_INCREMENT for table `movies`
--
ALTER TABLE `movies`
  MODIFY `movie_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=221;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `notification_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ratings`
--
ALTER TABLE `ratings`
  MODIFY `rating_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `subscriptions`
--
ALTER TABLE `subscriptions`
  MODIFY `subscription_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `subscription_plans`
--
ALTER TABLE `subscription_plans`
  MODIFY `plan_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `watch_history`
--
ALTER TABLE `watch_history`
  MODIFY `history_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`movie_id`) REFERENCES `movies` (`movie_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comments_ibfk_3` FOREIGN KEY (`episode_id`) REFERENCES `episodes` (`episode_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comments_ibfk_4` FOREIGN KEY (`parent_id`) REFERENCES `comments` (`comment_id`) ON DELETE CASCADE;

--
-- Constraints for table `episodes`
--
ALTER TABLE `episodes`
  ADD CONSTRAINT `episodes_ibfk_1` FOREIGN KEY (`movie_id`) REFERENCES `movies` (`movie_id`) ON DELETE CASCADE;

--
-- Constraints for table `favorites`
--
ALTER TABLE `favorites`
  ADD CONSTRAINT `favorites_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `favorites_ibfk_2` FOREIGN KEY (`movie_id`) REFERENCES `movies` (`movie_id`) ON DELETE CASCADE;

--
-- Constraints for table `movies`
--
ALTER TABLE `movies`
  ADD CONSTRAINT `movies_ibfk_1` FOREIGN KEY (`country_id`) REFERENCES `countries` (`country_id`) ON DELETE SET NULL;

--
-- Constraints for table `movie_actors`
--
ALTER TABLE `movie_actors`
  ADD CONSTRAINT `movie_actors_ibfk_1` FOREIGN KEY (`movie_id`) REFERENCES `movies` (`movie_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `movie_actors_ibfk_2` FOREIGN KEY (`actor_id`) REFERENCES `actors` (`actor_id`) ON DELETE CASCADE;

--
-- Constraints for table `movie_directors`
--
ALTER TABLE `movie_directors`
  ADD CONSTRAINT `movie_directors_ibfk_1` FOREIGN KEY (`movie_id`) REFERENCES `movies` (`movie_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `movie_directors_ibfk_2` FOREIGN KEY (`director_id`) REFERENCES `directors` (`director_id`) ON DELETE CASCADE;

--
-- Constraints for table `movie_genres`
--
ALTER TABLE `movie_genres`
  ADD CONSTRAINT `movie_genres_ibfk_1` FOREIGN KEY (`movie_id`) REFERENCES `movies` (`movie_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `movie_genres_ibfk_2` FOREIGN KEY (`genre_id`) REFERENCES `genres` (`genre_id`) ON DELETE CASCADE;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `ratings`
--
ALTER TABLE `ratings`
  ADD CONSTRAINT `ratings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ratings_ibfk_2` FOREIGN KEY (`movie_id`) REFERENCES `movies` (`movie_id`) ON DELETE CASCADE;

--
-- Constraints for table `subscriptions`
--
ALTER TABLE `subscriptions`
  ADD CONSTRAINT `subscriptions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `subscriptions_ibfk_2` FOREIGN KEY (`plan_id`) REFERENCES `subscription_plans` (`plan_id`) ON DELETE CASCADE;

--
-- Constraints for table `watch_history`
--
ALTER TABLE `watch_history`
  ADD CONSTRAINT `watch_history_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `watch_history_ibfk_2` FOREIGN KEY (`movie_id`) REFERENCES `movies` (`movie_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `watch_history_ibfk_3` FOREIGN KEY (`episode_id`) REFERENCES `episodes` (`episode_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
