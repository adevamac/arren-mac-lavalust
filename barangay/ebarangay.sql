-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 03, 2024 at 08:03 AM
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
-- Database: `ebarangay`
--

-- --------------------------------------------------------

--
-- Table structure for table `barangay_clearance`
--

CREATE TABLE `barangay_clearance` (
  `id` int(11) NOT NULL,
  `full_name` varchar(50) NOT NULL,
  `address` varchar(50) NOT NULL,
  `purpose` varchar(50) NOT NULL,
  `submitted_by` int(11) NOT NULL,
  `submitted_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `barangay_clearance`
--

INSERT INTO `barangay_clearance` (`id`, `full_name`, `address`, `purpose`, `submitted_by`, `submitted_at`) VALUES
(4, 'Jake Ryan Maneje Adeva', 'Centro 1', 'asd', 4, '2024-12-02 12:41:42');

-- --------------------------------------------------------

--
-- Table structure for table `barangay_info`
--

CREATE TABLE `barangay_info` (
  `id` int(11) NOT NULL,
  `barangay_name` varchar(50) NOT NULL,
  `city` varchar(50) NOT NULL,
  `province` varchar(50) NOT NULL,
  `zip_code` varchar(10) NOT NULL,
  `logo` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `barangay_info`
--

INSERT INTO `barangay_info` (`id`, `barangay_name`, `city`, `province`, `zip_code`, `logo`) VALUES
(5, 'Sta. Rosa 1', 'Baco', 'Oriental Mindoro', '5201', '6b78d6e035495f63f4e94dbbe4662639dcd0a530.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `business_clearance`
--

CREATE TABLE `business_clearance` (
  `id` int(11) NOT NULL,
  `business_name` varchar(50) NOT NULL,
  `owner_name` varchar(50) NOT NULL,
  `business_address` varchar(50) NOT NULL,
  `nature_of_business` varchar(50) NOT NULL,
  `submitted_by` int(11) NOT NULL,
  `submitted_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `business_clearance`
--

INSERT INTO `business_clearance` (`id`, `business_name`, `owner_name`, `business_address`, `nature_of_business`, `submitted_by`, `submitted_at`) VALUES
(1, 'asd', 'asd', 'asd', 'asd', 4, '2024-12-02 12:02:13'),
(2, 'asd', 'asd', 'asd', 'asd', 4, '2024-12-02 12:53:54');

-- --------------------------------------------------------

--
-- Table structure for table `certificate_of_indigency`
--

CREATE TABLE `certificate_of_indigency` (
  `id` int(11) NOT NULL,
  `full_name` varchar(50) NOT NULL,
  `reason` varchar(50) NOT NULL,
  `submitted_by` int(11) NOT NULL,
  `submitted_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `certificate_of_indigency`
--

INSERT INTO `certificate_of_indigency` (`id`, `full_name`, `reason`, `submitted_by`, `submitted_at`) VALUES
(3, 'Jake Ryan Maneje Adeva', 'asd', 4, '2024-12-02 12:51:38');

-- --------------------------------------------------------

--
-- Table structure for table `officials`
--

CREATE TABLE `officials` (
  `id` int(11) NOT NULL,
  `fullname` varchar(250) NOT NULL,
  `contact` varchar(11) NOT NULL,
  `position` varchar(20) NOT NULL,
  `is_signatory` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `officials`
--

INSERT INTO `officials` (`id`, `fullname`, `contact`, `position`, `is_signatory`, `created_at`) VALUES
(2, 'Jake Ryan Maneje Adeva', '0923122122', 'Barangay Captain', 1, '2024-12-02 03:26:54'),
(3, 'Mac Iroh Adeva', '09263882474', 'Barangay Secretary', 1, '2024-12-02 09:47:23');

-- --------------------------------------------------------

--
-- Table structure for table `profiling`
--

CREATE TABLE `profiling` (
  `id` int(11) NOT NULL,
  `f_name` varchar(50) NOT NULL,
  `m_name` varchar(50) NOT NULL,
  `l_name` varchar(50) NOT NULL,
  `suffix` varchar(20) DEFAULT NULL,
  `gender` varchar(10) NOT NULL,
  `dob` date NOT NULL,
  `civil_status` varchar(50) NOT NULL,
  `street_sitio` varchar(250) NOT NULL,
  `occupation_status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `profiling`
--

INSERT INTO `profiling` (`id`, `f_name`, `m_name`, `l_name`, `suffix`, `gender`, `dob`, `civil_status`, `street_sitio`, `occupation_status`) VALUES
(5, 'mac', 'r', 'adeva', '', 'Male', '2004-07-27', 'Single', 'canto', 'Student'),
(6, 'asd', 'asd', 'asd', '', 'Female', '2000-09-06', 'Single', 'canto', 'Retired'),
(7, 'benedict', 'R.', 'Rudabia', '', 'Female', '1993-02-27', 'Single', 'sitio centro', 'Student'),
(8, 'macdo', 'm', 'adeva', '', 'Male', '1994-07-01', 'Separated', 'barakan', 'Employed'),
(9, 'lakan', 'm', 'adeva', '', 'Male', '2023-02-01', 'Single', 'ibaba east', 'Unemployed');

-- --------------------------------------------------------

--
-- Table structure for table `requests`
--

CREATE TABLE `requests` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `request_type` enum('barangay_clearance','indigency','business_clearance','residency_certificate') NOT NULL,
  `request_data` varchar(50) NOT NULL,
  `status` enum('pending','approved','denied') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `requests`
--

INSERT INTO `requests` (`id`, `user_id`, `request_type`, `request_data`, `status`, `created_at`, `updated_at`) VALUES
(1, 4, 'barangay_clearance', '{\"full_name\":\"Jake Ryan Maneje Adeva\",\"address\":\"C', 'approved', '2024-12-02 12:41:42', '2024-12-02 12:41:42'),
(3, 4, 'indigency', '{\"full_name\":\"Jake Ryan Maneje Adeva\",\"reason\":\"as', 'pending', '2024-12-02 12:51:38', '2024-12-02 12:51:38'),
(4, 4, 'business_clearance', '{\"business_name\":\"asd\",\"owner_name\":\"asd\",\"busines', 'pending', '2024-12-02 05:53:54', '2024-12-02 05:53:54'),
(5, 4, 'residency_certificate', '{\"resident_name\":\"Jake Ryan M. Adeva\",\"years_of_re', 'pending', '2024-12-02 05:55:38', '2024-12-02 05:55:38');

-- --------------------------------------------------------

--
-- Table structure for table `residency_certificate`
--

CREATE TABLE `residency_certificate` (
  `id` int(11) NOT NULL,
  `resident_name` varchar(50) NOT NULL,
  `years_of_residency` int(11) NOT NULL,
  `submitted_by` int(11) NOT NULL,
  `submitted_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `residency_certificate`
--

INSERT INTO `residency_certificate` (`id`, `resident_name`, `years_of_residency`, `submitted_by`, `submitted_at`) VALUES
(1, 'Jake Ryan M. Adeva', 5, 4, '2024-12-02 12:05:50'),
(2, 'Jake Ryan M. Adeva', 5, 4, '2024-12-02 12:55:38');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `f_name` varchar(50) NOT NULL,
  `m_name` varchar(50) NOT NULL,
  `l_name` varchar(50) NOT NULL,
  `suffix` varchar(5) NOT NULL,
  `gender` varchar(7) NOT NULL,
  `dob` date NOT NULL,
  `address` varchar(50) NOT NULL,
  `email` varchar(250) NOT NULL,
  `password` varchar(250) NOT NULL,
  `verification_token` varchar(250) NOT NULL,
  `verification_status` int(1) NOT NULL,
  `user_avatar` varchar(250) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `user_type` enum('admin','client') NOT NULL DEFAULT 'client'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `f_name`, `m_name`, `l_name`, `suffix`, `gender`, `dob`, `address`, `email`, `password`, `verification_token`, `verification_status`, `user_avatar`, `date_created`, `user_type`) VALUES
(3, 'jake', 'maneje', 'adeva', '', 'male', '2024-01-01', 'Sta. Rosa 1, Baco', 'adevamac2004@gmail.com', '$2y$12$T.vqqMwbRn/NxhBLNBCBveG/PHmiuVGtuWWAh4LOsnAjB85lEy1Hi', '119916309', 1, 'da38545707934afede47f47b0901c2a4a4f5206f.jpg', '2024-11-25 12:15:58', 'admin'),
(4, 'Shalie', 'Perena', 'Buencuseco', '', 'female', '2004-06-19', 'Sta. Rosa 1, Baco', 'shalie2004@gmail.com', '$2y$12$CDztMAVMHQnyIMmE22b92exixvw.xCulbw9FAq1jtwbUw5QprqP52', '411726667', 1, '23afc09301bbf49862382ecddcb4a81a81009649.jpg', '2024-12-02 10:49:36', 'client');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barangay_clearance`
--
ALTER TABLE `barangay_clearance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `barangay_info`
--
ALTER TABLE `barangay_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `business_clearance`
--
ALTER TABLE `business_clearance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `certificate_of_indigency`
--
ALTER TABLE `certificate_of_indigency`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `officials`
--
ALTER TABLE `officials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `profiling`
--
ALTER TABLE `profiling`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `requests`
--
ALTER TABLE `requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `residency_certificate`
--
ALTER TABLE `residency_certificate`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `barangay_clearance`
--
ALTER TABLE `barangay_clearance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `barangay_info`
--
ALTER TABLE `barangay_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `business_clearance`
--
ALTER TABLE `business_clearance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `certificate_of_indigency`
--
ALTER TABLE `certificate_of_indigency`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `officials`
--
ALTER TABLE `officials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `profiling`
--
ALTER TABLE `profiling`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `requests`
--
ALTER TABLE `requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `residency_certificate`
--
ALTER TABLE `residency_certificate`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
