-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 09, 2013 at 04:02 AM
-- Server version: 5.5.27
-- PHP Version: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";# MySQL returned an empty result set (i.e. zero rows).

SET time_zone = "+00:00";# MySQL returned an empty result set (i.e. zero rows).



/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;# MySQL returned an empty result set (i.e. zero rows).

/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;# MySQL returned an empty result set (i.e. zero rows).

/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;# MySQL returned an empty result set (i.e. zero rows).

/*!40101 SET NAMES utf8 */;# MySQL returned an empty result set (i.e. zero rows).


--
-- Table structure for table `contacts`
--

CREATE TABLE IF NOT EXISTS `contacts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fname` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `lname` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `city` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `state` varchar(2) COLLATE utf8_unicode_ci NOT NULL,
  `zip` int(5) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Contain contact and location data' AUTO_INCREMENT=1 ;# MySQL returned an empty result set (i.e. zero rows).


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;# MySQL returned an empty result set (i.e. zero rows).

/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;# MySQL returned an empty result set (i.e. zero rows).

/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;# MySQL returned an empty result set (i.e. zero rows).


ALTER TABLE `contacts` ADD COLUMN `deleted` DATETIME NULL DEFAULT NULL  AFTER `zip` ;# MySQL returned an empty result set (i.e. zero rows).
