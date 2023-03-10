-- phpMyAdmin SQL Dump
-- version 5.0.4deb2+deb11u1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 24, 2023 at 10:53 AM
-- Server version: 10.5.18-MariaDB-0+deb11u1
-- PHP Version: 7.4.33

SET SQL_MODE='';
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `aivbut3`
--

-- --------------------------------------------------------

--
-- Table structure for table `Courses`
--

CREATE TABLE `Courses` (
  `id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `course_subject` varchar(250) NOT NULL,
  `course_type` varchar(250) NOT NULL,
  `course_difficulty` varchar(250) NOT NULL,
  `course_name` varchar(250) NOT NULL,
  `course_description` text DEFAULT NULL,
  `course_intro_video` varchar(500) DEFAULT NULL,
  `course_price` decimal(6,2) NOT NULL DEFAULT 0.00,
  `json_blob` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`json_blob`)),
  `creation_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Discounts`
--

CREATE TABLE `Discounts` (
  `id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `code` varchar(100) NOT NULL,
  `percentage` int(11) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Purchased_courses`
--

CREATE TABLE `Purchased_courses` (
  `id` int(11) NOT NULL,
  `course_id` int(20) NOT NULL,
  `user_id` int(10) NOT NULL,
  `discount_id` int(11) DEFAULT NULL,
  `purchase_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `lesson-rating` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Teachers`
--

CREATE TABLE `Teachers` (
  `id` int(11) NOT NULL,
  `email` varchar(320) NOT NULL,
  `password` varchar(255) NOT NULL,
  `credit` decimal(6,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
-- --------------------------------------------------------

--
-- Table structure for table `Teacher_profiles`
--

CREATE TABLE `Teacher_profiles` (
  `id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `first_name` varchar(250) NOT NULL,
  `last_name` varchar(250) NOT NULL,
  `avatar` varchar(500) DEFAULT NULL,
  `bio` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
-- --------------------------------------------------------

--
-- Table structure for table `Teacher_ratings`
--

CREATE TABLE `Teacher_ratings` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `rating` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Users`
--

CREATE TABLE `Users` (
  `id` int(11) NOT NULL,
  `email` varchar(320) NOT NULL,
  `password` varchar(255) NOT NULL,
  `credit` decimal(6,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `User_profiles`
--

CREATE TABLE `User_profiles` (
  `id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `avatar` varchar(500) DEFAULT NULL,
  `bio` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Indexes for dumped tables
--

--
-- Indexes for table `Courses`
--
ALTER TABLE `Courses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `teacher_to_course` (`teacher_id`);

--
-- Indexes for table `Discounts`
--
ALTER TABLE `Discounts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `teacher_to_discount` (`teacher_id`),
  ADD KEY `course_to_discount` (`course_id`);

--
-- Indexes for table `Purchased_courses`
--
ALTER TABLE `Purchased_courses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_to_purchased` (`user_id`),
  ADD KEY `discount_to_purchased` (`discount_id`),
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `Discounts`
--
ALTER TABLE `Discounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Purchased_courses`
--
ALTER TABLE `Purchased_courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Teachers`
--
ALTER TABLE `Teachers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `Teacher_profiles`
--
ALTER TABLE `Teacher_profiles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `Teacher_ratings`
--
ALTER TABLE `Teacher_ratings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Users`
--
ALTER TABLE `Users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `User_profiles`
--
ALTER TABLE `User_profiles`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Courses`
--
ALTER TABLE `Courses`
  ADD CONSTRAINT `teacher_to_course` FOREIGN KEY (`teacher_id`) REFERENCES `Teachers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `Discounts`
--
ALTER TABLE `Discounts`
  ADD CONSTRAINT `course_to_discount` FOREIGN KEY (`course_id`) REFERENCES `Courses` (`id`),
  ADD CONSTRAINT `teacher_to_discount` FOREIGN KEY (`teacher_id`) REFERENCES `Courses` (`teacher_id`);

--
-- Constraints for table `Purchased_courses`
--
ALTER TABLE `Purchased_courses`
  ADD CONSTRAINT `course_to_purchased` FOREIGN KEY (`course_id`) REFERENCES `Courses` (`id`),
  ADD CONSTRAINT `discount_to_purchased` FOREIGN KEY (`discount_id`) REFERENCES `Discounts` (`id`),
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
-- Constraints for table `User_profiles`
--
ALTER TABLE `User_profiles`
  ADD CONSTRAINT `user_to_user_profile` FOREIGN KEY (`user_id`) REFERENCES `Users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
