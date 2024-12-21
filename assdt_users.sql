-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 14, 2024 at 11:28 AM
-- Server version: 8.0.30
-- PHP Version: 8.2.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `codegenie`
--

-- --------------------------------------------------------

--
-- Table structure for table `assdt_users`
--

CREATE TABLE `assdt_users` (
  `id` int NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email_id` varchar(50) NOT NULL COMMENT 'email id should be unique',
  `mobile_number` varchar(10) NOT NULL COMMENT 'mobile number should be unique',
  `password` varchar(50) NOT NULL COMMENT 'password should be of minimum 8 characters and should be hashed through md5',
  `created_on` datetime NOT NULL,
  `last_login_ip` varchar(50) DEFAULT NULL,
  `is_active` enum('ACTIVE','BLOCKED') NOT NULL COMMENT 'if BLOCKED, user cannot login his/her account'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `assdt_users`
--
ALTER TABLE `assdt_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email_id` (`email_id`),
  ADD UNIQUE KEY `mobile_number` (`mobile_number`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `assdt_users`
--
ALTER TABLE `assdt_users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
