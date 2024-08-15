-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 15, 2024 at 12:21 PM
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
-- Table structure for table `program_table`
--

CREATE TABLE `program_table` (
  `id` int(11) NOT NULL,
  `university` varchar(255) NOT NULL,
  `program_name` varchar(255) NOT NULL,
  `prog_code` varchar(50) DEFAULT NULL,
  `coordinator_name` varchar(255) DEFAULT NULL,
  `medium` enum('English','Tamil') NOT NULL,
  `duration` varchar(100) DEFAULT NULL,
  `course_fee_lkr` decimal(10,2) DEFAULT NULL,
  `course_fee_gbp` decimal(10,2) DEFAULT NULL,
  `course_fee_usd` decimal(10,2) DEFAULT NULL,
  `course_fee_euro` decimal(10,2) DEFAULT NULL,
  `entry_requirement` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `program_table`
--

INSERT INTO `program_table` (`id`, `university`, `program_name`, `prog_code`, `coordinator_name`, `medium`, `duration`, `course_fee_lkr`, `course_fee_gbp`, `course_fee_usd`, `course_fee_euro`, `entry_requirement`) VALUES
(86, 'BMS', 'International Foundation Diploma (Business) – ATHE Level 3', '9999', 'Hasni Nihar', 'Tamil', '18 months', 3333.00, 4444.00, 5555.00, 6666.00, 'Bachelors,Diploma,CBM,A/L'),
(88, 'BMS', 'Patience Joyce', 'Vel amet aspernatur', 'Imashi Abeysiriwardana', 'English', 'Pariatur Proident ', 12.00, 18.00, 76.00, 97.00, 'Bachelors,Diploma,CBM,Work Experience,PGDip');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `program_table`
--
ALTER TABLE `program_table`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `program_table`
--
ALTER TABLE `program_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
