-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 07, 2025 at 06:52 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `culturef`
--

-- --------------------------------------------------------

--
-- Table structure for table `dialect_map`
--

CREATE TABLE `dialect_map` (
  `id` int(11) NOT NULL,
  `division` varchar(100) NOT NULL,
  `dialect` text NOT NULL,
  `cultural_insights` text DEFAULT NULL,
  `notable_facts` text DEFAULT NULL,
  `dialects` text DEFAULT NULL,
  `festivals` text DEFAULT NULL,
  `historical_facts` text DEFAULT NULL,
  `notable_figures` text DEFAULT NULL,
  `images` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `festival_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `dialect_map`
--

INSERT INTO `dialect_map` (`id`, `division`, `dialect`, `cultural_insights`, `notable_facts`, `dialects`, `festivals`, `historical_facts`, `notable_figures`, `images`, `created_at`, `festival_date`) VALUES
(1, 'Sylhet', '', NULL, NULL, 'Bhaat (Cooked rice), Bujhti So (Do you understand?)', 'Boishakhi Mela: A colorful cultural fair celebrating Bengali New Year, Tea Festival: Celebrates Sylhet\'s tea culture and heritage', 'Sylhet is known as the land of saints, especially Shah Jalal., It was part of Assam during British India until 1947.', 'Shah Jalal (Sufi saint who introduced Islam to Sylhet region.)', 'https://example.com/images/sylhet1.jpg, https://example.com/images/tea-garden.jpg', '2025-05-01 05:01:31', NULL),
(6, 'Sylhet', '', NULL, NULL, 'Bhaat (Cooked rice), Bujhti So (Do you understand?)', 'Boishakhi Mela: A colorful cultural fair celebrating Bengali New Year, date: April 14, Tea Festival: Celebrates Sylhet\'s tea culture and heritage, date: No Date Provided', 'Sylhet is known as the land of saints, especially Shah Jalal., It was part of Assam during British India until 1947.', 'Shah Jalal (Sufi saint who introduced Islam to Sylhet region.)', 'https://example.com/images/sylhet1.jpg, https://example.com/images/tea-garden.jpg', '2025-05-01 06:19:01', NULL),
(7, 'Sylhet', '', NULL, NULL, 'Bhaat (Cooked rice), Bujhti So (Do you understand?)', 'Boishakhi Mela: A colorful cultural fair celebrating Bengali New Year, April 14, Tea Festival: Celebrates Sylhet\'s tea culture and heritage, No Date Provided', 'Sylhet is known as the land of saints, especially Shah Jalal., It was part of Assam during British India until 1947.', 'Shah Jalal (Sufi saint who introduced Islam to Sylhet region.)', 'https://example.com/images/sylhet1.jpg, https://example.com/images/tea-garden.jpg', '2025-05-01 06:22:48', NULL),
(8, 'Sylhet', '', NULL, NULL, 'Bhaat (Cooked rice), Bujhti So (Do you understand?)', 'Boishakhi Mela: A colorful cultural fair celebrating Bengali New Year, April 14, Tea Festival: Celebrates Sylhet\'s tea culture and heritage, ', 'Sylhet is known as the land of saints, especially Shah Jalal., It was part of Assam during British India until 1947.', 'Shah Jalal (Sufi saint who introduced Islam to Sylhet region.)', 'https://example.com/images/sylhet1.jpg, https://example.com/images/tea-garden.jpg', '2025-05-01 06:24:42', NULL),
(9, 'Sylhet', '', NULL, NULL, 'Bhaat (Cooked rice), Bujhti So (Do you understand?)', 'Boishakhi Mela: A colorful cultural fair celebrating Bengali New Year, Date: April 14, Tea Festival: Celebrates Sylhet\'s tea culture and heritage, Date: No Date Provided', 'Sylhet is known as the land of saints, especially Shah Jalal., It was part of Assam during British India until 1947.', 'Shah Jalal (Sufi saint who introduced Islam to Sylhet region.)', 'https://example.com/images/sylhet1.jpg, https://example.com/images/tea-garden.jpg', '2025-05-01 06:28:24', NULL),
(10, 'Sylhet', '', NULL, NULL, 'Bhaat (Cooked rice), Bujhti So (Do you understand?)', 'Boishakhi Mela: A colorful cultural fair celebrating Bengali New Year, Date: 2025-04-14, Tea Festival: Celebrates Sylhet\'s tea culture and heritage, Date: 2025-05-01', 'Sylhet is known as the land of saints, especially Shah Jalal., It was part of Assam during British India until 1947.', 'Shah Jalal (Sufi saint who introduced Islam to Sylhet region.)', 'https://example.com/images/sylhet1.jpg, https://example.com/images/tea-garden.jpg', '2025-05-01 06:31:06', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `elder_wisdom`
--

CREATE TABLE `elder_wisdom` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `wisdom_text` text DEFAULT NULL,
  `video_url` varchar(255) DEFAULT NULL,
  `likes` int(11) DEFAULT 0,
  `comments` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `region` varchar(255) NOT NULL,
  `elder_name` varchar(255) NOT NULL,
  `elder_age` int(11) NOT NULL,
  `photo_url` varchar(255) DEFAULT NULL,
  `category` varchar(255) NOT NULL,
  `content_type` enum('text','video') NOT NULL,
  `status` enum('approved','pending','rejected') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `elder_wisdom`
--

INSERT INTO `elder_wisdom` (`id`, `user_id`, `title`, `wisdom_text`, `video_url`, `likes`, `comments`, `created_at`, `region`, `elder_name`, `elder_age`, `photo_url`, `category`, `content_type`, `status`) VALUES
(2, 6, 'Updated: Wisdom from My Childhood', 'Always help your neighbor, because in hard times, they are your first family.', NULL, 0, 0, '2025-04-30 17:59:53', '', '', 73, NULL, 'Life Advice', 'text', '');

-- --------------------------------------------------------

--
-- Table structure for table `heritage_calendar`
--

CREATE TABLE `heritage_calendar` (
  `id` int(11) NOT NULL,
  `event_name` varchar(255) NOT NULL,
  `event_date` date NOT NULL,
  `description` text DEFAULT NULL,
  `reminder` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `heritage_instruments`
--

CREATE TABLE `heritage_instruments` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `instrument_name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `quizzes`
--

CREATE TABLE `quizzes` (
  `id` int(11) NOT NULL,
  `question` text NOT NULL,
  `option_a` varchar(255) NOT NULL,
  `option_b` varchar(255) NOT NULL,
  `option_c` varchar(255) NOT NULL,
  `option_d` varchar(255) NOT NULL,
  `correct_option` char(1) NOT NULL,
  `category` enum('dialect','festival','food','history') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `recipes`
--

CREATE TABLE `recipes` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `recipe_name` varchar(255) NOT NULL,
  `category` enum('sweet','savory','seasonal') NOT NULL,
  `ingredients` text NOT NULL,
  `instructions` text NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `video_url` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `origin` varchar(255) NOT NULL,
  `division` varchar(255) NOT NULL,
  `cooking_time` varchar(255) NOT NULL,
  `difficulty` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `recipes`
--

INSERT INTO `recipes` (`id`, `user_id`, `recipe_name`, `category`, `ingredients`, `instructions`, `image_url`, `video_url`, `created_at`, `origin`, `division`, `cooking_time`, `difficulty`, `description`, `status`) VALUES
(1, 3, 'Panta Bhat', '', 'Cooked rice, Water, Salt, Green chili, Onion', 'Soak cooked rice in water overnight., Serve with salt, green chilies, and onions.', 'https://example.com/panta.jpg', NULL, '2025-04-29 14:54:36', '', '', '', '', '', ''),
(2, 6, 'Panta Bhat with Fried Hilsa', '', 'Cooked rice, Water, Salt, Green chili, Onion, Fried Hilsa fish', 'Soak cooked rice overnight., Serve with fried hilsa fish, green chilies, and onions.', 'https://example.com/panta_hilsa.jpg', NULL, '2025-04-29 15:30:02', 'Bengal', 'Dhaka', '20 minutes', 'Medium', 'Classic Bengali dish enjoyed with Hilsa fish.', 'approved'),
(3, 7, 'Panta Bhat', '', 'Cooked rice, Water, Salt, Green chili, Onion', 'Soak cooked rice in water overnight., Serve with salt, green chilies, and onions.', 'https://example.com/panta.jpg', NULL, '2025-04-29 15:34:18', '', '', '', '', '', ''),
(4, 7, 'Panta Bhat', '', 'Cooked rice, Water, Salt, Green chili, Onion', 'Soak cooked rice in water overnight., Serve with salt, green chilies, and onions.', 'https://example.com/panta.jpg', NULL, '2025-04-29 15:35:03', '', '', '', '', '', ''),
(6, 6, 'Panta Bhat with Fried Hilsa', '', 'Cooked rice, Water, Salt, Green chili, Onion, Fried Hilsa fish', 'Soak cooked rice overnight., Serve with fried hilsa fish, green chilies, and onions.', 'https://example.com/panta_hilsa.jpg', NULL, '2025-04-29 15:46:07', 'Bengal', 'Dhaka', '20 minutes', 'Medium', 'Classic Bengali dish enjoyed with Hilsa fish.', 'approved'),
(7, 7, 'khicuri', '', 'Cooked rice, Water, Salt, Green chili, Onion', 'Soak cooked rice in water overnight., Serve with salt, green chilies, and onions.', 'https://example.com/panta.jpg', NULL, '2025-04-29 15:47:16', '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `storytelling`
--

CREATE TABLE `storytelling` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `story_title` varchar(255) NOT NULL,
  `story_text` text DEFAULT NULL,
  `video_url` varchar(255) DEFAULT NULL,
  `audio_url` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `profile_picture` varchar(255) DEFAULT NULL,
  `division` enum('Dhaka','Chattogram','Rajshahi','Rangpur','Barishal','khulna','Mymensingh','Sylhet') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `role` enum('user','admin') NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `email`, `password`, `profile_picture`, `division`, `created_at`, `role`) VALUES
(6, 'newuser', 'abc@example.com', '12345', NULL, 'Dhaka', '2025-04-29 06:59:43', 'user'),
(7, 'xyz', 'z@gmail.com', '12345', NULL, 'Rangpur', '2025-04-29 15:32:23', 'user');

-- --------------------------------------------------------

--
-- Table structure for table `user_badges`
--

CREATE TABLE `user_badges` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `badge_name` varchar(255) NOT NULL,
  `awarded_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_profiles`
--

CREATE TABLE `user_profiles` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `contributions` int(11) DEFAULT 0,
  `interactions` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_quiz_scores`
--

CREATE TABLE `user_quiz_scores` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `quiz_id` int(11) NOT NULL,
  `score` int(11) DEFAULT 0,
  `completed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `dialect_map`
--
ALTER TABLE `dialect_map`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `elder_wisdom`
--
ALTER TABLE `elder_wisdom`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `heritage_calendar`
--
ALTER TABLE `heritage_calendar`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `heritage_instruments`
--
ALTER TABLE `heritage_instruments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `quizzes`
--
ALTER TABLE `quizzes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `recipes`
--
ALTER TABLE `recipes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `storytelling`
--
ALTER TABLE `storytelling`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `user_badges`
--
ALTER TABLE `user_badges`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `user_profiles`
--
ALTER TABLE `user_profiles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `user_quiz_scores`
--
ALTER TABLE `user_quiz_scores`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `quiz_id` (`quiz_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `dialect_map`
--
ALTER TABLE `dialect_map`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `elder_wisdom`
--
ALTER TABLE `elder_wisdom`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `heritage_calendar`
--
ALTER TABLE `heritage_calendar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `heritage_instruments`
--
ALTER TABLE `heritage_instruments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `quizzes`
--
ALTER TABLE `quizzes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `recipes`
--
ALTER TABLE `recipes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `storytelling`
--
ALTER TABLE `storytelling`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `user_badges`
--
ALTER TABLE `user_badges`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_profiles`
--
ALTER TABLE `user_profiles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_quiz_scores`
--
ALTER TABLE `user_quiz_scores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `elder_wisdom`
--
ALTER TABLE `elder_wisdom`
  ADD CONSTRAINT `elder_wisdom_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `heritage_instruments`
--
ALTER TABLE `heritage_instruments`
  ADD CONSTRAINT `heritage_instruments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `storytelling`
--
ALTER TABLE `storytelling`
  ADD CONSTRAINT `storytelling_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `user_badges`
--
ALTER TABLE `user_badges`
  ADD CONSTRAINT `user_badges_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `user_profiles`
--
ALTER TABLE `user_profiles`
  ADD CONSTRAINT `user_profiles_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `user_quiz_scores`
--
ALTER TABLE `user_quiz_scores`
  ADD CONSTRAINT `user_quiz_scores_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `user_quiz_scores_ibfk_2` FOREIGN KEY (`quiz_id`) REFERENCES `quizzes` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
