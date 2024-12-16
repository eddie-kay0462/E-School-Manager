-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 15, 2024 at 09:08 PM
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
-- Database: `e-school-management`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `admin_id` varchar(20) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`admin_id`, `first_name`, `last_name`) VALUES
('ADMIN-246', 'Ebo', 'Curtis');

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `attendance_id` varchar(20) NOT NULL,
  `student_id` varchar(20) DEFAULT NULL,
  `class_id` int(11) DEFAULT NULL,
  `date` date NOT NULL,
  `status` enum('present','absent','late') NOT NULL,
  `marked_by` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `classes`
--

CREATE TABLE `classes` (
  `class_id` int(11) NOT NULL,
  `class_name` varchar(50) NOT NULL,
  `class_teacher_id` varchar(20) DEFAULT NULL,
  `academic_year` varchar(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `classes`
--

INSERT INTO `classes` (`class_id`, `class_name`, `class_teacher_id`, `academic_year`) VALUES
(1, 'jss2', 'TEACH-002', '2024-2025'),
(2, 'jss3', 'TEACH-003', '2024-2025'),
(3, 'jss1', 'TEACH-004', '2024-2025');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `course_code` varchar(10) NOT NULL,
  `course_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`course_code`, `course_name`) VALUES
('computingJ', 'computing'),
('englishJH', 'english'),
('frenchJH', 'french'),
('mathJH', 'math'),
('scienceJH', 'science'),
('socialJH', 'social');

-- --------------------------------------------------------

--
-- Table structure for table `grades`
--

CREATE TABLE `grades` (
  `grade_id` int(11) NOT NULL,
  `student_id` varchar(20) NOT NULL,
  `course_code` varchar(10) NOT NULL,
  `class_id` int(11) NOT NULL,
  `teacher_id` varchar(20) NOT NULL,
  `term` enum('first','second','third') NOT NULL,
  `academic_year` varchar(255) DEFAULT '2024-2025',
  `assignment_score` decimal(5,2) NOT NULL,
  `test_score` decimal(5,2) NOT NULL,
  `mid_term_score` int(255) NOT NULL,
  `exam_score` decimal(5,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `grades`
--

INSERT INTO `grades` (`grade_id`, `student_id`, `course_code`, `class_id`, `teacher_id`, `term`, `academic_year`, `assignment_score`, `test_score`, `mid_term_score`, `exam_score`) VALUES
(1, 'STU-023', 'mathJH', 3, 'TEACH-001', 'first', '2024-2025', 100.00, 100.00, 100, 100.00),
(2, 'STU-026', 'mathJH', 3, 'TEACH-001', 'first', '2024-2025', 20.00, 20.00, 20, 20.00),
(3, 'STU-021', 'mathJH', 3, 'TEACH-001', 'first', '2024-2025', 100.00, 100.00, 100, 100.00),
(4, 'STU-020', 'mathJH', 3, 'TEACH-001', 'first', '2024-2025', 50.00, 50.00, 50, 50.00),
(5, 'STU-024', 'mathJH', 3, 'TEACH-001', 'first', '2024-2025', 80.00, 80.00, 80, 90.00),
(6, 'STU-022', 'mathJH', 3, 'TEACH-001', 'first', '2024-2025', 67.00, 66.00, 66, 66.00),
(7, 'STU-899', 'mathJH', 3, 'TEACH-001', 'first', '2024-2025', 90.00, 99.00, 87, 77.00),
(8, 'STU-777', 'mathJH', 3, 'TEACH-001', 'first', '2024-2025', 66.00, 56.00, 56, 56.00),
(10, 'STU-014', 'mathJH', 1, 'TEACH-001', 'first', '2024-2025', 55.00, 90.00, 88, 92.00),
(11, 'STU-002', 'mathJH', 1, 'TEACH-001', 'first', '2024-2025', 33.00, 12.00, 22, 55.00),
(12, 'STU-017', 'mathJH', 1, 'TEACH-001', 'first', '2024-2025', 12.00, 45.00, 45, 55.00),
(13, 'STU-001', 'mathJH', 1, 'TEACH-001', 'first', '2024-2025', 55.00, 55.00, 55, 55.00),
(14, 'STU-012', 'mathJH', 1, 'TEACH-001', 'first', '2024-2025', 100.00, 60.00, 77, 67.00),
(15, 'STU-013', 'mathJH', 1, 'TEACH-001', 'first', '2024-2025', 25.00, 55.00, 55, 67.00),
(16, 'STU-877', 'mathJH', 1, 'TEACH-001', 'first', '2024-2025', 67.00, 78.00, 78, 78.00),
(17, 'STU-015', 'mathJH', 1, 'TEACH-001', 'first', '2024-2025', 90.00, 90.00, 99, 99.00),
(18, 'STU-977', 'mathJH', 1, 'TEACH-001', 'first', '2024-2025', 60.00, 55.00, 55, 89.00),
(19, 'STU-016', 'mathJH', 1, 'TEACH-001', 'first', '2024-2025', 88.00, 88.00, 88, 88.00),
(20, 'STU-007', 'mathJH', 2, 'TEACH-001', 'first', '2024-2025', 100.00, 100.00, 100, 100.00),
(21, 'STU-025', 'mathJH', 2, 'TEACH-001', 'first', '2024-2025', 100.00, 90.00, 90, 98.00),
(22, 'STU-010', 'mathJH', 2, 'TEACH-001', 'first', '2024-2025', 78.00, 78.00, 78, 78.00),
(23, 'STU-011', 'mathJH', 2, 'TEACH-001', 'first', '2024-2025', 66.00, 78.00, 77, 66.00),
(24, 'STU-005', 'mathJH', 2, 'TEACH-001', 'first', '2024-2025', 57.00, 56.00, 56, 56.00),
(25, 'STU-006', 'mathJH', 2, 'TEACH-001', 'first', '2024-2025', 88.00, 99.00, 88, 99.00),
(26, 'STU-004', 'mathJH', 2, 'TEACH-001', 'first', '2024-2025', 78.00, 78.00, 78, 78.00),
(27, 'STU-177', 'mathJH', 2, 'TEACH-001', 'first', '2024-2025', 0.00, 99.00, 0, 99.00),
(28, 'STU-078', 'mathJH', 2, 'TEACH-001', 'first', '2024-2025', 89.00, 89.00, 89, 0.00),
(29, 'STU-009', 'mathJH', 2, 'TEACH-001', 'first', '2024-2025', 89.00, 99.00, 0, 99.00),
(30, 'STU-477', 'mathJH', 2, 'TEACH-001', 'first', '2024-2025', 12.00, 33.00, 33, 45.00),
(31, 'STU-008', 'mathJH', 2, 'TEACH-001', 'first', '2024-2025', 89.00, 99.00, 99, 99.00),
(32, 'STU-077', 'mathJH', 2, 'TEACH-001', 'first', '2024-2025', 89.00, 89.00, 89, 89.00),
(33, 'STU-003', 'mathJH', 2, 'TEACH-001', 'first', '2024-2025', 12.00, 0.00, 0, 0.00),
(34, 'STU-023', 'scienceJH', 3, 'TEACH-001', 'first', '2024-2025', 100.00, 20.00, 99, 99.00),
(35, 'STU-026', 'scienceJH', 3, 'TEACH-001', 'first', '2024-2025', 78.00, 78.00, 78, 77.00),
(36, 'STU-021', 'scienceJH', 3, 'TEACH-001', 'first', '2024-2025', 23.00, 55.00, 66, 78.00),
(37, 'STU-020', 'scienceJH', 3, 'TEACH-001', 'first', '2024-2025', 89.00, 89.00, 89, 89.00),
(38, 'STU-024', 'scienceJH', 3, 'TEACH-001', 'first', '2024-2025', 78.00, 66.00, 55, 44.00),
(39, 'STU-022', 'scienceJH', 3, 'TEACH-001', 'first', '2024-2025', 78.00, 66.00, 55, 67.00),
(40, 'STU-899', 'scienceJH', 3, 'TEACH-001', 'first', '2024-2025', 87.00, 66.00, 44, 33.00),
(41, 'STU-777', 'scienceJH', 3, 'TEACH-001', 'first', '2024-2025', 12.00, 44.00, 55, 44.00),
(42, 'STU-014', 'scienceJH', 1, 'TEACH-001', 'first', '2024-2025', 12.00, 66.00, 44, 44.00),
(43, 'STU-002', 'scienceJH', 1, 'TEACH-001', 'first', '2024-2025', 88.00, 99.00, 88, 99.00),
(46, 'STU-017', 'scienceJH', 1, 'TEACH-001', 'first', '2024-2025', 77.00, 88.00, 77, 89.00),
(52, 'STU-001', 'scienceJH', 1, 'TEACH-001', 'first', '2024-2025', 33.00, 20.00, 20, 20.00),
(58, 'STU-012', 'scienceJH', 1, 'TEACH-001', 'first', '2024-2025', 100.00, 50.00, 50, 89.00),
(60, 'STU-013', 'scienceJH', 1, 'TEACH-001', 'first', '2024-2025', 10.00, 77.00, 76, 45.00),
(67, 'STU-007', 'scienceJH', 2, 'TEACH-001', 'first', '2024-2025', 10.00, 100.00, 66, 77.00),
(68, 'STU-025', 'scienceJH', 2, 'TEACH-001', 'first', '2024-2025', 50.00, 0.00, 0, 0.00),
(69, 'STU-877', 'scienceJH', 1, 'TEACH-001', 'first', '2024-2025', 59.00, 66.00, 77, 77.00),
(70, 'STU-015', 'scienceJH', 1, 'TEACH-001', 'first', '2024-2025', 88.00, 77.00, 88, 77.00),
(71, 'STU-977', 'scienceJH', 1, 'TEACH-001', 'first', '2024-2025', 77.00, 88.00, 77, 88.00),
(72, 'STU-016', 'scienceJH', 1, 'TEACH-001', 'first', '2024-2025', 77.00, 88.00, 88, 88.00),
(73, 'STU-010', 'scienceJH', 2, 'TEACH-001', 'first', '2024-2025', 77.00, 88.00, 77, 88.00),
(74, 'STU-011', 'scienceJH', 2, 'TEACH-001', 'first', '2024-2025', 8.00, 87.00, 89, 66.00),
(75, 'STU-005', 'scienceJH', 2, 'TEACH-001', 'first', '2024-2025', 67.00, 66.00, 54, 33.00),
(76, 'STU-006', 'scienceJH', 2, 'TEACH-001', 'first', '2024-2025', 16.00, 55.00, 55, 4.00),
(77, 'STU-004', 'scienceJH', 2, 'TEACH-001', 'first', '2024-2025', 33.00, 33.00, 33, 33.00),
(78, 'STU-177', 'scienceJH', 2, 'TEACH-001', 'first', '2024-2025', 56.00, 56.00, 56, 44.00),
(79, 'STU-078', 'scienceJH', 2, 'TEACH-001', 'first', '2024-2025', 100.00, 100.00, 100, 99.00),
(80, 'STU-009', 'scienceJH', 2, 'TEACH-001', 'first', '2024-2025', 90.00, 90.00, 8, 77.00),
(81, 'STU-477', 'scienceJH', 2, 'TEACH-001', 'first', '2024-2025', 99.00, 99.00, 99, 8.00),
(82, 'STU-008', 'scienceJH', 2, 'TEACH-001', 'first', '2024-2025', 8.00, 88.00, 99, 99.00),
(83, 'STU-077', 'scienceJH', 2, 'TEACH-001', 'first', '2024-2025', 12.00, 44.00, 44, 44.00),
(84, 'STU-003', 'scienceJH', 2, 'TEACH-001', 'first', '2024-2025', 98.00, 77.00, 66, 55.00),
(85, 'STU-079', 'scienceJH', 2, 'TEACH-001', 'first', '2024-2025', 77.00, 99.00, 88, 44.00),
(86, 'STU-079', 'mathJH', 2, 'TEACH-001', 'first', '2024-2025', 55.00, 44.00, 55, 44.00),
(87, 'STU-023', 'computingJ', 3, 'TEACH-005', 'first', '2024-2025', 0.00, 0.00, 0, 0.00),
(88, 'STU-026', 'computingJ', 3, 'TEACH-005', 'first', '2024-2025', 89.00, 89.00, 77, 66.00),
(89, 'STU-021', 'computingJ', 3, 'TEACH-005', 'first', '2024-2025', 99.00, 88.00, 77, 66.00),
(90, 'STU-020', 'computingJ', 3, 'TEACH-005', 'first', '2024-2025', 88.00, 77.00, 66, 13.00),
(91, 'STU-024', 'computingJ', 3, 'TEACH-005', 'first', '2024-2025', 99.00, 87.00, 77, 66.00),
(92, 'STU-022', 'computingJ', 3, 'TEACH-005', 'first', '2024-2025', 33.00, 44.00, 44, 33.00),
(93, 'STU-899', 'computingJ', 3, 'TEACH-005', 'first', '2024-2025', 90.00, 99.00, 99, 98.00),
(94, 'STU-777', 'computingJ', 3, 'TEACH-005', 'first', '2024-2025', 78.00, 78.00, 78, 77.00),
(95, 'STU-014', 'computingJ', 1, 'TEACH-005', 'first', '2024-2025', 66.00, 77.00, 77, 88.00),
(96, 'STU-002', 'computingJ', 1, 'TEACH-005', 'first', '2024-2025', 55.00, 66.00, 77, 77.00),
(97, 'STU-017', 'computingJ', 1, 'TEACH-005', 'first', '2024-2025', 89.00, 88.00, 66, 55.00),
(98, 'STU-001', 'computingJ', 1, 'TEACH-005', 'first', '2024-2025', 34.00, 34.00, 44, 55.00),
(99, 'STU-012', 'computingJ', 1, 'TEACH-005', 'first', '2024-2025', 45.00, 45.00, 66, 77.00),
(100, 'STU-013', 'computingJ', 1, 'TEACH-005', 'first', '2024-2025', 78.00, 66.00, 77, 67.00),
(101, 'STU-877', 'computingJ', 1, 'TEACH-005', 'first', '2024-2025', 45.00, 66.00, 77, 13.00),
(102, 'STU-015', 'computingJ', 1, 'TEACH-005', 'first', '2024-2025', 56.00, 54.00, 56, 56.00),
(103, 'STU-977', 'computingJ', 1, 'TEACH-005', 'first', '2024-2025', 78.00, 88.00, 55, 55.00),
(104, 'STU-016', 'computingJ', 1, 'TEACH-005', 'first', '2024-2025', 88.00, 12.00, 55, 22.00),
(105, 'STU-007', 'computingJ', 2, 'TEACH-005', 'first', '2024-2025', 55.00, 77.00, 88, 55.00),
(106, 'STU-025', 'computingJ', 2, 'TEACH-005', 'first', '2024-2025', 25.00, 44.00, 55, 85.00),
(107, 'STU-010', 'computingJ', 2, 'TEACH-005', 'first', '2024-2025', 55.00, 55.00, 22, 55.00),
(108, 'STU-011', 'computingJ', 2, 'TEACH-005', 'first', '2024-2025', 78.00, 88.00, 88, 88.00),
(109, 'STU-005', 'computingJ', 2, 'TEACH-005', 'first', '2024-2025', 78.00, 78.00, 85, 23.00),
(110, 'STU-006', 'computingJ', 2, 'TEACH-005', 'first', '2024-2025', 44.00, 67.00, 67, 67.00),
(111, 'STU-004', 'computingJ', 2, 'TEACH-005', 'first', '2024-2025', 88.00, 55.00, 88, 55.00),
(112, 'STU-177', 'computingJ', 2, 'TEACH-005', 'first', '2024-2025', 72.00, 15.00, 55, 55.00),
(113, 'STU-079', 'computingJ', 2, 'TEACH-005', 'first', '2024-2025', 87.00, 88.00, 55, 55.00),
(114, 'STU-078', 'computingJ', 2, 'TEACH-005', 'first', '2024-2025', 15.00, 22.00, 55, 66.00),
(115, 'STU-009', 'computingJ', 2, 'TEACH-005', 'first', '2024-2025', 12.00, 55.00, 88, 99.00),
(116, 'STU-477', 'computingJ', 2, 'TEACH-005', 'first', '2024-2025', 55.00, 55.00, 22, 55.00),
(117, 'STU-008', 'computingJ', 2, 'TEACH-005', 'first', '2024-2025', 88.00, 55.00, 55, 25.00),
(118, 'STU-077', 'computingJ', 2, 'TEACH-005', 'first', '2024-2025', 25.00, 25.00, 25, 55.00),
(119, 'STU-003', 'computingJ', 2, 'TEACH-005', 'first', '2024-2025', 88.00, 88.00, 55, 55.00),
(120, 'STU-023', 'socialJH', 3, 'TEACH-002', 'first', '2024-2025', 100.00, 100.00, 100, 100.00),
(121, 'STU-026', 'socialJH', 3, 'TEACH-002', 'first', '2024-2025', 77.00, 88.00, 77, 88.00),
(122, 'STU-021', 'socialJH', 3, 'TEACH-002', 'first', '2024-2025', 99.00, 88.00, 99, 88.00),
(123, 'STU-020', 'socialJH', 3, 'TEACH-002', 'first', '2024-2025', 67.00, 88.00, 77, 66.00),
(124, 'STU-024', 'socialJH', 3, 'TEACH-002', 'first', '2024-2025', 67.00, 66.00, 77, 66.00),
(125, 'STU-022', 'socialJH', 3, 'TEACH-002', 'first', '2024-2025', 78.00, 88.00, 88, 88.00),
(126, 'STU-899', 'socialJH', 3, 'TEACH-002', 'first', '2024-2025', 89.00, 87.00, 88, 99.00),
(127, 'STU-777', 'socialJH', 3, 'TEACH-002', 'first', '2024-2025', 15.00, 77.00, 66, 77.00),
(128, 'STU-014', 'socialJH', 1, 'TEACH-002', 'first', '2024-2025', 66.00, 77.00, 66, 77.00),
(129, 'STU-002', 'socialJH', 1, 'TEACH-002', 'first', '2024-2025', 89.00, 6.00, 66, 55.00),
(130, 'STU-017', 'socialJH', 1, 'TEACH-002', 'first', '2024-2025', 100.00, 100.00, 100, 100.00),
(131, 'STU-001', 'socialJH', 1, 'TEACH-002', 'first', '2024-2025', 78.00, 88.00, 88, 88.00),
(132, 'STU-012', 'socialJH', 1, 'TEACH-002', 'first', '2024-2025', 67.00, 0.00, 0, 0.00),
(133, 'STU-013', 'socialJH', 1, 'TEACH-002', 'first', '2024-2025', 66.00, 55.00, 77, 77.00),
(134, 'STU-877', 'socialJH', 1, 'TEACH-002', 'first', '2024-2025', 66.00, 77.00, 88, 77.00),
(135, 'STU-015', 'socialJH', 1, 'TEACH-002', 'first', '2024-2025', 77.00, 88.00, 77, 88.00),
(136, 'STU-977', 'socialJH', 1, 'TEACH-002', 'first', '2024-2025', 33.00, 55.00, 66, 77.00),
(137, 'STU-016', 'socialJH', 1, 'TEACH-002', 'first', '2024-2025', 67.00, 55.00, 44, 33.00),
(138, 'STU-007', 'socialJH', 2, 'TEACH-002', 'first', '2024-2025', 67.00, 67.00, 55, 97.00),
(139, 'STU-025', 'socialJH', 2, 'TEACH-002', 'first', '2024-2025', 55.00, 66.00, 77, 55.00),
(140, 'STU-010', 'socialJH', 2, 'TEACH-002', 'first', '2024-2025', 66.00, 77.00, 55, 8.00),
(141, 'STU-011', 'socialJH', 2, 'TEACH-002', 'first', '2024-2025', 36.00, 47.00, 49, 55.00),
(142, 'STU-005', 'socialJH', 2, 'TEACH-002', 'first', '2024-2025', 99.00, 87.00, 65, 75.00),
(143, 'STU-006', 'socialJH', 2, 'TEACH-002', 'first', '2024-2025', 58.00, 8.00, 58, 55.00),
(144, 'STU-004', 'socialJH', 2, 'TEACH-002', 'first', '2024-2025', 14.00, 55.00, 44, 55.00),
(145, 'STU-177', 'socialJH', 2, 'TEACH-002', 'first', '2024-2025', 15.00, 88.00, 65, 88.00),
(146, 'STU-079', 'socialJH', 2, 'TEACH-002', 'first', '2024-2025', 55.00, 58.00, 71, 25.00),
(147, 'STU-078', 'socialJH', 2, 'TEACH-002', 'first', '2024-2025', 17.00, 8.00, 55, 88.00),
(148, 'STU-009', 'socialJH', 2, 'TEACH-002', 'first', '2024-2025', 23.00, 69.00, 88, 53.00),
(149, 'STU-477', 'socialJH', 2, 'TEACH-002', 'first', '2024-2025', 12.00, 58.00, 66, 98.00),
(150, 'STU-008', 'socialJH', 2, 'TEACH-002', 'first', '2024-2025', 17.00, 44.00, 42, 59.00),
(151, 'STU-077', 'socialJH', 2, 'TEACH-002', 'first', '2024-2025', 17.00, 44.00, 26, 55.00),
(152, 'STU-003', 'socialJH', 2, 'TEACH-002', 'first', '2024-2025', 100.00, 100.00, 100, 65.00),
(153, 'STU-023', 'frenchJH', 3, 'TEACH-003', 'first', '2024-2025', 67.00, 54.00, 66, 66.00),
(154, 'STU-026', 'frenchJH', 3, 'TEACH-003', 'first', '2024-2025', 17.00, 44.00, 55, 44.00),
(155, 'STU-021', 'frenchJH', 3, 'TEACH-003', 'first', '2024-2025', 12.00, 55.00, 21, 86.00),
(156, 'STU-020', 'frenchJH', 3, 'TEACH-003', 'first', '2024-2025', 12.00, 33.00, 25, 82.00),
(157, 'STU-024', 'frenchJH', 3, 'TEACH-003', 'first', '2024-2025', 77.00, 33.00, 36, 25.00),
(158, 'STU-022', 'frenchJH', 3, 'TEACH-003', 'first', '2024-2025', 11.00, 42.00, 22, 58.00),
(159, 'STU-899', 'frenchJH', 3, 'TEACH-003', 'first', '2024-2025', 36.00, 99.00, 82, 88.00),
(160, 'STU-777', 'frenchJH', 3, 'TEACH-003', 'first', '2024-2025', 12.00, 12.00, 22, 55.00),
(161, 'STU-014', 'frenchJH', 1, 'TEACH-003', 'first', '2024-2025', 7.00, 68.00, 28, 4.00),
(162, 'STU-002', 'frenchJH', 1, 'TEACH-003', 'first', '2024-2025', 26.00, 38.00, 18, 55.00),
(163, 'STU-017', 'frenchJH', 1, 'TEACH-003', 'first', '2024-2025', 77.00, 95.00, 66, 26.00),
(164, 'STU-001', 'frenchJH', 1, 'TEACH-003', 'first', '2024-2025', 12.00, 55.00, 22, 58.00),
(165, 'STU-012', 'frenchJH', 1, 'TEACH-003', 'first', '2024-2025', 14.00, 55.00, 26, 66.00),
(166, 'STU-013', 'frenchJH', 1, 'TEACH-003', 'first', '2024-2025', 33.00, 25.00, 28, 59.00),
(167, 'STU-877', 'frenchJH', 1, 'TEACH-003', 'first', '2024-2025', 77.00, 82.00, 69, 25.00),
(168, 'STU-015', 'frenchJH', 1, 'TEACH-003', 'first', '2024-2025', 11.00, 25.00, 36, 99.00),
(169, 'STU-977', 'frenchJH', 1, 'TEACH-003', 'first', '2024-2025', 23.00, 66.00, 99, 99.00),
(170, 'STU-016', 'frenchJH', 1, 'TEACH-003', 'first', '2024-2025', 44.00, 55.00, 82, 93.00),
(171, 'STU-007', 'frenchJH', 2, 'TEACH-003', 'first', '2024-2025', 44.00, 26.00, 99, 99.00),
(172, 'STU-025', 'frenchJH', 2, 'TEACH-003', 'first', '2024-2025', 15.00, 22.00, 55, 55.00),
(173, 'STU-010', 'frenchJH', 2, 'TEACH-003', 'first', '2024-2025', 14.00, 52.00, 55, 55.00),
(174, 'STU-011', 'frenchJH', 2, 'TEACH-003', 'first', '2024-2025', 23.00, 55.00, 25, 82.00),
(175, 'STU-005', 'frenchJH', 2, 'TEACH-003', 'first', '2024-2025', 14.00, 25.00, 23, 55.00),
(176, 'STU-006', 'frenchJH', 2, 'TEACH-003', 'first', '2024-2025', 12.00, 55.00, 28, 25.00),
(177, 'STU-004', 'frenchJH', 2, 'TEACH-003', 'first', '2024-2025', 77.00, 48.00, 29, 5.00),
(178, 'STU-177', 'frenchJH', 2, 'TEACH-003', 'first', '2024-2025', 14.00, 22.00, 55, 86.00),
(179, 'STU-079', 'frenchJH', 2, 'TEACH-003', 'first', '2024-2025', 65.00, 8.00, 55, 83.00),
(180, 'STU-078', 'frenchJH', 2, 'TEACH-003', 'first', '2024-2025', 41.00, 25.00, 36, 69.00),
(181, 'STU-009', 'frenchJH', 2, 'TEACH-003', 'first', '2024-2025', 11.00, 25.00, 33, 92.00),
(182, 'STU-477', 'frenchJH', 2, 'TEACH-003', 'first', '2024-2025', 78.00, 98.00, 5, 22.00),
(183, 'STU-008', 'frenchJH', 2, 'TEACH-003', 'first', '2024-2025', 12.00, 55.00, 25, 88.00),
(184, 'STU-077', 'frenchJH', 2, 'TEACH-003', 'first', '2024-2025', 25.00, 55.00, 55, 55.00),
(185, 'STU-003', 'frenchJH', 2, 'TEACH-003', 'first', '2024-2025', 55.00, 85.00, 49, 55.00),
(186, 'STU-023', 'englishJH', 3, 'TEACH-004', 'first', '2024-2025', 55.00, 82.00, 55, 89.00),
(187, 'STU-026', 'englishJH', 3, 'TEACH-004', 'first', '2024-2025', 77.00, 58.00, 58, 55.00),
(188, 'STU-021', 'englishJH', 3, 'TEACH-004', 'first', '2024-2025', 78.00, 55.00, 88, 77.00),
(189, 'STU-020', 'englishJH', 3, 'TEACH-004', 'first', '2024-2025', 14.00, 58.00, 55, 88.00),
(190, 'STU-024', 'englishJH', 3, 'TEACH-004', 'first', '2024-2025', 14.00, 52.00, 55, 55.00),
(191, 'STU-022', 'englishJH', 3, 'TEACH-004', 'first', '2024-2025', 12.00, 58.00, 85, 85.00),
(192, 'STU-899', 'englishJH', 3, 'TEACH-004', 'first', '2024-2025', 17.00, 55.00, 55, 59.00),
(193, 'STU-777', 'englishJH', 3, 'TEACH-004', 'first', '2024-2025', 36.00, 99.00, 69, 99.00),
(194, 'STU-014', 'englishJH', 1, 'TEACH-004', 'first', '2024-2025', 55.00, 88.00, 55, 88.00),
(195, 'STU-002', 'englishJH', 1, 'TEACH-004', 'first', '2024-2025', 58.00, 55.00, 88, 52.00),
(196, 'STU-017', 'englishJH', 1, 'TEACH-004', 'first', '2024-2025', 99.00, 88.00, 99, 88.00),
(197, 'STU-001', 'englishJH', 1, 'TEACH-004', 'first', '2024-2025', 36.00, 95.00, 8, 88.00),
(198, 'STU-012', 'englishJH', 1, 'TEACH-004', 'first', '2024-2025', 99.00, 88.00, 55, 88.00),
(199, 'STU-013', 'englishJH', 1, 'TEACH-004', 'first', '2024-2025', 14.00, 55.00, 88, 77.00),
(200, 'STU-877', 'englishJH', 1, 'TEACH-004', 'first', '2024-2025', 36.00, 99.00, 69, 99.00),
(201, 'STU-015', 'englishJH', 1, 'TEACH-004', 'first', '2024-2025', 19.00, 88.00, 99, 69.00),
(202, 'STU-977', 'englishJH', 1, 'TEACH-004', 'first', '2024-2025', 77.00, 88.00, 77, 88.00),
(203, 'STU-016', 'englishJH', 1, 'TEACH-004', 'first', '2024-2025', 13.00, 69.00, 85, 85.00),
(204, 'STU-007', 'englishJH', 2, 'TEACH-004', 'first', '2024-2025', 12.00, 55.00, 55, 9.00),
(205, 'STU-025', 'englishJH', 2, 'TEACH-004', 'first', '2024-2025', 36.00, 99.00, 66, 5.00),
(206, 'STU-010', 'englishJH', 2, 'TEACH-004', 'first', '2024-2025', 77.00, 5.00, 88, 55.00),
(207, 'STU-011', 'englishJH', 2, 'TEACH-004', 'first', '2024-2025', 17.00, 22.00, 53, 99.00),
(208, 'STU-005', 'englishJH', 2, 'TEACH-004', 'first', '2024-2025', 77.00, 88.00, 55, 66.00),
(209, 'STU-006', 'englishJH', 2, 'TEACH-004', 'first', '2024-2025', 84.00, 84.00, 94, 95.00),
(210, 'STU-004', 'englishJH', 2, 'TEACH-004', 'first', '2024-2025', 45.00, 55.00, 88, 55.00),
(211, 'STU-177', 'englishJH', 2, 'TEACH-004', 'first', '2024-2025', 77.00, 58.00, 99, 85.00),
(212, 'STU-079', 'englishJH', 2, 'TEACH-004', 'first', '2024-2025', 33.00, 66.00, 33, 58.00),
(213, 'STU-078', 'englishJH', 2, 'TEACH-004', 'first', '2024-2025', 99.00, 66.00, 99, 66.00),
(214, 'STU-009', 'englishJH', 2, 'TEACH-004', 'first', '2024-2025', 12.00, 52.00, 63, 63.00),
(215, 'STU-477', 'englishJH', 2, 'TEACH-004', 'first', '2024-2025', 88.00, 77.00, 99, 88.00),
(216, 'STU-008', 'englishJH', 2, 'TEACH-004', 'first', '2024-2025', 23.00, 66.00, 66, 33.00),
(217, 'STU-077', 'englishJH', 2, 'TEACH-004', 'first', '2024-2025', 98.00, 99.00, 88, 99.00),
(218, 'STU-003', 'englishJH', 2, 'TEACH-004', 'first', '2024-2025', 25.00, 87.00, 58, 88.00);

-- --------------------------------------------------------

--
-- Table structure for table `parents`
--

CREATE TABLE `parents` (
  `parent_id` varchar(20) NOT NULL,
  `user_id` varchar(20) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `ward_id` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `parents`
--

INSERT INTO `parents` (`parent_id`, `user_id`, `full_name`, `ward_id`) VALUES
('PRNT-001', 'PRNT-001', 'Ida Yeboah', 'STU-001'),
('PRNT-002', 'PRNT-002', 'Ernestina Amoako', 'STU-002'),
('PRNT-567', 'PRNT-567', 'Miss Senam', 'STU-014'),
('PRNT-899', 'PRNT-899', 'Sean Combs Snr', 'STU-177');

-- --------------------------------------------------------

--
-- Table structure for table `remarks`
--

CREATE TABLE `remarks` (
  `remark_id` int(11) NOT NULL,
  `student_id` varchar(20) NOT NULL,
  `teacher_id` varchar(20) NOT NULL,
  `academic_year` varchar(9) NOT NULL,
  `remark` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `remarks`
--

INSERT INTO `remarks` (`remark_id`, `student_id`, `teacher_id`, `academic_year`, `remark`, `created_at`) VALUES
(1, 'STU-014', 'TEACH-002', '2023/2024', 'Good work so far. There is still some more room for improvement', '2024-12-15 19:02:04'),
(2, 'STU-177', 'TEACH-003', '2023/2024', 'More work needs to be done on him. But he has improved a bit', '2024-12-15 19:25:56');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `student_id` varchar(20) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `date_of_birth` date NOT NULL,
  `gender` enum('male','female','other') NOT NULL,
  `class_id` int(11) DEFAULT NULL,
  `enrollment_date` date NOT NULL,
  `status` enum('active','inactive','graduated','transferred') DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`student_id`, `first_name`, `last_name`, `date_of_birth`, `gender`, `class_id`, `enrollment_date`, `status`) VALUES
('STU-001', 'Precious', 'Asare', '2010-06-08', 'female', 1, '2024-12-08', 'active'),
('STU-002', 'Lydia', 'Adomako', '2011-06-08', 'female', 1, '2024-12-08', 'active'),
('STU-003', 'Gift', 'Quaye', '2005-02-10', 'male', 2, '2024-12-10', 'active'),
('STU-004', 'Jay', 'D', '2008-06-10', 'male', 2, '2024-12-10', 'active'),
('STU-005', 'William', 'Boateng', '2008-02-10', 'male', 2, '2024-12-10', 'active'),
('STU-006', 'Kelvin', 'Bosse', '2006-07-10', 'male', 2, '2024-12-10', 'active'),
('STU-007', 'Issah', 'Alhassan', '2008-02-10', 'male', 2, '2024-12-10', 'active'),
('STU-008', 'Hassan', 'Mohammed', '2008-06-10', 'male', 2, '2024-12-10', 'active'),
('STU-009', 'Helena', 'Kyei', '2009-06-10', 'male', 2, '2024-12-10', 'active'),
('STU-010', 'Emmanuel', 'Basakeng', '2007-06-10', 'male', 2, '2024-12-10', 'active'),
('STU-011', 'Emmanuel', 'Boateng', '2009-06-10', 'male', 2, '2024-12-10', 'active'),
('STU-012', 'Noble ', 'Ayine', '2012-02-10', 'male', 1, '2024-12-10', 'active'),
('STU-013', 'Ariana', 'Grande', '2011-02-10', 'female', 1, '2024-12-10', 'active'),
('STU-014', 'Senam', 'Abam', '2007-07-10', 'female', 1, '2024-12-10', 'active'),
('STU-015', 'Klenam', 'Kyei', '2010-02-10', 'female', 1, '2024-12-10', 'active'),
('STU-016', 'Eric', 'Tetteh', '2014-02-10', 'male', 1, '2024-12-10', 'active'),
('STU-017', 'Christiana ', 'Amerley', '2009-06-10', 'female', 1, '2024-12-10', 'active'),
('STU-020', 'Eric', 'Hatuglima', '2009-07-10', 'male', 3, '2024-12-10', 'active'),
('STU-021', 'Chris', 'Elisee', '2011-07-10', 'male', 3, '2024-12-10', 'active'),
('STU-022', 'Peniel', 'Prempeh', '2005-05-10', 'female', 3, '2024-12-10', 'active'),
('STU-023', 'Precious', 'Asante', '2006-06-10', 'female', 3, '2024-12-10', 'active'),
('STU-024', 'Austin', 'Iheji', '2010-07-10', 'male', 3, '2024-12-10', 'active'),
('STU-025', 'Emmanuel', 'Amponsah', '2010-02-15', 'male', 2, '2024-12-15', 'active'),
('STU-026', 'Enoch', 'Blay', '2013-07-10', 'male', 3, '2024-12-10', 'active'),
('STU-077', 'Trevon ', 'Newsome', '2014-02-10', 'male', 2, '2024-12-10', 'active'),
('STU-078', 'Madiba', 'Hudson', '2010-06-10', 'male', 2, '2024-12-10', 'active'),
('STU-079', 'KT', 'Hammond', '2006-06-15', 'male', 2, '2024-12-15', 'active'),
('STU-177', 'Puff', 'Daddy', '2006-06-10', 'male', 2, '2024-12-10', 'active'),
('STU-477', 'Nicky', 'Minach', '2008-06-10', 'female', 2, '2024-12-10', 'active'),
('STU-777', 'John ', 'Terence', '2011-02-15', 'male', 3, '2024-12-15', 'active'),
('STU-877', 'Salome', 'Kaluki', '2002-10-14', 'female', 1, '2024-12-14', 'active'),
('STU-899', 'Rage', 'Snow', '2011-06-10', 'male', 3, '2024-12-10', 'active'),
('STU-977', 'Gilgal', 'Owusu', '2009-10-16', 'male', 1, '2024-12-14', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `teachers`
--

CREATE TABLE `teachers` (
  `teacher_id` varchar(20) NOT NULL,
  `user_id` varchar(20) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `is_class_teacher` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teachers`
--

INSERT INTO `teachers` (`teacher_id`, `user_id`, `first_name`, `last_name`, `is_class_teacher`) VALUES
('TEACH-001', 'TEACH-001', 'Edward ', 'Mensah', 0),
('TEACH-002', 'TEACH-002', 'Godsway', 'Attakpah', 1),
('TEACH-003', 'TEACH-003', 'Patrick', 'Morgan', 1),
('TEACH-004', 'TEACH-004', 'Joseph', 'Akurugu', 1),
('TEACH-005', 'TEACH-005', 'Sean', 'Combs', 0);

-- --------------------------------------------------------

--
-- Table structure for table `teacher_courses`
--

CREATE TABLE `teacher_courses` (
  `teacher_id` varchar(20) NOT NULL,
  `course_code` varchar(10) NOT NULL,
  `academic_year` varchar(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teacher_courses`
--

INSERT INTO `teacher_courses` (`teacher_id`, `course_code`, `academic_year`) VALUES
('TEACH-001', 'mathJH', '2024-2025'),
('TEACH-001', 'scienceJH', '2024-2025'),
('TEACH-002', 'socialJH', '2024-2025'),
('TEACH-003', 'frenchJH', '2024-2025'),
('TEACH-004', 'englishJH', '2024-2025'),
('TEACH-005', 'computingJ', '2024-2025');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `user_id` varchar(20) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_type` enum('admin','teacher','parent') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `user_id`, `email`, `password`, `user_type`, `created_at`) VALUES
(3, 'ADMIN-246', 'e.c@josephus.edu.gh', '$2y$10$qUusj2c5kgS/gGNcGqFyruhtxXXm4CC3ZJZqSAVvBVANFaTyR/pT2', 'admin', '2024-12-07 18:08:40'),
(4, 'TEACH-001', 'edward.mensah@josephus.edu.gh', '$2y$10$MxeziJhltVuzrdThbepocOdASA9Io8YaienlRiGSgQ6rpO3GG0v.C', 'teacher', '2024-12-07 22:12:00'),
(5, 'TEACH-002', 'godsway.attakpah@josephus.edu.gh', '$2y$10$vGDRpydYQZoTA.aT2OrOVuE3g9o3xBHHu99LdOpd4RqPiYwUMCaZ.', 'teacher', '2024-12-07 23:10:58'),
(6, 'PRNT-001', 'ida.yeboah@gmail.com', '$2y$10$9/sVJ1TXP3OmuZpFAoyrH.crO1T9RYeHK9BWztWNAvUJzwFJu/jfG', 'parent', '2024-12-08 13:04:31'),
(7, 'PRNT-002', 'ernestina.amoako@gmail.com', '$2y$10$qA9G.X5CstpkMsYw0rB5jeEDgUKAtpsay9zCFKIzFAO.3hlybsgAy', 'parent', '2024-12-08 13:12:30'),
(8, 'TEACH-003', 'patrick.morgan@josephus.edu.gh', '$2y$10$fs/xBMY10X3uvDmJJto71eK5EIgCqIlNDXbDD6Ign9MkqxZFwtqry', 'teacher', '2024-12-10 00:13:04'),
(9, 'TEACH-004', 'joseph.akurugu@josephus.edu.gh', '$2y$10$kN9jCkPQJhNo7Y.sy6xAu..PmY5u9xWvrQMgqlcz1TOR6rBqsx5ZO', 'teacher', '2024-12-10 00:51:19'),
(11, 'TEACH-005', 'sean.combs@josephus.edu.gh', '$2y$10$t2NNhV6oJKmMCiIb4XDMS.vAfiI1DiIJ5QP4h/h.cN4DZRtC0h3py', 'teacher', '2024-12-14 23:13:29'),
(12, 'PRNT-567', 'miss.senam@gmail.com', '$2y$10$/zGLNwci6YT9TRLddxbo3uQcw2zdotECt4ctCZVT8a6H1m7yU4POa', 'parent', '2024-12-15 19:03:32'),
(13, 'PRNT-899', 'sean.combs@gmail.com', '$2y$10$HdY.jvj0taOdxETd02GM2.dvNG/NVUEo.JPf6KeemxX/eHVd.u01S', 'parent', '2024-12-15 19:28:12');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`attendance_id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `class_id` (`class_id`),
  ADD KEY `marked_by` (`marked_by`);

--
-- Indexes for table `classes`
--
ALTER TABLE `classes`
  ADD PRIMARY KEY (`class_id`),
  ADD KEY `class_teacher_id` (`class_teacher_id`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`course_code`);

--
-- Indexes for table `grades`
--
ALTER TABLE `grades`
  ADD PRIMARY KEY (`grade_id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `course_code` (`course_code`),
  ADD KEY `class_id` (`class_id`),
  ADD KEY `teacher_id` (`teacher_id`);

--
-- Indexes for table `parents`
--
ALTER TABLE `parents`
  ADD PRIMARY KEY (`parent_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `ward_id` (`ward_id`);

--
-- Indexes for table `remarks`
--
ALTER TABLE `remarks`
  ADD PRIMARY KEY (`remark_id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `teacher_id` (`teacher_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`student_id`),
  ADD KEY `class_id` (`class_id`);

--
-- Indexes for table `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`teacher_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `teacher_courses`
--
ALTER TABLE `teacher_courses`
  ADD PRIMARY KEY (`teacher_id`,`course_code`,`academic_year`),
  ADD KEY `course_code` (`course_code`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `classes`
--
ALTER TABLE `classes`
  MODIFY `class_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `grades`
--
ALTER TABLE `grades`
  MODIFY `grade_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=219;

--
-- AUTO_INCREMENT for table `remarks`
--
ALTER TABLE `remarks`
  MODIFY `remark_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admins`
--
ALTER TABLE `admins`
  ADD CONSTRAINT `admins_ibfk_1` FOREIGN KEY (`admin_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `attendance`
--
ALTER TABLE `attendance`
  ADD CONSTRAINT `attendance_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`student_id`),
  ADD CONSTRAINT `attendance_ibfk_2` FOREIGN KEY (`class_id`) REFERENCES `classes` (`class_id`),
  ADD CONSTRAINT `attendance_ibfk_3` FOREIGN KEY (`marked_by`) REFERENCES `teachers` (`teacher_id`);

--
-- Constraints for table `classes`
--
ALTER TABLE `classes`
  ADD CONSTRAINT `classes_ibfk_1` FOREIGN KEY (`class_teacher_id`) REFERENCES `teachers` (`teacher_id`);

--
-- Constraints for table `grades`
--
ALTER TABLE `grades`
  ADD CONSTRAINT `grades_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`student_id`),
  ADD CONSTRAINT `grades_ibfk_2` FOREIGN KEY (`course_code`) REFERENCES `courses` (`course_code`),
  ADD CONSTRAINT `grades_ibfk_3` FOREIGN KEY (`class_id`) REFERENCES `classes` (`class_id`),
  ADD CONSTRAINT `grades_ibfk_4` FOREIGN KEY (`teacher_id`) REFERENCES `teachers` (`teacher_id`);

--
-- Constraints for table `parents`
--
ALTER TABLE `parents`
  ADD CONSTRAINT `parents_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `parents_ibfk_2` FOREIGN KEY (`ward_id`) REFERENCES `students` (`student_id`);

--
-- Constraints for table `remarks`
--
ALTER TABLE `remarks`
  ADD CONSTRAINT `remarks_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`student_id`),
  ADD CONSTRAINT `remarks_ibfk_2` FOREIGN KEY (`teacher_id`) REFERENCES `teachers` (`teacher_id`);

--
-- Constraints for table `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `students_ibfk_1` FOREIGN KEY (`class_id`) REFERENCES `classes` (`class_id`);

--
-- Constraints for table `teachers`
--
ALTER TABLE `teachers`
  ADD CONSTRAINT `teachers_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `teacher_courses`
--
ALTER TABLE `teacher_courses`
  ADD CONSTRAINT `teacher_courses_ibfk_1` FOREIGN KEY (`teacher_id`) REFERENCES `teachers` (`teacher_id`),
  ADD CONSTRAINT `teacher_courses_ibfk_2` FOREIGN KEY (`course_code`) REFERENCES `courses` (`course_code`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
