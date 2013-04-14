-- phpMyAdmin SQL Dump
-- version 3.4.11.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 12, 2013 at 10:23 PM
-- Server version: 5.5.29
-- PHP Version: 5.4.6-1ubuntu1.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `brain_hunt`
--

-- --------------------------------------------------------

--
-- Table structure for table `attempts`
--

CREATE TABLE IF NOT EXISTS `attempts` (
  `user_ID` int(11) NOT NULL,
  `question_ID` int(11) NOT NULL,
  `answer` varchar(100) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `result` tinyint(1) NOT NULL,
  PRIMARY KEY (`user_ID`,`question_ID`,`time`),
  KEY `attempts_ibfk_2` (`question_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE IF NOT EXISTS `questions` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `location` varchar(100) NOT NULL,
  `answer` varchar(100) NOT NULL,
  `hint` text NOT NULL,
  `level` int(11) NOT NULL,
  `uploader` int(11) NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `location` (`location`),
  KEY `questions_ibfk_1` (`level`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`ID`, `location`, `answer`, `hint`, `level`, `uploader`) VALUES
(0, '/Questions/url.jpeg', 'temple run', 'temple run', 0, -1),
(1, '/Questions/550845_457533760949008_1672253051_n.jpg', 'nobody', 'nobody', 0, -1),
(2, '/Questions/551807_225137574270074_100003214988339_367985_1425871304_n.jpg', 'windows', 'windows', 1, -1),
(3, '/Questions/554647_4204378353657_747154830_n.jpg', 'firefox', 'firefox', 1, -1),
(4, '/Questions/563535_4324508953622_616110018_n.jpg', 'apple', 'apple', 1, -1),
(5, '/Questions/577508_4204395074075_308239800_n.jpg', 'nike', 'nike', 2, -1),
(6, '/Questions/579650_10150924337920890_296495560889_9884097_349686594_n.jpg', 'doctor', 'doctor', 2, -1),
(7, '/Questions/600900_332846513460159_33038086_n.jpg', 'dj', 'dj', 2, -1),
(8, '/Questions/4728156_460s.jpg', 'anonymous', 'anonymous', 2, -1),
(9, '/Questions/4728878_700b.jpg', 'boson', 'bosn', 0, -1);

-- --------------------------------------------------------

--
-- Table structure for table `results`
--

CREATE TABLE IF NOT EXISTS `results` (
  `user_ID` int(11) NOT NULL,
  `question_ID` int(11) NOT NULL,
  `time_present` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `time_success` timestamp NULL DEFAULT NULL,
  `hint` tinyint(1) NOT NULL,
  PRIMARY KEY (`user_ID`,`question_ID`),
  KEY `results_ibfk_2` (`question_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `thresholds`
--

CREATE TABLE IF NOT EXISTS `thresholds` (
  `level` int(11) NOT NULL,
  `threshold` int(11) NOT NULL,
  PRIMARY KEY (`level`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `thresholds`
--

INSERT INTO `thresholds` (`level`, `threshold`) VALUES
(0, 3),
(1, 7),
(2, 11),
(3, 11);

-- --------------------------------------------------------

--
-- Table structure for table `user_auth`
--

CREATE TABLE IF NOT EXISTS `user_auth` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;

--
-- Dumping data for table `user_auth`
--

INSERT INTO `user_auth` (`ID`, `username`, `name`, `password`) VALUES
(21, 'test1', 'test1', '5a105e8b9d40e1329780d62ea2265d8a');

-- --------------------------------------------------------

--
-- Table structure for table `user_state`
--

CREATE TABLE IF NOT EXISTS `user_state` (
  `user_ID` int(11) NOT NULL,
  `level` int(11) NOT NULL,
  `points` int(11) NOT NULL,
  PRIMARY KEY (`user_ID`),
  KEY `user_state_ibfk_2` (`level`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_state`
--

INSERT INTO `user_state` (`user_ID`, `level`, `points`) VALUES
(21, 0, 0);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attempts`
--
ALTER TABLE `attempts`
  ADD CONSTRAINT `attempts_ibfk_1` FOREIGN KEY (`user_ID`) REFERENCES `user_auth` (`ID`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `attempts_ibfk_2` FOREIGN KEY (`question_ID`) REFERENCES `questions` (`ID`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `questions_ibfk_1` FOREIGN KEY (`level`) REFERENCES `thresholds` (`level`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `results`
--
ALTER TABLE `results`
  ADD CONSTRAINT `results_ibfk_1` FOREIGN KEY (`user_ID`) REFERENCES `user_auth` (`ID`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `results_ibfk_2` FOREIGN KEY (`question_ID`) REFERENCES `questions` (`ID`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `user_state`
--
ALTER TABLE `user_state`
  ADD CONSTRAINT `user_state_ibfk_1` FOREIGN KEY (`user_ID`) REFERENCES `user_auth` (`ID`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `user_state_ibfk_2` FOREIGN KEY (`level`) REFERENCES `thresholds` (`level`) ON DELETE NO ACTION ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
