-- phpMyAdmin SQL Dump
-- version 2.11.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 27, 2015 at 09:41 PM
-- Server version: 5.1.57
-- PHP Version: 5.2.17

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `a1438837_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_member`
--

CREATE TABLE `tbl_member` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `user_name` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `pass_word` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `location` varchar(200) COLLATE latin1_general_ci NOT NULL,
  `email` varchar(300) COLLATE latin1_general_ci NOT NULL,
  `reg_status` varchar(1) COLLATE latin1_general_ci NOT NULL,
  `reg_no` varchar(6) COLLATE latin1_general_ci NOT NULL,
  `time_stamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `logins` int(11) NOT NULL DEFAULT '0' COMMENT 'No of user successful log in',
  `online` varchar(1) COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id` (`user_id`,`email`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;
