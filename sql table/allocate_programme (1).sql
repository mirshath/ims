-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 12, 2024 at 12:07 PM
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
-- Table structure for table `allocate_programme`
--

CREATE TABLE `allocate_programme` (
  `id` int(11) NOT NULL,
  `student_code` int(20) NOT NULL,
  `university_id` int(11) NOT NULL,
  `programme_code` int(11) NOT NULL,
  `batch_id` int(11) NOT NULL,
  `student_registration_id` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `allocate_programme`
--

INSERT INTO `allocate_programme` (`id`, `student_code`, `university_id`, `programme_code`, `batch_id`, `student_registration_id`) VALUES
(1, 8, 1, 20, 6, 'ss'),
(2, 19, 1, 24, 8, 'gdsf'),
(3, 8, 1, 24, 8, 'STU-000547878'),
(4, 15, 1, 20, 7, 'STU-000547879');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `allocate_programme`
--
ALTER TABLE `allocate_programme`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `student_registration_id` (`student_registration_id`),
  ADD KEY `student_code` (`student_code`),
  ADD KEY `university_id` (`university_id`),
  ADD KEY `programme_code` (`programme_code`),
  ADD KEY `batch_id` (`batch_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `allocate_programme`
--
ALTER TABLE `allocate_programme`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `allocate_programme`
--
ALTER TABLE `allocate_programme`
  ADD CONSTRAINT `allocate_programme_ibfk_1` FOREIGN KEY (`student_code`) REFERENCES `students` (`student_code`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `allocate_programme_ibfk_2` FOREIGN KEY (`university_id`) REFERENCES `universities` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `allocate_programme_ibfk_3` FOREIGN KEY (`programme_code`) REFERENCES `program_table` (`program_code`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `allocate_programme_ibfk_4` FOREIGN KEY (`batch_id`) REFERENCES `batch_table` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
