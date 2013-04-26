-- phpMyAdmin SQL Dump
-- version 3.3.7deb7
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 12, 2012 at 04:16 PM
-- Server version: 5.1.63
-- PHP Version: 5.3.3-7+squeeze13

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

-- --------------------------------------------------------

--
-- Table structure for table `nonce`
--

CREATE TABLE IF NOT EXISTS `nonce` (
  `nonce` text NOT NULL,
  `issue` int(11) NOT NULL,
  `lastseen` int(11) NOT NULL,
  `expire` int(11) NOT NULL,
  `nc` int(4) NOT NULL,
  PRIMARY KEY (`nonce`(25))
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
