-- phpMyAdmin SQL Dump
-- version 4.4.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Sep 15, 2016 at 01:27 PM
-- Server version: 5.6.25
-- PHP Version: 5.6.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
--
-- Database: `main_database`
--

-- --------------------------------------------------------

--
-- Table structure for table `bike`
--

CREATE TABLE IF NOT EXISTS `bike` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `description` varchar(500) NOT NULL,
  `number_plate` varchar(50) NOT NULL,
  `image` varchar(500) NOT NULL,
  `chasisnumber` bigint(20) NOT NULL,
  `rate_per_hr` int(10) NOT NULL,
  `bike_owner_id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bike`
--

INSERT INTO `bike` (`id`, `name`, `description`, `number_plate`, `image`, `chasisnumber`, `rate_per_hr`, `bike_owner_id`) VALUES
(1, 'Apache RTR', 'White Color', 'mh 12 AS 9548', 'Not Available', 12121212121212, 200, 1),
(2, 'Ramesh Dhawane', 'Greenish Color', 'mh 16 AA 45458', 'Not Available', 101215486582, 150, 2);

-- --------------------------------------------------------

--
-- Table structure for table `bike_owner`
--

CREATE TABLE IF NOT EXISTS `bike_owner` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `address` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `mob` bigint(10) NOT NULL,
  `offc_address` varchar(200) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bike_owner`
--

INSERT INTO `bike_owner` (`id`, `name`, `address`, `email`, `mob`, `offc_address`) VALUES
(1, 'Nitin Pawar', 'Kothrud,pune', 'nitinpawar@gmail.com', 8796104710, 'persistent,kothrud'),
(2, 'Ramesh Dhawane', 'Kothrud,pune', 'ramesh@gmail.com', 8796104710, 'giftease,kp');

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

CREATE TABLE IF NOT EXISTS `booking` (
  `id` int(11) NOT NULL,
  `startdate` date NOT NULL,
  `starttime` time NOT NULL,
  `enddate` date NOT NULL,
  `endtime` time NOT NULL,
  `bikeid` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `booking`
--

INSERT INTO `booking` (`id`, `startdate`, `starttime`, `enddate`, `endtime`, `bikeid`) VALUES
(1, '2016-09-16', '06:27:19', '2016-09-18', '04:18:20', 1),
(2, '2016-09-16', '03:09:16', '2016-09-17', '12:27:11', 2);

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE IF NOT EXISTS `order_details` (
  `id` int(11) NOT NULL,
  `bookingid` int(11) NOT NULL,
  `totalfare` int(20) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `order_details`
--

INSERT INTO `order_details` (`id`, `bookingid`, `totalfare`, `date`) VALUES
(1, 1, 200, '2016-09-17'),
(2, 2, 500, '2016-09-18');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `address` varchar(500) NOT NULL,
  `mobile` bigint(10) NOT NULL,
  `email` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `doc_submitted` varchar(150) NOT NULL,
  `bookingId` int(11) NOT NULL,
  `orderId` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `address`, `mobile`, `email`, `username`, `password`, `doc_submitted`, `bookingId`, `orderId`) VALUES
(3, 'Pradeep pandey', 'kothrud,pune', 9561313954, 'pradeeppandey@gmail.com', 'pradeep315', 'pradeep315', 'Adhar Card', 2, NULL),
(4, 'Rohan Kawade', 'kothrud,pune', 8796104710, 'rohankawade@gmail.com', 'rbk222tw', 'smalwonder', 'Adhar Card', 1, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bike`
--
ALTER TABLE `bike`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bike_owner_id` (`bike_owner_id`),
  ADD KEY `bike_owner_id_2` (`bike_owner_id`);

--
-- Indexes for table `bike_owner`
--
ALTER TABLE `bike_owner`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bikeid` (`bikeid`);

--
-- Indexes for table `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bookingid` (`bookingid`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bookingId` (`bookingId`),
  ADD KEY `orderId` (`orderId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bike`
--
ALTER TABLE `bike`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `bike_owner`
--
ALTER TABLE `bike_owner`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `booking`
--
ALTER TABLE `booking`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `bike`
--
ALTER TABLE `bike`
  ADD CONSTRAINT `bike_ibfk_1` FOREIGN KEY (`bike_owner_id`) REFERENCES `bike_owner` (`id`);

--
-- Constraints for table `booking`
--
ALTER TABLE `booking`
  ADD CONSTRAINT `booking_ibfk_1` FOREIGN KEY (`bikeid`) REFERENCES `bike` (`id`);

--
-- Constraints for table `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `order_details_ibfk_1` FOREIGN KEY (`bookingid`) REFERENCES `booking` (`id`);

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`bookingId`) REFERENCES `booking` (`id`),
  ADD CONSTRAINT `user_ibfk_2` FOREIGN KEY (`orderId`) REFERENCES `order_details` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
