-- phpMyAdmin SQL Dump
-- version 3.1.3.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 20, 2017 at 04:51 PM
-- Server version: 5.1.37
-- PHP Version: 5.2.9

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `onlinetest`
--

-- --------------------------------------------------------

--
-- Table structure for table `access`
--

CREATE TABLE IF NOT EXISTS `access` (
  `accessType` varchar(200) NOT NULL,
  `flag` int(11) NOT NULL,
  PRIMARY KEY (`accessType`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `access`
--

INSERT INTO `access` (`accessType`, `flag`) VALUES
('admin', 1),
('user', 2);

-- --------------------------------------------------------

--
-- Table structure for table `chapters`
--

CREATE TABLE IF NOT EXISTS `chapters` (
  `chapter` varchar(600) NOT NULL,
  `flag` int(11) NOT NULL,
  `numForm` int(11) NOT NULL,
  PRIMARY KEY (`chapter`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `chapters`
--


-- --------------------------------------------------------

--
-- Table structure for table `form`
--

CREATE TABLE IF NOT EXISTS `form` (
  `formNo` varchar(700) NOT NULL,
  `chapter` varchar(600) NOT NULL,
  `numMCQ` int(11) NOT NULL,
  `numEssay` int(11) NOT NULL,
  `flag` int(11) NOT NULL,
  `timeLimit` int(11) NOT NULL,
  PRIMARY KEY (`formNo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `form`
--


-- --------------------------------------------------------

--
-- Table structure for table `useranswers`
--

CREATE TABLE IF NOT EXISTS `useranswers` (
  `SrNo` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `chapterName` varchar(600) NOT NULL,
  `formNo` varchar(700) NOT NULL,
  `completionTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `totalCorrect` int(11) NOT NULL,
  `totalEssayGrade` int(11) NOT NULL,
  `achievedEssayGrade` int(11) NOT NULL,
  `finalPercentage` int(11) NOT NULL,
  `testTaken` tinyint(1) NOT NULL,
  `essayGraded` tinyint(1) NOT NULL,
  PRIMARY KEY (`SrNo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `useranswers`
--


-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `name` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(20) NOT NULL,
  `accessRest` varchar(50) NOT NULL,
  `flag` int(11) NOT NULL,
  `isLoggedIn` tinyint(1) NOT NULL,
  `numLogin` int(11) NOT NULL,
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`name`, `username`, `password`, `accessRest`, `flag`, `isLoggedIn`, `numLogin`) VALUES
('Administrator', 'admin', 'admin', 'admin', 1, 0, 0);