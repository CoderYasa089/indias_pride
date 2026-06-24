-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 24, 2026 at 06:58 PM
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
-- Database: `indias_pride_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `booking_date` date NOT NULL,
  `booking_time` time NOT NULL,
  `num_guests` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `name`, `phone`, `email`, `booking_date`, `booking_time`, `num_guests`, `created_at`) VALUES
(1, 'YASA CHRISTIAN', '9382775643', 'yasashirish2356@gmail.com', '2025-10-21', '00:10:00', 2, '2025-10-11 04:41:11'),
(2, 'neeraj', '8082351228', 'yasashirish2356@gmail.com', '2025-10-21', '00:25:00', 4, '2025-10-11 05:56:44'),
(3, 'YASA SHIRISH', '09313855223', 'yasachristian1906@gmail.com', '2025-11-12', '11:29:00', 2, '2025-11-03 05:59:09');

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `id` int(11) NOT NULL,
  `category` varchar(50) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id`, `category`, `name`, `description`, `price`) VALUES
(1, 'North Indian', 'Paneer Butter Masala', 'Creamy and rich tomato-based curry with paneer.', 250.00),
(2, 'North Indian', 'Dal Makhani', 'Creamy lentils cooked with butter and spices.', 200.00),
(3, 'South Indian', 'Masala Dosa', 'Crispy rice crepe filled with spiced potatoes.', 150.00),
(4, 'South Indian', 'Idli Sambar', 'Steamed rice cakes served with lentil soup.', 100.00),
(5, 'Breakfast', 'Poha', 'Flattened rice cooked with onions, potatoes, and spices.', 80.00),
(6, 'Snacks', 'Samosa', 'Fried pastry with a savory filling of spiced potatoes and peas.', 20.00),
(7, 'Drinks/Beverages', 'Mango Lassi', 'Yogurt-based mango milkshake.', 120.00),
(8, 'Chappati', 'Tandoori Roti', 'Whole wheat bread cooked in a tandoor.', 25.00);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `booking_id` int(11) DEFAULT NULL,
  `customer_name` varchar(100) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `order_status` varchar(50) DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `booking_id`, `customer_name`, `total_amount`, `order_status`, `created_at`) VALUES
(1, 1, 'YASA CHRISTIAN', 1675.00, 'Complete', '2025-10-11 04:41:11'),
(2, 2, 'neeraj', 970.00, 'complete', '2025-10-11 05:56:44'),
(3, 3, 'YASA SHIRISH', 2795.00, 'Pending', '2025-11-03 05:59:09');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `menu_item_id` int(11) DEFAULT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `menu_item_id`, `quantity`) VALUES
(1, 1, 5, 2),
(2, 1, 8, 1),
(3, 1, 7, 1),
(4, 1, 1, 2),
(5, 1, 2, 1),
(6, 1, 6, 1),
(7, 1, 3, 1),
(8, 1, 4, 5),
(9, 2, 5, 1),
(10, 2, 8, 2),
(11, 2, 7, 1),
(12, 2, 1, 1),
(13, 2, 2, 1),
(14, 2, 6, 1),
(15, 2, 3, 1),
(16, 2, 4, 1),
(17, 3, 5, 1),
(18, 3, 8, 3),
(19, 3, 7, 2),
(20, 3, 1, 4),
(21, 3, 2, 4),
(22, 3, 6, 5),
(23, 3, 3, 2),
(24, 3, 4, 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `booking_id` (`booking_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `menu_item_id` (`menu_item_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`menu_item_id`) REFERENCES `menu` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
