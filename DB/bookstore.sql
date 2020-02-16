-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 21, 2020 at 08:21 PM
-- Server version: 10.4.8-MariaDB
-- PHP Version: 7.3.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bookstore`
--

-- --------------------------------------------------------

--
-- Table structure for table `author`
--

CREATE TABLE `author` (
  `ID` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `author`
--

INSERT INTO `author` (`ID`, `name`) VALUES
(1, 'Papadopoulos Georgios'),
(2, 'Georgiadis Nikolaos');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `ID` int(11) NOT NULL,
  `Name` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`ID`, `Name`) VALUES
(1, 'History'),
(2, 'Horror'),
(3, 'Biography'),
(4, 'Computer & Tech'),
(5, 'Medical'),
(7, 'Mystery'),
(8, 'Romance'),
(9, 'Sci-Fi & Fantasy'),
(10, 'Comics'),
(11, 'Travel'),
(12, 'Academic'),
(13, 'Literature & Fiction'),
(14, '324342'),
(15, '0'),
(16, '0'),
(17, 'dsfsdf');

-- --------------------------------------------------------

--
-- Структура таблицы `coupon`
--

CREATE TABLE `coupon` (
  `coupon_id` int(11) NOT NULL,
  `code` varchar(15) NOT NULL,
  `discount` int(11) NOT NULL,
  `is_enable` tinyint(1) NOT NULL,
  `valid_from` date NOT NULL,
  `valid_to` date NOT NULL,
  `total_usage` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `coupon`
--

INSERT INTO `coupon` (`coupon_id`, `code`, `discount`, `is_enable`, `valid_from`, `valid_to`, `total_usage`) VALUES
(1, '0B5enJqwmM', 12, 0, '2020-01-23', '2020-01-25', 30),
(5, 'LynKl@ncM6', 92, 1, '2020-01-23', '2020-02-01', 20),
(6, '5ECDyxdaAz', 42, 1, '2020-01-23', '2020-01-26', 100);

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `ID` int(11) NOT NULL,
  `Fname` varchar(100) DEFAULT NULL,
  `Lname` varchar(100) DEFAULT NULL,
  `Address` varchar(300) DEFAULT NULL,
  `Phone` varchar(100) DEFAULT NULL,
  `uname` varchar(30) DEFAULT NULL,
  `passwd_enc` varchar(42) DEFAULT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`ID`, `Fname`, `Lname`, `Address`, `Phone`, `uname`, `passwd_enc`, `is_admin`) VALUES
(10, 'Kostas', 'Nikopoulos', 'Ampelokipwn 4', '464577777777', 'user', '*E6CC90B878B948C35E92B003C792C46C58C4AF40', 0),
(11, 'nikos1', 'dvsdvs', 'Skrra', '30231401111145', 'admin', '*E6CC90B878B948C35E92B003C792C46C58C4AF40', 1);

-- --------------------------------------------------------

--
-- Table structure for table `orderdetails`
--

CREATE TABLE `orderdetails` (
  `ID` int(11) NOT NULL,
  `Orders` int(11) DEFAULT NULL,
  `Quantity` int(11) DEFAULT NULL,
  `Product` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `orderdetails`
--

INSERT INTO `orderdetails` (`ID`, `Orders`, `Quantity`, `Product`) VALUES
(75, 14, 1, 1),
(76, 14, 1, 3),
(77, 15, 3, 12),
(78, 15, 1, 9),
(79, 16, 2, 8),
(80, 16, 1, 9),
(81, 16, 1, 4),
(82, 17, 2, 8),
(83, 17, 1, 9),
(84, 17, 1, 4),
(85, 18, 2, 8),
(86, 18, 1, 9),
(87, 18, 1, 4),
(88, 19, 2, 8),
(89, 19, 1, 9),
(90, 19, 1, 4),
(91, 20, 2, 8),
(92, 20, 1, 9),
(93, 20, 1, 4),
(94, 21, 2, 8),
(95, 21, 1, 9),
(96, 21, 1, 4),
(97, 22, 2, 8),
(98, 22, 1, 9),
(99, 22, 1, 4),
(100, 23, 2, 8),
(101, 23, 1, 9),
(102, 23, 1, 4),
(103, 24, 2, 8),
(104, 24, 1, 9),
(105, 24, 1, 4),
(106, 25, 2, 8),
(107, 25, 1, 9),
(108, 25, 1, 4),
(109, 26, 1, 1),
(110, 27, 1, 6),
(111, 27, 1, 3),
(112, 28, 1, 12),
(113, 29, 1, 12),
(114, 30, 3, 1),
(115, 31, 4, 1),
(116, 32, 5893, 12),
(117, 33, 1, 8),
(118, 34, 2, 12),
(119, 34, 1, 10),
(120, 35, 1, 1),
(121, 36, 1, 12),
(122, 37, 1, 10),
(123, 37, 1, 4),
(124, 38, 1, 10),
(125, 38, 3, 8),
(126, 39, 3, 8),
(127, 39, 1, 7),
(128, 40, 1, 3),
(129, 40, 2, 10),
(130, 41, 2, 2),
(131, 42, 5, 7),
(132, 43, 1, 12),
(133, 43, 121, 8),
(134, 44, 1, 8),
(135, 45, 1, 2),
(136, 45, 1, 9),
(137, 46, 1, 2),
(138, 46, 1, 11),
(139, 47, 10, 12),
(140, 48, 1, 1),
(141, 48, 1, 12),
(142, 49, 1, 9),
(143, 50, 1, 11),
(144, 51, 1, 3),
(145, 52, 1, 2),
(146, 52, 1, 8),
(147, 52, 1, 6),
(148, 53, 1, 11),
(149, 54, 1, 7),
(150, 55, 1, 10),
(151, 56, 1, 8),
(152, 57, 1, 6),
(153, 58, 1, 3),
(154, 59, 1, 10),
(155, 59, 1, 12),
(156, 60, 7, 11),
(157, 61, 1, 1),
(158, 62, 1, 8),
(159, 62, 1, 9),
(160, 63, 3, 11),
(161, 64, 1, 8),
(162, 64, 1, 6),
(163, 65, 1, 7),
(164, 65, 1, 9),
(165, 66, 1, 11),
(166, 67, 1, 9),
(167, 68, 2, 10),
(168, 68, 1, 9),
(169, 69, 2, 8),
(170, 70, 1, 1),
(171, 71, 1, 1),
(172, 71, 1, 10),
(173, 72, 1, 1),
(174, 73, 2, 4),
(175, 74, 1, 8),
(176, 74, 1, 12),
(177, 75, 1, 6),
(178, 76, 1, 12),
(179, 76, 1, 4),
(180, 76, 1, 1),
(181, 77, 1, 7),
(182, 77, 1, 6),
(183, 78, 1, 3),
(184, 78, 1, 8),
(185, 79, 1, 1),
(186, 80, 1, 8),
(187, 81, 8, 7),
(188, 81, 7, 6),
(189, 82, 1, 11),
(190, 82, 1, 1),
(191, 82, 1, 3),
(192, 82, 1, 2),
(193, 83, 1, 10),
(194, 84, 1, 8),
(195, 85, 1, 9),
(196, 86, 1, 11),
(197, 87, 2, 6),
(198, 88, 1, 1),
(199, 89, 1, 3),
(200, 90, 1, 3),
(201, 91, 1, 6),
(202, 92, 1, 10),
(203, 93, 5, 9),
(204, 94, 1, 9),
(205, 95, 1, 9),
(206, 96, 1, 1),
(207, 97, 1, 11),
(208, 98, 1, 2),
(209, 99, 1, 2),
(210, 100, 1, 6),
(211, 101, 1, 8),
(212, 102, 1, 2),
(213, 103, 1, 14),
(214, 104, 2, 9),
(215, 104, 3, 3),
(216, 104, 10, 2),
(217, 105, 1, 3),
(218, 106, 2, 7),
(219, 107, 1, 9),
(220, 108, 1, 8),
(221, 108, 1, 10),
(222, 109, 1, 5),
(223, 109, 1, 2),
(224, 110, 1, 6),
(225, 111, 1, 3),
(226, 111, 1, 9),
(227, 111, 1, 12),
(228, 111, 2, 6),
(229, 112, 1, 1),
(230, 113, 88, 1),
(231, 114, 18888888, 6),
(232, 115, 1, 9),
(233, 116, 1, 6),
(234, 116, 3, 1),
(235, 117, 1, 11),
(236, 117, 1, 3),
(237, 118, 1, 10),
(238, 118, 1, 2),
(239, 119, 1, 1),
(240, 120, 1, 7),
(241, 120, 1, 6),
(242, 121, 1, 1),
(243, 122, 9, 12),
(244, 122, 1, 9),
(245, 123, 1, 7),
(246, 124, 1, 11),
(247, 125, 2, 11),
(248, 126, 4, 1),
(249, 126, 1, 11),
(250, 127, 2, 5),
(251, 128, 1, 12),
(252, 129, 1, 1),
(253, 130, 2, 10),
(254, 131, 1, 8),
(255, 131, 1, 5),
(256, 132, 4, 10),
(257, 132, 4, 6),
(258, 132, 1, 15),
(259, 133, 1, 1),
(260, 133, 1, 12),
(261, 134, 6, 7),
(262, 134, 3, 4),
(263, 135, 3, 9),
(264, 136, 1, 11),
(265, 136, 1, 12),
(266, 137, 1, 9),
(267, 138, 1, 6),
(268, 139, 2, 9),
(269, 139, 9, 6),
(270, 139, 1, 8),
(271, 140, 1, 3),
(272, 141, 3, 10),
(273, 142, 26, 2),
(274, 142, 1, 6),
(275, 143, 3, 7),
(276, 143, 2, 6),
(277, 143, 1, 2),
(278, 144, 1, 3),
(279, 144, 2, 12),
(280, 145, 9, 6),
(281, 146, 16, 3),
(282, 146, 1, 12),
(283, 147, 4, 7),
(284, 148, 1, 8),
(285, 149, 6, 8),
(286, 150, 1, 3),
(287, 151, 1, 7),
(288, 152, 4, 1),
(289, 152, 3, 9),
(290, 152, 18, 5),
(291, 153, 1, 15),
(292, 154, 3, 10),
(293, 155, 1, 8),
(294, 156, 1, 4),
(295, 157, 1, 5),
(296, 157, 1, 12),
(297, 158, 1, 8),
(298, 158, 1, 12),
(299, 159, 1, 5),
(300, 159, 1, 12),
(301, 159, 1, 2),
(302, 160, 1, 7),
(303, 161, 1, 1),
(304, 162, 1, 4),
(305, 163, 1, 1),
(306, 164, 1, 4),
(307, 165, 1, 8),
(308, 166, 1, 8),
(309, 167, 1, 2),
(310, 167, 1, 8),
(312, 168, 1, 9),
(313, 169, 1, 6),
(314, 170, 1, 8),
(315, 171, 1, 11),
(316, 172, 1, 8),
(317, 173, 4, 6),
(318, 173, 4, 2),
(319, 173, 2, 8),
(320, 174, 1, 11),
(321, 174, 1, 3),
(322, 175, 3, 6),
(323, 175, 3, 1),
(324, 176, 2, 8),
(325, 177, 1, 9),
(326, 178, 1, 6),
(327, 178, 1, 9),
(328, 179, 6, 6),
(329, 180, 1, 3),
(330, 181, 2, 6),
(331, 181, 1, 8),
(332, 181, 1, 11),
(333, 182, 1, 6),
(334, 182, 1, 9),
(335, 183, 1, 6),
(336, 184, 1, 6),
(337, 185, 3, 8),
(338, 185, 2, 7),
(339, 186, 0, 1),
(340, 186, 1, 10),
(341, 186, -1, 11),
(342, 187, 2, 9),
(343, 187, 1, 6),
(344, 188, 4, 1),
(345, 188, 1, 12),
(346, 189, 1, 12),
(347, 190, 1, 2),
(348, 191, 1, 12),
(349, 191, 3, 14),
(350, 192, 8, 1),
(351, 192, 4, 12),
(352, 193, 1, 10),
(353, 194, 6, 9),
(354, 194, 13, 6),
(355, 194, 4, 3),
(356, 195, 1, 6),
(357, 196, 1, 2),
(358, 197, 5, 11),
(359, 197, 1, 12),
(360, 197, 6, 10),
(361, 197, 4, 9),
(362, 197, 1, 8),
(363, 198, 2, 10),
(364, 199, 3, 11),
(365, 199, 1, 12),
(366, 199, 1, 9),
(367, 200, 1, 9),
(368, 201, 1, 8),
(369, 202, 1, 6),
(370, 203, 2, 12),
(371, 204, 5, 3),
(372, 205, 3, 8),
(373, 205, 21, 6),
(374, 206, 1, 8),
(375, 207, 1, 9),
(376, 207, 1, 1),
(377, 207, 1, 3),
(378, 208, 1, 1),
(379, 209, 1, 1),
(380, 210, 1, 2),
(381, 211, 1, 1),
(382, 211, 1, 9),
(383, 212, 17, 11),
(384, 213, 5, 1),
(385, 214, 7, 1),
(386, 215, 2, 1),
(387, 216, 1, 6),
(388, 217, 1, 6),
(389, 217, 2, 11),
(390, 217, 1, 10),
(391, 217, 2, 15),
(392, 217, 1, 8),
(393, 218, 5, 6),
(394, 218, 1, 10),
(395, 218, 2, 11),
(396, 218, 13, 9),
(397, 219, 1, 8),
(398, 220, 1, 1),
(399, 220, 1, 7),
(400, 221, 1, 11),
(401, 222, 2, 8),
(402, 223, 1, 5),
(403, 224, 1, 9),
(404, 224, 1, 8),
(405, 225, 2, 12),
(406, 226, 1, 1),
(407, 227, 1, 6),
(408, 228, 1, 6),
(409, 229, 5, 14),
(410, 229, 2, 2),
(411, 230, 3, 7),
(412, 231, 1, 11),
(413, 231, 2, 14),
(414, 232, 2, 1),
(415, 232, 5, 6),
(416, 233, 1, 1),
(417, 233, 1, 6),
(418, 234, 1, 6),
(419, 235, 1, 2),
(420, 236, 1, 9),
(421, 237, 1, 1),
(422, 238, 4, 1),
(423, 238, 3, 9),
(424, 239, 2, 9),
(425, 240, 1, 8),
(426, 240, 2, 11),
(427, 241, 1, 9),
(428, 241, 1, 8),
(429, 242, 1, 11),
(430, 243, 1, 13),
(431, 244, 1, 9),
(432, 245, 1, 9),
(433, 245, 1, 12),
(434, 245, 1, 3),
(435, 246, 1, 2),
(436, 247, 2, 11),
(437, 247, 1, 6),
(438, 248, 1, 9),
(439, 249, 1, 15),
(440, 250, 1, 9),
(441, 251, 3, 11),
(442, 251, 2, 15),
(443, 252, 1, 12),
(444, 252, 1, 9),
(445, 252, 1, 6),
(446, 252, 1, 15),
(447, 253, 1, 9),
(448, 254, 1, 9),
(449, 254, 1, 6),
(450, 255, 1, 8),
(451, 255, 1, 6),
(452, 256, 10, 7),
(453, 256, 3, 9),
(454, 256, 5, 3),
(455, 257, 1, 9),
(456, 258, 1, 9),
(457, 259, 1, 9),
(458, 260, 1, 3),
(459, 261, 1, 9),
(460, 262, 1, 9),
(461, 263, 1, 12),
(462, 264, 1, 1),
(463, 265, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `ID` int(11) NOT NULL,
  `Customer` int(11) DEFAULT NULL,
  `oDate` date DEFAULT NULL,
  `Status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`ID`, `Customer`, `oDate`, `Status`) VALUES
