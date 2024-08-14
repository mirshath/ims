-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 14, 2024 at 01:07 PM
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
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(25) NOT NULL,
  `password` varchar(255) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp(),
  `status` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`, `date`, `status`) VALUES
(1, 'admin@gmail.com', '$2y$10$e3XCTthcTEdNTx5RAvOVAuJfte6InN0Aoa5ju/HPUj0QyJ.ItH2wG', '2024-05-14 15:28:31', 'active'),
(11, 'mirshath@gmail.com', '$2y$10$uxWEiCMA8mB1.eb8B4FUYOFg9GSIHz0CIhrNZPNF3ZDufQzAMXcfG', '2024-08-09 08:38:52', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `coordinator_table`
--

CREATE TABLE `coordinator_table` (
  `id` int(11) NOT NULL,
  `coordinator_code` varchar(50) NOT NULL,
  `title` enum('Mr','Mrs','Ms','Dr','Prof') NOT NULL,
  `coordinator_name` varchar(100) NOT NULL,
  `bms_email` varchar(100) NOT NULL,
  `password_hash` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `coordinator_table`
--

INSERT INTO `coordinator_table` (`id`, `coordinator_code`, `title`, `coordinator_name`, `bms_email`, `password_hash`) VALUES
(1, 'asa', 'Ms', 'Asma Raahman', 'asari@bms.ac.lk', '$2y$10$LnTuLDS0Cz8wWV8Er8IjiOILvj753szQ9RcqvhLKe3MegzxY.NVtK'),
(2, 'Commodi architecto c', 'Prof', 'Geethika Liyanage', 'latuhywu@mailinator.com', '$2y$10$HOK49FsnIAr/ZfiXTaQZ3.UOz3lUL23mTVvSdaOKFUIN5PmGi1J3u'),
(3, 'Repudiandae voluptat', 'Dr', 'Hasni Nihar', 'gulytax@mailinator.com', '$2y$10$0EQTFHGnAh7lcVf7wstFcO66JrBRPgI8IBuSq3q1rSaVInj4zADwO'),
(6, 'aa', 'Mr', 'Heshani Mudalige', 'admin@gmail.com', '$2y$10$3weokQJomtLcnSkNXprhN.yasRCQxzI9TK1v/5jZ2rXyUUG3R1Jdq'),
(7, 'ssd', 'Mr', 'Imashi Abeysiriwardana', 'admin@gmail.com', '$2y$10$M0gI8lQYGzj2GqZ5UCnvQ.o9VoU7iaJ3OoadsNma5j8EkD79H7cmC'),
(8, 'ssd', 'Mr', 'Imashi Abeysiriwardana', 'admin@gmail.com', '$2y$10$2OxSQoOXrlVaRRcGoBFqSOxq44zpcn52rNvMQ5WboiaBSrdAN/oFG');

-- --------------------------------------------------------

--
-- Table structure for table `criterias`
--

CREATE TABLE `criterias` (
  `id` int(11) NOT NULL,
  `criteria_code` varchar(100) NOT NULL,
  `criteria_name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `criterias`
--

INSERT INTO `criterias` (`id`, `criteria_code`, `criteria_name`, `created_at`) VALUES
(1, 'CR01', 'Bachelors', '2024-08-12 08:22:32'),
(2, 'CR02', 'Masters', '2024-08-12 08:22:32'),
(3, 'CR03', 'Diploma', '2024-08-12 08:22:32'),
(4, 'CR04', 'CBM', '2024-08-12 08:22:32'),
(7, 'CR006', 'A/L', '2024-08-14 05:37:09'),
(8, 'CR007', 'Work Experience', '2024-08-14 05:37:09'),
(9, 'CR008', 'PGDip', '2024-08-14 05:38:05'),
(10, 'CR009', 'IFD', '2024-08-14 05:38:05');

-- --------------------------------------------------------

--
-- Table structure for table `leads_table`
--

