-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 22, 2024 at 08:45 PM
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
-- Database: `consultation_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `consultation`
--

CREATE TABLE `consultation` (
  `user_id` int(8) NOT NULL,
  `c_id` varchar(10) NOT NULL,
  `course_code` varchar(10) NOT NULL,
  `consultant` varchar(50) NOT NULL,
  `classroom_no` varchar(10) NOT NULL,
  `total_consultation_request` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `consultation`
--

INSERT INTO `consultation` (`user_id`, `c_id`, `course_code`, `consultant`, `classroom_no`, `total_consultation_request`) VALUES
(20672, '1001', 'CSE370', 'ATY', '7A08C', 1),
(20456, '1002', 'CSE110', 'ADU', '5B3L', 1);

-- --------------------------------------------------------

--
-- Table structure for table `faculty`
--

CREATE TABLE `faculty` (
  `user_id` int(8) NOT NULL,
  `initial` varchar(10) NOT NULL,
  `total_consultation_hour` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `faculty`
--

INSERT INTO `faculty` (`user_id`, `initial`, `total_consultation_hour`) VALUES
(10345, 'ATY', 0);

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `user_id` int(8) NOT NULL,
  `initial` varchar(10) NOT NULL,
  `semester` varchar(10) NOT NULL,
  `course_name` varchar(50) NOT NULL,
  `rating` int(10) NOT NULL,
  `comment` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`user_id`, `initial`, `semester`, `course_name`, `rating`, `comment`) VALUES
(22101672, 'ATY', 'Spring 24', 'CSE370', 4, 'Good'),
(22101672, '', '', '', 0, ''),
(22101672, '', '', '', 0, ''),
(22101672, '', '', '', 0, ''),
(22101672, '', '', '', 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `schedule`
--

CREATE TABLE `schedule` (
  `user_id` int(8) NOT NULL,
  `semester` varchar(10) NOT NULL,
  `course` varchar(50) NOT NULL,
  `type` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `section` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `schedule`
--

INSERT INTO `schedule` (`user_id`, `semester`, `course`, `type`, `section`) VALUES
(20672, 'Spring 24', 'CSE370', 'LAB', 4),
(10345, 'Spring 24', 'CSE370 ', 'Theory', 4),
(20012, 'Summer 24', 'CSE111', 'Lab', 2),
(20012, 'Summer 24', 'CSE330', 'Lab', 1),
(20012, 'Summer 24', 'CSE331', 'Theory', 4),
(20012, 'Summer 24', 'PHY111', 'Lab', 8),
(20777, 'Spring 24', 'PHY112', 'Lab', 1),
(20777, 'Spring 24', 'CSE370', 'Lab', 3),
(20777, 'Spring 24', 'CSE331', 'Theory', 1),
(20777, 'Spring 24', 'CSE360', 'Theory', 1);

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `user_id` int(8) NOT NULL,
  `student_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`user_id`, `student_id`) VALUES
(20672, 22101672);

-- --------------------------------------------------------

--
-- Table structure for table `student_tutor`
--

CREATE TABLE `student_tutor` (
  `user_id` int(8) NOT NULL,
  `st_id` varchar(10) NOT NULL,
  `assigned_course` varchar(50) NOT NULL,
  `assigned_section` int(10) NOT NULL,
  `assigned_under` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student_tutor`
--

INSERT INTO `student_tutor` (`user_id`, `st_id`, `assigned_course`, `assigned_section`, `assigned_under`) VALUES
(30123, 'T55', 'CSE370', 4, 'ATY');

-- --------------------------------------------------------

--
-- Table structure for table `user_info`
--

CREATE TABLE `user_info` (
  `user_id` int(8) NOT NULL,
  `user_type` varchar(15) NOT NULL,
  `name` varchar(50) NOT NULL,
  `department` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_info`
--

INSERT INTO `user_info` (`user_id`, `user_type`, `name`, `department`, `email`, `password`) VALUES
(10345, 'Faculty', 'Ateya Shuborna', 'CSE', 'ateya@gmail.com', 'ateya123'),
(10876, 'Faculty', 'Ahmed Ruhan', 'CSE', 'ahmedr@gmail.com', 'ahmed123'),
(20012, 'Student', 'Atif Aslam', 'EEE', 'atif@gmail.com', 'atif1234'),
(20456, 'Student', 'Arya Stark', 'CSE', 'arya.stark@gmail.com', 'arya123'),
(20672, 'Student', 'Sabira Rahman', 'CSE', 'sabirar358@gmail.com', 'sabira123'),
(20777, 'Student', 'Hermonie Granger', 'CS', 'hermonieg@gmail.com', 'hermonie123'),
(20989, 'Student', 'Abir Hossain', 'CSE', 'abir@gmail.com', 'abir1234'),
(30123, 'Student Tutor', 'Keya Sharmin', 'CSE', 'keya@gmail.com', 'keya123');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `consultation`
--
ALTER TABLE `consultation`
  ADD KEY `u_id_fk` (`user_id`);

--
-- Indexes for table `faculty`
--
ALTER TABLE `faculty`
  ADD PRIMARY KEY (`initial`),
  ADD KEY `u_id_fk` (`user_id`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD KEY `u_id_fk` (`user_id`);

--
-- Indexes for table `schedule`
--
ALTER TABLE `schedule`
  ADD KEY `u_id_fk` (`user_id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`student_id`),
  ADD KEY `u_id_fk` (`user_id`);

--
-- Indexes for table `student_tutor`
--
ALTER TABLE `student_tutor`
  ADD PRIMARY KEY (`st_id`),
  ADD KEY `u_id_fk` (`user_id`),
  ADD KEY `f_id_fk` (`assigned_under`);

--
-- Indexes for table `user_info`
--
ALTER TABLE `user_info`
  ADD PRIMARY KEY (`user_id`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `consultation`
--
ALTER TABLE `consultation`
  ADD CONSTRAINT `consultation_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user_info` (`user_id`);

--
-- Constraints for table `faculty`
--
ALTER TABLE `faculty`
  ADD CONSTRAINT `faculty_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `schedule` (`user_id`);

--
-- Constraints for table `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `feedback_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `student` (`student_id`);

--
-- Constraints for table `schedule`
--
ALTER TABLE `schedule`
  ADD CONSTRAINT `schedule_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user_info` (`user_id`);

--
-- Constraints for table `student`
--
ALTER TABLE `student`
  ADD CONSTRAINT `student_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `schedule` (`user_id`);

--
-- Constraints for table `student_tutor`
--
ALTER TABLE `student_tutor`
  ADD CONSTRAINT `student_tutor_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user_info` (`user_id`),
  ADD CONSTRAINT `student_tutor_ibfk_2` FOREIGN KEY (`assigned_under`) REFERENCES `faculty` (`initial`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