(14, 10, '2011-12-21', 1),
(15, 11, '2011-12-21', 0),
(16, 11, '2017-10-25', -1),
(17, 11, '2017-10-25', 0),
(18, 11, '2017-10-25', -1),
(19, 11, '2017-10-25', 0),
(20, 11, '2017-10-25', 0),
(21, 11, '2017-10-25', 1),
(22, 11, '2017-10-25', 0),
(23, 11, '2017-10-25', 0),
(24, 11, '2017-10-25', 0),
(25, 11, '2017-10-25', 0),
(26, 11, '2017-11-04', 0),
(27, 11, '2017-11-06', 0),
(28, 11, '2017-11-09', 0),
(29, 10, '2017-11-09', 0),
(30, 11, '2017-11-10', 0),
(31, 11, '2017-11-10', 0),
(32, 11, '2017-11-10', 0),
(33, 11, '2017-11-10', 0),
(34, 11, '2017-11-10', 0),
(35, 11, '2017-11-10', 0),
(36, 11, '2017-11-10', 0),
(37, 10, '2017-11-11', 0),
(38, 10, '2017-11-11', 0),
(39, 10, '2017-11-11', 0),
(40, 11, '2017-11-12', 0),
(41, 11, '2017-11-12', 0),
(42, 11, '2017-11-13', 0),
(43, 11, '2017-11-13', 0),
(44, 11, '2017-11-13', 0),
(45, 11, '2017-11-13', 0),
(46, 10, '2017-11-13', 0),
(47, 10, '2017-11-13', 0),
(48, 11, '2017-11-13', 0),
(49, 11, '2017-11-13', 0),
(50, 11, '2017-11-13', 0),
(51, 11, '2017-11-13', 0),
(52, 11, '2017-11-13', 0),
(53, 11, '2017-11-13', 0),
(54, 11, '2017-11-13', 0),
(55, 10, '2017-11-14', 0),
(56, 11, '2017-11-14', 0),
(57, 11, '2017-11-15', 0),
(58, 11, '2017-11-15', 0),
(59, 10, '2017-11-15', 0),
(60, 11, '2017-11-15', 0),
(61, 11, '2017-11-16', 0),
(62, 11, '2017-11-16', 0),
(63, 11, '2017-11-16', 0),
(64, 11, '2017-11-16', 0),
(65, 11, '2017-11-16', 0),
(66, 10, '2017-11-16', 0),
(67, 10, '2017-11-16', 0),
(68, 10, '2017-11-16', 0),
(69, 11, '2017-11-17', 0),
(70, 11, '2017-11-17', 0),
(71, 11, '2017-11-17', 0),
(72, 11, '2017-11-17', 0),
(73, 11, '2017-11-17', 0),
(74, 10, '2017-11-17', 0),
(75, 10, '2017-11-17', 0),
(76, 10, '2017-11-17', 0),
(77, 11, '2017-11-17', 0),
(78, 11, '2017-11-18', 0),
(79, 11, '2017-11-18', 0),
(80, 11, '2017-11-18', 0),
(81, 11, '2017-11-18', 0),
(82, 11, '2017-11-18', 0),
(83, 11, '2017-11-18', 0),
(84, 11, '2017-11-18', 0),
(85, 11, '2017-11-18', 0),
(86, 11, '2017-11-18', 0),
(87, 11, '2017-11-18', 0),
(88, 11, '2017-11-18', 0),
(89, 11, '2017-11-18', 0),
(90, 11, '2017-11-18', 0),
(91, 11, '2017-11-18', 0),
(92, 11, '2017-11-18', 0),
(93, 10, '2017-11-18', 0),
(94, 11, '2017-11-18', 0),
(95, 11, '2017-11-18', 0),
(96, 10, '2017-11-18', 0),
(97, 10, '2017-11-18', 0),
(98, 10, '2017-11-18', 0),
(99, 10, '2017-11-18', 0),
(100, 10, '2017-11-18', 0),
(101, 10, '2017-11-18', 0),
(102, 10, '2017-11-18', 0),
(103, 10, '2017-11-18', 0),
(104, 11, '2017-11-18', 0),
(105, 11, '2017-11-18', 0),
(106, 11, '2017-11-18', 0),
(107, 11, '2017-11-18', 0),
(108, 11, '2017-11-18', 0),
(109, 11, '2017-11-18', 0),
(110, 11, '2017-11-18', 0),
(111, 11, '2017-11-18', 0),
(112, 10, '2017-11-19', 0),
(113, 10, '2017-11-19', 0),
(114, 10, '2017-11-19', 0),
(115, 11, '2017-11-19', 0),
(116, 11, '2017-11-19', 0),
(117, 11, '2017-11-19', 0),
(118, 10, '2017-11-19', 0),
(119, 11, '2017-11-19', 0),
(120, 11, '2017-11-19', 0),
(121, 11, '2017-11-19', 0),
(122, 10, '2017-11-19', 0),
(123, 11, '2017-11-19', 0),
(124, 11, '2017-11-19', 0),
(125, 10, '2017-11-19', 0),
(126, 11, '2017-11-19', 0),
(127, 11, '2017-11-19', 0),
(128, 11, '2017-11-19', 0),
(129, 11, '2017-11-19', 0),
(130, 10, '2017-11-19', 0),
(131, 10, '2017-11-19', 0),
(132, 10, '2017-11-19', 0),
(133, 10, '2017-11-19', 0),
(134, 11, '2017-11-19', 0),
(135, 11, '2017-11-19', 0),
(136, 11, '2017-11-19', 0),
(137, 10, '2017-11-19', 0),
(138, 11, '2017-11-19', 0),
(139, 11, '2017-11-19', 0),
(140, 10, '2017-11-19', 0),
(141, 10, '2017-11-19', 0),
(142, 11, '2017-11-20', 0),
(143, 11, '2017-11-20', 0),
(144, 10, '2017-11-20', 0),
(145, 11, '2017-11-20', 0),
(146, 10, '2017-11-20', 0),
(147, 10, '2017-11-20', 0),
(148, 11, '2017-11-20', 0),
(149, 11, '2017-11-20', 0),
(150, 10, '2017-11-20', 0),
(151, 10, '2017-11-20', 0),
(152, 11, '2017-11-23', 0),
(153, 11, '2017-11-23', 0),
(154, 11, '2017-11-23', 0),
(155, 11, '2017-11-23', 0),
(156, 10, '2017-11-23', 0),
(157, 10, '2017-11-23', 0),
(158, 10, '2017-11-24', 0),
(159, 10, '2017-11-24', 0),
(160, 10, '2017-11-25', 0),
(161, 10, '2017-11-26', 0),
(162, 11, '2017-11-27', 0),
(163, 11, '2017-11-27', 0),
(164, 11, '2017-11-28', 0),
(165, 11, '2017-11-28', 0),
(166, 11, '2017-11-28', 0),
(167, 11, '2017-11-29', 0),
(168, 11, '2017-11-29', 0),
(169, 11, '2017-11-29', 0),
(170, 11, '2017-11-29', 0),
(171, 11, '2017-12-01', 0),
(172, 11, '2017-12-03', 0),
(173, 11, '2017-12-03', 0),
(174, 11, '2017-12-03', 0),
(175, 11, '2017-12-05', 0),
(176, 11, '2017-12-06', 0),
(177, 11, '2017-12-06', 0),
(178, 11, '2017-12-07', 0),
(179, 11, '2017-12-07', 0),
(180, 11, '2017-12-17', 0),
(181, 11, '2017-12-19', 0),
(182, 11, '2017-12-19', 0),
(183, 11, '2017-12-19', 0),
(184, 11, '2017-12-19', 0),
(185, 11, '2017-12-19', 0),
(186, 11, '2017-12-19', 0),
(187, 10, '2017-12-26', 0),
(188, 11, '2018-01-06', 0),
(189, 11, '2018-01-06', 0),
(190, 11, '2018-01-06', 0),
(191, 11, '2018-01-06', 0),
(192, 11, '2018-01-09', 0),
(193, 11, '2018-01-13', 0),
(194, 11, '2018-01-13', 0),
(195, 11, '2018-01-13', 0),
(196, 11, '2018-01-13', 0),
(197, 11, '2018-01-13', 0),
(198, 11, '2018-01-13', 0),
(199, 11, '2018-01-13', 0),
(200, 11, '2018-01-13', 0),
(201, 11, '2018-01-13', 0),
(202, 11, '2018-01-13', 0),
(203, 11, '2018-01-14', 0),
(204, 10, '2018-01-14', 0),
(205, 11, '2018-01-22', 0),
(206, 11, '2018-02-11', 0),
(207, 11, '2018-02-11', 0),
(208, 11, '2018-02-12', 0),
(209, 11, '2018-02-12', 0),
(210, 11, '2018-02-12', 0),
(211, 11, '2018-02-12', 0),
(212, 11, '2018-02-12', 0),
(213, 11, '2018-02-12', 0),
(214, 11, '2018-02-12', 0),
(215, 11, '2018-02-12', 0),
(216, 11, '2019-10-28', 0),
(217, 11, '2019-11-18', 0),
(218, 11, '2019-11-18', 0),
(219, 11, '2019-11-18', 0),
(220, 11, '2019-11-19', 0),
(221, 11, '2019-11-19', 0),
(222, 11, '2019-11-19', 0),
(223, 11, '2019-11-19', 0),
(224, 11, '2019-11-19', 0),
(225, 11, '2019-11-19', 0),
(226, 11, '2019-11-20', 0),
(227, 10, '2019-11-20', 0),
(228, 10, '2019-11-20', 0),
(229, 11, '2019-11-22', 0),
(230, 11, '2019-11-22', 0),
(231, 11, '2019-11-23', 0),
(232, 11, '2019-11-23', 0),
(233, 11, '2019-11-23', 0),
(234, 11, '2019-11-23', 0),
(235, 11, '2019-11-23', 0),
(236, 11, '2019-11-23', 0),
(237, 11, '2019-11-23', 0),
(238, 11, '2019-11-23', 0),
(239, 10, '2019-11-24', 0),
(240, 11, '2019-11-25', 0),
(241, 11, '2019-11-25', 0),
(242, 11, '2019-11-25', 0),
(243, 11, '2019-11-25', 0),
(244, 11, '2019-11-25', 0),
(245, 11, '2019-11-25', 0),
(246, 10, '2019-11-25', 0),
(247, 10, '2019-11-26', 0),
(248, 11, '2019-11-26', 0),
(249, 11, '2019-11-26', 0),
(250, 11, '2019-11-26', 0),
(251, 11, '2019-11-26', 0),
(252, 11, '2019-11-26', 0),
(253, 10, '2019-11-27', 0),
(254, 10, '2019-11-27', 0),
(255, 11, '2019-11-27', 0),
(256, 11, '2019-11-29', 0),
(257, 11, '2019-11-29', 0),
(258, 11, '2019-11-29', 0),
(259, 10, '2019-11-30', 0),
(260, 10, '2019-11-30', 0),
(261, 11, '2019-12-03', 0),
(262, 11, '2019-12-03', 0),
(263, 11, '2019-12-03', 0),
(264, 11, '2019-12-03', 0),
(265, 11, '2019-12-03', 0);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `ID` int(11) NOT NULL,
  `Title` varchar(200) DEFAULT NULL,
  `author` int(11) NOT NULL,
  `Description` varchar(500) DEFAULT NULL,
  `Price` float DEFAULT NULL,
  `stock` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `Category` int(11) DEFAULT NULL,
  `image` varchar(500) NOT NULL DEFAULT 'products/empty.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`ID`, `Title`, `author`, `Description`, `Price`, `stock`, `Category`, `image`) VALUES
