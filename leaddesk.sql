-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 05, 2022 at 11:24 AM
-- Server version: 10.5.16-MariaDB-cll-lve
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u626443699_leaddesk`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `Id` bigint(20) NOT NULL,
  `UserId` int(11) NOT NULL,
  `AttendanceDate` date NOT NULL,
  `CheckInTime` datetime DEFAULT NULL,
  `CheckOutTime` datetime DEFAULT NULL,
  `LessTimeReason` varchar(150) DEFAULT NULL,
  `DailyWorkingTimeInMin` int(11) DEFAULT NULL,
  `CompanyId` int(11) DEFAULT NULL,
  `AllowOfficeLessTime` int(11) DEFAULT NULL,
  `IsLeave` bit(1) DEFAULT NULL,
  `CheckInTimeFile` varchar(255) DEFAULT NULL,
  `CheckOutTimeFile` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`Id`, `UserId`, `AttendanceDate`, `CheckInTime`, `CheckOutTime`, `LessTimeReason`, `DailyWorkingTimeInMin`, `CompanyId`, `AllowOfficeLessTime`, `IsLeave`, `CheckInTimeFile`, `CheckOutTimeFile`) VALUES
(23, 55, '2022-11-30', '2022-11-30 05:56:33', '2022-11-30 06:06:16', '', 0, 58, 0, NULL, '2f77cf87-a4ec-46cd-8d20-97b44aaf0f2e.jpg', '3079ea49-f255-4bc6-80a1-e7396d445266.jpg'),
(24, 55, '2022-12-01', '2022-12-01 13:27:52', '2022-12-01 21:27:20', '', 0, 58, 0, NULL, '4188e20f-64b2-4b4e-84d0-dcf87b7e3356.jpg', '5b6e4651-ca04-4901-a94d-f49b79851df0.jpg'),
(25, 55, '2022-12-02', '2022-12-02 05:59:36', '2022-12-02 06:23:27', '', 0, 58, 0, NULL, '441ba51e-b1cd-4ea8-8569-190562f333a0.jpg', 'f3a2153b-bf3b-449f-bdc8-37dc8c42299c.jpg'),
(26, 55, '2022-12-04', '2022-12-04 08:30:52', '2022-12-04 19:15:34', '', 0, 58, 0, NULL, '92a27ce2-39bc-405f-b2e2-58e59ac3a7f2.jpg', 'ac7d1246-fdc7-4d37-8736-d969f8847cd1.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `company`
--

CREATE TABLE `company` (
  `Id` int(11) NOT NULL,
  `PortalUserId` int(11) NOT NULL,
  `CompanyName` varchar(200) NOT NULL,
  `Address` varchar(300) DEFAULT NULL,
  `PhoneNumber` varchar(12) NOT NULL,
  `ImageFileName` varchar(150) DEFAULT NULL,
  `ImageFileId` varchar(100) DEFAULT NULL,
  `CreatedDate` datetime DEFAULT NULL,
  `MaximumOfficeHours` time DEFAULT NULL,
  `OfficeOutTime` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `company`
--

INSERT INTO `company` (`Id`, `PortalUserId`, `CompanyName`, `Address`, `PhoneNumber`, `ImageFileName`, `ImageFileId`, `CreatedDate`, `MaximumOfficeHours`, `OfficeOutTime`) VALUES
(58, 53, 'TeamCubers', NULL, '03361136808', NULL, NULL, NULL, NULL, NULL),
(59, 54, 'Abc', NULL, '03351371853', NULL, NULL, NULL, NULL, NULL),
(60, 56, 'New Company', NULL, '123456789', NULL, NULL, NULL, NULL, NULL),
(61, 58, 'TEt comp', NULL, '132465', NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `Id` int(11) NOT NULL,
  `pid` int(11) NOT NULL DEFAULT 0,
  `CompanyId` int(11) NOT NULL,
  `DepartmentName` varchar(150) NOT NULL,
  `display_order` int(255) NOT NULL DEFAULT 0,
  `CreateDate` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`Id`, `pid`, `CompanyId`, `DepartmentName`, `display_order`, `CreateDate`) VALUES
(11, 0, 58, 'UI Team', 0, '2022-11-27 19:42:31'),
(12, 0, 60, 'It', 0, '2022-11-28 05:43:06'),
(13, 11, 58, 'Graphics Designer', 0, '2022-12-01 16:43:20');

-- --------------------------------------------------------

--
-- Table structure for table `employeeuser`
--

CREATE TABLE `employeeuser` (
  `Id` int(11) NOT NULL,
  `UserName` varchar(30) NOT NULL,
  `Designation` varchar(30) NOT NULL,
  `CompanyId` int(11) NOT NULL,
  `DepartmentId` int(11) NOT NULL,
  `PhoneNumber` varchar(12) NOT NULL,
  `ImageFileName` varchar(200) DEFAULT NULL,
  `ImageFileId` varchar(50) DEFAULT NULL,
  `UserId` int(11) NOT NULL,
  `IsAutoCheckPoint` bit(1) NOT NULL,
  `AutoCheckPointTime` varchar(10) DEFAULT NULL,
  `MaximumOfficeHours` varchar(10) DEFAULT NULL,
  `OfficeOutTime` varchar(10) DEFAULT NULL,
  `CreateDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `IsActive` bit(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `employeeuser`
--

INSERT INTO `employeeuser` (`Id`, `UserName`, `Designation`, `CompanyId`, `DepartmentId`, `PhoneNumber`, `ImageFileName`, `ImageFileId`, `UserId`, `IsAutoCheckPoint`, `AutoCheckPointTime`, `MaximumOfficeHours`, `OfficeOutTime`, `CreateDate`, `IsActive`) VALUES
(21, 'Burhanuddin Shabbar', 'Junior Developer', 58, 11, '03361136807', '862f726f-46da-4206-9676-01adab89a81e.png', '', 55, b'1', '', '8:00:00', '00:30:00', '2022-11-28 07:34:16', b'1'),
(22, 'New Employee', 'Developer', 60, 12, '852147963', NULL, NULL, 57, b'1', '1:00:00', '8:00:00', '00:30:00', '2022-11-28 07:34:16', b'1'),
(23, 'Abdul Rehman', 'Junior UI Assitant', 58, 11, '0331136806', 'null', '', 59, b'1', '1:00:00', '8:00:00', '00:30:00', '2022-12-01 06:07:59', b'1'),
(24, 'John', 'Manager', 58, 11, '123456789', NULL, NULL, 60, b'1', '1:00:00', '8:00:00', '00:30:00', '2022-12-01 06:34:26', b'1'),
(25, 'Waleed Andari', 'Pune', 58, 11, '03361136806', NULL, NULL, 61, b'1', '1:00:00', '8:00:00', '00:30:00', '2022-12-01 21:31:17', b'1');

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
(13, 58, 21, '2022-11-29 12:08:35', '2022-11-30 12:08:35', 0, 1, 'I have a urgent emergency', '2022-12-29 11:17:07', 1, 0, NULL, '53', '2022-11-30 08:15:44'),
(14, 58, 21, '2022-12-02 02:29:09', '2022-12-03 02:29:09', 0, 2, 'im having fever', '0000-00-00 00:00:00', 0, 1, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `noticeboard`
--

CREATE TABLE `noticeboard` (
  `Id` int(128) NOT NULL,
  `Details` varchar(250) DEFAULT NULL,
  `PostingDate` datetime NOT NULL,
  `ImageFileName` varchar(200) DEFAULT NULL,
  `CreatedBy` varchar(128) NOT NULL,
  `CreatedDate` datetime NOT NULL,
  `CompanyId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `noticeboard`
--

INSERT INTO `noticeboard` (`Id`, `Details`, `PostingDate`, `ImageFileName`, `CreatedBy`, `CreatedDate`, `CompanyId`) VALUES
(19, 'TEst', '2022-11-28 06:07:30', 'f5287910-61d6-45ed-b6eb-cbbaf7c74ed0.jpg', '57', '2022-11-28 06:07:30', 60),
(20, 'Have any one got this?', '2022-11-28 09:13:49', 'e3951c7a-b11f-4e9b-91b3-0b9b8f79a7a8.jpg', '55', '2022-11-28 09:13:49', 58),
(21, 'Test', '2022-11-28 10:22:25', '6d166a69-998e-4030-9e56-ad6067d0919e.jpg', '53', '2022-11-28 10:22:25', 58),
(22, 'Te', '2022-11-30 07:26:17', '91ac1b3d-bf10-49f7-8202-6fc3109d0eeb.jpg', '55', '2022-11-30 07:26:17', 58),
(23, 'NEW', '2022-11-30 07:27:41', 'eb7637a4-2640-4dfb-9797-2b1d0c19e752.jpg', '55', '2022-11-30 07:27:41', 58),
(24, 'TEst', '2022-11-30 07:28:16', 'f424a4e6-2901-4ab6-b682-e52aeead7586.jpg', '55', '2022-11-30 07:28:16', 58),
(25, 'tfguygu', '2022-11-30 07:29:38', '2b5e97f4-f33b-4fa2-b6a4-cb9fee311950.jpg', '55', '2022-11-30 07:29:38', 58),
(26, 'TEst', '2022-12-01 05:42:50', 'b3c85aa9-538a-49f3-a696-0f3c45c60071.jpg', '55', '2022-12-01 05:42:50', 58);

-- --------------------------------------------------------

--
-- Table structure for table `task`
--

CREATE TABLE `task` (
  `Id` int(11) NOT NULL,
  `Title` text NOT NULL,
  `Description` text DEFAULT NULL,
  `CreatedById` int(11) DEFAULT NULL,
  `CreatedAt` datetime DEFAULT NULL,
  `StatusId` int(11) DEFAULT NULL,
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

INSERT INTO `task` (`Id`, `Title`, `Description`, `CreatedById`, `CreatedAt`, `StatusId`, `AssignedToId`, `DueDate`, `CompanyId`, `TaskNo`, `PriorityId`, `UpdatedById`, `UpdatedAt`) VALUES
(9, 'Visit P&G', 'talk to procurement ', 55, '2022-11-28 09:12:34', 4, '55', '2022-11-28 00:00:00', 58, 1, 1, '55', '2022-11-30 07:00:04'),
(10, 'Visit Engro', 'visit the procurement department and get invoices', 53, '2022-11-28 09:19:31', 2, '55', '2022-11-28 00:00:00', 58, 2, 1, '53', '2022-11-30 08:13:51'),
(12, 'Test', 'Test', 55, '2022-12-01 05:41:43', 1, '55', '2022-12-01 00:00:00', 58, 3, 2, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `taskattachments`
--

CREATE TABLE `taskattachments` (
  `Id` int(11) NOT NULL,
  `TaskId` int(11) NOT NULL,
  `FileName` varchar(150) NOT NULL,
  `BlobName` varchar(50) DEFAULT NULL,
  `UpdatedAt` datetime NOT NULL,
  `UpdatedById` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `taskattachments`
--

INSERT INTO `taskattachments` (`Id`, `TaskId`, `FileName`, `BlobName`, `UpdatedAt`, `UpdatedById`) VALUES
(22, 8, 'fd840f5b-b4d2-441c-9cb3-f6b80247f2db.jpg', 'fd840f5b-b4d2-441c-9cb3-f6b80247f2db.jpg', '2022-11-28 06:06:13', '57'),
(24, 12, '7018cd2c-232f-4f3e-aa5e-0abadbf47073.jpg', '7018cd2c-232f-4f3e-aa5e-0abadbf47073.jpg', '2022-12-01 05:41:43', '55');

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

INSERT INTO `usercredentials` (`Id`, `FullName`, `Email`, `ContactNo`, `LoginID`, `Password`, `UserTypeId`, `IsActive`, `CreatedAt`, `Theme`, `OrganizationId`, `Gender`, `Token`) VALUES
(53, 'Hussain Mustafa', 'Mayocube@gmail.com', '03361136808', '03361136808', '$2y$10$h0YdcIkn4DZ/0CM5qG823OJPv0KGYygvYoa74F0SKkaBoFWDJQLyG', 0, b'1', '2022-11-26 13:47:38', NULL, NULL, 'Male', 'ExponentPushToken[uoYf9oGx7Uej2rbdELTXGu]'),
(54, 'Burhanuddin', 'burhanshabbar29@gmail.com', '03351371853', '03351371853', '$2y$10$dGUvIYsEq0YzSty6xt6XLe14tqUxufovIEfbOrTVkHKeXKws3zg3q', 0, b'1', '2022-11-27 08:25:43', NULL, NULL, 'Male', NULL),
(55, 'Burhanuddin Shabbar', 'sp19bscs0096@maju.edu.pk', '03361136807', '03361136807', '$2y$10$uLXi8WFvCNCN9FQXy1zdw.Zd5znWLLbNs00pUhX2aIlfePmWUekBq', 1, b'1', '2022-11-27 19:43:26', NULL, NULL, 'Male', 'ExponentPushToken[uoYf9oGx7Uej2rbdELTXGu]'),
(56, 'new admin', 'new@admin.com', '123456789', '123456789', '$2y$10$N/oQoRmnHY3qcu/7b5hBKeRQfoOdX4YfTMnymOXjy0MTtAyyufzfq', 0, b'1', '2022-11-28 05:32:19', NULL, NULL, 'Male', 'ExponentPushToken[p7MORHDQ2u65gvZlEGTfCk]'),
(57, 'New Employee', 'new@employee.com', '852147963', '852147963', '$2y$10$hMjnKOdHr818YqCvZgDMc.t21ya2xqICOB0vt1dm1RB.J9gOmqseK', 1, b'1', '2022-11-28 05:44:25', NULL, NULL, 'Male', 'ExponentPushToken[p7MORHDQ2u65gvZlEGTfCk]'),
(58, 'Test', 'test@test.com', '132465', '132465', '$2y$10$p4ac8YTfHyn.NIcAqDhCyOcNdwFg.9RPmejjoSw5cyTecxPJBY9T.', 0, b'1', '2022-11-30 10:15:15', NULL, NULL, 'Male', NULL),
(59, 'Abdul Rehman', 'cubeserver53@gmail.com', '0331136806', '0331136806', '$2y$10$hekR3ItS3IG8yW9TdOk4C.9ydc2SpVMzEC5TS4ofoSQPUdw0WQKI.', 1, b'1', '2022-12-01 06:07:59', NULL, NULL, 'Male', NULL),
(60, 'John', 'john@test.com', '123456789', '123456789', '$2y$10$rI/Lrwi9R6/PC8F1rqk6GuHS2a28nw5uDS4BxbeqUvw2J88rkKody', 1, b'1', '2022-12-01 06:34:26', NULL, NULL, 'Male', NULL),
(61, 'Waleed Andari', 'sp19bscs0096@maju.edu.pk', '03361136806', '03361136806', '$2y$10$ak6mR/jgrSDJgQsog7Y0G./RNzBfJk0dGrf/vaz.rK33PiG.5T.EW', 1, b'1', '2022-12-01 21:31:17', NULL, NULL, 'Male', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `usermovementlog`
--

CREATE TABLE `usermovementlog` (
  `Id` int(11) NOT NULL,
  `UserId` int(11) NOT NULL,
  `LogDateTime` datetime NOT NULL,
  `Latitude` float DEFAULT NULL,
  `Longitude` float DEFAULT NULL,
  `LogLocation` text DEFAULT NULL,
  `IsCheckedInPoint` int(1) DEFAULT NULL,
  `IsCheckedOutPoint` int(1) DEFAULT NULL,
  `DeviceName` varchar(50) DEFAULT NULL,
  `DeviceOSVersion` varchar(50) DEFAULT NULL,
  `CompanyId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `usermovementlog`
--

INSERT INTO `usermovementlog` (`Id`, `UserId`, `LogDateTime`, `Latitude`, `Longitude`, `LogLocation`, `IsCheckedInPoint`, `IsCheckedOutPoint`, `DeviceName`, `DeviceOSVersion`, `CompanyId`) VALUES
(65, 55, '2022-11-30 05:56:33', 24.8608, 67.071, 'Karachi, Pakistan', 1, 0, '', '31', 58),
(67, 55, '2022-11-30 06:05:38', 24.8608, 67.071, 'Karachi, Pakistan', 0, 0, '', '31', 58),
(68, 55, '2022-11-30 06:06:02', 24.8608, 67.071, 'Karachi, Pakistan', 0, 0, '', '31', 58),
(69, 55, '2022-11-30 06:06:16', 24.8608, 67.071, 'Karachi, Pakistan', 0, 1, '', '31', 58),
(76, 55, '2022-12-01 13:27:52', 24.9383, 67.0428, 'Karachi, Pakistan', 1, 0, '', '31', 58),
(78, 55, '2022-12-01 14:22:53', 24.9383, 67.0428, 'Karachi, Pakistan', 0, 0, '', '31', 58),
(79, 55, '2022-12-01 15:17:16', 24.9382, 67.0427, 'Karachi, Pakistan', 0, 0, '', '29', 58),
(80, 55, '2022-12-01 15:20:10', 24.9261, 67.0332, 'null', 0, 0, '', '29', 58),
(82, 55, '2022-12-01 15:20:19', 24.9249, 67.0327, 'Karachi, Pakistan', 0, 0, '', '29', 58),
(85, 55, '2022-12-01 21:27:20', 24.9352, 67.04, 'Karachi, Pakistan', 0, 1, '', '31', 58),
(86, 55, '2022-12-02 05:59:36', 37.4221, -122.084, 'Amphitheatre Parkway, Mountain View, United States', 1, 0, '', '28', 58),
(87, 55, '2022-12-02 06:06:47', 30.2915, 67.0054, 'Unnamed Road, Quetta, Pakistan', 0, 0, '', '28', 58),
(88, 55, '2022-12-02 06:10:32', 30.2915, 67.0054, 'Unnamed Road, Quetta, Pakistan', 0, 0, '', '28', 58),
(89, 55, '2022-12-02 06:13:46', 30.2915, 67.0054, 'Unnamed Road, Quetta, Pakistan', 0, 0, '', '28', 58),
(90, 55, '2022-12-02 06:16:52', 30.2915, 67.0054, 'Unnamed Road, Quetta, Pakistan', 0, 0, '', '28', 58),
(91, 55, '2022-12-02 06:18:27', 30.2915, 67.0054, 'Unnamed Road, Quetta, Pakistan', 0, 0, '', '28', 58),
(92, 55, '2022-12-02 06:19:10', 30.2915, 67.0054, 'Unnamed Road, Quetta, Pakistan', 0, 0, '', '28', 58),
(93, 55, '2022-12-02 06:23:27', 30.2915, 67.0054, 'Unnamed Road, Quetta, Pakistan', 0, 1, '', '28', 58),
(94, 55, '2022-12-04 08:30:52', 24.8604, 67.0699, 'Karachi, Pakistan', 1, 0, '', '31', 58),
(95, 55, '2022-12-04 19:15:34', 24.9352, 67.04, 'Karachi, Pakistan', 0, 1, '', '31', 58);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `UserId` (`UserId`),
  ADD KEY `CompanyId` (`CompanyId`);

--
-- Indexes for table `company`
--
ALTER TABLE `company`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `PortalUserId` (`PortalUserId`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `CompanyId` (`CompanyId`);

--
-- Indexes for table `employeeuser`
--
ALTER TABLE `employeeuser`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `UserId` (`UserId`),
  ADD KEY `CompanyId` (`CompanyId`);

--
-- Indexes for table `leaveapplication`
--
ALTER TABLE `leaveapplication`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `EmployeeId` (`EmployeeId`),
  ADD KEY `CompanyId` (`CompanyId`);

--
-- Indexes for table `noticeboard`
--
ALTER TABLE `noticeboard`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `CompanyId` (`CompanyId`);

--
-- Indexes for table `task`
--
ALTER TABLE `task`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `CompanyId` (`CompanyId`);

--
-- Indexes for table `taskattachments`
--
ALTER TABLE `taskattachments`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `TaskId` (`TaskId`);

--
-- Indexes for table `usercredentials`
--
ALTER TABLE `usercredentials`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `usermovementlog`
--
ALTER TABLE `usermovementlog`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `UserId` (`UserId`,`CompanyId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `Id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `company`
--
ALTER TABLE `company`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `employeeuser`
--
ALTER TABLE `employeeuser`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `leaveapplication`
--
ALTER TABLE `leaveapplication`
  MODIFY `Id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `noticeboard`
--
ALTER TABLE `noticeboard`
  MODIFY `Id` int(128) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `task`
--
ALTER TABLE `task`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `taskattachments`
--
ALTER TABLE `taskattachments`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `usercredentials`
--
ALTER TABLE `usercredentials`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `usermovementlog`
--
ALTER TABLE `usermovementlog`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=96;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attendance`
--
ALTER TABLE `attendance`
  ADD CONSTRAINT `attendance_ibfk_1` FOREIGN KEY (`UserId`) REFERENCES `employeeuser` (`UserId`) ON DELETE CASCADE;

--
-- Constraints for table `company`
--
ALTER TABLE `company`
  ADD CONSTRAINT `company_ibfk_1` FOREIGN KEY (`PortalUserId`) REFERENCES `usercredentials` (`Id`) ON DELETE CASCADE;

--
-- Constraints for table `department`
--
ALTER TABLE `department`
  ADD CONSTRAINT `department_ibfk_1` FOREIGN KEY (`CompanyId`) REFERENCES `company` (`Id`) ON DELETE CASCADE;

--
-- Constraints for table `employeeuser`
--
ALTER TABLE `employeeuser`
  ADD CONSTRAINT `employeeuser_ibfk_1` FOREIGN KEY (`UserId`) REFERENCES `usercredentials` (`Id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `leaveapplication`
--
ALTER TABLE `leaveapplication`
  ADD CONSTRAINT `leaveapplication_ibfk_1` FOREIGN KEY (`CompanyId`) REFERENCES `company` (`Id`) ON DELETE CASCADE;

--
-- Constraints for table `noticeboard`
--
ALTER TABLE `noticeboard`
  ADD CONSTRAINT `noticeboard_ibfk_1` FOREIGN KEY (`CompanyId`) REFERENCES `company` (`Id`) ON DELETE CASCADE;

--
-- Constraints for table `usermovementlog`
--
ALTER TABLE `usermovementlog`
  ADD CONSTRAINT `usermovementlog_ibfk_1` FOREIGN KEY (`UserId`) REFERENCES `employeeuser` (`UserId`) ON DELETE CASCADE ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
