-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jan 22, 2017 at 06:06 PM
-- Server version: 5.6.34
-- PHP Version: 7.0.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lucy_pet_service`
--

-- --------------------------------------------------------

--
-- Table structure for table `owner`
--

CREATE TABLE `owner` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `address` text NOT NULL,
  `distance_from_pet_shop` int(11) NOT NULL,
  `email` varchar(40) NOT NULL,
  `password` varchar(200) NOT NULL,
  `phone` int(11) DEFAULT NULL,
  `zipcode` varchar(20) DEFAULT NULL,
  `is_admin` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `owner`
--

INSERT INTO `owner` (`id`, `name`, `address`, `distance_from_pet_shop`, `email`, `password`, `phone`, `zipcode`, `is_admin`) VALUES
(1, 'Imtiaz Mahbub', 'H-247, Eastern Housing Ltd., Pallabi 2nd Phase, Mirpur, Dhaka', 32, 'md.imtiazmahbub@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', 1553420810, '1216', 1);

-- --------------------------------------------------------

--
-- Table structure for table `pet`
--

CREATE TABLE `pet` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `owner_id` int(11) NOT NULL,
  `color` varchar(40) NOT NULL,
  `weight` float NOT NULL,
  `category` varchar(100) NOT NULL,
  `diet_preference` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pet`
--

INSERT INTO `pet` (`id`, `name`, `owner_id`, `color`, `weight`, `category`, `diet_preference`) VALUES
(5, 'Tommy', 1, 'Black', 20, 'American Doberman', '1350 Calories\r\nHas a mouth for Diet Pepsi!'),
(6, 'Max', 1, 'Gray', 35, 'German Shepherd', '1900 Calories\r\nLikes Dry foods'),
(7, 'Sammy', 1, 'Light Brown', 18, 'Deshi Kutta', 'Trash, Anything!\r\nNo diet plan!'),
(9, '', 1, '', 0, '', '');

-- --------------------------------------------------------

--
-- Table structure for table `pet_services`
--

CREATE TABLE `pet_services` (
  `id` int(11) NOT NULL,
  `pet_id` int(11) NOT NULL COMMENT 'the pet ID from pet table',
  `service_id` int(11) NOT NULL COMMENT 'The Owner ID from owner table',
  `duration` int(11) NOT NULL COMMENT 'Duration in minutes',
  `time_of_day` time DEFAULT NULL COMMENT 'if specified, the service will be applied everyday at that time',
  `day_of_week` varchar(20) DEFAULT NULL COMMENT 'if specified, the service will be applied on that day of week, every week',
  `day_of_month` text COMMENT 'if specified by a number, the service will be applied to only 1 day of a month',
  `service_off_day` date DEFAULT NULL COMMENT 'if specified, the service will be off for that day. even if matched by the previous rules.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `rate` float NOT NULL COMMENT 'Rate per 15 minutes',
  `min_increment` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `name`, `rate`, `min_increment`) VALUES
(1, 'Pet Walking', 1, 15),
(2, 'Pet Feeding', 3, 0),
(3, 'Puppy Socialization', 8, 120),
(4, 'Play Session', 3, 30);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `owner`
--
ALTER TABLE `owner`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pet`
--
ALTER TABLE `pet`
  ADD PRIMARY KEY (`id`),
  ADD KEY `owner_id` (`owner_id`);

--
-- Indexes for table `pet_services`
--
ALTER TABLE `pet_services`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pet_id` (`pet_id`),
  ADD KEY `service_id` (`service_id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `owner`
--
ALTER TABLE `owner`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `pet`
--
ALTER TABLE `pet`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `pet_services`
--
ALTER TABLE `pet_services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `pet`
--
ALTER TABLE `pet`
  ADD CONSTRAINT `pet_ibfk_1` FOREIGN KEY (`owner_id`) REFERENCES `owner` (`id`);

--
-- Constraints for table `pet_services`
--
ALTER TABLE `pet_services`
  ADD CONSTRAINT `pet_services_ibfk_1` FOREIGN KEY (`pet_id`) REFERENCES `pet` (`id`),
  ADD CONSTRAINT `pet_services_ibfk_2` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
