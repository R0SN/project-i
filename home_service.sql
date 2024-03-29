-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 29, 2024 at 09:11 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `home_service`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `email` varchar(60) NOT NULL,
  `password` char(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `email`, `password`) VALUES
(1, 'admin@gmail.com', '$2y$10$qbkSAy/jxNmXu.lwzbpLXe/j4hThv0i8vSUgjdHEsDZ6JTBSIZ/qK');

-- --------------------------------------------------------

--
-- Table structure for table `applications`
--

CREATE TABLE `applications` (
  `id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `phone` varchar(11) NOT NULL,
  `email` varchar(30) NOT NULL,
  `skill` varchar(20) NOT NULL,
  `service_area` varchar(50) NOT NULL,
  `photo` blob NOT NULL,
  `certificate` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `worker_id` int(11) NOT NULL,
  `dateTime` datetime NOT NULL,
  `status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `user_id`, `worker_id`, `dateTime`, `status`) VALUES
(17, 27, 41, '2024-03-28 11:21:00', 1),
(18, 27, 41, '2024-03-29 03:32:00', NULL),
(19, 27, 47, '2024-03-28 13:43:00', 2);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `location` varchar(50) NOT NULL,
  `password` char(60) NOT NULL,
  `phone` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `location`, `password`, `phone`) VALUES
(27, 'User', 'user@gmail.com', 'kathmandu', '$2y$10$1jUhJ91yZogl4bxZ4pUP9ew5u3R1XqEcbu6K0wfaZDkQLv7p4MdMW', '9808332133');

-- --------------------------------------------------------

--
-- Table structure for table `workers`
--

CREATE TABLE `workers` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `phone` varchar(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `skill` varchar(50) NOT NULL,
  `service_area` varchar(50) NOT NULL,
  `photo` blob NOT NULL,
  `certificate` blob NOT NULL,
  `password` char(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `workers`
--

INSERT INTO `workers` (`id`, `name`, `phone`, `email`, `skill`, `service_area`, `photo`, `certificate`, `password`) VALUES
(41, 'worker', '9873772341', 'work@gmail.com', 'electrician', 'kathmandu', 0x5f35653932636137362d353231302d343737372d613039612d3032666634623265396665382e6a7067, 0x6376722e706466, '$2y$10$4lt6c0.zWlJI.Kx.cGtCEO4NYIyaEOsl6bxvmgAWH81fPRyDPlx.K'),
(47, '123', '9816749027', '123@gmail.com', 'interior_design', 'koteshwor', 0x5f34343666333336612d656135632d343861662d613632642d3630343635343961656639382e6a7067, 0x5f61663462356239622d616165352d346462612d383435372d6337386135633064623461302e6a7067, '$2y$10$PeP4MYrvwN2/p8M4yy/uV.0oTwt9Ky6K8qvJbi0vLuNUsuPiJ0qPK');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `applications`
--
ALTER TABLE `applications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `worker_id` (`worker_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `workers`
--
ALTER TABLE `workers`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `applications`
--
ALTER TABLE `applications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `workers`
--
ALTER TABLE `workers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`worker_id`) REFERENCES `workers` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
