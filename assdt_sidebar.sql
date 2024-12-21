-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 14, 2024 at 02:18 PM
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
-- Table structure for table `assdt_sidebar`
--

CREATE TABLE `assdt_sidebar` (
  `sidebar_id` int NOT NULL,
  `parent_id` int NOT NULL COMMENT 'if 0 no parent else sidebar_id of parent tab',
  `tab_name` varchar(100) NOT NULL,
  `tab_icon_class` varchar(30) DEFAULT NULL,
  `link_url` varchar(250) NOT NULL,
  `active_link_name` varchar(50) NOT NULL,
  `tab_order` int NOT NULL,
  `is_active` tinyint NOT NULL COMMENT '1=>active (visible to users), 0=>inactive (hidden from users)'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `assdt_sidebar`
--

INSERT INTO `assdt_sidebar` (`sidebar_id`, `parent_id`, `tab_name`, `tab_icon_class`, `link_url`, `active_link_name`, `tab_order`, `is_active`) VALUES
(1, 0, 'Dashboard', 'fa fa-dashboard', 'admin/dashboard', 'Dashbaord.php', 1, 1),
(2, 0, 'My Account', 'fa fa-user', 'javascript:void();', 'MyAccount', 2, 1),
(3, 2, 'My Profile', 'fa-solid fa-id-card', 'admin/profile', 'MyProfile', 1, 1),
(4, 0, 'Assessment', 'fa fa-th', 'javascript:void(0);', 'Assessment', 3, 1),
(5, 4, 'Question 1', 'fa-solid fa-question', 'admin/assessment/qone', 'qone', 1, 1),
(6, 4, 'Question 2', 'fa-solid fa-question', 'admin/assessment/qtwo', 'qtwo', 2, 1),
(7, 4, 'Question 3', 'fa-solid fa-question', 'admin/assessment/qthree', 'three', 3, 1),
(8, 0, 'Logout', 'fa fa-bullhorn', 'admin/logout', 'Logout', 4, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `assdt_sidebar`
--
ALTER TABLE `assdt_sidebar`
  ADD PRIMARY KEY (`sidebar_id`),
  ADD KEY `parent_id` (`parent_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `assdt_sidebar`
--
ALTER TABLE `assdt_sidebar`
  MODIFY `sidebar_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
