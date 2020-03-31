-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 29, 2020 at 07:20 PM
-- Server version: 10.4.8-MariaDB
-- PHP Version: 7.3.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `discordportaldb`
--

-- --------------------------------------------------------

--
-- Table structure for table `commands`
--

CREATE TABLE `commands` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `article` text NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `commands`
--

INSERT INTO `commands` (`id`, `user_id`, `post_id`, `article`, `user_name`, `date`) VALUES
(77, 10, 49, 'adadaddasfsfsf', 'Ori Apple', '2020-03-27 05:41:47'),
(78, 10, 49, 'adadadadad', 'Ori Apple', '2020-03-27 05:41:47'),
(79, 10, 48, 'תגובה ראשונה', 'Ori Apple', '2020-03-27 05:41:47'),
(80, 1, 49, 'Hello webpage!', 'Avi Cohen', '2020-03-27 05:41:47'),
(81, 9, 49, 'Holalalala', 'ori', '2020-03-27 05:41:47'),
(82, 9, 48, 'Hello There!', 'Yaron Applebaum', '2020-03-27 05:46:50');

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `user_name` varchar(255) DEFAULT '''NULL''',
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `likes`
--

INSERT INTO `likes` (`id`, `user_id`, `post_id`, `user_name`, `date`) VALUES
(65, 10, 49, 'Ori Apple', '2020-03-22 01:05:11'),
(66, 10, 48, 'Ori Apple', '2020-03-26 18:12:06');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `article` text NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp(),
  `support` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `user_id`, `title`, `article`, `date`, `support`) VALUES
