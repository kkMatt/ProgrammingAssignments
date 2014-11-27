-- phpMyAdmin SQL Dump
-- version 4.2.5
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1:3306
-- Generation Time: Nov 27, 2014 at 05:39 AM
-- Server version: 5.5.23
-- PHP Version: 5.5.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `test`
--

-- --------------------------------------------------------

--
-- Table structure for table `nfq_groups`
--

DROP TABLE IF EXISTS `nfq_groups`;
CREATE TABLE IF NOT EXISTS `nfq_groups` (
`group_id` int(10) unsigned NOT NULL,
  `group_name` varchar(100) COLLATE utf8_lithuanian_ci NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_lithuanian_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `nfq_groups`
--

INSERT INTO `nfq_groups` (`group_id`, `group_name`) VALUES
(2, 'Developers'),
(1, 'Gamers');

-- --------------------------------------------------------

--
-- Table structure for table `nfq_users`
--

DROP TABLE IF EXISTS `nfq_users`;
CREATE TABLE IF NOT EXISTS `nfq_users` (
`user_id` int(10) unsigned NOT NULL,
  `user_name` varchar(100) COLLATE utf8_lithuanian_ci NOT NULL DEFAULT '',
  `user_joined` int(11) unsigned NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_lithuanian_ci AUTO_INCREMENT=6 ;

--
-- Dumping data for table `nfq_users`
--

INSERT INTO `nfq_users` (`user_id`, `user_name`, `user_joined`) VALUES
(1, 'Peter', 1416957271),
(2, 'John', 1416957271),
(3, 'Kestutis', 1416957271),
(4, 'Vilius', 1416957271),
(5, 'David', 1416957271);

-- --------------------------------------------------------

--
-- Table structure for table `nfq_user_groups`
--

DROP TABLE IF EXISTS `nfq_user_groups`;
CREATE TABLE IF NOT EXISTS `nfq_user_groups` (
  `user_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_lithuanian_ci;

--
-- Dumping data for table `nfq_user_groups`
--

INSERT INTO `nfq_user_groups` (`user_id`, `group_id`) VALUES
(1, 1),
(1, 2),
(2, 1),
(3, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `nfq_groups`
--
ALTER TABLE `nfq_groups`
 ADD PRIMARY KEY (`group_id`), ADD KEY `group_name` (`group_name`);

--
-- Indexes for table `nfq_users`
--
ALTER TABLE `nfq_users`
 ADD PRIMARY KEY (`user_id`), ADD KEY `user_name` (`user_name`);

--
-- Indexes for table `nfq_user_groups`
--
ALTER TABLE `nfq_user_groups`
 ADD UNIQUE KEY `user_id_2` (`user_id`,`group_id`), ADD KEY `user_id` (`user_id`,`group_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `nfq_groups`
--
ALTER TABLE `nfq_groups`
MODIFY `group_id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `nfq_users`
--
ALTER TABLE `nfq_users`
MODIFY `user_id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
