-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 04, 2024 at 09:11 AM
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
-- Table structure for table `batch_table`
--

CREATE TABLE `batch_table` (
  `id` int(11) NOT NULL,
  `batch_name` varchar(255) NOT NULL,
  `university` int(11) NOT NULL,
  `programme` varchar(255) NOT NULL,
  `year_batch_code` varchar(50) NOT NULL,
  `intake_date` date NOT NULL,
  `end_date` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `batch_table`
--

INSERT INTO `batch_table` (`id`, `batch_name`, `university`, `programme`, `year_batch_code`, `intake_date`, `end_date`, `created_at`, `updated_at`) VALUES
(5, 'Batch 10', 1, 'International Foundation Diploma (Business) – ATHE Level 3', '1993', '1980-07-08', '1985-01-14', '2024-08-16 09:35:23', '2024-09-04 07:06:27'),
(6, 'Batch 20', 1, 'Higher Diploma in Biomedical Science', '2022', '2024-08-23', '2024-08-31', '2024-08-16 09:35:48', '2024-09-04 07:06:34'),
(8, 'Batch 30', 14, 'BTEC Higher National Diploma in Business', '2023', '2024-06-19', '2024-09-26', '2024-09-04 06:54:29', '2024-09-04 07:06:39'),
(9, 'Batch 11', 1, 'International Foundation Diploma (Business) – ATHE Level 3', '1994', '2024-06-12', '2024-07-18', '2024-09-04 07:07:04', '2024-09-04 07:07:04');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `batch_table`
--
ALTER TABLE `batch_table`
  ADD PRIMARY KEY (`id`),
  ADD KEY `university` (`university`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `batch_table`
--
ALTER TABLE `batch_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `batch_table`
--
ALTER TABLE `batch_table`
  ADD CONSTRAINT `batch_table_ibfk_1` FOREIGN KEY (`university`) REFERENCES `universities` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