(1, 1, 'Avi first post', 'Text demo article for avi post bla bla.', '2020-02-19 19:05:26', 0),
(2, 3, 'Vered is the best', 'Vered is very best ever!', '2020-02-19 19:06:15', 0),
(5, 1, 'edit post demo', 'hazarti betshoova', '2020-02-23 18:33:34', 0),
(6, 3, 'Vered second post', 'i&#39;m the &#34;best&#34; ever!\r\nMy second line bla bla.', '2020-02-23 18:56:38', 0),
(7, 3, 'BLA BLA', 'i\'m the \"best\" ever!', '2020-02-23 18:59:58', 0),
(8, 3, 'gfdgdf', 'fdgdfg', '2020-02-26 18:02:43', 0),
(9, 7, 'Shimi first post', 'bla bla bla', '2020-03-01 18:50:02', 0),
(10, 1, 'fhfghfgh', 'gfhfghadad`2`2`2', '2020-03-01 20:48:36', 0),
(11, 8, 'adadad ad ad', 'ad ad ad', '2020-03-02 02:03:42', 0),
(13, 8, 'Hello blog', 'Hello, blog!', '2020-03-02 14:31:56', 0),
(14, 9, 'Test #1', 'Test #1', '2020-03-02 17:32:09', 0),
(19, 9, 'Test #2', 'Test #2', '2020-03-02 17:42:09', 0),
(23, 8, 'This is an support blog', 'HELLO SUPPORT', '2020-03-02 21:23:57', 1),
(26, 1, 'Hello can someone help me here?', 'idk how to edit my profile pfp window.open(\"google.com\")', '2020-03-03 01:12:52', 1),
(29, 10, 'ADADADADAAD', 'ADADADADAD', '2020-03-06 16:45:52', 0),
(43, 8, '1212121212', '1212121212', '2020-03-16 20:42:17', 1),
(46, 8, 'adad', 'adadad', '2020-03-16 21:36:52', 0),
(48, 17, 'שלום', 'אני חדשה כאן', '2020-03-17 19:53:05', 0),
(49, 19, 'Hey Hey', 'HeyHeyHey', '2020-03-20 20:59:37', 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `ip` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `description`, `ip`) VALUES
(1, 'Avi Cohen', 'avi@gmail.com', '$2y$10$zb2/cLtJXE.hkOPKN1OncOrhi0BIPZnAYilprMqn1LYwW/30A2A2e', 'Hello World', ''),
(2, 'Moshe Levi', 'mosh@gmail.com', '$2y$10$zb2/cLtJXE.hkOPKN1OncOrhi0BIPZnAYilprMqn1LYwW/30A2A2e', 'This user prefers to keep their biography a mystery. ?', '0'),
(3, 'Vered Bitun', 'vered@gmail.com', '$2y$10$zb2/cLtJXE.hkOPKN1OncOrhi0BIPZnAYilprMqn1LYwW/30A2A2e', 'This user prefers to keep their biography a mystery. ', '0'),
(4, 'popeye', 'popeye@gmail.com', '$2y$10$P7dKzrPeYFsaUFiq6EWmPuuCyebuA5M9tpe3uUfUTmOH7sSs49JI6', 'This user prefers to keep their biography a mystery. ', '0'),
(5, 'Haim', 'haim@gmail.com', '$2y$10$yFWSoaNeW/G1E01XfJYm1.DdziAnYV0F9gxjl8XM.fVZq/g6srhX.', 'This user prefers to keep their biography a mystery. ?', '0'),
(7, 'ShimiL', 'shimi@gmail.com', '$2y$10$cgMiEqDaxXmgdbV6wXK7C.W2hxaFSD2hXQxZ2AZ/AMq66jHF.vrcK', 'So, fuck you dude', '0'),
(8, 'Ori Applebaum', 'admin@gmail.com', '$2y$10$qDxk3xI6BV.vjbWI/74TUOZVP2JzA./1No9yF2Jyqsa4Jjeh4ueee', '\"OR\"1\"#;', '1'),
(9, 'Yaron Applebaum', 'plbwymw@gmail.com', '$2y$10$cdmE6BsEP.fYpPyYunRaI.H/wCH2pMdvGUpHdxEGSDbzcoksskj62', 'This user prefers to keep their biography a mystery.', ''),
(10, 'Ori Apple', 'ori@gmail.com', '$2y$10$wDZoVPcHNutxvgjW4Lz03efSDFrxYhSH1XHB6bIsK/vA4Sh2d6bvS', 'This user prefers to keep their biography a mystery.', ''),
(17, 'נועה גייזלר', 'noa@gmail.com', '$2y$10$LaF2o5NJlcs2I5w8QNgbp.0tEbZdSbFVyFOCsUKyFigmheAo/jM72', 'This user prefers to keep their biography a mystery.', ''),
(19, 'Asi Test', 'asas@gmail.com', '$2y$10$QO87wZAJzDF3QNrqGTQe7.RGkt53lfxoIbHISx4qO86sZVVzUr9VS', '<script>console.log(\"asad\")</script>', '');

-- --------------------------------------------------------

--
-- Table structure for table `users_profile`
--

CREATE TABLE `users_profile` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `image_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users_profile`
--

INSERT INTO `users_profile` (`id`, `user_id`, `image_name`) VALUES
(1, 4, 'default_profile.png'),
(2, 1, 'default_profile.png'),
(3, 2, 'default_profile.png'),
(4, 3, 'default_profile.png'),
(5, 5, 'default_profile.png'),
(7, 7, '2020.03.01.17.48.53-shimi.png'),
(8, 8, '2020.03.02.01.02.12-Staff.png'),
(9, 9, '2020.03.02.15.54.25-R C N.gif'),
(10, 10, 'default_profile.png'),
(17, 17, '2020.03.17.18.52.48-R C N - Copy.gif'),
(19, 19, 'default_profile.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `commands`
--
ALTER TABLE `commands`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`) USING BTREE,
  ADD KEY `post_id` (`post_id`) USING BTREE;

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `users_profile`
--
ALTER TABLE `users_profile`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `commands`
--
ALTER TABLE `commands`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `users_profile`
--
ALTER TABLE `users_profile`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `users_profile`
--
ALTER TABLE `users_profile`
  ADD CONSTRAINT `users_profile_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
