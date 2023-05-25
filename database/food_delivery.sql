-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 25, 2023 at 05:05 AM
-- Server version: 10.3.35-MariaDB
-- PHP Version: 7.3.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `id19930663_food_delivery`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `CID` int(11) NOT NULL,
  `CName` varchar(200) COLLATE utf8mb4_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`CID`, `CName`) VALUES
(1, 'ส้มตำ'),
(2, 'ปิ้ง/ย่าง'),
(3, 'ทอด'),
(4, 'ผลไม้สด');

-- --------------------------------------------------------

--
-- Table structure for table `files`
--

CREATE TABLE `files` (
  `FilesID` int(4) NOT NULL,
  `Name` varchar(100) COLLATE utf8_bin NOT NULL,
  `FilesName` varchar(100) COLLATE utf8_bin NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `files`
--

INSERT INTO `files` (`FilesID`, `Name`, `FilesName`) VALUES
(1, 'win', 'win.jpg'),
(2, 'plakrim', 'plakrim.jpg'),
(3, '111', '1.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `food_trucks`
--

CREATE TABLE `food_trucks` (
  `FTID` int(11) NOT NULL,
  `FTName` varchar(200) COLLATE utf8mb4_bin NOT NULL,
  `Description` text COLLATE utf8mb4_bin NOT NULL,
  `Truck_Picture` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `Food_Picture` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `Location` varchar(100) COLLATE utf8mb4_bin NOT NULL,
  `Hours` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `qrCode` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `UID` int(11) NOT NULL,
  `CID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Dumping data for table `food_trucks`
--

INSERT INTO `food_trucks` (`FTID`, `FTName`, `Description`, `Truck_Picture`, `Food_Picture`, `Location`, `Hours`, `qrCode`, `UID`, `CID`) VALUES
(5, 'ร้านส้มตำ', 'ส้มตำแซ่บๆ', 'foodpapaya.jpg', 'papaya.jpg', '5/175', '10.00 - 20.00', 'qrpapaya.png', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `menu_items`
--

CREATE TABLE `menu_items` (
  `MIID` int(11) NOT NULL,
  `MName` varchar(200) COLLATE utf8mb4_bin NOT NULL,
  `Description` text COLLATE utf8mb4_bin NOT NULL,
  `Price` double NOT NULL,
  `Menu_Photo` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `Food_Or_Drink` int(11) NOT NULL,
  `FTID` int(11) NOT NULL,
  `MI_Status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Dumping data for table `menu_items`
--

INSERT INTO `menu_items` (`MIID`, `MName`, `Description`, `Price`, `Menu_Photo`, `Food_Or_Drink`, `FTID`, `MI_Status`) VALUES
(11, 'ส้มตำปูปลาร้า', 'ส้มตำปูปลาร้าแซ่บๆ', 45, 'somtampu.jpg', 1, 5, 1),
(13, 'ไก่ทอด', 'ไก่ทอด', 35, 'chicken.jpg', 1, 5, 1);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `OID` int(11) NOT NULL,
  `OName` varchar(200) COLLATE utf8mb4_bin NOT NULL,
  `Pick_Up_Time` datetime NOT NULL,
  `Status` int(11) NOT NULL,
  `Tip_Amount` double NOT NULL,
  `Total_Paid` double NOT NULL,
  `Delivery` int(11) NOT NULL,
  `UID` int(11) NOT NULL,
  `Money_Slip` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `FTID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`OID`, `OName`, `Pick_Up_Time`, `Status`, `Tip_Amount`, `Total_Paid`, `Delivery`, `UID`, `Money_Slip`, `FTID`) VALUES
(18, 'sorawit', '2023-05-25 03:02:35', 4, 0, 45, 1, 4, 'slip.jpg', 5),
(19, 'sorawit', '2023-05-25 04:21:37', 3, 0, 45, 1, 4, 'slip.jpg', 5),
(20, 'sorawit', '2023-05-25 04:32:59', 4, 0, 80, 1, 4, 'slip.jpg', 5);

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `OIID` int(11) NOT NULL,
  `OIName` varchar(200) COLLATE utf8mb4_bin NOT NULL,
  `Quantity` double NOT NULL,
  `Price` double NOT NULL,
  `MIID` int(11) NOT NULL,
  `OID` int(11) NOT NULL,
  `Notes` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`OIID`, `OIName`, `Quantity`, `Price`, `MIID`, `OID`, `Notes`) VALUES
(11, 'ส้มตำปูปลาร้า', 1, 45, 11, 18, ''),
(12, 'ส้มตำปูปลาร้า', 1, 45, 11, 19, ''),
(13, 'ส้มตำปูปลาร้า', 1, 45, 11, 20, ''),
(14, 'ไก่ทอด', 1, 35, 13, 20, '');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `UID` int(11) NOT NULL,
  `Email` varchar(200) COLLATE utf8mb4_bin NOT NULL,
  `Password` varchar(200) COLLATE utf8mb4_bin NOT NULL,
  `Username` varchar(100) COLLATE utf8mb4_bin NOT NULL,
  `Full_Name` varchar(200) COLLATE utf8mb4_bin NOT NULL,
  `Phone_Number` varchar(20) COLLATE utf8mb4_bin NOT NULL,
  `Profile_Picture` text COLLATE utf8mb4_bin NOT NULL,
  `isRole` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UID`, `Email`, `Password`, `Username`, `Full_Name`, `Phone_Number`, `Profile_Picture`, `isRole`) VALUES
(1, 'food.truck001@example.com', 'ft001pass', 'food.truck001', 'food truck001', '11111', 'profile.jpg', 10),
(2, 'food.customer001@example.com', 'fc001pass', 'food.customer001', 'food customer001', '+667999999999', 'default.jpg', 10),
(4, 'puttasosorawit@gmail.com', '123456', 'sorawit', 'sorawit', '0955535477', 'default.jpg', 20);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`CID`);

--
-- Indexes for table `files`
--
ALTER TABLE `files`
  ADD PRIMARY KEY (`FilesID`);

--
-- Indexes for table `food_trucks`
--
ALTER TABLE `food_trucks`
  ADD PRIMARY KEY (`FTID`);

--
-- Indexes for table `menu_items`
--
ALTER TABLE `menu_items`
  ADD PRIMARY KEY (`MIID`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`OID`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`OIID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `CID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `files`
--
ALTER TABLE `files`
  MODIFY `FilesID` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `food_trucks`
--
ALTER TABLE `food_trucks`
  MODIFY `FTID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `menu_items`
--
ALTER TABLE `menu_items`
  MODIFY `MIID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `OID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `OIID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
