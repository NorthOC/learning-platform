-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 13, 2023 at 09:21 PM
-- Server version: 8.0.32-0ubuntu0.22.04.2
-- PHP Version: 8.1.2-1ubuntu2.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `denlis14`
--

-- --------------------------------------------------------

--
-- Table structure for table `Courses`
--

CREATE TABLE `Courses` (
  `id` int NOT NULL,
  `teacher_id` int NOT NULL,
  `course_subject` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `course_type` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `course_difficulty` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `course_name` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `course_description` text COLLATE utf8mb4_general_ci,
  `course_intro_video` varchar(500) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `course_price` decimal(6,2) NOT NULL DEFAULT '0.00',
  `json_blob` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `creation_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ;

--
-- Dumping data for table `Courses`
--

INSERT INTO `Courses` (`id`, `teacher_id`, `course_subject`, `course_type`, `course_difficulty`, `course_name`, `course_description`, `course_intro_video`, `course_price`, `json_blob`, `creation_date`) VALUES
(3, 4, 'photography', 'video', 'intermediate', 'Professional Horse Photography', '', NULL, '12.00', '{\"0\":{\"title\":\"Positioning the camera\",\"desc\":\"In this lesson you will lean to positon the camera\",\"link\":\"%\"},\"1\":{\"title\":\"Gridlines\",\"desc\":\"In this lesson you will learn how to use gridlines for better photoshoots\",\"link\":\"%\"}}', '2023-02-07 16:38:38');

-- --------------------------------------------------------

--
-- Table structure for table `Purchased_courses`
--

CREATE TABLE `Purchased_courses` (
  `id` int NOT NULL,
  `course_id` int NOT NULL,
  `user_id` int NOT NULL,
  `purchase_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `lesson-rating` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Purchased_courses`
--

INSERT INTO `Purchased_courses` (`id`, `course_id`, `user_id`, `purchase_date`, `lesson-rating`) VALUES
(1, 3, 7, '2023-03-06 22:05:06', NULL),
(2, 3, 8, '2023-03-13 19:34:34', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `Teachers`
--

CREATE TABLE `Teachers` (
  `id` int NOT NULL,
  `email` varchar(320) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `credit` decimal(6,2) NOT NULL DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Teachers`
--

INSERT INTO `Teachers` (`id`, `email`, `password`, `credit`) VALUES
(4, 'rev.denisas@gmail.com', '$2y$12$ZninSvhILH0Gt5/Fj/BJueuc361/wTuU3rORb08bBEfwHPGAP2eBC', '0.00');

-- --------------------------------------------------------

--
-- Table structure for table `Teacher_profiles`
--

CREATE TABLE `Teacher_profiles` (
  `id` int NOT NULL,
  `teacher_id` int NOT NULL,
  `first_name` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `last_name` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `avatar` varchar(500) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `bio` text COLLATE utf8mb4_general_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Teacher_profiles`
--

INSERT INTO `Teacher_profiles` (`id`, `teacher_id`, `first_name`, `last_name`, `avatar`, `bio`) VALUES
(3, 4, 'Denis', 'Lisunov', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `Teacher_ratings`
--

CREATE TABLE `Teacher_ratings` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `teacher_id` int NOT NULL,
  `rating` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Transactions`
--

CREATE TABLE `Transactions` (
  `id` int NOT NULL,
  `amount` decimal(6,2) NOT NULL,
  `teacher_id` int NOT NULL,
  `completed` varchar(250) NOT NULL DEFAULT 'FALSE'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `Transactions`
--

INSERT INTO `Transactions` (`id`, `amount`, `teacher_id`, `completed`) VALUES
(1, '9.60', 4, 'FALSE');

-- --------------------------------------------------------

--
-- Table structure for table `Users`
--

CREATE TABLE `Users` (
  `id` int NOT NULL,
  `email` varchar(320) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `credit` decimal(6,2) NOT NULL DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Users`
--

INSERT INTO `Users` (`id`, `email`, `password`, `credit`) VALUES
(7, 'rev.denisas@gmail.com', '$2y$12$N4EKjAJteVc39p/12ruQx.OqJFtf8v9W8ftDtBV6PsXiBHJaxIZqa', '3.05'),
(8, 'pepe@gmail.com', '$2y$12$8fyZKNOBJtKw1N3F3Rx36Oq6kUSDD6GI25X3XyCOmJEWu4DpXjEim', '987.00');

-- --------------------------------------------------------

--
-- Table structure for table `User_profiles`
--

CREATE TABLE `User_profiles` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `avatar` varchar(500) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `bio` text COLLATE utf8mb4_general_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `User_profiles`
--

INSERT INTO `User_profiles` (`id`, `user_id`, `first_name`, `last_name`, `avatar`, `bio`) VALUES
(5, 7, 'Denis', 'Barisov', NULL, NULL),
(6, 8, 'Dene', 'Lene', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Courses`
--
ALTER TABLE `Courses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `teacher_to_course` (`teacher_id`);

--
-- Indexes for table `Purchased_courses`
--
ALTER TABLE `Purchased_courses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_to_purchased` (`user_id`),
  ADD KEY `course_to_purchased` (`course_id`);

--
-- Indexes for table `Teachers`
--
ALTER TABLE `Teachers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `Teacher_profiles`
--
ALTER TABLE `Teacher_profiles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `teacher_id` (`teacher_id`);

--
-- Indexes for table `Teacher_ratings`
--
ALTER TABLE `Teacher_ratings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_to_rating_teacher` (`user_id`),
  ADD KEY `teacher_to_ratings` (`teacher_id`);

--
-- Indexes for table `Transactions`
--
ALTER TABLE `Transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `teacher_id_to_teacher` (`teacher_id`);

--
-- Indexes for table `Users`
--
ALTER TABLE `Users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `User_profiles`
--
ALTER TABLE `User_profiles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Courses`
--
ALTER TABLE `Courses`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Purchased_courses`
--
ALTER TABLE `Purchased_courses`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `Teachers`
--
ALTER TABLE `Teachers`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `Teacher_profiles`
--
ALTER TABLE `Teacher_profiles`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `Teacher_ratings`
--
ALTER TABLE `Teacher_ratings`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Transactions`
--
ALTER TABLE `Transactions`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `Users`
--
ALTER TABLE `Users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `User_profiles`
--
ALTER TABLE `User_profiles`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Courses`
--
ALTER TABLE `Courses`
  ADD CONSTRAINT `teacher_to_course` FOREIGN KEY (`teacher_id`) REFERENCES `Teachers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `Purchased_courses`
--
ALTER TABLE `Purchased_courses`
  ADD CONSTRAINT `course_to_purchased` FOREIGN KEY (`course_id`) REFERENCES `Courses` (`id`),
  ADD CONSTRAINT `user_to_purchased` FOREIGN KEY (`user_id`) REFERENCES `Users` (`id`);

--
-- Constraints for table `Teacher_profiles`
--
ALTER TABLE `Teacher_profiles`
  ADD CONSTRAINT `teacher_to_profile` FOREIGN KEY (`teacher_id`) REFERENCES `Teachers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `Teacher_ratings`
--
ALTER TABLE `Teacher_ratings`
  ADD CONSTRAINT `teacher_to_ratings` FOREIGN KEY (`teacher_id`) REFERENCES `Teachers` (`id`);

--
-- Constraints for table `Transactions`
--
ALTER TABLE `Transactions`
  ADD CONSTRAINT `teacher_id_to_teacher` FOREIGN KEY (`teacher_id`) REFERENCES `Teachers` (`id`);

--
-- Constraints for table `User_profiles`
--
ALTER TABLE `User_profiles`
  ADD CONSTRAINT `user_to_user_profile` FOREIGN KEY (`user_id`) REFERENCES `Users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
