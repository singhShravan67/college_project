-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 25, 2025 at 07:02 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `college_events`
--

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `title` varchar(200) NOT NULL,
  `description` text NOT NULL,
  `event_date` date NOT NULL,
  `event_time` time NOT NULL,
  `location` varchar(200) NOT NULL,
  `max_participants` int(11) DEFAULT 100,
  `current_participants` int(11) DEFAULT 0,
  `category` varchar(50) NOT NULL,
  `organizer_name` varchar(100) NOT NULL,
  `organizer_email` varchar(100) NOT NULL,
  `organizer_phone` varchar(15) NOT NULL,
  `registration_fee` decimal(10,2) DEFAULT 0.00,
  `status` enum('upcoming','ongoing','completed','cancelled') DEFAULT 'upcoming',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `title`, `description`, `event_date`, `event_time`, `location`, `max_participants`, `current_participants`, `category`, `organizer_name`, `organizer_email`, `organizer_phone`, `registration_fee`, `status`, `created_at`) VALUES
(1, 'Tech Conference 2025', 'Join India biggest technology conference. Special sessions on AI, Machine Learning, and Web Development with industry experts.', '2025-09-15', '10:00:00', 'Delhi', 500, 235, 'Technical', 'Tech Team', 'tech@college.edu', '9876543210', 0.00, 'upcoming', '2025-09-19 18:11:42'),
(2, 'Cultural Fest', 'Experience the blend of Indian classical music to modern Bollywood hits. An unforgettable evening with renowned artists.', '2025-09-22', '18:00:00', 'Mumbai', 1000, 757, 'Cultural', 'Cultural Committee', 'culture@college.edu', '9876543211', 0.00, 'upcoming', '2025-09-19 18:11:42'),
(3, 'Sports Tournament', 'Cricket, Football, Badminton and Table Tennis tournaments. Attractive prizes for winners.', '2025-10-05', '09:00:00', 'Pune', 200, 145, 'Sports', 'Sports Dept', 'sports@college.edu', '9876543212', 0.00, 'upcoming', '2025-09-19 18:11:42'),
(4, 'Workshop on AI', 'Hands-on workshop on Artificial Intelligence and Machine Learning. Learn from industry experts.', '2025-09-30', '14:00:00', 'Bangalore', 50, 23, 'Workshop', 'CS Department', 'cs@college.edu', '9876543213', 0.00, 'upcoming', '2025-09-19 18:11:42'),
(5, 'Annual Day Celebration', 'Grand celebration of college annual day with cultural programs, awards ceremony and much more.', '2025-10-15', '16:00:00', 'College Auditorium', 800, 568, 'Cultural', 'Event Team', 'events@college.edu', '9876543214', 0.00, 'upcoming', '2025-09-19 18:11:42'),
(6, 'Coding Competition', 'Show your programming skills in this competitive coding contest. Great prizes awaiting winners.', '2025-09-28', '11:00:00', 'Computer Lab', 100, 78, 'Competition', 'Programming Club', 'coding@college.edu', '9876543215', 0.00, 'upcoming', '2025-09-19 18:11:42'),
(7, 'Tech Conference 2025', 'Join India biggest technology conference. Special sessions on AI, Machine Learning, and Web Development with industry experts.', '2025-09-15', '10:00:00', 'Delhi', 500, 235, 'Technical', 'Tech Team', 'tech@college.edu', '9876543210', 560.00, 'upcoming', '2025-09-19 20:35:49');

-- --------------------------------------------------------

--
-- Table structure for table `registrations`
--

CREATE TABLE `registrations` (
  `id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_name` varchar(100) DEFAULT NULL,
  `user_email` varchar(100) DEFAULT NULL,
  `user_phone` varchar(15) DEFAULT NULL,
  `semester` varchar(10) DEFAULT NULL,
  `branch` varchar(100) DEFAULT NULL,
  `iu_number` varchar(50) DEFAULT NULL,
  `event_name` varchar(200) DEFAULT NULL,
  `special_requirements` text DEFAULT NULL,
  `registration_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `payment_status` enum('pending','paid','failed') DEFAULT 'pending',
  `attendance_status` enum('registered','attended','absent') DEFAULT 'registered'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `registrations`
--

INSERT INTO `registrations` (`id`, `event_id`, `user_id`, `user_name`, `user_email`, `user_phone`, `semester`, `branch`, `iu_number`, `event_name`, `special_requirements`, `registration_date`, `payment_status`, `attendance_status`) VALUES
(3, 2, 5, 'praveen singh', 'praveensingh@gmail.com', '9950568285', '5', 'Computer Science', 'IU2341230549', 'Cultural Fest', 'hy', '2025-09-21 06:17:29', 'pending', 'registered'),
(4, 6, 7, NULL, NULL, NULL, '3', 'Chemical Engineering', 'IU2541230649', NULL, 'hello', '2025-09-21 15:56:55', 'pending', 'registered'),
(5, 5, 7, 'raj', 'praveensingh0708m@gmail.com', '9950568285', '1', 'Information Technology', 'IU2541130249', 'Annual Day Celebration', 'hello', '2025-09-21 17:08:08', 'pending', 'registered');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `password` varchar(255) NOT NULL,
  `college_id` varchar(20) DEFAULT NULL,
  `course` varchar(50) DEFAULT NULL,
  `year_of_study` int(11) DEFAULT NULL,
  `user_type` enum('student','admin') DEFAULT 'student',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `password`, `college_id`, `course`, `year_of_study`, `user_type`, `created_at`) VALUES
(1, 'Admin User', 'admin@college.edu', '9999999999', '0192023a7bbd73250516f069df18b500', NULL, NULL, NULL, 'admin', '2025-09-20 09:30:46'),
(2, 'shravan', 'shravansingh@gmail.com', '6376435108', 'ea77b7939ee696cc8508a5e510404731', NULL, NULL, NULL, 'student', '2025-09-20 09:34:47'),
(3, 'shravansingh', 'shravansingh0909@gmail.com', '6376435108', 'ea77b7939ee696cc8508a5e510404731', NULL, NULL, NULL, 'student', '2025-09-20 09:38:17'),
(4, 'shravansingh90', 'shravansingh09096@gmail.com', '6376435108', 'ee511920f1e053d78f1dbdee5fb18193', NULL, NULL, NULL, 'student', '2025-09-20 12:53:36'),
(5, 'praveen singh', 'praveensingh@gmail.com', '9950568285', 'dd4b21e9ef71e1291183a46b913ae6f2', NULL, NULL, NULL, 'student', '2025-09-20 13:46:34'),
(6, 'shravansingh', 'shravansinngh47098@gmail.com', '6353467916', 'c477982623b6d3cb33a8a7c6b047c45e', NULL, NULL, NULL, 'student', '2025-09-21 15:51:08'),
(7, 'raj', 'praveensingh0708m@gmail.com', '9950568285', '5e0b6b8656735689469b4f0379940f81', NULL, NULL, NULL, 'student', '2025-09-21 15:55:59');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `registrations`
--
ALTER TABLE `registrations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_registration` (`event_id`,`user_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `registrations`
--
ALTER TABLE `registrations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `registrations`
--
ALTER TABLE `registrations`
  ADD CONSTRAINT `registrations_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `registrations_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
