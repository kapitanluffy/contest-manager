-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 14, 2011 at 03:49 AM
-- Server version: 5.1.41
-- PHP Version: 5.3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `scoring_db`
--
CREATE DATABASE `scoring_db` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `scoring_db`;

-- --------------------------------------------------------

--
-- Table structure for table `contest`
--

CREATE TABLE IF NOT EXISTS `contest` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `mid` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `criterias` varchar(1000) NOT NULL,
  `contestants` varchar(1000) NOT NULL,
  `postContest` varchar(1000) DEFAULT NULL,
  `numberOfJudges` int(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `contest`
--

INSERT INTO `contest` (`id`, `mid`, `name`, `criterias`, `contestants`, `postContest`, `numberOfJudges`) VALUES
(2, 1, 'Variety Show - Elimination', 'a:3:{s:12:"Choreography";s:2:"30";s:6:"Timing";s:2:"30";s:9:"Execution";s:2:"40";}', 'a:5:{i:0;s:1:"1";i:1;s:1:"2";i:2;s:1:"4";i:3;s:1:"5";i:4;s:1:"6";}', 'a:2:{s:2:"id";s:1:"3";s:5:"limit";s:1:"3";}', 0),
(3, 1, 'Variety Show - Finals', 'a:5:{s:7:"Mastery";s:2:"20";s:5:"Style";s:2:"20";s:11:"Originality";s:2:"30";s:7:"Costume";s:2:"20";s:15:"Audience Impact";s:2:"10";}', 'N;', 'a:2:{s:2:"id";s:0:"";s:5:"limit";s:0:"";}', 0),
(6, 1, 'sample', 'a:3:{s:12:"Choreography";s:2:"30";s:6:"Timing";s:2:"30";s:9:"Execution";s:2:"40";}', 'a:5:{i:0;s:1:"1";i:1;s:1:"2";i:2;s:1:"4";i:3;s:1:"5";i:4;s:1:"6";}', 'a:2:{s:2:"id";s:0:"";s:5:"limit";s:1:"0";}', 3);

-- --------------------------------------------------------

--
-- Table structure for table `contestants`
--

CREATE TABLE IF NOT EXISTS `contestants` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `number` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `contestants`
--

INSERT INTO `contestants` (`id`, `number`, `name`) VALUES
(1, 1, 'Bernadette Rivera'),
(2, 2, 'Ramon Bong Revilla'),
(4, 3, 'King Derril Duenas'),
(5, 4, 'Gelo Reyes'),
(6, 5, 'Edward Elrick'),
(7, 6, 'Stephanie Cruz'),
(8, 7, 'Jan Michael Martirez'),
(9, 8, 'Errol Aguilar'),
(10, 9, 'Marikris Manalo'),
(11, 10, 'Jackielyn Valencia'),
(12, 11, 'Johnny Melchor'),
(13, 69, 'Rainer Padlan'),
(15, 69, 'Mark Sim Calimag');

-- --------------------------------------------------------

--
-- Table structure for table `criterias`
--

CREATE TABLE IF NOT EXISTS `criterias` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `percentage` int(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- Dumping data for table `criterias`
--

INSERT INTO `criterias` (`id`, `name`, `percentage`) VALUES
(3, 'Choreography', 30),
(4, 'Timing', 30),
(5, 'Execution', 40),
(11, 'Mastery', 20),
(10, 'Style', 20),
(12, 'Originality', 30),
(13, 'Costume', 20),
(14, 'Audience Impact', 10),
(16, 'Malibog ', 50);

-- --------------------------------------------------------

--
-- Table structure for table `managers`
--

CREATE TABLE IF NOT EXISTS `managers` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `managers`
--

INSERT INTO `managers` (`id`, `username`, `password`) VALUES
(1, 'alex', '123123');

-- --------------------------------------------------------

--
-- Table structure for table `scores`
--

CREATE TABLE IF NOT EXISTS `scores` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `contestId` int(100) NOT NULL,
  `contestantId` int(100) NOT NULL,
  `scores` varchar(1000) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `judge` varchar(1000) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `scores`
--

INSERT INTO `scores` (`id`, `contestId`, `contestantId`, `scores`, `total`, `judge`) VALUES
(1, 6, 1, 'a:3:{s:12:"Choreography";s:2:"30";s:6:"Timing";s:2:"25";s:9:"Execution";s:2:"38";}', '93.00', 'luffy'),
(2, 6, 1, 'a:3:{s:12:"Choreography";s:2:"30";s:6:"Timing";s:2:"25";s:9:"Execution";s:2:"35";}', '90.00', 'Errol'),
(3, 6, 2, 'a:3:{s:12:"Choreography";s:2:"25";s:6:"Timing";s:2:"28";s:9:"Execution";s:2:"40";}', '93.00', 'luffy'),
(4, 6, 4, 'a:3:{s:12:"Choreography";s:2:"30";s:6:"Timing";s:2:"29";s:9:"Execution";s:2:"35";}', '94.00', 'luffy'),
(5, 6, 5, 'a:3:{s:12:"Choreography";s:2:"28";s:6:"Timing";s:2:"29";s:9:"Execution";s:2:"35";}', '92.00', 'luffy'),
(6, 6, 6, 'a:3:{s:12:"Choreography";s:2:"29";s:6:"Timing";s:2:"29";s:9:"Execution";s:2:"35";}', '93.00', 'luffy'),
(7, 6, 2, 'a:3:{s:12:"Choreography";s:2:"25";s:6:"Timing";s:2:"25";s:9:"Execution";s:2:"35";}', '85.00', 'Errol'),
(8, 6, 4, 'a:3:{s:12:"Choreography";s:2:"30";s:6:"Timing";s:2:"25";s:9:"Execution";s:2:"35";}', '90.00', 'Errol'),
(9, 6, 5, 'a:3:{s:12:"Choreography";s:2:"28";s:6:"Timing";s:2:"28";s:9:"Execution";s:2:"30";}', '86.00', 'Errol'),
(10, 6, 6, 'a:3:{s:12:"Choreography";s:2:"30";s:6:"Timing";s:2:"30";s:9:"Execution";s:2:"38";}', '98.00', 'Errol'),
(11, 2, 1, 'a:3:{s:12:"Choreography";s:2:"30";s:6:"Timing";s:2:"30";s:9:"Execution";s:2:"38";}', '98.00', 'Errol');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
