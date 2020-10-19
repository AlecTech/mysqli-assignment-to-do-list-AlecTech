-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 19, 2020 at 04:17 AM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `to_do_list`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `catID` int(11) NOT NULL,
  `name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`catID`, `name`) VALUES
(1, 'Chores'),
(2, 'Homework');

-- --------------------------------------------------------

--
-- Table structure for table `todos`
--

CREATE TABLE `todos` (
  `id` int(11) NOT NULL,
  `todoTitle` varchar(200) NOT NULL,
  `checked` tinyint(1) NOT NULL DEFAULT 0,
  `date` datetime NOT NULL DEFAULT current_timestamp(),
  `duedate` date DEFAULT NULL,
  `catID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `todos`
--

INSERT INTO `todos` (`id`, `todoTitle`, `checked`, `date`, `duedate`, `catID`) VALUES
(3, 'take a nap and bath', 0, '2020-10-15 19:22:32', '2020-10-16', 1),
(5, 'finish assignment', 0, '2020-10-15 19:24:08', '2020-10-30', 2),
(8, 'go work out', 0, '2020-10-15 19:24:16', '2020-11-03', 2),
(9, 'start BBQ', 0, '2020-10-16 13:10:38', '2020-11-11', 1),
(10, 'Find a real job', 0, '2020-10-17 14:47:20', '2020-10-30', 1),
(11, 'Build a website', 0, '2020-10-17 14:49:11', '2020-10-27', 2),
(12, 'Fix a furnace', 1, '2020-10-17 14:54:34', '2020-10-15', 1),
(13, 'Read a book', 0, '2020-10-17 15:06:50', '2020-10-23', 1),
(14, 'Put kids to bed', 0, '2020-10-17 15:16:35', '2020-10-22', 1),
(15, 'Finish painting', 1, '2020-10-17 15:19:20', '2020-10-26', 2),
(18, 'buy sushi', 1, '2020-10-17 16:45:54', '2020-10-16', 1),
(21, 'Call mother', 0, '2020-10-18 18:42:22', '2020-10-29', 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`catID`);

--
-- Indexes for table `todos`
--
ALTER TABLE `todos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `test` (`catID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `catID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `todos`
--
ALTER TABLE `todos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `todos`
--
ALTER TABLE `todos`
  ADD CONSTRAINT `test` FOREIGN KEY (`catID`) REFERENCES `categories` (`catID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
