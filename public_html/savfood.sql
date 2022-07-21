-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 27, 2022 at 07:54 AM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 8.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `savfood`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(10) UNSIGNED NOT NULL,
  `admin_username` varchar(50) CHARACTER SET latin1 NOT NULL,
  `admin_password` varchar(32) CHARACTER SET latin1 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `admin_username`, `admin_password`) VALUES
(1, 'admin123', 'Admin123!');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `qty` int(10) NOT NULL,
  `box_id` int(10) UNSIGNED NOT NULL,
  `cust_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `cust_id` int(10) UNSIGNED NOT NULL,
  `cust_fname` varchar(30) CHARACTER SET latin1 NOT NULL,
  `cust_lname` varchar(30) CHARACTER SET latin1 NOT NULL,
  `cust_phone` varchar(15) CHARACTER SET latin1 NOT NULL,
  `cust_email` varchar(50) CHARACTER SET latin1 NOT NULL,
  `cust_password` varchar(32) CHARACTER SET latin1 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`cust_id`, `cust_fname`, `cust_lname`, `cust_phone`, `cust_email`, `cust_password`) VALUES
(1, 'Mickey', 'Mouse', '161234567', 'mickeymouse@gmail.com', '9f3754f679f212460d9043936b20ba69'),
(11, 'Viva', 'Demo', '161234567', 'viva@gmail.com', 'e6bda2eac3504c27ff444477682b8ddd');

-- --------------------------------------------------------

--
-- Table structure for table `donation`
--

CREATE TABLE `donation` (
  `donation_id` int(10) UNSIGNED NOT NULL,
  `donation_amount` int(20) NOT NULL,
  `donation_datetime` datetime NOT NULL,
  `cust_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `donation`
--

INSERT INTO `donation` (`donation_id`, `donation_amount`, `donation_datetime`, `cust_id`) VALUES
(27, 10, '2021-11-23 12:45:24', 11);

-- --------------------------------------------------------

--
-- Table structure for table `foodbox`
--

CREATE TABLE `foodbox` (
  `box_id` int(10) UNSIGNED NOT NULL,
  `box_price` float NOT NULL,
  `box_qty` int(10) NOT NULL,
  `box_allergy` varchar(150) CHARACTER SET latin1 NOT NULL,
  `box_startTime` datetime NOT NULL,
  `box_endTime` datetime NOT NULL,
  `restaurant_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `foodbox`
--

INSERT INTO `foodbox` (`box_id`, `box_price`, `box_qty`, `box_allergy`, `box_startTime`, `box_endTime`, `restaurant_id`) VALUES
(1, 9.9, 18, 'Cheese, Butter', '2021-11-23 09:39:55', '2021-11-23 20:06:19', 1),
(28, 20, 17, 'Cheese', '2021-11-23 04:58:32', '2021-11-23 23:58:32', 27),
(29, 20, 17, 'cheese', '2021-11-23 12:32:00', '2021-11-23 14:37:00', 28);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(10) UNSIGNED NOT NULL,
  `order_datetime` datetime NOT NULL,
  `cust_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `order_datetime`, `cust_id`) VALUES
