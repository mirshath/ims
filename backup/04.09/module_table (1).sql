-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 04, 2024 at 12:49 PM
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
-- Table structure for table `module_table`
--

CREATE TABLE `module_table` (
  `id` int(11) NOT NULL,
  `module_code` varchar(50) NOT NULL,
  `module_name` varchar(255) NOT NULL,
  `university` int(11) NOT NULL,
  `programme` varchar(255) NOT NULL,
  `assessment_components` text NOT NULL,
  `pass_mark` int(11) NOT NULL,
  `type` enum('Compulsory','Elective') NOT NULL,
  `lecturers` text DEFAULT NULL,
  `institution` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `module_table`
--

INSERT INTO `module_table` (`id`, `module_code`, `module_name`, `university`, `programme`, `assessment_components`, `pass_mark`, `type`, `lecturers`, `institution`) VALUES
(11, 'BIMT 410', 'Academic Writing and Study Skills', 1, 'International Foundation Diploma (Business) – ATHE Level 3', 'Assignment - 60% Group Presentation - 40%', 60, 'Compulsory', '', ''),
(12, 'Cupidatat illum nob', 'Academic Writing and Study Skills', 1, 'Higher Diploma in Biomedical Science', 'Dolores odit sapient', 50, 'Compulsory', '', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `module_table`
--
ALTER TABLE `module_table`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_university` (`university`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `module_table`
--
ALTER TABLE `module_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `module_table`
--
ALTER TABLE `module_table`
  ADD CONSTRAINT `fk_university` FOREIGN KEY (`university`) REFERENCES `universities` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
