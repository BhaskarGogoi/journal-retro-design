-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jun 25, 2024 at 03:44 PM
-- Server version: 8.0.31
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `journal`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
CREATE TABLE IF NOT EXISTS `admin` (
  `id` int NOT NULL AUTO_INCREMENT,
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` bigint NOT NULL,
  `password` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `firstname`, `lastname`, `email`, `phone`, `password`) VALUES
(2, 'Admin', 'Admin', 'admin@admin.com', 1234567890, '$2y$10$jFzGVGVtssVhqnI8U/uIEe4FB5yNMN9j4D4Em4LB8Fhh2.LNvVMPi'),
(5, 'Bhaskarjyoti', 'Gogoi', 'bgogoi.mail@gmail.com', 7002072619, '$2y$10$ZkvcfMGrw58I8HRiFXgKzO.L3UhJS8VB5fabeC.zyQMtbjG2SZXpq');

-- --------------------------------------------------------

--
-- Table structure for table `articles`
--

DROP TABLE IF EXISTS `articles`;
CREATE TABLE IF NOT EXISTS `articles` (
  `article_id` int NOT NULL AUTO_INCREMENT,
  `journal_id` int NOT NULL,
  `title` varchar(500) NOT NULL,
  `author` varchar(200) NOT NULL,
  `filename` varchar(500) NOT NULL,
  `unique_visitors` int NOT NULL,
  PRIMARY KEY (`article_id`)
) ENGINE=InnoDB AUTO_INCREMENT=240 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `articles`
--

INSERT INTO `articles` (`article_id`, `journal_id`, `title`, `author`, `filename`, `unique_visitors`) VALUES
(208, 1, 'All Articles', 'Department of History, DU', '13052022090518.pdf', 1),
(209, 2, 'All Articles', 'Department of History, DU', '13052022090825.pdf', 2),
(210, 5, 'All Articles', 'Department of History, DU', '13052022091115.pdf', 0),
(211, 6, 'All Articles', 'Department of History, DU', '13052022091212.pdf', 0),
(212, 7, 'All Articles', 'Department of History, DU', '13052022091258.pdf', 1),
(213, 8, 'All Articles', 'Department of History, DU', '13052022091444.pdf', 1),
(227, 9, 'dfsd', 'ertert', '06022024043219.pdf', 1),
(228, 9, 'Article 3', 'ertert', '06022024043401.pdf', 1),
(229, 9, 'dfgdfh', 'dsfgfdgfdg', '07022024062859.pdf', 1),
(230, 9, 'dsgfdgs', 'asdsad', '09022024061712.pdf', 1),
(231, 9, 'asdsad', 'sadsad', '09022024061719.pdf', 1),
(232, 9, 'ryu654u3', 'rgheth', '09022024061727.pdf', 1),
(233, 9, 'sss', 'sss', 'C:/wamp64/www/journal-management-system/Archive/12022024065547.pdf', 0),
(234, 9, 'sadsammmmm', 'sadsad', '12022024065613.pdf', 1),
(235, 9, 'sdfsfgsdgINTERNET MEMES AS CATALYSTS FOR POLITICAL ACTIVISM IN CHINA ACTIVISM IN CHINA ACTIVISM IN CHINA', 'fdgdfgdf', '11062024072736.pdf', 1),
(236, 9, 'THE STRATEGIC SIGNIFICANCE OF THE INDIAN OCEAN FOR INDIA\\\'S SECURITY IN THE 21ST CENTURY: AN OVERVIEW', 'tryrtytr', '14062024071728.pdf', 1),
(237, 9, 'dgfhrjtkCHANGING LANDSCAPE AND GENDER DYNAMICS IN THE NORTH EAST', 'reytjyyrt', '14062024071734.pdf', 1),
(238, 9, 'dghdfgdf', 'dfgfdgfdg', '18062024065443.pdf', 0),
(239, 9, 'sadsad', 'sadsad', '18062024065535.pdf', 0);

-- --------------------------------------------------------

--
-- Table structure for table `contact_msg`
--

DROP TABLE IF EXISTS `contact_msg`;
CREATE TABLE IF NOT EXISTS `contact_msg` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `message` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `contact_msg`
--

INSERT INTO `contact_msg` (`id`, `name`, `email`, `message`, `date`) VALUES
(1, 'sadsda', 'saddsfds@jvnjv.com', 'sadasdsad', '2022-05-12 18:21:19'),
(2, 'People', 'thebhaskargogoi@gmail.com', 'sdhsaif dfhuidshf sdfhuidsfh sdf', '2022-05-12 18:31:16');

-- --------------------------------------------------------

--
-- Table structure for table `journals`
--

DROP TABLE IF EXISTS `journals`;
CREATE TABLE IF NOT EXISTS `journals` (
  `journal_id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(500) NOT NULL,
  `filename` text,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `published_date` varchar(10) DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'Not Published',
  PRIMARY KEY (`journal_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `journals`
--

INSERT INTO `journals` (`journal_id`, `title`, `filename`, `date`, `published_date`, `status`) VALUES
(1, 'Vol 1', NULL, '2022-04-29 14:29:05', '13-05-2022', 'Published'),
(2, 'Vol 4', NULL, '2022-04-29 14:40:04', '13-05-2022', 'Published'),
(5, 'Vol 5', NULL, '2022-05-10 19:50:56', '13-05-2022', 'Published'),
(6, 'Vol 7', NULL, '2022-05-13 07:11:48', '13-05-2022', 'Published'),
(7, 'Vol 8', NULL, '2022-05-13 07:12:38', '13-05-2022', 'Published'),
(8, 'Vol 9', NULL, '2022-05-13 07:14:13', '13-05-2022', 'Published'),
(9, 'Vol 11', '18062024065427.pdf', '2022-05-13 07:14:59', '18-06-2024', 'Published');

-- --------------------------------------------------------

--
-- Table structure for table `visitor_count`
--

DROP TABLE IF EXISTS `visitor_count`;
CREATE TABLE IF NOT EXISTS `visitor_count` (
  `visitor_id` int NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(20) NOT NULL,
  `article_id` int NOT NULL,
  PRIMARY KEY (`visitor_id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `visitor_count`
--

INSERT INTO `visitor_count` (`visitor_id`, `ip_address`, `article_id`) VALUES
(1, '0', 192),
(2, '0', 10),
(3, '0', 16),
(4, '0', 15),
(5, '0', 208),
(6, '0', 209),
(7, '0', 222),
(8, '0', 223),
(9, '0', 217),
(10, '0', 214),
(11, '1270', 214),
(12, '0', 212),
(13, '::1', 214),
(14, '::1', 213),
(15, '::1', 227),
(16, '::1', 228),
(17, '::1', 229),
(18, '::1', 232),
(19, '::1', 234),
(20, '::1', 209),
(21, '::1', 237),
(22, '::1', 236),
(23, '::1', 235),
(24, '::1', 231),
(25, '::1', 230);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
