-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 16, 2025 at 01:05 PM
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
-- Database: `oesm`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `email` varchar(50) NOT NULL,
  `password` varchar(500) NOT NULL,
  `gender` varchar(50) NOT NULL,
  `college` varchar(255) NOT NULL,
  `photo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`email`, `password`, `gender`, `college`, `photo`) VALUES
('sunnygkp10@gmail.com', '123456', '', '', ''),
('d@d.com', 'asd', 'a', 'asd', '');

-- --------------------------------------------------------

--
-- Table structure for table `answer`
--

CREATE TABLE `answer` (
  `qid` text NOT NULL,
  `ansid` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `answer`
--

INSERT INTO `answer` (`qid`, `ansid`) VALUES
('55892169bf6a7', '55892169d2efc'),
('5589216a3646e', '5589216a48722'),
('558922117fcef', '5589221195248'),
('55892211e44d5', '55892211f1fa7'),
('558922894c453', '558922895ea0a'),
('558922899ccaa', '55892289aa7cf'),
('558923538f48d', '558923539a46c'),
('55892353f05c4', '55892354051be'),
('607336aa8c987', '607336aa961b5'),
('607336aacedd1', '607336aadc68e'),
('607336ab244aa', '607336ab31664');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `id` text NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `subject` varchar(500) NOT NULL,
  `feedback` varchar(500) NOT NULL,
  `date` date NOT NULL,
  `time` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`id`, `name`, `email`, `subject`, `feedback`, `date`, `time`) VALUES
('60730932a3d1b', 'Demo Test', 'test@feedback.com', 'Testing Feedbacks', 'This is a demo text for testing purpose', '2021-04-11', '04:35:30pm'),
('607309ab640d8', 'Chris', 'chris@gmail.com', 'Regard System', 'this is a demo text!', '2021-04-11', '04:37:31pm'),
('60730a627e21f', 'Oliver', 'oliver@gmail.com', 'Bug', 'demo demo', '2021-04-11', '04:40:34pm');

-- --------------------------------------------------------

--
-- Table structure for table `history`
--

CREATE TABLE `history` (
  `email` varchar(50) NOT NULL,
  `eid` text NOT NULL,
  `score` int(11) NOT NULL,
  `level` int(11) NOT NULL,
  `sahi` int(11) NOT NULL,
  `wrong` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `history`
--

INSERT INTO `history` (`email`, `eid`, `score`, `level`, `sahi`, `wrong`, `date`) VALUES
('sunnygkp10@gmail.com', '558921841f1ec', 4, 2, 2, 0, '2015-06-23 09:31:26'),
('sunnygkp10@gmail.com', '558920ff906b8', 4, 2, 2, 0, '2015-06-23 13:32:09'),
('avantika420@gmail.com', '558921841f1ec', 4, 2, 2, 0, '2015-06-23 14:33:04'),
('avantika420@gmail.com', '5589222f16b93', 4, 2, 2, 0, '2015-06-23 14:49:39'),
('mi5@hollywood.com', '5589222f16b93', 4, 2, 2, 0, '2015-06-23 15:12:56'),
('nik1@gmail.com', '558921841f1ec', 1, 2, 1, 1, '2015-06-23 16:11:50'),
('clancy@gmail.com', '5589222f16b93', 4, 2, 2, 0, '2021-04-11 13:24:37'),
('sunnygkp10@gmail.com', '5589222f16b93', 4, 2, 2, 0, '2021-04-11 16:27:21'),
('doe@gmail.com', '558921841f1ec', 4, 2, 2, 0, '2021-04-11 17:20:17'),
('james@gmail.com', '558921841f1ec', 4, 2, 2, 0, '2021-04-11 17:26:12'),
('james@gmail.com', '5589222f16b93', 4, 2, 2, 0, '2021-04-11 17:26:54'),
('steeve@gmail.com', '558921841f1ec', 4, 2, 2, 0, '2021-04-11 17:44:46'),
('steeve@gmail.com', '5589222f16b93', 4, 2, 2, 0, '2021-04-11 17:45:20'),
('steeve@gmail.com', '6073360884420', 6, 3, 3, 0, '2021-04-11 17:50:15'),
('kianr664@gmail.com', '558922ec03021', -2, 2, 0, 2, '2025-04-16 09:44:25'),
('kianr664@gmail.com', '558922ec03021', -2, 2, 0, 2, '2025-04-16 09:44:25'),
('kianr664@gmail.com', '6073360884420', 0, 3, 2, 2, '2025-04-16 10:50:06'),
('kianr664@gmail.com', '6073360884420', 0, 3, 2, 2, '2025-04-16 10:50:06');

-- --------------------------------------------------------

--
-- Table structure for table `options`
--

CREATE TABLE `options` (
  `qid` varchar(50) NOT NULL,
  `option` varchar(5000) NOT NULL,
  `optionid` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `options`
--

INSERT INTO `options` (`qid`, `option`, `optionid`) VALUES
('55892169bf6a7', 'usermod', '55892169d2efc'),
('55892169bf6a7', 'useradd', '55892169d2f05'),
('55892169bf6a7', 'useralter', '55892169d2f09'),
('55892169bf6a7', 'groupmod', '55892169d2f0c'),
('5589216a3646e', '751', '5589216a48713'),
('5589216a3646e', '752', '5589216a4871a'),
('5589216a3646e', '754', '5589216a4871f'),
('5589216a3646e', '755', '5589216a48722'),
('558922117fcef', 'echo', '5589221195248'),
('558922117fcef', 'print', '558922119525a'),
('558922117fcef', 'printf', '5589221195265'),
('558922117fcef', 'cout', '5589221195270'),
('55892211e44d5', 'int a', '55892211f1f97'),
('55892211e44d5', '$a', '55892211f1fa7'),
('55892211e44d5', 'long int a', '55892211f1fb4'),
('55892211e44d5', 'int a$', '55892211f1fbd'),
('558922894c453', 'cin>>a;', '558922895ea0a'),
('558922894c453', 'cin<<a;', '558922895ea26'),
('558922894c453', 'cout>>a;', '558922895ea34'),
('558922894c453', 'cout<a;', '558922895ea41'),
('558922899ccaa', 'cout', '55892289aa7cf'),
('558922899ccaa', 'cin', '55892289aa7df'),
('558922899ccaa', 'print', '55892289aa7eb'),
('558922899ccaa', 'printf', '55892289aa7f5'),
('558923538f48d', '255.0.0.0', '558923539a46c'),
('558923538f48d', '255.255.255.0', '558923539a480'),
('558923538f48d', '255.255.0.0', '558923539a48b'),
('558923538f48d', 'none of these', '558923539a495'),
('55892353f05c4', '192.168.1.100', '5589235405192'),
('55892353f05c4', '172.168.16.2', '55892354051a3'),
('55892353f05c4', '10.0.0.0.1', '55892354051b4'),
('55892353f05c4', '11.11.11.11', '55892354051be'),
('607336aa8c987', 'module.expose', '607336aa961a7'),
('607336aa8c987', 'module', '607336aa961b1'),
('607336aa8c987', 'module.exports', '607336aa961b5'),
('607336aa8c987', 'all', '607336aa961b9'),
('607336aacedd1', 'nodejs codeastro.js', '607336aadc686'),
('607336aacedd1', 'node codeastro.js', '607336aadc68e'),
('607336aacedd1', 'codeastro.js', '607336aadc691'),
('607336aacedd1', 'none', '607336aadc694'),
('607336ab244aa', 'npm --version', '607336ab31664'),
('607336ab244aa', 'npm --ver', '607336ab31670'),
('607336ab244aa', 'npm help', '607336ab31672'),
('607336ab244aa', 'none', '607336ab31673');

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `eid` text NOT NULL,
  `qid` text NOT NULL,
  `qns` text NOT NULL,
  `choice` int(10) NOT NULL,
  `sn` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`eid`, `qid`, `qns`, `choice`, `sn`) VALUES
('558920ff906b8', '55892169bf6a7', 'what is command for changing user information??', 4, 1),
('558920ff906b8', '5589216a3646e', 'what is permission for view only for other??', 4, 2),
('558921841f1ec', '558922117fcef', 'what is command for print in php??', 4, 1),
('558921841f1ec', '55892211e44d5', 'which is a variable of php??', 4, 2),
('5589222f16b93', '558922894c453', 'what is correct statement in c++??', 4, 1),
('5589222f16b93', '558922899ccaa', 'which command is use for print the output in c++?', 4, 2),
('558922ec03021', '558923538f48d', 'what is correct mask for A class IP???', 4, 1),
('558922ec03021', '55892353f05c4', 'which is not a private IP??', 4, 2),
('6073360884420', '607336aa8c987', 'The node.js modules can be exposed using', 4, 1),
('6073360884420', '607336aacedd1', 'Which statement executes the code of codeastro.js file?', 4, 2),
('6073360884420', '607336ab244aa', 'How can we check the current version of NPM?', 4, 3);

-- --------------------------------------------------------

--
-- Table structure for table `quiz`
--

CREATE TABLE `quiz` (
  `eid` text NOT NULL,
  `title` varchar(100) NOT NULL,
  `sahi` int(11) NOT NULL,
  `wrong` int(11) NOT NULL,
  `total` int(11) NOT NULL,
  `time` bigint(20) NOT NULL,
  `intro` text NOT NULL,
  `tag` varchar(100) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `quiz`
--

INSERT INTO `quiz` (`eid`, `title`, `sahi`, `wrong`, `total`, `time`, `intro`, `tag`, `date`) VALUES
('558920ff906b8', 'Linux : File Managment', 2, 1, 2, 5, '', 'linux', '2015-06-23 09:03:59'),
('558921841f1ec', 'Php Coding', 2, 1, 2, 5, '', 'PHP', '2015-06-23 09:06:12'),
('5589222f16b93', 'C++ Coding', 2, 1, 2, 5, '', 'c++', '2015-06-23 09:09:03'),
('558922ec03021', 'Networking', 2, 1, 2, 5, '', 'networking', '2015-06-23 09:12:12'),
('6073360884420', 'Nodejs Term', 2, 2, 3, 2, 'Basic test for nodejs terms', 'nodejs', '2021-04-11 17:46:48');

-- --------------------------------------------------------

--
-- Table structure for table `rank`
--

CREATE TABLE `rank` (
  `email` varchar(50) NOT NULL,
  `score` int(11) NOT NULL,
  `time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `rank`
