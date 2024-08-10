-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 10, 2024 at 12:46 PM
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
-- Database: `demo_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `reg`
--

CREATE TABLE `reg` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reg`
--

INSERT INTO `reg` (`id`, `name`, `email`, `phone`) VALUES
(1, 'Scott Medina', 'mirshath@gmail.com', '0254904455'),
(6, 'qwqwq', 'bugejo@mailinator.com', '+1 (702) 954-2527'),
(7, 'Ralph Christian', 'himyzy@mailinator.coms', '+1 (172) 756-1023');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `student_code` varchar(50) DEFAULT NULL,
  `title` varchar(20) DEFAULT NULL,
  `firstname` varchar(50) DEFAULT NULL,
  `lastname` varchar(50) DEFAULT NULL,
  `name_for_certificate` varchar(100) DEFAULT NULL,
  `preferred_name` varchar(100) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `nationality` varchar(50) DEFAULT NULL,
  `permanent_address` text DEFAULT NULL,
  `current_address` text DEFAULT NULL,
  `mobile` varchar(20) DEFAULT NULL,
  `telephone` varchar(20) DEFAULT NULL,
  `emergency_contact_name` varchar(100) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `nic` varchar(20) DEFAULT NULL,
  `passport` varchar(20) DEFAULT NULL,
  `personal_email` varchar(100) DEFAULT NULL,
  `bms_email` varchar(100) DEFAULT NULL,
  `occupation` varchar(50) DEFAULT NULL,
  `organization` varchar(100) DEFAULT NULL,
  `previous_organization` varchar(100) DEFAULT NULL,
  `qualifications` set('Bachelors','Masters','Diploma','CBM','A/L','Work Experience','GDip','IFD','O/L','Professional Qualification') DEFAULT NULL,
  `active` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `student_code`, `title`, `firstname`, `lastname`, `name_for_certificate`, `preferred_name`, `date_of_birth`, `nationality`, `permanent_address`, `current_address`, `mobile`, `telephone`, `emergency_contact_name`, `photo`, `nic`, `passport`, `personal_email`, `bms_email`, `occupation`, `organization`, `previous_organization`, `qualifications`, `active`) VALUES
(1, 's001', 'Mr', 'Mirshath', 'Guthrie', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(2, 'Id et et ipsum omn', 'Mrs', 'Sean', 'Hatfield', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1),
(3, 'Quia accusantium con', 'Miss', 'Nicole', 'Chambers', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `reg`
--
ALTER TABLE `reg`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `reg`
--
ALTER TABLE `reg`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
