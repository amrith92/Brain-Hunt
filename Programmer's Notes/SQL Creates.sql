SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

CREATE TABLE IF NOT EXISTS `attempts` (
  `user_ID` int(11) NOT NULL,
  `question_ID` int(11) NOT NULL,
  `answer` varchar(100) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `result` tinyint(1) NOT NULL,
  PRIMARY KEY (`user_ID`,`question_ID`,`time`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `questions` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `location` varchar(100) NOT NULL,
  `answer` varchar(100) NOT NULL,
  `hint` varchar(500) NOT NULL,
  `level` int(11) NOT NULL,
  `uploader` int(11) NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `location` (`location`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `results` (
  `user_ID` int(11) NOT NULL,
  `question_ID` int(11) NOT NULL,
  `time_present` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `time_success` timestamp NULL DEFAULT NULL,
  `hint` tinyint(1) NOT NULL,
  PRIMARY KEY (`user_ID`,`question_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `thresholds` (
  `level` int(11) NOT NULL,
  `threshold` int(11) NOT NULL,
  PRIMARY KEY (`level`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `user_auth` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `user_state` (
  `user_ID` int(11) NOT NULL,
  `level` int(11) NOT NULL,
  `points` int(11) NOT NULL,
  PRIMARY KEY (`user_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `attempts`
  ADD CONSTRAINT `attempts_ibfk_1` FOREIGN KEY (`user_ID`) REFERENCES `user_auth` (`ID`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `attempts_ibfk_2` FOREIGN KEY (`question_ID`) REFERENCES `questions` (`ID`) ON DELETE NO ACTION ON UPDATE CASCADE;

ALTER TABLE `questions`
  ADD CONSTRAINT `questions_ibfk_1` FOREIGN KEY (`level`) REFERENCES `thresholds` (`level`) ON DELETE NO ACTION ON UPDATE CASCADE;

ALTER TABLE `results`
  ADD CONSTRAINT `results_ibfk_1` FOREIGN KEY (`user_ID`) REFERENCES `user_auth` (`ID`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `results_ibfk_2` FOREIGN KEY (`question_ID`) REFERENCES `questions` (`ID`) ON DELETE NO ACTION ON UPDATE CASCADE;
  
ALTER TABLE `user_state`
  ADD CONSTRAINT `user_state_ibfk_1` FOREIGN KEY (`user_ID`) REFERENCES `user_auth` (`ID`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `user_state_ibfk_2` FOREIGN KEY (`level`) REFERENCES `thresholds` (`level`) ON DELETE NO ACTION ON UPDATE CASCADE;
