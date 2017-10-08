-- phpMyAdmin SQL Dump
-- version 4.1.14.8
-- http://www.phpmyadmin.net
--
-- Host: db699388435.db.1and1.com
-- Generation Time: Sep 30, 2017 at 02:20 PM
-- Server version: 5.5.57-0+deb7u1-log
-- PHP Version: 5.4.45-0+deb7u11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `db699388435`
--

-- --------------------------------------------------------

--
-- Table structure for table `actions`
--

CREATE TABLE IF NOT EXISTS `actions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `device` int(11) NOT NULL,
  `state` varchar(1024) COLLATE latin1_german2_ci NOT NULL,
  `r` int(11) NOT NULL,
  `g` int(11) NOT NULL,
  `b` int(11) NOT NULL,
  `actionText` varchar(2048) COLLATE latin1_german2_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_german2_ci AUTO_INCREMENT=0 ;

-- --------------------------------------------------------

--
-- Table structure for table `devices`
--

CREATE TABLE IF NOT EXISTS `devices` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `internal_id` int(11) NOT NULL,
  `unique_id` varchar(1024) COLLATE latin1_german2_ci NOT NULL,
  `name` varchar(1024) COLLATE latin1_german2_ci NOT NULL,
  `state` varchar(1024) COLLATE latin1_german2_ci NOT NULL,
  `reachable` varchar(1024) COLLATE latin1_german2_ci NOT NULL,
  `type` varchar(1024) COLLATE latin1_german2_ci NOT NULL,
  `model` varchar(1024) COLLATE latin1_german2_ci NOT NULL,
  `bridge_name` varchar(1024) COLLATE latin1_german2_ci NOT NULL,
  `bridge_ip` varchar(1024) COLLATE latin1_german2_ci NOT NULL,
  `key` varchar(1024) COLLATE latin1_german2_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_german2_ci AUTO_INCREMENT=0 ;

-- --------------------------------------------------------

--
-- Table structure for table `ip_link`
--

CREATE TABLE IF NOT EXISTS `ip_link` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip_outer` varchar(1024) COLLATE latin1_german2_ci NOT NULL,
  `ip_inner` varchar(1024) COLLATE latin1_german2_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_german2_ci AUTO_INCREMENT=0 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(1024) COLLATE latin1_german2_ci NOT NULL,
  `password` varchar(1024) COLLATE latin1_german2_ci NOT NULL,
  `key` varchar(1024) COLLATE latin1_german2_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_german2_ci AUTO_INCREMENT=0 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
