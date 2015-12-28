-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 28, 2015 at 06:28 AM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `wartracker`
--

-- --------------------------------------------------------

--
-- Table structure for table `attack`
--

CREATE TABLE IF NOT EXISTS `attack` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `war_id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `member_id` (`member_id`),
  KEY `war_id` (`war_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `clan`
--

CREATE TABLE IF NOT EXISTS `clan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `clan_name` varchar(25) COLLATE utf8_unicode_ci DEFAULT NULL,
  `clan_tag` varchar(25) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;

--
-- Dumping data for table `clan`
--

INSERT INTO `clan` (`id`, `user_id`, `clan_name`, `clan_tag`) VALUES
(5, 19, 'gay', 'gay');

-- --------------------------------------------------------

--
-- Table structure for table `member`
--

CREATE TABLE IF NOT EXISTS `member` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `clan_id` int(11) NOT NULL,
  `name` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`),
  KEY `clan_id` (`clan_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=9 ;

--
-- Dumping data for table `member`
--

INSERT INTO `member` (`id`, `clan_id`, `name`) VALUES
(1, 5, 'asd'),
(2, 5, 'a'),
(3, 5, 'w'),
(4, 5, 'q'),
(5, 5, 'aa'),
(6, 5, 'aaa'),
(7, 5, 'khjasdkhjakahjsd'),
(8, 5, 'aaaaaaa');

-- --------------------------------------------------------

--
-- Table structure for table `roster`
--

CREATE TABLE IF NOT EXISTS `roster` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `war_id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `war_id` (`war_id`),
  KEY `member_id` (`member_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` char(64) COLLATE utf8_unicode_ci NOT NULL,
  `salt` char(16) COLLATE utf8_unicode_ci NOT NULL,
  `privilege` varchar(25) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'user',
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=20 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `salt`, `privilege`, `email`) VALUES
(19, 'keiwo', 'd9851e7ad31ea0a63c9edd48a9566802c97d733266a2957065f2fdd611271120', '4a83e25a1588667a', 'user', 'i_like_something@hotmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `war`
--

CREATE TABLE IF NOT EXISTS `war` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `clan_id` int(11) NOT NULL,
  `enemy_clan` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `size` int(5) NOT NULL,
  `comments` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `clan_id` (`clan_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `war`
--

INSERT INTO `war` (`id`, `clan_id`, `enemy_clan`, `size`, `comments`) VALUES
(1, 5, 'clan one', 10, 'what'),
(2, 5, 'clan 2', 1, '1'),
(3, 5, 'clan 3', 2, '2');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attack`
--
ALTER TABLE `attack`
  ADD CONSTRAINT `member_fk2` FOREIGN KEY (`member_id`) REFERENCES `member` (`id`),
  ADD CONSTRAINT `war_fk2` FOREIGN KEY (`war_id`) REFERENCES `war` (`id`);

--
-- Constraints for table `clan`
--
ALTER TABLE `clan`
  ADD CONSTRAINT `user_fk1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `member`
--
ALTER TABLE `member`
  ADD CONSTRAINT `clan_fk1` FOREIGN KEY (`clan_id`) REFERENCES `clan` (`id`);

--
-- Constraints for table `roster`
--
ALTER TABLE `roster`
  ADD CONSTRAINT `member_fk1` FOREIGN KEY (`member_id`) REFERENCES `member` (`id`),
  ADD CONSTRAINT `war_fk1` FOREIGN KEY (`war_id`) REFERENCES `war` (`id`);

--
-- Constraints for table `war`
--
ALTER TABLE `war`
  ADD CONSTRAINT `clan_fk2` FOREIGN KEY (`clan_id`) REFERENCES `clan` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
