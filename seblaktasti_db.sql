-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 28, 2024 at 10:34 AM
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
-- Database: `seblaktasti_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(225) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`, `created_at`) VALUES
(1, 'testuser', 'hashedpassword', '2024-12-25 10:34:54'),
(2, 'admin', 'admin', '2024-12-25 10:35:26');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `order_date` datetime DEFAULT current_timestamp(),
  `total_price` decimal(10,2) DEFAULT NULL,
  `payment_method` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `order_date`, `total_price`, `payment_method`) VALUES
(1, '2024-12-25 16:23:14', 15000.00, 'asd'),
(2, '2024-12-25 16:42:06', 75000.00, 'QRIS'),
(3, '2024-12-25 17:57:07', 25000.00, 'QRIS'),
(4, '2024-12-25 17:58:57', 30000.00, 'QRIS'),
(5, '2024-12-25 18:26:55', 20000.00, 'asd'),
(9, '2024-12-25 18:36:49', 75000.00, 'Cash'),
(10, '2024-12-25 18:41:00', 40000.00, 'asdqwe'),
(11, '2024-12-25 18:42:14', 40000.00, 'asdqwe'),
(12, '2024-12-25 18:43:08', 40000.00, 'asdqwe'),
(13, '2024-12-25 18:48:17', 45000.00, 'asdas'),
(14, '2024-12-25 18:50:34', 60000.00, 'asdas'),
(15, '2024-12-25 18:56:33', 45000.00, 'okok'),
(16, '2024-12-26 04:18:34', 115000.00, 'QRIS'),
(17, '2024-12-26 04:53:49', 10000.00, 'QRIS'),
(18, '2024-12-26 04:57:27', 80000.00, 'QRIS'),
(19, '2024-12-26 04:59:20', 75000.00, 'qwewqe'),
(20, '2024-12-26 05:00:14', 50000.00, 'asdas'),
(21, '2024-12-26 05:02:21', 85000.00, '12312'),
(22, '2024-12-26 05:05:07', 10000.00, 'Credit Card'),
(23, '2024-12-26 05:54:05', 30000.00, 'Debit'),
(24, '2024-12-26 06:20:29', 200000.00, 'QRIS'),
(25, '2024-12-26 06:23:16', 25000.00, 'QRIS'),
(26, '2024-12-26 07:25:17', 30000.00, 'Cash'),
(27, '2024-12-26 07:41:47', 45000.00, 'QRIS');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `price_per_item` decimal(10,2) DEFAULT NULL,
  `total_price` decimal(10,2) DEFAULT NULL,
  `payment_method` varchar(50) DEFAULT NULL,
  `product_category` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_category` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `product_price` decimal(10,2) NOT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `product_description` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stok`
--

CREATE TABLE `stok` (
  `id` int(11) NOT NULL,
  `item_name` varchar(50) NOT NULL,
  `quantity` int(11) NOT NULL,
  `total_price` int(11) NOT NULL,
  `Added` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `stok`
--

INSERT INTO `stok` (`id`, `item_name`, `quantity`, `total_price`, `Added`) VALUES
(2, 'SUSU STMJ', 10, 10000, '2024-12-25 13:54:24'),
(3, 'coca cola', 20, 20000, '2024-12-25 15:11:30'),
(4, 'Kerupuk Orange', 2, 100000, '2024-12-26 07:39:56');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(225) NOT NULL,
  `register_date` datetime NOT NULL,
  `email` varchar(60) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `register_date`, `email`) VALUES
(1, 'Client123', '$2y$10$DeVJCERQMIWE8/7mxl2FI.XpHBWyFUQUBldiFMPcBRf/19b3cjB96', '0000-00-00 00:00:00', NULL),
(2, 'nahrul123', '$2y$10$3uFAk4GrLnyaAkrnM.hRceV.SQzhPmX3pkBA5ZG7PbX3TdpnQG38O', '2024-12-25 14:53:48', NULL),
(3, 'uwi123', '$2y$10$228zdiDnKXzpgwPgZowucurqzsKn9CfddUbQB/EnttWnlYUFTyUnW', '2024-12-25 15:28:17', 'uwithelifter@gmail.com'),
(4, 'admin', 'admin', '0000-00-00 00:00:00', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `stok`
--
ALTER TABLE `stok`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `stok`
--
ALTER TABLE `stok`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