CREATE TABLE `leads_table` (
  `id` int(11) NOT NULL,
  `lead_type` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `leads_table`
--

INSERT INTO `leads_table` (`id`, `lead_type`, `created_at`) VALUES
(1, 'Website', '2024-08-12 06:41:04'),
(2, 'Social Media', '2024-08-12 06:41:04'),
(3, 'Referral', '2024-08-12 06:41:04');

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
(86, 'BMS', 'International Foundation Diploma (Business) – ATHE Level 3', '003215', 'Hasni Nihar', 'English', '18 months', 222.00, 22.00, 22.00, 22.00, 'Bachelors,Diploma,CBM,A/L');

-- --------------------------------------------------------

--
-- Table structure for table `semester_table`
--

CREATE TABLE `semester_table` (
  `id` int(11) NOT NULL,
  `semester_name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `semester_table`
--

INSERT INTO `semester_table` (`id`, `semester_name`, `created_at`) VALUES
(1, '1st Semester', '2024-01-01 04:30:00'),
(2, '2nd Semester', '2024-04-01 04:30:00'),
(3, '3rd Semester', '2024-08-01 04:30:00'),
(5, '4th semester', '2024-08-12 07:57:21');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `student_code` int(20) NOT NULL,
  `title` enum('Mr','Mrs','Ms','Dr','Prof') NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `certificate_name` varchar(100) NOT NULL,
  `preferred_name` varchar(50) NOT NULL,
  `date_of_birth` date NOT NULL,
  `nationality` varchar(50) NOT NULL,
  `permanent_address` text NOT NULL,
  `current_address` text NOT NULL,
  `mobile` varchar(20) NOT NULL,
  `telephone` varchar(20) NOT NULL,
  `emergency_contact_name` varchar(100) NOT NULL,
  `emergency_contact_number` varchar(20) NOT NULL,
  `english_ability` tinyint(1) NOT NULL,
  `minimum_entry_qualification` tinyint(1) NOT NULL,
  `nic` varchar(20) NOT NULL,
  `passport` varchar(20) NOT NULL,
  `personal_email` varchar(100) NOT NULL,
  `bms_email` varchar(100) NOT NULL,
  `occupation` varchar(100) NOT NULL,
  `organization` varchar(100) NOT NULL,
  `previous_organization` varchar(100) NOT NULL,
  `qualifications` set('Bachelors','Masters','Diploma','CBM','A/L','PGDip','IFD','O/L') NOT NULL,
  `active` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`student_code`, `title`, `first_name`, `last_name`, `certificate_name`, `preferred_name`, `date_of_birth`, `nationality`, `permanent_address`, `current_address`, `mobile`, `telephone`, `emergency_contact_name`, `emergency_contact_number`, `english_ability`, `minimum_entry_qualification`, `nic`, `passport`, `personal_email`, `bms_email`, `occupation`, `organization`, `previous_organization`, `qualifications`, `active`) VALUES
(8, 'Dr', 'Mirshaths', 'Mohameds', 'min moh moh mirshath', 'Minzar Mirshath', '1979-05-13', 'Expedita autem conse', 'Reprehenderit et ad', 'Nulla facere et ulla', 'Quas dolorem dolorib', '+1 (908) 902-4066', 'Kelly Greer', '353', 1, 1, '990190984V', 'Voluptatem dolor cor', 'byruc@mailinator.com', 'mojade@mailinator.com', 'Non rerum culpa bea', 'Carson Willis Co', 'Roberts Dillard Trading', 'Bachelors', 1),
(15, 'Mrs', 'MMM', 'mmm', 'Mason Huber', 'Imani Reilly', '2002-07-09', 'Dolores ea dignissim', 'Voluptatem rerum dol', 'Nesciunt in facilis', 'Sed nostrud voluptat', '+1 (169) 886-2188', 'Abdul Mccray', '689', 1, 0, 'Cillum eum irure acc', 'Qui officiis velit ', 'boza@mailinator.com', 'bybe@mailinator.com', 'Unde ad iure in et d', 'Humphrey and Bowman Trading', 'James and Franco Associates', 'Masters,Diploma,CBM,IFD', 1);

-- --------------------------------------------------------

--
-- Table structure for table `universities`
--

CREATE TABLE `universities` (
  `id` int(11) NOT NULL,
  `university_code` varchar(100) NOT NULL,
  `university_name` varchar(255) NOT NULL,
  `address` text DEFAULT NULL,
  `uni_code` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `universities`
--

INSERT INTO `universities` (`id`, `university_code`, `university_name`, `address`, `uni_code`, `created_at`) VALUES
(1, 'UN01', 'BMS', '123 MirUni', 'UEX01', '2024-08-12 08:27:18');

-- --------------------------------------------------------

--
-- Table structure for table `year_table`
--

CREATE TABLE `year_table` (
  `id` int(11) NOT NULL,
  `year_name` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `year_table`
--

INSERT INTO `year_table` (`id`, `year_name`, `created_at`) VALUES
(17, '1st years', '2024-08-12 07:47:35'),
(18, '2nd years', '2024-08-12 07:47:37'),
(19, '3rd year', '2024-08-12 07:47:39'),
(20, 'N/A', '2024-08-12 07:47:45');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `coordinator_table`
--
ALTER TABLE `coordinator_table`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `criterias`
--
ALTER TABLE `criterias`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `leads_table`
--
ALTER TABLE `leads_table`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `program_table`
--
ALTER TABLE `program_table`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `semester_table`
--
ALTER TABLE `semester_table`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`student_code`);

--
-- Indexes for table `universities`
--
ALTER TABLE `universities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `year_table`
--
ALTER TABLE `year_table`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `coordinator_table`
--
ALTER TABLE `coordinator_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `criterias`
--
ALTER TABLE `criterias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `leads_table`
--
ALTER TABLE `leads_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;

--
-- AUTO_INCREMENT for table `program_table`
--
ALTER TABLE `program_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;

--
-- AUTO_INCREMENT for table `semester_table`
--
ALTER TABLE `semester_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `student_code` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `universities`
--
ALTER TABLE `universities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `year_table`
--
ALTER TABLE `year_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
