-- phpMyAdmin SQL Dump
-- version 4.1.7
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Фев 13 2014 г., 20:29
-- Версия сервера: 5.5.35-0ubuntu0.13.10.2
-- Версия PHP: 5.5.3-1ubuntu2.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `test`
--

-- --------------------------------------------------------

--
-- Структура таблицы `behavior`
--

CREATE TABLE IF NOT EXISTS `behavior` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL,
  `model_name` varchar(30) NOT NULL,
  `field_name` varchar(30) NOT NULL,
  `field_val` text,
  `record_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=22 ;

--
-- Дамп данных таблицы `behavior`
--

INSERT INTO `behavior` (`id`, `item_id`, `model_name`, `field_name`, `field_val`, `record_time`) VALUES
(12, 10, 'Data', 'priority', '1', '2014-02-13 14:41:48'),
(13, 7, 'Data', 'priority', '2', '2014-02-13 14:41:48'),
(14, 8, 'Data', 'priority', '3', '2014-02-13 14:41:48'),
(15, 11, 'Data', 'priority', '4', '2014-02-13 14:41:48'),
(16, 9, 'Data', 'priority', '5', '2014-02-13 14:41:48'),
(17, 7, 'Data', 'priority', '1', '2014-02-13 15:49:34'),
(18, 10, 'Data', 'priority', '2', '2014-02-13 15:49:34'),
(19, 8, 'Data', 'priority', '2', '2014-02-13 15:49:35'),
(20, 11, 'Data', 'priority', '3', '2014-02-13 15:49:35'),
(21, 10, 'Data', 'priority', '4', '2014-02-13 15:49:35');

-- --------------------------------------------------------

--
-- Структура таблицы `data`
--

CREATE TABLE IF NOT EXISTS `data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `text` text NOT NULL,
  `priority` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- Дамп данных таблицы `data`
--

INSERT INTO `data` (`id`, `text`, `priority`, `status`) VALUES
(7, '1', 1, 1),
(8, '2', 2, 1),
(9, '32', 5, 1),
(10, '4', 4, 1),
(11, '56', 3, 1),
(12, '2', 6, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `hist`
--

CREATE TABLE IF NOT EXISTS `hist` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `step` int(11) NOT NULL,
  `text` text NOT NULL,
  `priority` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=79 ;

--
-- Дамп данных таблицы `hist`
--

INSERT INTO `hist` (`id`, `step`, `text`, `priority`, `item_id`, `status`) VALUES
(12, 1, '1', 1, 7, 1),
(13, 2, '2', 2, 8, 1),
(14, 3, '3', 3, 9, 1),
(15, 4, '4', 4, 10, 1),
(16, 5, '5', 5, 11, 1),
(17, 6, '51', 5, 11, 1),
(18, 7, '31', 3, 9, 1),
(19, 8, '1', 1, 7, 1),
(20, 9, '2', 2, 8, 1),
(21, 10, '31', 3, 9, 1),
(22, 11, '51', 4, 11, 1),
(23, 12, '4', 5, 10, 1),
(24, 13, '32', 3, 9, 1),
(25, 14, '2', 6, 12, 1),
(26, 15, '50', 4, 11, 1),
(27, 16, '51', 4, 11, 1),
(28, 17, '1', 1, 7, 1),
(29, 18, '2', 2, 8, 1),
(30, 19, '51', 3, 11, 1),
(31, 20, '32', 4, 9, 1),
(32, 21, '4', 5, 10, 1),
(33, 22, '2', 6, 12, 1),
(34, 23, '53', 3, 11, 1),
(35, 24, '52', 3, 11, 1),
(36, 25, '53', 3, 11, 1),
(37, 26, '58', 3, 11, 1),
(38, 27, '57', 3, 11, 1),
(39, 28, '56', 3, 11, 1),
(40, 29, '1', 1, 7, 1),
(41, 30, '2', 2, 8, 1),
(42, 31, '32', 3, 9, 1),
(43, 32, '56', 4, 11, 1),
(44, 33, '4', 5, 10, 1),
(45, 34, '2', 6, 12, 1),
(46, 35, '1', 1, 7, 1),
(47, 36, '2', 2, 8, 1),
(48, 37, '56', 3, 11, 1),
(49, 38, '32', 4, 9, 1),
(50, 39, '4', 5, 10, 1),
(51, 40, '2', 6, 12, 1),
(52, 41, '1', 1, 7, 1),
(53, 42, '2', 2, 8, 1),
(54, 43, '32', 3, 9, 1),
(55, 44, '1', 1, 7, 1),
(56, 45, '2', 2, 8, 1),
(57, 46, '56', 3, 11, 1),
(58, 47, '32', 4, 9, 1),
(59, 48, '4', 5, 10, 1),
(60, 49, '2', 6, 12, 1),
(61, 50, '4', 1, 10, 1),
(62, 51, '1', 2, 7, 1),
(63, 52, '2', 3, 8, 1),
(64, 53, '56', 4, 11, 1),
(65, 54, '32', 5, 9, 1),
(66, 55, '2', 6, 12, 1),
(67, 56, '1', 1, 7, 1),
(68, 57, '4', 2, 10, 1),
(69, 58, '2', 3, 8, 1),
(70, 59, '56', 4, 11, 1),
(71, 60, '1', 1, 7, 1),
(72, 61, '32', 5, 9, 1),
(73, 62, '2', 2, 8, 1),
(74, 63, '2', 6, 12, 1),
(75, 64, '56', 3, 11, 1),
(76, 65, '4', 4, 10, 1),
(77, 66, '32', 5, 9, 1),
(78, 67, '2', 6, 12, 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