--

INSERT INTO `rank` (`email`, `score`, `time`) VALUES
('sunnygkp10@gmail.com', 5, '2021-04-11 16:27:17'),
('avantika420@gmail.com', 8, '2015-06-23 14:49:39'),
('mi5@hollywood.com', 4, '2015-06-23 15:12:56'),
('nik1@gmail.com', 1, '2015-06-23 16:11:50'),
('doe@gmail.com', 4, '2021-04-11 17:20:17'),
('clancy@gmail.com', 4, '2021-04-11 13:24:37'),
('james@gmail.com', 14, '2021-04-11 17:32:53'),
('steeve@gmail.com', 14, '2021-04-11 17:50:15'),
('kianr664@gmail.com', -4, '2025-04-16 10:50:06');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `name` varchar(50) NOT NULL,
  `gender` varchar(5) NOT NULL,
  `college` varchar(100) NOT NULL,
  `email` varchar(50) NOT NULL,
  `mob` bigint(20) NOT NULL,
  `password` varchar(50) NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1 = Enabled, 0 = Disabled'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`name`, `gender`, `college`, `email`, `mob`, `password`, `photo`, `status`) VALUES
('Asley', 'F', 'Wh Coast College', 'ashley@gmail.com', 3014797869, 'e10adc3949ba59abbe56e057f20f883e', NULL, 1),
('Tom Clancy', 'M', 'Wh Coast College', 'clancy@gmail.com', 1485554569, '5f4dcc3b5aa765d61d8327deb882cf99', NULL, 1),
('John Doe', 'M', 'Demo College', 'doe@gmail.com', 1245788880, '5f4dcc3b5aa765d61d8327deb882cf99', NULL, 1),
('Freda Mack\n', 'F', 'Wh Coast College', 'freda@gmail.com', 2150488880, 'e10adc3949ba59abbe56e057f20f883e', NULL, 1),
('James Rhoades', 'M', 'Westham College', 'james@gmail.com', 245778540, '5f4dcc3b5aa765d61d8327deb882cf99', NULL, 1),
('Johnny', 'M', 'Greenville College', 'johnnys@gmail.com', 3780145870, 'e10adc3949ba59abbe56e057f20f883e', NULL, 1),
('Rhea M. Melchor.', 'M', 'fewfe', 'jruby13111@gmail.com', 7464, '$2y$10$xzQ/Oui0g4/Vw6lob.Qbm.6gbkcuro4vfm3blZki3TR', 'uploads/user_67fd8c77270f7.png', 1),
('Rhea M. Melchor.', 'F', 'fewfe', 'jruby13111@gmail.wom', 7464, '$2y$10$koVfG9mkxHKL3pqqZqAhZeR2a9XQE6yDd6q82OtXC..', 'uploads/user_67fd8e96e2ba2.png', 1),
('Rhea M. Melchor.', 'M', 'fewfe', 'jruby1311@gmail.com', 7464, '$2y$10$m19FU/EZ7VhLqOchEmkjAuD9Un9UrCow/9mzPCM5Bz7', 'uploads/user_67fceafbed4c5.png', 1),
('Rhea M. Melchor.', 'M', 'fewfe', 'jruby131@gmail.com', 7464, '$2y$10$svc8n3Hj05vbvpxYzA.eFuZaqwNrlTy//c.2mT6MdoU', 'uploads/user_67fce8e5b4ade5.41049439.jpg', 1),
('Rodriguez, Kian A.', 'M', '3-1', 'kianr664@gmail.com', 3423242, '1edd4a1fe5695e7d4bdfd47c13318201', NULL, 0),
('Liam', 'M', 'Liberty College', 'liam@gmail.com', 1753150015, 'e10adc3949ba59abbe56e057f20f883e', NULL, 1),
('Steeve Moore', 'M', 'Westview College', 'steeve@gmail.com', 2146975696, '5f4dcc3b5aa765d61d8327deb882cf99', NULL, 1),
('William', 'M', 'Riverview College', 'will@gmail.com', 3478540365, 'e10adc3949ba59abbe56e057f20f883e', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `warning`
--

CREATE TABLE `warning` (
  `id` int(11) NOT NULL,
  `timestamp` datetime NOT NULL,
  `email` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `warning`
--

INSERT INTO `warning` (`id`, `timestamp`, `email`) VALUES
(4, '2025-04-16 12:38:15', 'kianr664@gmail.com'),
(5, '2025-04-16 12:38:33', 'kianr664@gmail.com'),
(6, '2025-04-16 12:46:27', 'kianr664@gmail.com'),
(7, '2025-04-16 12:47:56', 'kianr664@gmail.com'),
(8, '2025-04-16 12:48:04', 'kianr664@gmail.com'),
(9, '2025-04-16 12:49:30', 'kianr664@gmail.com'),
(10, '2025-04-16 12:49:47', 'kianr664@gmail.com'),
(11, '2025-04-16 12:49:50', 'kianr664@gmail.com'),
(12, '2025-04-16 13:04:42', 'kianr664@gmail.com'),
(13, '2025-04-16 13:04:46', 'kianr664@gmail.com');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `warning`
--
ALTER TABLE `warning`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `warning`
--
ALTER TABLE `warning`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
