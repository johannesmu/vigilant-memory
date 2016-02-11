-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Feb 11, 2016 at 04:24 AM
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
-- Table structure for table `pages`
--

CREATE TABLE IF NOT EXISTS `pages` (
  `id` smallint(6) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `title` varchar(128) NOT NULL,
  `link` varchar(64) NOT NULL,
  `content` text NOT NULL,
  `side` varchar(5) NOT NULL,
  `loginrequired` tinyint(1) NOT NULL DEFAULT '0',
  `image` varchar(256) NOT NULL,
  `notes` varchar(128) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `name`, `title`, `link`, `content`, `side`, `loginrequired`, `image`, `notes`) VALUES
(1, 'home', 'Welcome to our store', 'index.php', 'Welcome to our store. We work very hard to create a beautifully-curated selection of merchandise for you, we hope you like it.', 'left', 0, '', ''),
(2, 'store', 'Love of Bags', 'store.php', 'We created this collection with love, we hope you will love it too.', 'left', 0, '', ''),
(3, 'contact', 'Contact Us', 'contact.php', 'Please feel free to get in touch with us. We love hearing from our customers. Let us know how we can help you.', 'left', 0, '', ''),
(4, 'About', 'About Us', 'about.php', '<p>We are a group of enthusiasts in our field who love to share our collections with our customers. We select the finest products to display in our store, from the latest trends. We hope our expertise in this area will make your journey in discovering the beauty in each of our products enjoyable and fun.</p>\r\n<p>\r\nIf there is anything that we can do better, please get in touch via our <a href="contact.php">contact</a> section. Heppy shopping.</p>', 'left', 0, '', ''),
(5, 'cart', 'Contents of Shopping Cart', 'viewshoppingcart.php', 'Preview the content of your cart.', 'right', 0, '', ''),
(6, 'Login/Register', 'Login or Join Bag of Love', 'login.php', 'Login or register into your account', 'right', 0, '', ''),
(7, 'Account', 'Your Account Details', 'user-dashboard.php', 'Details of your account and activities', 'right', 1, '', ''),
(8, 'Log Out', 'Log Out', 'logout.php', 'Log out of your account', 'right', 1, '', ''),
(9, 'Admin', 'Admin Panel', 'admin.php', 'Administration Panel', 'right', 2, '', ''),
(10, 'wishlist', 'Items in your wishlist', 'viewwishlist.php', 'Here are some items that you have added to your wish list', 'right', 1, '', '');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
