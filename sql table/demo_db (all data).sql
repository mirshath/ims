-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 10, 2024 at 11:24 AM
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

-- --------------------------------------------------------

--
-- Table structure for table `batch_table`
--

CREATE TABLE `batch_table` (
  `id` int(11) NOT NULL,
  `batch_name` varchar(255) NOT NULL,
  `university` int(11) NOT NULL,
  `programme` int(11) NOT NULL,
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
(6, 'BMS IFD(B) 1', 1, 20, '2006', '1985-03-30', '2011-04-11', '2024-09-04 09:18:56', '2024-09-04 09:18:56'),
(7, 'BMS IFD(B) 2', 1, 20, '1998', '2000-09-07', '2016-09-12', '2024-09-04 09:19:10', '2024-09-04 09:19:10'),
(8, 'BMS HD BS - 1', 1, 24, '1988', '2012-01-04', '2012-06-22', '2024-09-04 09:19:36', '2024-09-04 09:19:36'),
(9, 'EE_B1', 14, 23, '2022', '2024-09-02', '2024-09-18', '2024-09-04 10:26:10', '2024-09-04 10:26:10'),
(10, 'EE_B2', 14, 23, '2022', '2024-09-02', '2024-09-19', '2024-09-04 10:26:27', '2024-09-04 10:26:27');

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
(1, 'COD1', 'Ms', 'Asma Raahman', 'asari@bms.ac.lk', '$2y$10$LnTuLDS0Cz8wWV8Er8IjiOILvj753szQ9RcqvhLKe3MegzxY.NVtK'),
(2, 'COD2', 'Prof', 'Geethika Liyanage', 'latuhywu@mailinator.com', '$2y$10$HOK49FsnIAr/ZfiXTaQZ3.UOz3lUL23mTVvSdaOKFUIN5PmGi1J3u'),
(3, 'COD3', 'Dr', 'Hasni Nihar', 'webmaster@bms.ac.lk', '$2y$10$0EQTFHGnAh7lcVf7wstFcO66JrBRPgI8IBuSq3q1rSaVInj4zADwO');

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
(1, 'CR01', 'Bachelor', '2024-08-12 08:22:32'),
(2, 'CR02', 'Masters', '2024-08-12 08:22:32'),
(3, 'CR03', 'Diploma', '2024-08-12 08:22:32'),
(4, 'CR04', 'CBM', '2024-08-12 08:22:32'),
(7, 'CR006', 'A/L', '2024-08-14 05:37:09'),
(8, 'CR007', 'Work Experience', '2024-08-14 05:37:09'),
(9, 'CR008', 'PGDip', '2024-08-14 05:38:05'),
(10, 'CR009', 'IFD', '2024-08-14 05:38:05');

-- --------------------------------------------------------

--
-- Table structure for table `currency_table`
--

CREATE TABLE `currency_table` (
  `id` int(11) NOT NULL,
  `currency_code` varchar(50) NOT NULL,
  `currency_name` varchar(100) NOT NULL,
  `short_name` varchar(50) NOT NULL,
  `symbol` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `currency_table`
--

INSERT INTO `currency_table` (`id`, `currency_code`, `currency_name`, `short_name`, `symbol`) VALUES
(1, 'SL', 'Sri Lankan Rupees', 'Rs', 'Rs'),
(2, 'GBP', 'Pound Sterling', 'GBP', '£'),
(3, 'USD', 'United States Dollar', 'USD', '$');

-- --------------------------------------------------------

--
-- Table structure for table `decision_table`
--

CREATE TABLE `decision_table` (
  `id` int(11) NOT NULL,
  `decision_code` varchar(50) NOT NULL,
  `decision_name` varchar(100) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `grade_table`
--

CREATE TABLE `grade_table` (
  `id` int(11) NOT NULL,
  `grade_code` varchar(50) NOT NULL,
  `grade_name` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `grade_table`
--

INSERT INTO `grade_table` (`id`, `grade_code`, `grade_name`, `created_at`, `updated_at`) VALUES
(1, '0001', 'Distinction', '2024-08-16 09:47:10', '2024-08-16 10:11:16'),
(2, '0002', 'Merit', '2024-08-16 09:47:27', '2024-08-16 09:47:27'),
(3, '0003', 'Pass', '2024-08-16 09:47:38', '2024-08-16 09:51:18');

-- --------------------------------------------------------

--
-- Table structure for table `leads`
--

CREATE TABLE `leads` (
  `id` int(11) NOT NULL,
  `date` date NOT NULL,
  `type` varchar(255) NOT NULL,
  `university` varchar(255) NOT NULL,
  `programme` varchar(255) NOT NULL,
  `intake` date NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `contact` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `details` text DEFAULT NULL,
  `status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `leads`
--

INSERT INTO `leads` (`id`, `date`, `type`, `university`, `programme`, `intake`, `first_name`, `last_name`, `contact`, `email`, `details`, `status`) VALUES
(11, '1993-01-01', 'Social Media', '1', 'Higher Diploma in Biomedical Science', '1980-09-27', 'Nisam', 'Mohamed', '0124984458', 'nizam@mailinator.com', 'ABCDEFG HIJKLMNO', 'Prospectives'),
(12, '2024-08-31', 'Referral', '14', 'BTEC Higher National Diploma in Business', '2024-09-19', 'Daniels', 'Herrera', '0254904455', 'nenyli@mailinator.com', 'SSS', 'Future Intake');

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
(1, 'Websites', '2024-08-12 06:41:04'),
(2, 'Social Media', '2024-08-12 06:41:04'),
(3, 'Referrals', '2024-08-12 06:41:04');

-- --------------------------------------------------------

--
-- Table structure for table `lecturer_table`
--

CREATE TABLE `lecturer_table` (
  `id` int(11) NOT NULL,
  `title` enum('Mr','Mrs','Ms','Dr','Prof') NOT NULL,
  `lecturer_name` varchar(255) NOT NULL,
  `hourly_rate` decimal(10,2) NOT NULL,
  `qualification` text NOT NULL,
  `programs` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lecturer_table`
--

INSERT INTO `lecturer_table` (`id`, `title`, `lecturer_name`, `hourly_rate`, `qualification`, `programs`, `created_at`) VALUES
(45, 'Mr', 'noname 3', 0.00, 'MBA, UK', 'International Foundation Diploma (Business) – ATHE Level 3', '2024-08-15 06:39:58'),
(46, 'Ms', 'Noname 2', 0.00, 'BSc (Hons) Business with Human Resource Management, UK', 'BTEC Higher National Diploma in Business', '2024-08-15 06:41:11'),
(48, 'Prof', 'Kadeem Lester', 500.00, 'Laboris similique cu', 'Higher Diploma in Biomedical Science', '2024-08-15 10:42:21');

-- --------------------------------------------------------

--
-- Table structure for table `module_table`
--

CREATE TABLE `module_table` (
  `id` int(11) NOT NULL,
  `module_code` varchar(50) NOT NULL,
  `module_name` varchar(255) NOT NULL,
  `university` int(11) NOT NULL,
  `programme` int(11) NOT NULL,
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
(11, 'IFDB 301', 'Economics for Business', 1, 0, 'Assignment - 60% Group Presentation - 40%', 60, 'Compulsory', '', ''),
(12, 'BIMT 410', 'Academic Writing and Study Skills', 1, 0, 'Assignment - 60% Group Presentation - 40%', 50, 'Compulsory', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `program_table`
--

CREATE TABLE `program_table` (
  `program_code` int(11) NOT NULL,
  `university_id` int(11) NOT NULL,
  `program_name` varchar(255) NOT NULL,
  `prog_code` varchar(50) DEFAULT NULL,
  `coordinator_name` varchar(255) DEFAULT NULL,
  `medium` enum('English','Tamil') NOT NULL,
  `duration` varchar(100) DEFAULT NULL,
  `course_fee_lkr` decimal(10,2) DEFAULT NULL,
  `course_fee_gbp` decimal(10,2) DEFAULT NULL,
  `course_fee_usd` decimal(10,2) DEFAULT NULL,
  `course_fee_euro` decimal(10,2) DEFAULT NULL,
  `entry_requirement` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `program_table`
--

INSERT INTO `program_table` (`program_code`, `university_id`, `program_name`, `prog_code`, `coordinator_name`, `medium`, `duration`, `course_fee_lkr`, `course_fee_gbp`, `course_fee_usd`, `course_fee_euro`, `entry_requirement`) VALUES
(20, 1, 'International Foundation Diploma (Business) – ATHE Level 3', 'Pp1', 'Hasni Nihar', 'English', '12 months', 250000.00, 0.00, 320.00, 250.00, 'Diploma,CBM,Work Experience,IFD'),
(23, 14, 'BTEC Higher National Diploma in Business', 'P2', 'Hasni Nihar', 'English', '6 months', 56.00, 37.00, 22.00, 51.00, 'Diploma,A/L,PGDip,IFD'),
(24, 1, 'Higher Diploma in Biomedical Science', 'P3', 'Geethika Liyanage', 'English', '18 months', 9.00, 23.00, 91.00, 7.00, 'A/L,Work Experience,PGDip,IFD');

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
(1, '1nd Semester', '2024-01-01 04:30:00'),
(2, '2nd Semester', '2024-04-01 04:30:00'),
(3, '3rd Semester', '2024-08-01 04:30:00'),
(5, '4rd Semester', '2024-08-12 07:57:21');

-- --------------------------------------------------------

--
-- Table structure for table `status_table`
--

CREATE TABLE `status_table` (
  `id` int(11) NOT NULL,
  `status_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `status_table`
--

INSERT INTO `status_table` (`id`, `status_name`) VALUES
(2, 'Prospectives'),
(3, 'Not prospective'),
(4, 'Interested'),
(7, 'N/A'),
(9, 'Future Intake');

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
(8, 'Prof', 'Mirshath', 'Mohamed', 'Minzar Mohammadhu Mohamed Mirshath', 'Minzar Mirshath', '1999-01-19', 'Srilankan', 'Anuradhapura', 'Maradana', '0766158014', '0756158014', 'mirshath', '0786158014', 1, 1, '990190984V', '', 'mirshath@gmail.com', 'mirshath.m@cgs.lk', '', '', '', 'Bachelors', 1),
(15, 'Mrs', 'Testing', 'Testing', 'Mason Huber', 'Imani Reilly', '2002-07-09', 'Dolores ea dignissim', 'Voluptatem rerum dol', 'Nesciunt in facilis', 'Sed nostrud voluptat', '+1 (169) 886-2188', 'Abdul Mccray', '689', 1, 0, '978455214V', 'Qui officiis velit ', 'boza@mailinator.com', 'bybe@mailinator.com', '', '', '', 'Masters,Diploma,CBM,IFD', 1),
(17, 'Mr', 'Shana', 'West', 'Buffy Warren', 'Carly Strickland', '1995-10-16', 'Aliqua Eligendi ali', 'Ut magnam in illum ', 'Eius est laudantium', 'Aut commodi cupidita', '+1 (201) 591-1956', 'Burton Burke', '747', 0, 1, '35648754552V', 'Quod ea ut et optio', 'xiviji@mailinator.com', 'motiput@mailinator.com', '', '', '', 'Diploma,PGDip', 1),
(18, 'Ms', 'Jelani', 'Wilkins', 'Stuart Kelly', 'Jin Raymond', '2003-08-17', 'Repellendus Libero ', 'Itaque vel qui anim ', 'Aut neque consequat', 'Deserunt dolor maxim', '+1 (507) 563-5695', 'Jael Vargas', '739', 1, 1, '965484511V', '', 'dosysyp@mailinator.com', 'woru@mailinator.com', '', '', '', 'Bachelors,Diploma', 1),
(19, 'Mrs', 'Haley', 'Kelly', 'Neil Skinner', 'Cain Valdez', '2012-10-22', 'Porro dolor ea vitae', 'Qui iste odio dignis', 'Quis amet duis aut ', 'Ullamco quod deserun', '+1 (794) 602-9706', 'Uriel Hutchinson', '261', 0, 1, '9987854644V', '', 'dyzulocar@mailinator.com', 'qoco@mailinator.com', '', '', '', 'Masters,CBM,PGDip', 1);

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
(1, 'UN01', 'BMS', 'Wellawatte', 'UEX01', '2024-08-12 08:27:18'),
(14, 'UN02', 'ESOFT', 'bamba', 'UEX02', '2024-08-15 10:30:06');

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
(17, '1st year', '2024-08-12 07:47:35'),
(18, '2nd year', '2024-08-12 07:47:37'),
(19, '3rd year', '2024-08-12 07:47:39'),
(42, 'N/A', '2024-08-17 07:18:28');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `batch_table`
--
ALTER TABLE `batch_table`
  ADD PRIMARY KEY (`id`),
  ADD KEY `university` (`university`),
  ADD KEY `programme` (`programme`);

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
-- Indexes for table `currency_table`
--
ALTER TABLE `currency_table`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `decision_table`
--
ALTER TABLE `decision_table`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `grade_table`
--
ALTER TABLE `grade_table`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `leads`
--
ALTER TABLE `leads`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `leads_table`
--
ALTER TABLE `leads_table`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lecturer_table`
--
ALTER TABLE `lecturer_table`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `module_table`
--
ALTER TABLE `module_table`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_university` (`university`),
  ADD KEY `programme` (`programme`) USING BTREE;

--
-- Indexes for table `program_table`
--
ALTER TABLE `program_table`
  ADD PRIMARY KEY (`program_code`),
  ADD KEY `university_id` (`university_id`);

--
-- Indexes for table `semester_table`
--
ALTER TABLE `semester_table`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `status_table`
--
ALTER TABLE `status_table`
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
-- AUTO_INCREMENT for table `allocate_programme`
--
ALTER TABLE `allocate_programme`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `batch_table`
--
ALTER TABLE `batch_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `coordinator_table`
--
ALTER TABLE `coordinator_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `criterias`
--
ALTER TABLE `criterias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `currency_table`
--
ALTER TABLE `currency_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `decision_table`
--
ALTER TABLE `decision_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `grade_table`
--
ALTER TABLE `grade_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `leads`
--
ALTER TABLE `leads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `leads_table`
--
ALTER TABLE `leads_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- AUTO_INCREMENT for table `lecturer_table`
--
ALTER TABLE `lecturer_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `module_table`
--
ALTER TABLE `module_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `program_table`
--
ALTER TABLE `program_table`
  MODIFY `program_code` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `semester_table`
--
ALTER TABLE `semester_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `status_table`
--
ALTER TABLE `status_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `student_code` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `universities`
--
ALTER TABLE `universities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `year_table`
--
ALTER TABLE `year_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

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

--
-- Constraints for table `batch_table`
--
ALTER TABLE `batch_table`
  ADD CONSTRAINT `batch_table_ibfk_1` FOREIGN KEY (`university`) REFERENCES `universities` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_programme_code` FOREIGN KEY (`programme`) REFERENCES `program_table` (`program_code`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `module_table`
--
ALTER TABLE `module_table`
  ADD CONSTRAINT `fk_university` FOREIGN KEY (`university`) REFERENCES `universities` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `program_table`
--
ALTER TABLE `program_table`
  ADD CONSTRAINT `program_table_ibfk_1` FOREIGN KEY (`university_id`) REFERENCES `universities` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
