-- Adminer 4.7.7 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `homework`;
CREATE TABLE `homework` (
  `test_name` mediumtext NOT NULL,
  `test_id` mediumtext NOT NULL,
  `select_answer` mediumtext NOT NULL,
  `select_answer_score` mediumtext NOT NULL,
  `answer` mediumtext NOT NULL,
  `answer_score` mediumtext NOT NULL,
  `username` mediumtext NOT NULL,
  `classname` mediumtext NOT NULL,
  `complete` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `username` mediumtext NOT NULL,
  `password` mediumtext NOT NULL,
  `classname` mediumtext NOT NULL,
  `userid` mediumtext NOT NULL,
  `per` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- 2021-01-22 12:45:30