(58, '2021-11-23 12:42:57', 11);

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE `order_details` (
  `quantity` int(10) NOT NULL,
  `rate` int(10) NOT NULL,
  `review` varchar(260) CHARACTER SET latin1 NOT NULL,
  `rate_date` datetime NOT NULL,
  `status` varchar(20) CHARACTER SET latin1 NOT NULL,
  `order_id` int(10) UNSIGNED NOT NULL,
  `box_id` int(10) UNSIGNED NOT NULL,
  `restaurant_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `order_details`
--

INSERT INTO `order_details` (`quantity`, `rate`, `review`, `rate_date`, `status`, `order_id`, `box_id`, `restaurant_id`) VALUES
(3, 0, '', '0000-00-00 00:00:00', 'Pending', 58, 29, 28),
(3, 4, 'Good! :)', '2021-11-23 12:44:17', 'Picked-up', 58, 28, 27);

-- --------------------------------------------------------

--
-- Table structure for table `restaurant`
--

CREATE TABLE `restaurant` (
  `restaurant_id` int(10) UNSIGNED NOT NULL,
  `restaurant_name` varchar(50) CHARACTER SET latin1 NOT NULL,
  `restaurant_desc` varchar(3000) CHARACTER SET latin1 NOT NULL,
  `restaurant_cuisine` varchar(50) CHARACTER SET latin1 NOT NULL,
  `restaurant_unit` varchar(20) CHARACTER SET latin1 NOT NULL,
  `restaurant_building` varchar(50) CHARACTER SET latin1 NOT NULL,
  `restaurant_street` varchar(50) CHARACTER SET latin1 NOT NULL,
  `restaurant_postcode` int(10) NOT NULL,
  `restaurant_city` varchar(20) CHARACTER SET latin1 NOT NULL,
  `restaurant_state` varchar(20) CHARACTER SET latin1 NOT NULL,
  `restaurant_latitude` double NOT NULL,
  `restaurant_longitude` double NOT NULL,
  `restaurant_rate` double NOT NULL,
  `restaurant_phone` varchar(15) CHARACTER SET latin1 NOT NULL,
  `restaurant_image` varchar(260) CHARACTER SET latin1 NOT NULL,
  `restaurant_status` varchar(20) CHARACTER SET latin1 NOT NULL,
  `restaurant_email` varchar(50) CHARACTER SET latin1 NOT NULL,
  `restaurant_password` varchar(32) CHARACTER SET latin1 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `restaurant`
--

INSERT INTO `restaurant` (`restaurant_id`, `restaurant_name`, `restaurant_desc`, `restaurant_cuisine`, `restaurant_unit`, `restaurant_building`, `restaurant_street`, `restaurant_postcode`, `restaurant_city`, `restaurant_state`, `restaurant_latitude`, `restaurant_longitude`, `restaurant_rate`, `restaurant_phone`, `restaurant_image`, `restaurant_status`, `restaurant_email`, `restaurant_password`) VALUES
(1, 'Mcdonald\'s (Greenlane)', 'McDonald’s is the world’s leading quick service restaurant chain with more than 36,000 restaurants worldwide, serving more than 69 million customers daily in over 100 countries. In Malaysia, McDonald’s serves over 13.5 million customers a month in 300 restaurants nationwide. McDonald’s employs more than 14,000 Malaysians in its restaurants across the nation, providing career, training and development opportunities.', 'Fast Food', 'Lot 2506', '7 Section 6', 'Jalan Masjid Negeri', 11600, 'George Town', 'Penang', 0.0556783, 99.1506488, 4.3, '04-283 4299', 'mcd.png', 'Approved', 'mcd@gmail.com', 'c04633a657cba6fc94a6b4ab703235d8'),
(27, 'Sushi King', 'Your Happy Sushi Place. Sushi King - Malaysia largest Halal Japanese chain of restaurants, serves quality sushi and other Japanese cuisine at great value ...', 'Asian', 'G12 & G13', 'E-gate', 'Lebuh Tunku Kudin 2', 11700, 'Gelugor', 'Penang', 5.378202, 100.315687, 4, '04-1233456', 'sushi.jpg', 'Approved', 'sushiking@gmail.com', '123456'),
(28, 'Haidilao Hot Pot', 'The brand Haidilao was founded in 1994. With over 20 years of development, Haidilao International Holding Ltd. has become a world-renowned catering enterprise. By June 30th 2019, Haidilao owns 593 directly-operated branch restaurants scattered globally across China (Mainland, Hong Kong and Taiwan), Singapore, the United States of America, South Korea, Japan, Australia, Canada, the United Kingdom, Malaysia and Vietnam. It has outlets in 118 cities in Mainland China alone.', 'Korean', 'LOT3F-27/28/28', '100, Queensbay Mall', 'Persiaran Bayan Indah', 11900, 'Bayan Lepas', 'Penang', 5.3368925, 100.3083147, 0, '0161234567', '16180362_LOGO-HAIDILAO-900X900.png', 'Approved', 'haidilao@gmail.com', '789bfdc809a5c4d75e18f4bd4153cd22');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD KEY `box_id` (`box_id`),
  ADD KEY `custId` (`cust_id`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`cust_id`);

--
-- Indexes for table `donation`
--
ALTER TABLE `donation`
  ADD PRIMARY KEY (`donation_id`),
  ADD KEY `fk_cust_id` (`cust_id`);

--
-- Indexes for table `foodbox`
--
ALTER TABLE `foodbox`
  ADD PRIMARY KEY (`box_id`),
  ADD KEY `restaurant_id` (`restaurant_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `cust_id` (`cust_id`);

--
-- Indexes for table `order_details`
--
ALTER TABLE `order_details`
  ADD KEY `order_id` (`order_id`),
  ADD KEY `box_id` (`box_id`) USING BTREE,
  ADD KEY `fk_restaurant_id` (`restaurant_id`);

--
-- Indexes for table `restaurant`
--
ALTER TABLE `restaurant`
  ADD PRIMARY KEY (`restaurant_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `cust_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `donation`
--
ALTER TABLE `donation`
  MODIFY `donation_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `foodbox`
--
ALTER TABLE `foodbox`
  MODIFY `box_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `restaurant`
--
ALTER TABLE `restaurant`
  MODIFY `restaurant_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `box_id` FOREIGN KEY (`box_id`) REFERENCES `foodbox` (`box_id`),
  ADD CONSTRAINT `custId` FOREIGN KEY (`cust_id`) REFERENCES `customer` (`cust_id`);

--
-- Constraints for table `donation`
--
ALTER TABLE `donation`
  ADD CONSTRAINT `fk_cust_id` FOREIGN KEY (`cust_id`) REFERENCES `customer` (`cust_id`);

--
-- Constraints for table `foodbox`
--
ALTER TABLE `foodbox`
  ADD CONSTRAINT `restaurant_id` FOREIGN KEY (`restaurant_id`) REFERENCES `restaurant` (`restaurant_id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `cust_id` FOREIGN KEY (`cust_id`) REFERENCES `customer` (`cust_id`);

--
-- Constraints for table `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `boxId` FOREIGN KEY (`box_id`) REFERENCES `foodbox` (`box_id`),
  ADD CONSTRAINT `fk_restaurant_id` FOREIGN KEY (`restaurant_id`) REFERENCES `restaurant` (`restaurant_id`),
  ADD CONSTRAINT `order_id` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
