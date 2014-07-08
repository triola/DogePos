-- phpMyAdmin SQL Dump
-- version 3.4.9
-- http://www.phpmyadmin.net
--
-- Host: mysql51-123.wc1:3306
-- Generation Time: Jul 08, 2014 at 05:23 AM
-- Server version: 5.1.70
-- PHP Version: 5.2.13

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `825627_temp`
--

-- --------------------------------------------------------

--
-- Table structure for table `doge_price`
--

CREATE TABLE IF NOT EXISTS `doge_price` (
  `id` int(11) NOT NULL DEFAULT '0',
  `dogetobtc` double NOT NULL,
  `btctodollars` double NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `doge_price`
--

INSERT INTO `doge_price` (`id`, `dogetobtc`, `btctodollars`) VALUES
(1, 3.6e-07, 621.03);

-- --------------------------------------------------------

--
-- Table structure for table `uc_configuration`
--

CREATE TABLE IF NOT EXISTS `uc_configuration` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `value` varchar(150) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `uc_configuration`
--

INSERT INTO `uc_configuration` (`id`, `name`, `value`) VALUES
(1, 'website_name', 'DogePos'),
(2, 'website_url', 'http://www.dogepos.com/'),
(3, 'email', 'noreply@dogepos.com'),
(4, 'activation', 'false'),
(5, 'resend_activation_threshold', '0'),
(6, 'language', 'models/languages/en.php'),
(7, 'template', 'models/site-templates/default.css'),
(8, 'remember_me_length', '1wk'),
(9, 'message', 'Wallets are currently offline while we upgrade server disk space. Thanks for your patience!'),
(10, 'message_type', 'disabled');

-- --------------------------------------------------------

--
-- Table structure for table `uc_customer_info`
--

CREATE TABLE IF NOT EXISTS `uc_customer_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `transaction_id` int(11) NOT NULL,
  `first` varchar(32) DEFAULT NULL,
  `last` varchar(32) NOT NULL,
  `address` varchar(32) NOT NULL,
  `address2` varchar(32) NOT NULL,
  `city` varchar(32) NOT NULL,
  `state` varchar(32) NOT NULL,
  `zip` varchar(32) NOT NULL,
  `phone` varchar(16) DEFAULT NULL,
  `email` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Table structure for table `uc_pages`
--

CREATE TABLE IF NOT EXISTS `uc_pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page` varchar(150) NOT NULL,
  `private` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=35 ;

--
-- Dumping data for table `uc_pages`
--

INSERT INTO `uc_pages` (`id`, `page`, `private`) VALUES
(1, 'account.php', 1),
(2, 'activate-account.php', 0),
(3, 'admin_configuration.php', 1),
(4, 'admin_page.php', 1),
(5, 'admin_pages.php', 1),
(6, 'admin_permission.php', 1),
(7, 'admin_permissions.php', 1),
(8, 'admin_user.php', 1),
(9, 'admin_users.php', 1),
(10, 'forgot-password.php', 0),
(11, 'index.php', 0),
(12, 'left-nav.php', 0),
(13, 'login.php', 0),
(14, 'logout.php', 1),
(15, 'register.php', 0),
(16, 'resend-activation.php', 0),
(17, 'user_settings.php', 1),
(18, 'process_doge.php', 1),
(19, 'process_btc.php', 1),
(20, 'footer.php', 0),
(21, 'process_doge_calc.php', 0),
(22, 'transactions.php', 1),
(23, 'demo.php', 0),
(25, 'newaccount.php', 0),
(26, 'thankyou.php', 0),
(27, 'demo-btc.php', 0),
(28, 'demo-doge.php', 0),
(29, 'demo-pos.php', 0),
(30, 'index-old.php', 0),
(31, 'faq.php', 0),
(32, 'ourstory.php', 0),
(33, 'top-nav.php', 0),
(34, 'dogepos-paynow.php', 0);

-- --------------------------------------------------------

--
-- Table structure for table `uc_permissions`
--

CREATE TABLE IF NOT EXISTS `uc_permissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `uc_permissions`
--

INSERT INTO `uc_permissions` (`id`, `name`) VALUES
(1, 'New'),
(2, 'Administrator'),
(3, 'Clients');

-- --------------------------------------------------------

--
-- Table structure for table `uc_permission_page_matches`
--

CREATE TABLE IF NOT EXISTS `uc_permission_page_matches` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `permission_id` int(11) NOT NULL,
  `page_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=35 ;

--
-- Dumping data for table `uc_permission_page_matches`
--

INSERT INTO `uc_permission_page_matches` (`id`, `permission_id`, `page_id`) VALUES
(4, 2, 1),
(5, 2, 3),
(6, 2, 4),
(7, 2, 5),
(8, 2, 6),
(9, 2, 7),
(10, 2, 8),
(11, 2, 9),
(12, 2, 14),
(13, 2, 17),
(23, 2, 18),
(24, 2, 19),
(28, 3, 1),
(29, 3, 14),
(30, 3, 17),
(31, 3, 18),
(32, 3, 19),
(33, 3, 22),
(34, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `uc_sessions`
--

CREATE TABLE IF NOT EXISTS `uc_sessions` (
  `sessionStart` int(11) NOT NULL,
  `sessionData` text NOT NULL,
  `sessionID` varchar(255) NOT NULL,
  PRIMARY KEY (`sessionID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `uc_transactions`
--

CREATE TABLE IF NOT EXISTS `uc_transactions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `currency` varchar(16) NOT NULL,
  `fiatcurrency` varchar(8) DEFAULT '-',
  `amount` double NOT NULL,
  `fiat` double NOT NULL,
  `receiving_address` varchar(512) NOT NULL,
  `sending_address` varchar(512) NOT NULL,
  `timestamp` int(32) NOT NULL,
  `transactionid` varchar(512) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=435 ;

-- --------------------------------------------------------

--
-- Table structure for table `uc_users`
--

CREATE TABLE IF NOT EXISTS `uc_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(50) NOT NULL,
  `display_name` varchar(50) NOT NULL,
  `password` varchar(225) NOT NULL,
  `pin_hash` varchar(512) NOT NULL,
  `email` varchar(150) NOT NULL,
  `dogeaddress` varchar(512) NOT NULL,
  `dogeaddress-verified` tinyint(1) NOT NULL,
  `autodoge` tinyint(1) NOT NULL,
  `btcaddress` varchar(512) NOT NULL,
  `btcaddress-verified` tinyint(1) NOT NULL,
  `autobtc` tinyint(1) NOT NULL,
  `currency` varchar(8) NOT NULL DEFAULT 'USD',
  `activation_token` varchar(225) NOT NULL,
  `last_activation_request` int(11) NOT NULL,
  `lost_password_request` tinyint(1) NOT NULL,
  `active` tinyint(1) NOT NULL,
  `title` varchar(150) NOT NULL,
  `sign_up_stamp` int(11) NOT NULL,
  `last_sign_in_stamp` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=120 ;

--
-- Dumping data for table `uc_users`
--

INSERT INTO `uc_users` (`id`, `user_name`, `display_name`, `password`, `pin_hash`, `email`, `dogeaddress`, `dogeaddress-verified`, `autodoge`, `btcaddress`, `btcaddress-verified`, `autobtc`, `currency`, `activation_token`, `last_activation_request`, `lost_password_request`, `active`, `title`, `sign_up_stamp`, `last_sign_in_stamp`) VALUES
(119, 'tempadmin', 'tempadmin', 'f26f7b1d959a342cbd770b1a4f658789492d2720550cbb4f119c113e241f17d5d', 'bc1e65b43a202bd9999f8b04d060702885c9f7499a0e1782c9cc9f94a9438c97e', 'info@dogepos.com', '', 0, 0, '', 0, 0, 'USD', '0aa84de42c62e31afc2ec93ba5212084', 1404814013, 0, 1, 'New Member', 1404814013, 0);

-- --------------------------------------------------------

--
-- Table structure for table `uc_user_permission_matches`
--

CREATE TABLE IF NOT EXISTS `uc_user_permission_matches` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=181 ;

--
-- Dumping data for table `uc_user_permission_matches`
--

INSERT INTO `uc_user_permission_matches` (`id`, `user_id`, `permission_id`) VALUES
(179, 119, 3),
(180, 119, 2);

-- --------------------------------------------------------

--
-- Table structure for table `user_receive_address`
--

CREATE TABLE IF NOT EXISTS `user_receive_address` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `doge_address` varchar(256) NOT NULL,
  `doge_last_balance` double NOT NULL,
  `btc_address` varchar(512) NOT NULL,
  `btc_last_balance` double NOT NULL,
  `rotating` tinyint(1) NOT NULL DEFAULT '0',
  `type` varchar(8) NOT NULL,
  `in_use` tinyint(1) NOT NULL,
  `expiration` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=95 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
