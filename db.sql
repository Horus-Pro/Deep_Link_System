-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 05, 2023 at 06:00 PM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `deeplink_db`
--
CREATE DATABASE IF NOT EXISTS `deeplink_db` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `deeplink_db`;

-- --------------------------------------------------------

--
-- Table structure for table `deeplink`
--

CREATE TABLE `deeplink` (
  `id` int(6) UNSIGNED NOT NULL,
  `URLName` varchar(25) NOT NULL,
  `YTCode` varchar(11) NOT NULL,
  `VideoTitle` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `clicks` int(6) NOT NULL,
  `username` varchar(50) NOT NULL,
  `Reg_Date` timestamp NOT NULL DEFAULT current_timestamp(),
  `Update_Date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `deeplink_prd`
--

CREATE TABLE `deeplink_prd` (
  `id` int(6) UNSIGNED NOT NULL,
  `YTCode` varchar(11) NOT NULL,
  `VideoTitle` varchar(200) CHARACTER SET utf8 NOT NULL,
  `clicks` int(6) NOT NULL,
  `link_status` int(1) NOT NULL,
  `username` varchar(50) NOT NULL,
  `Reg_Date` timestamp NOT NULL DEFAULT current_timestamp(),
  `Update_Date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `url_shorten`
--

CREATE TABLE `url_shorten` (
  `id` int(11) NOT NULL,
  `url` tinytext NOT NULL,
  `short_code` varchar(50) NOT NULL,
  `hits` int(11) NOT NULL,
  `added_date` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(60) NOT NULL,
  `acc_status` int(1) NOT NULL,
  `subscription` int(1) NOT NULL,
  `Reg_Date` timestamp NOT NULL DEFAULT current_timestamp(),
  `Update_Date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `token` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `deeplink`
--
ALTER TABLE `deeplink`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `URLName` (`URLName`),
  ADD UNIQUE KEY `YTCode` (`YTCode`);

--
-- Indexes for table `deeplink_prd`
--
ALTER TABLE `deeplink_prd`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `url_shorten`
--
ALTER TABLE `url_shorten`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `deeplink`
--
ALTER TABLE `deeplink`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `deeplink_prd`
--
ALTER TABLE `deeplink_prd`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `url_shorten`
--
ALTER TABLE `url_shorten`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
