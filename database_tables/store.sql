-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 24, 2016 at 12:22 AM
-- Server version: 5.5.44-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `store`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `description` varchar(256) NOT NULL,
  `datecreated` date NOT NULL,
  `notes` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`, `datecreated`, `notes`) VALUES
(1, 'travel', 'travel bags', '2015-12-01', 'all bags in travel category'),
(2, 'briefcase', 'briefases', '2015-12-01', 'briefcase bags'),
(3, 'backpack', 'backpacks and satchels', '2015-12-01', 'backpacks and satchels'),
(4, 'handbag', 'handbags', '2015-12-01', 'handbags'),
(5, 'luggage', 'luggage', '2015-12-01', 'luggage'),
(6, 'overnighter', 'overnight bags', '2015-12-01', 'overnight bags'),
(7, 'all', 'all categories', '2016-01-16', 'category to show all products');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(12) NOT NULL AUTO_INCREMENT,
  `transactionid` int(12) NOT NULL,
  `productid` int(8) NOT NULL,
  `quantity` int(3) NOT NULL,
  `userid` int(6) NOT NULL,
  `paymentstatus` tinyint(1) NOT NULL,
  `shipdate` date NOT NULL,
  `tracking` int(16) NOT NULL,
  `datecreated` date NOT NULL,
  `notes` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE IF NOT EXISTS `pages` (
  `id` smallint(6) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `title` varchar(128) NOT NULL,
  `link` varchar(64) NOT NULL,
  `content` text NOT NULL,
  `image` varchar(256) NOT NULL,
  `notes` varchar(128) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `name`, `title`, `link`, `content`, `image`, `notes`) VALUES
(1, 'home', 'Welcome to our store', 'index.php', 'Welcome to our store. We work very hard to create a beautifully-curated selection of merchandise for you, we hope you like it.', '', ''),
(2, 'store', 'Love of things', 'store.php', 'We created this collection with love, we hope you will love it too.', '', ''),
(3, 'contact', 'Contact Us', 'contact.php', 'Please feel free to get in touch with us. We love hearing from our customers. Let us know how we can help you.', '', ''),
(4, 'About', 'About Us', 'about.php', '<p>We are a group of enthusiasts in our field who love to share our collections with our customers. We select the finest products to display in our store, from the latest trends. We hope our expertise in this area will make your journey in discovering the beauty in each of our products enjoyable and fun.</p>\r\n<p>\r\nIf there is anything that we can do better, please get in touch via our <a href="contact.php">contact</a> section. Heppy shopping.</p>', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE IF NOT EXISTS `products` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `sku` int(8) NOT NULL,
  `stocklevel` smallint(3) NOT NULL,
  `category` varchar(32) NOT NULL,
  `material` varchar(64) NOT NULL,
  `name` varchar(128) NOT NULL,
  `description` text NOT NULL,
  `brand` varchar(128) NOT NULL,
  `color` varchar(128) NOT NULL,
  `weight` int(8) NOT NULL,
  `width` int(6) NOT NULL,
  `height` int(6) NOT NULL,
  `depth` int(6) NOT NULL,
  `netprice` int(8) NOT NULL,
  `sellprice` int(8) NOT NULL,
  `specialprice` int(8) NOT NULL,
  `image` varchar(256) NOT NULL,
  `datecreated` date NOT NULL,
  `datemodified` date NOT NULL,
  `notes` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `sku`, `stocklevel`, `category`, `material`, `name`, `description`, `brand`, `color`, `weight`, `width`, `height`, `depth`, `netprice`, `sellprice`, `specialprice`, `image`, `datecreated`, `datemodified`, `notes`) VALUES
(1, 23344578, 5, '2', 'leather', 'Tosca', 'A touch of ellegance with you everywhere. The perfect companion for those traversing the corporate structure', 'Enorm', 'brown', 520, 600, 400, 28, 89, 209, 0, 'productimage.png', '2016-01-07', '2016-01-07', 'Awesome bag'),
(2, 94563756, 6, '3', 'nylon', 'Java', 'Travel anywhere with the complete versatility of the Java backpack. Take all your creature comforts with you and more.', 'Enorm', 'green', 580, 550, 600, 48, 120, 199, 0, 'productimage.png', '2016-01-07', '2016-01-07', 'Hahaha'),
(3, 49032736, 18, '1', 'nylon', 'Vector', 'No need to ask for directions, as Vector will take you there in comfort and capacity.', 'Global', 'blue', 650, 820, 680, 220, 109, 229, 0, 'productimage.png', '2016-01-07', '2016-01-07', ''),
(4, 20450143, 12, '4', 'leather', 'Rio Grande', 'Take anywhere for that luxurious feel and elegance, yet full of all the mod-cons for the modern urban movers.', 'Goats', 'orange', 450, 530, 300, 120, 159, 279, 0, 'productimage.png', '2016-01-06', '2016-01-07', ''),
(5, 74017849, 5, '5', 'polycarbonate shell', 'Tokyo', 'The go anywhere luggage, perfect for those on the move across continents and horizons.', 'Enorm', 'green', 720, 900, 550, 300, 119, 259, 0, 'productimage.png', '2016-01-07', '2016-01-07', ''),
(6, 49032426, 12, '1', 'polycarbonate', 'Chernobyl', 'Nuclear travel case with utmost security and ease of handling. Perfect for the traveller who venture off the beaten paths', 'Global', 'black', 820, 850, 480, 220, 199, 399, 0, 'productimage.png', '2016-01-06', '2016-01-06', ''),
(7, 63145026, 12, '6', 'nylon', 'StarryNite', 'From one night stand to one week house-sit, this one is perfect for chilling out.', 'Global', 'blue', 356, 750, 320, 320, 69, 139, 0, 'productimage.png', '2016-01-07', '2016-01-07', '');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(12) NOT NULL AUTO_INCREMENT,
  `username` varchar(128) NOT NULL,
  `email` varchar(256) NOT NULL,
  `pass` varchar(256) NOT NULL,
  `firstname` varchar(128) NOT NULL,
  `lastname` varchar(128) NOT NULL,
  `apartment` varchar(6) NOT NULL,
  `streetnumber` varchar(6) NOT NULL,
  `streetname` varchar(256) NOT NULL,
  `suburb` varchar(128) NOT NULL,
  `state` varchar(128) NOT NULL,
  `postcode` varchar(8) NOT NULL,
  `country` varchar(256) NOT NULL,
  `isadmin` tinyint(1) NOT NULL DEFAULT '0',
  `datecreated` date NOT NULL,
  `datemodified` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE IF NOT EXISTS `wishlist` (
  `id` int(12) NOT NULL AUTO_INCREMENT,
  `productid` varchar(12) NOT NULL,
  `userid` varchar(64) NOT NULL,
  `datecreated` date NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
