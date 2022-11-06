-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Nov 06, 2022 at 11:20 AM
-- Server version: 8.0.28
-- PHP Version: 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `web_shop_php`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

DROP TABLE IF EXISTS `category`;
CREATE TABLE IF NOT EXISTS `category` (
  `category_id` int NOT NULL AUTO_INCREMENT,
  `category_name` text NOT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `category_name`) VALUES
(1, 'clothing'),
(2, 'foods'),
(3, 'toys');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `product_id` int NOT NULL AUTO_INCREMENT,
  `product_name` text NOT NULL,
  `description` text NOT NULL,
  `price` int NOT NULL,
  `image_src` varchar(255) NOT NULL,
  `sub_category_id` int NOT NULL,
  PRIMARY KEY (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `product_name`, `description`, `price`, `image_src`, `sub_category_id`) VALUES
(16, 'Hoodies for men', 'Shop for a range of mens sweatshirt styles, from plain to zip up and oversized hoodies.', 100, './images/men1', 1),
(17, 'Mens Shoes', 'comfortable shoes for your parties ', 300, './images/men2.jpg', 1),
(18, 'Women Clothing', 'loose comfortable pants ', 250, './images/women1', 2),
(19, 'Women Clothing', 'heel shoes for women', 400, './images/women2', 2),
(20, 'Smooth Chocklate Cake', 'tasty chocklate cake as a dessert', 30, './images/vegan3', 3),
(21, 'Spicy Chicken Pizza', 'Spicy Chicken Pizza, medium size, with extra cheese', 40, './images/nonvegan2', 4),
(22, 'Chicken Curry with rice', 'Indian style chicken curry ', 100, './images/nonvegan1', 4),
(23, 'Veg Burger', 'Vegetarian burger with cheese, and tomatoes', 40, './images/vegan1', 3),
(24, 'Scooty for Boy', 'Electric scooty for your kid to play around', 500, './images/boy1', 5),
(25, 'Mini Basketball Pole', 'Play basketball in your room with our special mini basketball pole', 400, './images/boy2', 5),
(26, 'Teddy for girl', 'Cute teddy bear for small girl to hang around with', 60, './images/girl1', 6);

-- --------------------------------------------------------

--
-- Table structure for table `sub_category`
--

DROP TABLE IF EXISTS `sub_category`;
CREATE TABLE IF NOT EXISTS `sub_category` (
  `sub_category_id` int NOT NULL AUTO_INCREMENT,
  `sub_category_name` text NOT NULL,
  `category_id` int NOT NULL,
  PRIMARY KEY (`sub_category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `sub_category`
--

INSERT INTO `sub_category` (`sub_category_id`, `sub_category_name`, `category_id`) VALUES
(1, 'Mens Clothing', 1),
(2, 'Women Clothing', 1),
(3, 'Vegan', 2),
(4, 'Non-Vegan', 2),
(5, 'Boy Toys', 3),
(6, 'Girls Toys', 3);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int NOT NULL AUTO_INCREMENT,
  `fullname` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `contact_no` varchar(255) NOT NULL,
  `email` text NOT NULL,
  `password` text NOT NULL,
  `user_type` text NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `fullname`, `address`, `contact_no`, `email`, `password`, `user_type`) VALUES
(1, 'Rukshan Pokharel', 'Vognporten 14 223, 2620 Albertslund', '52817914', 'root@gmail.com', 'Rukshan', ''),
(2, 'Rukshan Shady', 'Vognporten 14 Albertslund', '52817913', 'test@gmail.com', 'testing', 'user'),
(3, 'Test User', 'jlkadsfjldsakfj', '52817914', 'test@gmail.com', 'Root8848', 'admin');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
