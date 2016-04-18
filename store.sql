-- phpMyAdmin SQL Dump
-- version 4.0.8
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Време на генериране: 
-- Версия на сървъра: 5.1.71-community
-- Версия на PHP: 5.4.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- БД: `store`
--

-- --------------------------------------------------------

--
-- Структура на таблица `contractor`
--

CREATE TABLE IF NOT EXISTS `contractor` (
  `contractor_id` int(11) NOT NULL AUTO_INCREMENT,
  `contractor_name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `note` text CHARACTER SET utf8,
  PRIMARY KEY (`contractor_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Схема на данните от таблица `contractor`
--

INSERT INTO `contractor` (`contractor_id`, `contractor_name`, `note`) VALUES
(2, 'Доставик 1', 'yuyuyuyuyuyu'),
(3, 'Втори доставчик', 'sdddadada'),
(4, 'Киборг 123', '3333333333333333');

-- --------------------------------------------------------

--
-- Структура на таблица `prices`
--

CREATE TABLE IF NOT EXISTS `prices` (
  `product_id` int(11) NOT NULL,
  `quantity` int(4) NOT NULL,
  `distributor_price` decimal(15,2) NOT NULL,
  `selling_price` decimal(15,2) NOT NULL,
  `insert_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Схема на данните от таблица `prices`
--

INSERT INTO `prices` (`product_id`, `quantity`, `distributor_price`, `selling_price`, `insert_date`) VALUES
(14, 1, '13.00', '19.00', '2014-04-08'),
(15, 2, '6.23', '7.80', '2014-04-08');

-- --------------------------------------------------------

--
-- Структура на таблица `products`
--

CREATE TABLE IF NOT EXISTS `products` (
  `product_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `unit_id` int(11) NOT NULL,
  `contractor_id` int(11) NOT NULL,
  PRIMARY KEY (`product_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Схема на данните от таблица `products`
--

INSERT INTO `products` (`product_id`, `product_name`, `unit_id`, `contractor_id`) VALUES
(14, 'new 123', 1, 3),
(15, 'product 7', 1, 2);

-- --------------------------------------------------------

--
-- Структура на таблица `units`
--

CREATE TABLE IF NOT EXISTS `units` (
  `unit_id` int(11) NOT NULL AUTO_INCREMENT,
  `unit_name` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `note` text CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`unit_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Схема на данните от таблица `units`
--

INSERT INTO `units` (`unit_id`, `unit_name`, `note`) VALUES
(1, 'килограм', '124'),
(2, 'литър', 'няма');

-- --------------------------------------------------------

--
-- Структура на таблица `user_data`
--

CREATE TABLE IF NOT EXISTS `user_data` (
  `data_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_date` date NOT NULL,
  `user_unit` int(11) NOT NULL DEFAULT '0',
  `user_contractor` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`data_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Схема на данните от таблица `user_data`
--

INSERT INTO `user_data` (`data_id`, `user_date`, `user_unit`, `user_contractor`) VALUES
(1, '2014-04-01', 1, 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
