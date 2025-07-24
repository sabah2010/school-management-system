-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Oct 31, 2024 at 08:18 PM
-- Server version: 8.3.0
-- PHP Version: 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `school_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `grades`
--

DROP TABLE IF EXISTS `grades`;
CREATE TABLE IF NOT EXISTS `grades` (
  `id` int NOT NULL AUTO_INCREMENT,
  `student_id` int DEFAULT NULL,
  `subject` varchar(100) DEFAULT NULL,
  `max_grade` int DEFAULT NULL,
  `student_grade` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `student_id` (`student_id`)
) ENGINE=MyISAM AUTO_INCREMENT=63 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `grades`
--

INSERT INTO `grades` (`id`, `student_id`, `subject`, `max_grade`, `student_grade`) VALUES
(5, 32, 'Arabic', 20, 20),
(6, 30, 'Math', 20, 18),
(7, 32, 'Math', 20, 13),
(39, 33, 'Arabic', 101, 0),
(9, 30, 'Arabic', 100, 99),
(10, 30, 'Science', 100, 100),
(11, 30, 'Social', 100, 100),
(12, 23, 'Science', 100, 88),
(13, NULL, 'Computer', NULL, NULL),
(14, 27, 'Computer', 100, 100),
(15, NULL, 'Arabic', NULL, NULL),
(16, NULL, 'Math', NULL, NULL),
(17, 27, 'Arabic', 100, 99),
(18, 25, 'Science', 100, 66),
(19, 24, 'Math', 100, 77),
(20, 18, 'Science', 100, 100),
(21, 20, 'Math', 100, 85),
(22, 16, 'Math', 100, 45),
(23, 15, 'Science', 100, 0),
(24, 26, 'Social', 100, 0),
(25, 27, 'English', 100, 0),
(26, 26, 'English', 100, 0),
(27, 27, 'Science', 100, 0),
(28, 26, 'Science', 99, 0),
(29, 27, 'Social', 99, 100),
(30, 22, 'Science', 100, 99),
(31, 15, 'Arabic', 100, 99),
(32, 20, 'Arabic', 100, 88),
(33, 14, 'Science', 100, 99),
(34, 28, 'Arabic', 100, 88),
(35, 24, 'Science', 100, 0),
(36, 24, 'Science', 100, 89),
(38, 30, 'Arabic', 100, 80),
(40, 33, 'Math', 100, 0),
(41, 1, 'Arabic', 100, 15),
(42, 1, 'Math', 100, 10),
(43, 20, 'Computer', 100, 0),
(44, 26, 'Arabic', 100, 0),
(45, 25, 'Computer', 100, 88),
(46, 29, 'Computer', 100, 88),
(47, 14, 'Arabic', 100, 99),
(48, 25, 'Social', 100, 89),
(49, 17, 'Science', 100, 95),
(50, 17, 'Arabic', 100, 100),
(51, 22, 'Computer', 100, 99),
(52, 36, 'Arabic', 100, 98),
(53, 36, 'Math', 100, 99),
(54, 36, 'Social', 100, 97),
(55, 35, 'Arabic', 100, 98),
(56, 35, 'Science', 100, 77),
(57, 35, 'Computer', 100, 88),
(58, 36, 'Computer', 100, 75),
(59, 18, 'English', 100, 100),
(60, 36, 'English', 100, 89),
(61, 37, 'Arabic', 100, 88),
(62, 37, 'Math', 100, 98);

-- --------------------------------------------------------

--
-- Table structure for table `studentdata`
--

DROP TABLE IF EXISTS `studentdata`;
CREATE TABLE IF NOT EXISTS `studentdata` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `date_of_birth` date NOT NULL,
  `gender` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `city` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=38 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `studentdata`
--

INSERT INTO `studentdata` (`id`, `name`, `date_of_birth`, `gender`, `city`) VALUES
(1, 'sabah', '1999-11-01', 'Female', 'Riyadh'),
(15, 'baraah', '2018-04-02', 'Female', 'Riyadh'),
(14, 'yaman', '2018-04-14', 'Male', 'Dammam'),
(10, 'rolan', '2000-03-05', 'Female', 'Makkah'),
(11, 'juman', '1888-12-31', 'Female', 'Riyadh'),
(16, 'ahmed shaban', '2018-09-27', 'Male', 'Riyadh'),
(17, 'Eyman', '2018-01-01', 'Female', 'Makkah'),
(18, 'omar', '2018-02-10', 'Male', 'Dammam'),
(35, 'jana', '2018-10-10', 'Female', 'Dammam'),
(20, 'muhannad', '2018-05-03', 'Male', 'Riyadh'),
(21, 'Alaa', '2018-04-04', 'Male', 'Makkah'),
(22, 'mona', '2018-02-01', 'Female', 'Makkah'),
(23, 'wedd', '2018-05-04', 'Female', 'Riyadh'),
(24, 'doaa', '2018-03-10', 'Female', 'Riyadh'),
(25, 'zaina', '2018-07-03', 'Female', 'Dammam'),
(26, 'hala', '2018-04-11', 'Female', 'Riyadh'),
(27, 'jihad ', '2018-02-03', 'Male', 'Makkah'),
(28, 'walaa', '2018-04-12', 'Male', 'Riyadh'),
(29, 'mawadah', '2018-02-02', 'Female', 'Makkah'),
(30, 'moamen', '2018-04-03', 'Male', 'Makkah'),
(37, 'Maher', '2018-10-11', 'Male', 'Riyadh'),
(36, 'molhem ', '2018-10-10', 'Male', 'Makkah');

--
-- Triggers `studentdata`
--
DROP TRIGGER IF EXISTS `prevent_student_deletion`;
DELIMITER $$
CREATE TRIGGER `prevent_student_deletion` BEFORE DELETE ON `studentdata` FOR EACH ROW BEGIN
    DECLARE grade_count INT;

    -- تحقق من عدد الدرجات المرتبطة بالطالب
    SELECT COUNT(*) INTO grade_count 
    FROM grades 
    WHERE student_id = OLD.id;

    -- إذا كان لديه درجات، امنع الحذف
    IF grade_count > 0 THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'لا يمكن حذف الطالب، لأنه يحتوي على درجات مسجلة.';
    END IF;
END
$$
DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
