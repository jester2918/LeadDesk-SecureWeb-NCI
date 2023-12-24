-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 24, 2023 at 02:26 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `leaddesk`
--

-- --------------------------------------------------------

--
-- Table structure for table `company`
--

CREATE TABLE `company` (
  `Id` int(11) NOT NULL,
  `PortalUserId` varchar(128) NOT NULL,
  `CompanyName` varchar(200) NOT NULL,
  `Address` varchar(300) DEFAULT NULL,
  `PhoneNumber` varchar(12) NOT NULL,
  `CreatedDate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `company`
--

INSERT INTO `company` (`Id`, `PortalUserId`, `CompanyName`, `Address`, `PhoneNumber`, `CreatedDate`) VALUES
(58, '63', 'TeamCubers', '7 adrreig close adamstown lucan ', '03361136808', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `Id` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `CompanyId` int(11) NOT NULL,
  `DepartmentName` varchar(150) NOT NULL,
  `display_order` int(255) NOT NULL DEFAULT 0,
  `CreateDate` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`Id`, `pid`, `CompanyId`, `DepartmentName`, `display_order`, `CreateDate`) VALUES
(12, 0, 60, 'It', 0, '2022-11-28 05:43:06'),
(20, 0, 58, 'UI / UX Team', 0, '2023-12-22 15:35:05'),
(21, 0, 58, 'Backend Team', 0, '2023-12-22 15:35:15');

-- --------------------------------------------------------

--
-- Table structure for table `leaveapplication`
--

CREATE TABLE `leaveapplication` (
  `Id` bigint(20) NOT NULL,
  `CompanyId` int(11) NOT NULL,
  `EmployeeId` int(11) NOT NULL,
  `FromDate` datetime DEFAULT NULL,
  `ToDate` datetime DEFAULT NULL,
  `IsHalfDay` int(1) DEFAULT NULL,
  `LeaveTypeId` int(11) NOT NULL,
  `LeaveReason` varchar(150) DEFAULT NULL,
  `CreatedAt` datetime NOT NULL,
  `IsApproved` int(1) DEFAULT NULL,
  `IsRejected` int(1) DEFAULT NULL,
  `RejectReason` varchar(150) DEFAULT NULL,
  `ApprovedById` text DEFAULT NULL,
  `ApprovedAt` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `leaveapplication`
--

INSERT INTO `leaveapplication` (`Id`, `CompanyId`, `EmployeeId`, `FromDate`, `ToDate`, `IsHalfDay`, `LeaveTypeId`, `LeaveReason`, `CreatedAt`, `IsApproved`, `IsRejected`, `RejectReason`, `ApprovedById`, `ApprovedAt`) VALUES
(23, 58, 65, '2023-12-23 00:00:00', '2023-12-23 00:00:00', 1, 1, 'Give Me Chutti Dear', '0000-00-00 00:00:00', 1, 0, NULL, '53', '2023-12-22 16:44:49'),
(24, 58, 64, '2023-12-24 00:00:00', '2023-12-30 00:00:00', 1, 1, 'I want a Christmas holiday', '0000-00-00 00:00:00', 0, 1, NULL, NULL, NULL),
(25, 58, 66, '2023-12-25 00:00:00', '2023-12-31 00:00:00', 1, 1, 'Please give me  holiday', '0000-00-00 00:00:00', 0, 0, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `task`
--

CREATE TABLE `task` (
  `Id` int(11) NOT NULL,
  `Title` text NOT NULL,
  `Description` text DEFAULT NULL,
  `CreatedById` text DEFAULT NULL,
  `CreatedAt` datetime DEFAULT NULL,
  `StatusId` int(11) DEFAULT NULL,
  `TaskGroupId` int(11) DEFAULT NULL,
  `AssignedToId` text DEFAULT NULL,
  `DueDate` datetime DEFAULT NULL,
  `CompanyId` int(11) DEFAULT NULL,
  `TaskNo` int(11) DEFAULT NULL,
  `PriorityId` int(11) DEFAULT NULL,
  `UpdatedById` text DEFAULT NULL,
  `UpdatedAt` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `task`
--

INSERT INTO `task` (`Id`, `Title`, `Description`, `CreatedById`, `CreatedAt`, `StatusId`, `TaskGroupId`, `AssignedToId`, `DueDate`, `CompanyId`, `TaskNo`, `PriorityId`, `UpdatedById`, `UpdatedAt`) VALUES
(22, 'This needs to be done', 'Admin your part', '66', '2023-12-22 22:15:27', 1, NULL, '53', '2023-12-30 00:00:00', 58, 1, 2, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `usercredentials`
--

CREATE TABLE `usercredentials` (
  `Id` int(11) NOT NULL,
  `FullName` text NOT NULL,
  `Email` varchar(50) NOT NULL,
  `ContactNo` varchar(50) NOT NULL,
  `LoginID` varchar(50) DEFAULT NULL,
  `Password` varchar(255) NOT NULL,
  `UserTypeId` int(11) NOT NULL,
  `DepartmentId` int(11) DEFAULT NULL,
  `IsActive` bit(1) NOT NULL,
  `CreatedAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `Theme` int(11) DEFAULT NULL,
  `OrganizationId` text DEFAULT NULL,
  `Gender` varchar(255) DEFAULT NULL,
  `Token` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `usercredentials`
--

INSERT INTO `usercredentials` (`Id`, `FullName`, `Email`, `ContactNo`, `LoginID`, `Password`, `UserTypeId`, `DepartmentId`, `IsActive`, `CreatedAt`, `Theme`, `OrganizationId`, `Gender`, `Token`) VALUES
(53, 'Burhanuddin Shabbar', 'Mayocube@gmail.com', '03361136808', '03361136808', '$2y$10$3OVyGjku3boljE3x7OCms.1W/INQCD76AlxNK9Q0oz9acVkB6hptS', 0, 0, b'1', '2022-11-26 13:47:38', NULL, '58', 'Male', 'ExponentPushToken[E2ErSbCaIMxH_d1VxVLPHd]'),
(64, 'John ', 'johndeo@gmail.com', '03351371853', '03351371853', '$2y$10$n4.3Zy5.wth1IK0cL4WBHes3d5UKCGjgJLxHd9.2uC77mp5o4bYRq', 1, 20, b'1', '2023-12-22 15:38:26', NULL, '58', 'Male', NULL),
(65, 'Alex Adams', 'alexadams@gmail.com', '03351371852', '03351371852', '$2y$10$piocxIXW/MkeAzwBwlXVX.TYbLDKuB3anst4AbC7q7Z0TDqoZ4rmG', 1, 21, b'1', '2023-12-22 15:39:37', NULL, '58', 'Male', NULL),
(66, 'John Wick ', 'johnwick@gmail.com', '03361136805', '03361136805', '$2y$10$gvCas2hDU87QmV9oHKr9EuNi9..M4Bj2KB4JZgOinBdQtqqQJpN3G', 1, 21, b'1', '2023-12-22 22:13:10', NULL, '58', 'Male', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `company`
--
ALTER TABLE `company`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `leaveapplication`
--
ALTER TABLE `leaveapplication`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `task`
--
ALTER TABLE `task`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `usercredentials`
--
ALTER TABLE `usercredentials`
  ADD PRIMARY KEY (`Id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `company`
--
ALTER TABLE `company`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `leaveapplication`
--
ALTER TABLE `leaveapplication`
  MODIFY `Id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `task`
--
ALTER TABLE `task`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `usercredentials`
--
ALTER TABLE `usercredentials`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