(1, 'Sams Teach Yourself SQL in 10 Minutes (3rd Edition)', 2, 'Sams Teach Yourself SQL in 10 Minutes has established itself as the gold standard for introductory SQL books, offering a fast-paced accessible tutorial to the major themes and techniques involved in applying the SQL language. Forta\'s examples are clear and his writing style is crisp and concise. As with earlier editions, this revision includes coverage of current versions of all major commercial SQL platforms.', 15, 2, 3, 'products/prod_2.png'),
(2, 'Fundamentals of Database Systems', 2, 'This introduction to database systems offers a comprehensive approach, focusing on database design, database use, and implementation of database applications and database management systems.', 30, 3, 3, 'products/prod_3.png'),
(3, 'Database Systems: The Complete Book', 2, 'Clear explanations of theory and design, broad coverage of models and real systems, and an up-to-date introduction to modern database technologies result in a leading introduction to database systems. Intended for computer science majors, Fundamentals of Database Systems, 6/e emphasizes math models, design issues, relational algebra, and relational calculus.', 35, 4, 3, 'products/prod_1.png'),
(4, 'Java In A Nutshell, 5th Edition', 1, 'With more than 700,000 copies sold to date, Java in a Nutshell from O\'Reilly is clearly the favorite resource amongst the legion of developers and programmers using Java technology. And now, with the release of the 5.0 version of Java, O\'Reilly has given the book that defined the \"in a Nutshell\" category another impressive tune-up. ', 30, 2, 1, 'products/prod_1.png'),
(5, 'Essential C# 4.0', 2, 'Essential C# 4.0 is a well-organized,no-fluff guide to all versions of C# for programmers at all levels of C# experience. This fully updated edition shows how to make the most of C# 4.0’s new features and programming patterns to write code that is simple, yet powerful.', 40, 0, 1, 'products/prod_3.png'),
(6, 'PHP and MySQL Web Development ', 2, 'The PHP server-side scripting language and the MySQL database management system (DBMS) make a potent pair. Both are open-source products--free of charge for most purposes--remarkably strong, and capable of handling all but the most enormous transaction loads. Both are supported by large, skilled, and enthusiastic communities of architects, programmers, and designers.', 35, 2, 1, 'products/prod_1.png'),
(7, 'Unix in a Nutshell, Fourth Edition', 2, 'Unix in a Nutshell is the standard desktop reference, without question. (Manpages come in a close second.) With a clean layout and superior command tables available at a glance, O\'Reilly\'s third edition of Nutshell is an essential to own.', 25, 3, 2, 'products/prod_1.png'),
(8, 'Windows 7: The Missing Manual', 2, 'In early reviews, geeks raved about Windows 7. But if you\'re an ordinary mortal, learning what this new system is all about will be challenging. Fear not: David Pogue\'s Windows 7: The Missing Manual comes to the rescue. Like its predecessors, this book illuminates its subject with reader-friendly insight, plenty of wit, and hardnosed objectivity for beginners as well as veteran PC users. ', 25, 1, 2, 'products/prod_3.png'),
(9, 'Understanding the Linux Kernel, Third Edition', 2, 'In order to thoroughly understand what makes Linux tick and why it works so well on a wide variety of systems, you need to delve deep into the heart of the kernel. The kernel handles all interactions between the CPU and the external world, and determines which programs will share processor time, in what order. It manages limited memory so well that hundreds of processes can share the system efficiently, and expertly organizes data transfers so that the CPU isn\'t kept waiting any longer than nece', 30, 2, 2, 'products/prod_1.png'),
(10, 'TCP/IP Illustrated, Vol. 1: The Protocols ', 1, 'TCP/IP Illustrated, Volume 1: The Protocols is an excellent text that provides encyclopedic coverage of the TCP/IP protocol suite. What sets this book apart from others on this subject is the fact that the author supplements all of the discussion with data collected via diagnostic programs; thus, it is possible to \"watch\" the protocols in action in a real situation. Also, the diagnostic tools involved are publicly available; the reader has the opportunity to play along at home. This offers the r', 50, 1, 4, 'products/prod_3.png'),
(11, 'CCNA: Cisco Certified Network Associate Study Guide', 2, 'Cisco networking authority Todd Lammle has completely updated this new edition to cover all of the exam objectives for the latest version of the CCNA exam. Todd’s straightforward style provides lively examples, easy-to-understand analogies, and real-world scenarios that will not only help you prepare for the exam, but also give you a solid foundation as a Cisco networking professional.', 50, 4, 4, 'products/prod_3.png'),
(12, 'Network Security Essentials: Applications and Standards (4th Edition)', 1, 'Wiliiam Stallings\' Network Security: Applications and Standards, 4/e is a practical survey of network security applications and standards, with unmatched support for instructors and students.', 60, 4, 4, 'products/prod_2.png'),
(13, 'Learning Web Design: A Beginner\'s Guide to (X)HTML, StyleSheets, and Web Graphics', 2, 'Everything you need to know to create professional web sites is right here. Learning Web Design  starts from the beginning -- defining how the Web and web pages work -- and builds from there. By the end of the book, you\'ll have the skills to create multi-column CSS layouts with optimized graphic files, and you\'ll know how to get your pages up on the Web.\r\nEverything you need to know to create professional web sites is right here. Learning Web Design  starts from the beginning -- defining how the', 40, 4, 5, 'products/prod_2.png'),
(14, 'Beginning Web Programming with HTML, XHTML, and CSS', 1, 'This beginning guide reviews HTML and also introduces you to using XHTML for the structure of a web page and cascading style sheets (CSS) for controlling how a document should appear on a web page. You?ll learn how to take advantage of the latest features of browsers while making sure that your pages still work in older, but popular, browsers. By incorporating usability and accessibility, you?ll be able to write professional-looking and well-coded web pages that use the latest technologies. ', 35, 3, 12, 'products/prod_4.png'),
(15, 'Programming the World Wide Web', 1, 'Programming the World Wide Web 2010 provides a comprehensive introduction to the tools and skills required for both client- and server-side programming, teaching students how to develop platform-independent sites using the most current Web development technology', 50, 4, 5, 'products/prod_3.png'),
(21, 'Windows 10: The Missing Manual', 2, 'In early reviews, geeks raved about Windows 10. But if you\'re an ordinary mortal, learning what this new system is all about will be challenging. Fear not: David Pogue\'s Windows 7: The Missing Manual comes to the rescue. Like its predecessors, this book illuminates its subject with reader-friendly insight, plenty of wit, and hardnosed objectivity for beginners as well as veteran PC users. ', 25, 0, 2, 'products/prod_1.png'),
(25, 'dfhgdfg', 1, 'dfgdfg', 45, 45, 7, 'products/empty.png'),
(26, 'asd', 2, 'sdf', 24, 234, 9, 'products/empty.png'),
(28, 'fg', 1, '435dfgdfg dfg', 43, 34, 1, 'products/empty.png'),
(29, 'http://localhost:8080/', 1, 'dg', 45, 45, 8, 'products/empty.png'),
(33, 'dfg', 2, 'dfg', 45, 45, 1, 'products/empty.png');

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_best_sellers`
-- (See below for the actual view)
--
CREATE TABLE `v_best_sellers` (
`id` int(11)
,`title` varchar(200)
,`img` varchar(500)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_books`
-- (See below for the actual view)
--
CREATE TABLE `v_books` (
`book_id` int(11)
,`title` varchar(200)
,`author_id` int(11)
,`author` varchar(100)
,`description` varchar(500)
,`category_id` int(11)
,`category` varchar(200)
,`price` float
,`stock` int(11) unsigned
,`image` varchar(500)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_new_books`
-- (See below for the actual view)
--
CREATE TABLE `v_new_books` (
`id` int(11)
,`title` varchar(200)
,`img` varchar(500)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_orders`
-- (See below for the actual view)
--
CREATE TABLE `v_orders` (
`ID` int(11)
,`customer` varchar(201)
,`oDate` date
,`total price` double
,`Status` int(11)
);

-- --------------------------------------------------------

--
-- Structure for view `v_best_sellers`
--
DROP TABLE IF EXISTS `v_best_sellers`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_best_sellers`  AS  select `d`.`Product` AS `id`,`p`.`Title` AS `title`,`p`.`image` AS `img` from (`orderdetails` `d` join `product` `p` on(`p`.`ID` = `d`.`Product`)) group by `d`.`Product` order by count(`d`.`ID` * `d`.`Quantity`) desc limit 5 ;

-- --------------------------------------------------------

--
-- Structure for view `v_books`
--
DROP TABLE IF EXISTS `v_books`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_books`  AS  select `b`.`ID` AS `book_id`,`b`.`Title` AS `title`,`a`.`ID` AS `author_id`,`a`.`name` AS `author`,`b`.`Description` AS `description`,`c`.`ID` AS `category_id`,`c`.`Name` AS `category`,`b`.`Price` AS `price`,`b`.`stock` AS `stock`,`b`.`image` AS `image` from ((`product` `b` join `category` `c` on(`c`.`ID` = `b`.`Category`)) join `author` `a` on(`a`.`ID` = `b`.`author`)) order by `b`.`Title` ;

-- --------------------------------------------------------

--
-- Structure for view `v_new_books`
--
DROP TABLE IF EXISTS `v_new_books`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_new_books`  AS  select `d`.`Product` AS `id`,`p`.`Title` AS `title`,`p`.`image` AS `img` from (`orderdetails` `d` join `product` `p` on(`p`.`ID` = `d`.`Product`)) group by `d`.`Product` order by `p`.`ID` desc limit 5 ;

-- --------------------------------------------------------

--
-- Structure for view `v_orders`
--
DROP TABLE IF EXISTS `v_orders`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_orders`  AS  select `orders`.`ID` AS `ID`,concat(`customer`.`Lname`,' ',`customer`.`Fname`) AS `customer`,`orders`.`oDate` AS `oDate`,sum(`orderdetails`.`Quantity` * `product`.`Price`) AS `total price`,`orders`.`Status` AS `Status` from (((`orders` join `orderdetails` on(`orderdetails`.`Orders` = `orders`.`ID`)) join `product` on(`product`.`ID` = `orderdetails`.`Product`)) join `customer` on(`customer`.`ID` = `orders`.`Customer`)) group by `orderdetails`.`Orders` ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `author`
--
ALTER TABLE `author`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `orderdetails`
--
ALTER TABLE `orderdetails`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `fk_orderdetails_orderID` (`Orders`),
  ADD KEY `fk_orderdetails_productID` (`Product`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `fk_order_customerID` (`Customer`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `Category` (`Category`),
  ADD KEY `fk_product_authorid` (`author`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `author`
--
ALTER TABLE `author`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `orderdetails`
--
ALTER TABLE `orderdetails`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=464;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=266;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orderdetails`
--
ALTER TABLE `orderdetails`
  ADD CONSTRAINT `fk_orderdetails_orderID` FOREIGN KEY (`Orders`) REFERENCES `orders` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_orderdetails_productID` FOREIGN KEY (`Product`) REFERENCES `product` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `fk_order_customerID` FOREIGN KEY (`Customer`) REFERENCES `customer` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `fk_product_authorid` FOREIGN KEY (`author`) REFERENCES `author` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_product_categoryid` FOREIGN KEY (`Category`) REFERENCES `category` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
