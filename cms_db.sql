-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 24, 2025 at 06:06 AM
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
-- Database: `cms_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_login`
--

CREATE TABLE `admin_login` (
  `id` int(11) NOT NULL,
  `username` varchar(150) NOT NULL,
  `password` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_login`
--

INSERT INTO `admin_login` (`id`, `username`, `password`) VALUES
(1, 'admin', '000111');

-- --------------------------------------------------------

--
-- Table structure for table `cms_appointments`
--

CREATE TABLE `cms_appointments` (
  `appointment_id` int(9) NOT NULL,
  `patient_id` int(9) NOT NULL,
  `appointment_date` varchar(150) NOT NULL,
  `description` text NOT NULL,
  `status` varchar(150) NOT NULL DEFAULT 'pending',
  `created_by` varchar(150) NOT NULL,
  `create_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cms_appointments`
--

INSERT INTO `cms_appointments` (`appointment_id`, `patient_id`, `appointment_date`, `description`, `status`, `created_by`, `create_at`) VALUES
(1, 1, '2025-12-09', 'ddddddd', 'verified', 'doctor', '2025-12-09 03:37:57'),
(3, 3, '2024-02-22', 'aaaaaaaaa', 'pending', 'doctor', '2025-12-10 06:49:42'),
(4, 1, '2026-01-28', '', 'pending', 'doctor', '2025-12-10 09:41:19'),
(7, 6, '2025-12-10', 'DDDDDDDDD', 'pending', 'doctor', '2025-12-10 13:01:17'),
(8, 7, '2025-12-25', 'Eye Painn', 'reject', 'doctor', '2025-12-13 05:14:15'),
(10, 8, '2025-12-11', 'TEST CHECK-UP', 'pending', 'patient', '2025-12-11 13:33:37'),
(11, 8, '2025-12-19', 'aaaaaaa', 'pending', 'patient', '2025-12-11 13:35:54'),
(12, 9, '2025-12-11', 'ROUTINE CHECK UP', 'pending', 'patient', '2025-12-11 16:53:41'),
(13, 9, '2025-12-11', 'Hello Doc', 'pending', 'patient', '2025-12-11 17:25:57'),
(14, 10, '2025-12-12', 'TEST', 'pending', 'patient', '2025-12-12 03:59:50'),
(15, 11, '2025-12-12', 'Test', 'pending', 'patient', '2025-12-12 04:05:26'),
(16, 11, '2025-12-12', 'yyyyyyyy', 'pending', 'patient', '2025-12-12 05:08:58'),
(17, 9, '2025-12-17', 'aaaaaaa', 'verified', 'patient', '2025-12-13 05:13:56'),
(18, 12, '2025-12-12', 'Testing the password Generattion', 'pending', 'patient', '2025-12-12 06:16:18'),
(19, 9, '2025-12-17', 'Testing THe ragav', 'verified', 'patient', '2025-12-13 05:14:04'),
(20, 11, '2025-12-12', 'Testing the patient Dashboard', 'pending', 'patient', '2025-12-12 10:31:31'),
(21, 11, '2025-12-12', 'testing the deepti\'s profile', 'pending', 'patient', '2025-12-12 10:43:52'),
(22, 13, '2025-12-12', 'Test', 'pending', 'patient', '2025-12-12 15:03:30'),
(23, 11, '2025-12-13', 'Cheching the final', 'pending', 'patient', '2025-12-13 10:06:54'),
(24, 11, '2025-12-18', 'Email remove', 'pending', 'patient', '2025-12-13 10:45:52'),
(25, 14, '2025-12-13', 'hey\r\n', 'pending', 'doctor', '2025-12-13 12:09:45'),
(26, 9, '2025-12-21', '', 'pending', 'patient', '2025-12-21 14:47:39'),
(27, 9, '2025-12-24', 'final testing', 'pending', 'patient', '2025-12-24 04:10:34'),
(28, 9, '2025-12-24', 'final testing', 'pending', 'patient', '2025-12-24 04:10:38'),
(29, 9, '2025-12-24', 'final testing', 'pending', 'patient', '2025-12-24 04:10:44');

-- --------------------------------------------------------

--
-- Table structure for table `cms_clinic_details`
--

CREATE TABLE `cms_clinic_details` (
  `clinic_id` int(9) NOT NULL,
  `clinic_logo` varchar(150) NOT NULL,
  `clinic_name` varchar(150) NOT NULL,
  `doctor_name` varchar(150) NOT NULL,
  `phone` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `address` text NOT NULL,
  `about_image` varchar(150) NOT NULL,
  `about_title` varchar(150) NOT NULL,
  `description` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cms_clinic_details`
--

INSERT INTO `cms_clinic_details` (`clinic_id`, `clinic_logo`, `clinic_name`, `doctor_name`, `phone`, `email`, `address`, `about_image`, `about_title`, `description`, `created_at`) VALUES
(1, '1765377576_7514780.jpg', 'CMS', 'Joshi', '1234567897', 'abc@gmail.com', 'Nashik, Maharashtra, India', '1765443982_ladydoc.jpg', 'About Clinic', 'Our clinic is dedicated to providing compassionate, high-quality healthcare for patients of all ages. With modern facilities, advanced diagnostic tools, and a skilled medical team, we focus on delivering accurate evaluations and personalized treatment plans.                                                                    We strive to create a welcoming environment where every patient feels cared for, informed, and supported throughout their health journey', '2025-12-11 09:06:22');

-- --------------------------------------------------------

--
-- Table structure for table `cms_patients`
--

CREATE TABLE `cms_patients` (
  `patient_id` int(9) NOT NULL,
  `full_name` varchar(150) NOT NULL,
  `age` varchar(150) NOT NULL,
  `phone` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `gender` varchar(150) NOT NULL,
  `verification_code` varchar(150) NOT NULL,
  `is_verify` varchar(150) NOT NULL DEFAULT 'unverified',
  `password` varchar(150) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cms_patients`
--

INSERT INTO `cms_patients` (`patient_id`, `full_name`, `age`, `phone`, `email`, `gender`, `verification_code`, `is_verify`, `password`, `created_at`) VALUES
(1, 'Vedshree', '25', '(777) 777-7777', 'deeptiajoshi01@gmail.com', 'Male', '', 'verified', '12345', '2025-12-09 03:37:57'),
(2, 'Deepti Joshi', '24', '(797) 264-3129', 'deeptiajoshi01@gmail.com', 'Female', '', 'reject', '12345', '2025-12-09 15:25:27'),
(3, 'Deepti Joshi', '22', '(079) 726-43129', 'deeptiajoshi01@gmail.com', 'Female', '', 'pending', '12345', '2025-12-10 06:49:42'),
(4, 'Meera Joshi', '40', '(079) 726-43129', 'deeptiajoshi01@gmail.com', 'Female', '', 'pending', '12345', '2025-12-10 11:38:02'),
(5, 'Avinash Joshi', '50', '(079) 726-43129', 'deeptiajoshi01@gmail.com', 'Male', '', 'pending', '12345', '2025-12-10 11:38:26'),
(6, 'Soham Kulkarni', '12', '(111) 111-1111', 'deeptiajoshi01@gmail.com', 'Male', '', 'pending', '12345', '2025-12-10 13:01:17'),
(7, 'Sarevsh  Kulkarni', '12', '0987654321', 'sarvesh@gmail.com', 'Male', '', 'pending', '12345', '2025-12-11 05:19:54'),
(8, 'Neha', '25', '1111111111', '', 'Female', '', 'unverified', '', '2025-12-11 13:30:15'),
(9, 'Deepti Avinash Joshi', '24', '7972643129', 'deeptiajoshi01@gmail.com', 'Female', '398816', 'verified', '78306', '2025-12-24 04:11:22'),
(10, 'Amit Joshi', '29', '7777777777', 'deeptiajoshi01@gmail.com', 'Male', '993536', 'pending', '64968', '2025-12-12 03:59:40'),
(11, 'Deepti Joshi', '24', '07972643129', 'deeptiajoshi01@gmail.com', '', '142223', 'verified', '73548', '2025-12-13 10:46:21'),
(12, 'Harshada Muley', '11', '0000000000', 'deeptiajoshi01@gmail.com', 'Female', '873455', 'pending', '30811', '2025-12-12 06:16:18'),
(13, 'Shubham Nagulwar', '23', '9657850830', 'vedshribidwai29@gmail.com', 'Female', '634150', 'verified', '51587', '2025-12-12 15:46:17'),
(14, 'Roshan Deshmukh', '24', '7972643129', 'deeptiajoshi01@gmail.com', 'Male', '257726', 'pending', '97739', '2025-12-13 12:09:45');

-- --------------------------------------------------------

--
-- Table structure for table `cms_services`
--

CREATE TABLE `cms_services` (
  `service_id` int(9) NOT NULL,
  `icon` varchar(150) NOT NULL,
  `title` varchar(150) NOT NULL,
  `description` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cms_services`
--

INSERT INTO `cms_services` (`service_id`, `icon`, `title`, `description`, `created_at`) VALUES
(2, 'fa-solid fa-tooth', 'Dental Care', 'Complete oral care including cleaning, whitening, fillings, and cosmetic dentistry.', '2025-12-11 12:27:37'),
(3, 'fa-solid fa-eye', 'Eye Care', 'Comprehensive vision checkups and advanced eye treatments using modern diagnostic tools.', '2025-12-11 12:30:19'),
(4, 'fa-solid fa-bone', 'Orthopedic Care', 'Specialized bone and joint treatments for injuries, arthritis, and mobility issues.', '2025-12-11 12:31:49'),
(5, 'fa-solid fa-heart-pulse', 'Cardiology', 'Expert heart care including diagnostics, monitoring, and personalized treatment plans.', '2025-12-11 12:32:47');

-- --------------------------------------------------------

--
-- Table structure for table `cms_slider`
--

CREATE TABLE `cms_slider` (
  `slider_id` int(9) NOT NULL,
  `slider_image` varchar(150) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cms_slider`
--

INSERT INTO `cms_slider` (`slider_id`, `slider_image`, `created_at`) VALUES
(5, '1765629628_pic1.jpg', '2025-12-13 12:40:32'),
(10, '1765635936_clinic.jpg', '2025-12-13 14:25:42');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_login`
--
ALTER TABLE `admin_login`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cms_appointments`
--
ALTER TABLE `cms_appointments`
  ADD PRIMARY KEY (`appointment_id`);

--
-- Indexes for table `cms_clinic_details`
--
ALTER TABLE `cms_clinic_details`
  ADD PRIMARY KEY (`clinic_id`);

--
-- Indexes for table `cms_patients`
--
ALTER TABLE `cms_patients`
  ADD PRIMARY KEY (`patient_id`);

--
-- Indexes for table `cms_services`
--
ALTER TABLE `cms_services`
  ADD PRIMARY KEY (`service_id`);

--
-- Indexes for table `cms_slider`
--
ALTER TABLE `cms_slider`
  ADD PRIMARY KEY (`slider_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_login`
--
ALTER TABLE `admin_login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cms_appointments`
--
ALTER TABLE `cms_appointments`
  MODIFY `appointment_id` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `cms_clinic_details`
--
ALTER TABLE `cms_clinic_details`
  MODIFY `clinic_id` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cms_patients`
--
ALTER TABLE `cms_patients`
  MODIFY `patient_id` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `cms_services`
--
ALTER TABLE `cms_services`
  MODIFY `service_id` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `cms_slider`
--
ALTER TABLE `cms_slider`
  MODIFY `slider_id` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
