-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 2018 m. Sau 23 d. 15:11
-- Server version: 10.1.26-MariaDB
-- PHP Version: 7.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `social_network`
--

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `conversation`
--

CREATE TABLE `conversation` (
  `id` int(11) NOT NULL,
  `user_one` int(11) NOT NULL,
  `user_two` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Sukurta duomenų kopija lentelei `conversation`
--

INSERT INTO `conversation` (`id`, `user_one`, `user_two`) VALUES
(1, 40, 57),
(2, 54, 40),
(3, 40, 56),
(4, 40, 58),
(5, 57, 56),
(6, 61, 56),
(7, 62, 56);

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `friendrequest`
--

CREATE TABLE `friendrequest` (
  `request_id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Sukurta duomenų kopija lentelei `friendrequest`
--

INSERT INTO `friendrequest` (`request_id`, `sender_id`, `receiver_id`) VALUES
(2, 40, 59);

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `friends`
--

CREATE TABLE `friends` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_friend_id` int(11) NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Sukurta duomenų kopija lentelei `friends`
--

INSERT INTO `friends` (`id`, `user_id`, `user_friend_id`, `date`) VALUES
(1, 40, 57, '2017-12-27 23:03:13'),
(2, 57, 40, '2017-12-27 23:03:13'),
(3, 56, 57, '2017-12-27 23:08:35'),
(4, 57, 56, '2017-12-27 23:08:35'),
(5, 40, 56, '2017-12-27 23:09:28'),
(6, 56, 40, '2017-12-27 23:09:29'),
(7, 54, 40, '2017-12-27 23:15:58'),
(8, 40, 54, '2017-12-27 23:15:58'),
(9, 58, 40, '2017-12-28 21:31:54'),
(10, 40, 58, '2017-12-28 21:31:54'),
(11, 61, 56, '2018-01-10 17:12:48'),
(12, 56, 61, '2018-01-10 17:12:48'),
(15, 62, 56, '2018-01-11 07:14:41'),
(16, 56, 62, '2018-01-11 07:14:41');

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `hobbielist`
--

CREATE TABLE `hobbielist` (
  `hobbie_id` int(11) NOT NULL,
  `hobbie_name` varchar(200) NOT NULL,
  `hobie_type` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Sukurta duomenų kopija lentelei `hobbielist`
--

INSERT INTO `hobbielist` (`hobbie_id`, `hobbie_name`, `hobie_type`) VALUES
(10, 'KrepÅ¡inis', 'Sport'),
(11, 'Futbolas', 'Sport'),
(12, 'Tenisas', 'Sport'),
(13, 'Tinklinis', 'Sport'),
(14, 'Å achmatai', 'Sport'),
(15, 'Rokas', 'Music'),
(16, 'ElektroninÄ— muzika', 'Music'),
(17, 'KlasikinÄ— muzika', 'Music'),
(18, 'Liaudies muzika', 'Music'),
(19, 'Pop muzika', 'Music'),
(20, 'Sunkusis Metalas', 'Music'),
(21, 'Repas', 'Music'),
(22, 'MokslinÄ— literatÅ«ra', 'Books'),
(23, 'Detektyvai', 'Books'),
(24, 'Fantastika', 'Books'),
(25, 'MeilÄ—s romanai', 'Books'),
(26, 'Teatras', 'Other'),
(27, 'Kinas', 'Other'),
(28, 'Å½Å«klÄ—', 'Other'),
(29, 'MedÅ¾ioklÄ—', 'Other'),
(30, 'Stovyklavimas', 'Other'),
(35, 'Kovos menai', 'Sport'),
(37, 'ParaÅ¡iutÅ³ sportas', 'Sport'),
(38, 'AutomobiliÅ³ sportas', 'Sport'),
(39, 'Dartai', 'Sport'),
(40, 'biljardas', 'Sport');

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `hobbies`
--

CREATE TABLE `hobbies` (
  `hobbie_id` int(11) NOT NULL,
  `hobbie_name` varchar(255) NOT NULL,
  `hobbie_type` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Sukurta duomenų kopija lentelei `hobbies`
--

INSERT INTO `hobbies` (`hobbie_id`, `hobbie_name`, `hobbie_type`, `user_id`) VALUES
(88, 'Futbolas', 'sport', 54),
(89, 'ElektroninÄ— muzika', 'music', 54),
(90, 'Pop muzika', 'music', 54),
(91, 'Repas', 'music', 54),
(92, 'Detektyvai', 'books', 54),
(93, 'Fantastika', 'books', 54),
(94, 'Kinas', 'other', 54),
(95, 'Å½Å«klÄ—', 'other', 54),
(96, 'MedÅ¾ioklÄ—', 'other', 54),
(98, 'Futbolas', 'sport', 55),
(99, 'Pop muzika', 'music', 55),
(100, 'MedÅ¾ioklÄ—', 'other', 55),
(101, 'Stovyklavimas', 'other', 55),
(110, 'Futbolas', 'sport', 57),
(111, 'Liaudies muzika', 'music', 57),
(112, 'Pop muzika', 'music', 57),
(113, 'MokslinÄ— literatÅ«ra', 'books', 57),
(114, 'Å½Å«klÄ—', 'other', 57),
(115, 'MedÅ¾ioklÄ—', 'other', 57),
(116, 'Stovyklavimas', 'other', 57),
(129, 'Tenisas', 'sport', 59),
(130, 'Tinklinis', 'sport', 59),
(131, 'Rokas', 'music', 59),
(132, 'ElektroninÄ— muzika', 'music', 59),
(133, 'Sunkusis Metalas', 'music', 59),
(134, 'MokslinÄ— literatÅ«ra', 'books', 59),
(135, 'MeilÄ—s romanai', 'books', 59),
(136, 'Teatras', 'other', 59),
(137, 'Kinas', 'other', 59),
(138, 'Stovyklavimas', 'other', 59),
(396, 'KrepÅ¡inis', 'sport', 56),
(397, 'Tinklinis', 'sport', 56),
(398, 'AutomobiliÅ³ sportas', 'sport', 56),
(399, 'Repas', 'music', 56),
(400, 'Kinas', 'other', 56),
(401, 'Å½Å«klÄ—', 'other', 56),
(402, 'MedÅ¾ioklÄ—', 'other', 56),
(405, 'KrepÅ¡inis', 'sport', 61),
(406, 'AutomobiliÅ³ sportas', 'sport', 61),
(443, 'KrepÅ¡inis', 'sport', 62),
(444, 'AutomobiliÅ³ sportas', 'sport', 62),
(445, 'Rokas', 'music', 62),
(446, 'Å½Å«klÄ—', 'other', 62),
(447, 'MedÅ¾ioklÄ—', 'other', 62),
(482, 'Tenisas', 'sport', 58),
(483, 'Å achmatai', 'sport', 58),
(484, 'Rokas', 'music', 58),
(485, 'ElektroninÄ— muzika', 'music', 58),
(486, 'Pop muzika', 'music', 58),
(487, 'Sunkusis Metalas', 'music', 58),
(488, 'Fantastika', 'books', 58),
(489, 'MeilÄ—s romanai', 'books', 58),
(490, 'Teatras', 'other', 58),
(491, 'Kinas', 'other', 58),
(492, 'Stovyklavimas', 'other', 58),
(493, 'KrepÅ¡inis', 'sport', 40),
(494, 'Futbolas', 'sport', 40),
(495, 'Tenisas', 'sport', 40),
(496, 'Tinklinis', 'sport', 40),
(497, 'Å achmatai', 'sport', 40),
(498, 'Rokas', 'music', 40),
(499, 'Sunkusis Metalas', 'music', 40),
(500, 'Repas', 'music', 40),
(501, 'MokslinÄ— literatÅ«ra', 'books', 40),
(502, 'Detektyvai', 'books', 40),
(503, 'Fantastika', 'books', 40),
(504, 'MeilÄ—s romanai', 'books', 40),
(505, 'Teatras', 'other', 40),
(506, 'Kinas', 'other', 40),
(507, 'Å½Å«klÄ—', 'other', 40),
(508, 'MedÅ¾ioklÄ—', 'other', 40),
(509, 'Stovyklavimas', 'other', 40);

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `conversation_id` int(11) NOT NULL,
  `user_from` int(11) NOT NULL,
  `user_to` int(11) NOT NULL,
  `message` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Sukurta duomenų kopija lentelei `messages`
--

INSERT INTO `messages` (`id`, `conversation_id`, `user_from`, `user_to`, `message`) VALUES
(1, 2, 54, 40, 'Labas, Administratoriau'),
(2, 2, 40, 54, 'Labas, Deividai,'),
(3, 4, 58, 40, 'Labas, administratoriau :)'),
(4, 4, 40, 58, 'Labas :)'),
(5, 7, 62, 56, 'Sveikias kai sekasi?'),
(6, 7, 56, 62, 'Gerai, o tau'),
(7, 4, 40, 58, 'Kaip sekasi?');

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `suggestedhobbies`
--

CREATE TABLE `suggestedhobbies` (
  `suggest_id` int(11) NOT NULL,
  `suggest_name` varchar(100) NOT NULL,
  `suggest_type` varchar(100) NOT NULL,
  `suggest_user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `userpictures`
--

CREATE TABLE `userpictures` (
  `picture_Id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `picture_link` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Sukurta duomenų kopija lentelei `userpictures`
--

INSERT INTO `userpictures` (`picture_Id`, `user_id`, `name`, `picture_link`) VALUES
(7, 40, '5a20735eea7800.03179910.png', 'uploads/40/5a20735eea7800.03179910.png'),
(8, 45, '5a39172da6fd86.02303648.png', 'uploads/45/5a39172da6fd86.02303648.png'),
(10, 45, '5a39174e999084.39858184.png', 'uploads/45/5a39174e999084.39858184.png'),
(11, 46, '5a39ff6ccc4208.06023597.png', 'uploads/46/5a39ff6ccc4208.06023597.png'),
(12, 54, '5a43fdb30d8760.65015865.jpg', 'uploads/54/5a43fdb30d8760.65015865.jpg'),
(13, 55, '5a441444d86190.68980771.png', 'uploads/55/5a441444d86190.68980771.png'),
(14, 56, '5a4416edc599f6.47295926.jpg', 'uploads/56/5a4416edc599f6.47295926.jpg'),
(15, 56, '5a4416f2322934.80217482.jpg', 'uploads/56/5a4416f2322934.80217482.jpg'),
(16, 57, '5a4417a8b57087.88821490.jpg', 'uploads/57/5a4417a8b57087.88821490.jpg'),
(17, 57, '5a4417abc87914.98105130.jpg', 'uploads/57/5a4417abc87914.98105130.jpg'),
(18, 40, '5a441bd5eca2c3.45644923.png', 'uploads/40/5a441bd5eca2c3.45644923.png'),
(19, 58, '5a441d5b29fe34.13360067.jpg', 'uploads/58/5a441d5b29fe34.13360067.jpg'),
(20, 59, '5a441e09738b51.65210022.png', 'uploads/59/5a441e09738b51.65210022.png'),
(22, 61, '5a563b073dee91.48795159.png', 'uploads/61/5a563b073dee91.48795159.png'),
(23, 56, '5a568797d5e745.29892040.jpg', 'uploads/56/5a568797d5e745.29892040.jpg'),
(24, 62, '5a5702266d76c2.41756791.png', 'uploads/62/5a5702266d76c2.41756791.png');

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `userpost`
--

CREATE TABLE `userpost` (
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `description` varchar(200) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Sukurta duomenų kopija lentelei `userpost`
--

INSERT INTO `userpost` (`post_id`, `user_id`, `description`, `date`) VALUES
(25, 54, 'Sveiki, Å¡iandien labai graÅ¾us Oras!', '2017-12-27 21:03:08'),
(26, 56, 'Breaking bad yra vienas geriausias serialÅ³ kurios maÄiau!', '2017-12-27 22:56:29'),
(27, 40, 'Kilus klausimams praÅ¡au raÅ¡yti Ä¯ PM', '2017-12-27 23:05:54'),
(28, 40, 'Man labai patiko daina https://www.youtube.com/watch?v=fLexgOxsZu0', '2017-12-31 00:36:33'),
(31, 58, 'Man labai patiko daina  https://www.youtube.com/watch?v=v2AC41dglnM', '2018-01-07 20:33:18'),
(32, 56, 'https://www.youtube.com/watch?v=AUJ1LiXO1MQ', '2018-01-10 16:48:08'),
(33, 61, 'KrepÅ¡inis jÄ—ga! https://www.youtube.com/watch?v=s696wUoQbDY', '2018-01-10 17:09:02'),
(34, 58, 'https://www.youtube.com/watch?v=-tJYN-eG1zk', '2018-01-10 22:49:23'),
(35, 62, 'Man patiko Å¡is Å¾aidimas - https://www.youtube.com/watch?v=zdbnXv8UsVc', '2018-01-11 07:15:19');

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `profileImage` varchar(200) NOT NULL,
  `genre` char(1) NOT NULL DEFAULT 'u',
  `role` int(11) NOT NULL,
  `warning` int(11) NOT NULL,
  `birthDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Sukurta duomenų kopija lentelei `users`
--

INSERT INTO `users` (`user_id`, `name`, `email`, `password`, `profileImage`, `genre`, `role`, `warning`, `birthDate`) VALUES
(40, 'Administratorius', 'admin@testmail.com', '$2y$10$Q8gBpoZTzvylxndM8HM6Du28BlseD0YmjCYHYywpncr11vLP/jaJe', 'uploads/40/5a441bd5eca2c3.45644923.png', 'U', 1, 0, '1995-10-16'),
(54, 'Deividas', 'deividas@testmail.com', '$2y$10$Q8gBpoZTzvylxndM8HM6Du28BlseD0YmjCYHYywpncr11vLP/jaJe', 'uploads/54/5a43fdb30d8760.65015865.jpg', 'M', 0, 0, '1997-07-01'),
(55, 'erlandas', 'erlandas@testmail.com', '$2y$10$lOlHR5zel918Ow8ryvlCGe/tClTWIu9zsU1tfhhkeGMYyKRNEJaBq', 'uploads/55/5a441444d86190.68980771.png', 'M', 0, 0, '1997-12-07'),
(56, 'Automanas', 'jonas@testmail.com', '$2y$10$f5RPub0W3uTDvkSo5XOgfOYZg/OLRJp0KiVpfZDVw0PwS1Nq/z/X.', 'uploads/56/5a4416f2322934.80217482.jpg', 'M', 0, 0, '1990-01-01'),
(57, 'antanas', 'antanas@testmail.com', '$2y$10$zK7RU1f6Xc6RyNftdc0KTeaeTKT/jWd2MWJbL5edouclM56e8ms2q', 'uploads/57/5a4417abc87914.98105130.jpg', 'M', 0, 0, '1985-12-16'),
(58, 'Janina', 'janina@testmail.com', '$2y$10$JiBm58j7.l0Z3iGctwYKye7lb3t94w1EiJ3ZLpGzkZ3IsweP8HxnO', 'uploads/58/5a441d5b29fe34.13360067.jpg', 'F', 0, 0, '1994-12-16'),
(59, 'AgnÄ—', 'agne@testmail.com', '$2y$10$rl1hww/lnSd98gYOEdyXBuWFlLzPJhb4NQnrV4bChnLz4B4GJdE22', 'uploads/59/5a441e09738b51.65210022.png', 'F', 0, 0, '1990-12-05'),
(60, 'testas', 'test@testmail.com', '$2y$10$qaRqSQddTEI8/r1o8lhktegEV0FIsKN4hfO1od1Qzb1oRln7Hk28m', 'assets/images/defaultProfileImage.png', 'M', 0, 2, '1995-12-12'),
(61, 'Kamuolys', 'ignas@testmail.com', '$2y$10$5IT/mFFsaAziaXFKWzpQ3eJHl4B8aFfG5/2DFahd9OohP8j86Pivq', 'uploads/61/5a563b073dee91.48795159.png', 'M', 0, 0, '1995-06-16'),
(62, 'zaidejas', 'zaidejas@testmail.com', '$2y$10$ISdMNAq9jQzpYhgdwNJiSu7KPNkE7hHI/067XuJCQ0UmrqN7MkW1K', 'uploads/62/5a5702266d76c2.41756791.png', 'M', 0, 0, '1995-12-16');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `conversation`
--
ALTER TABLE `conversation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `friendrequest`
--
ALTER TABLE `friendrequest`
  ADD PRIMARY KEY (`request_id`);

--
-- Indexes for table `friends`
--
ALTER TABLE `friends`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hobbielist`
--
ALTER TABLE `hobbielist`
  ADD PRIMARY KEY (`hobbie_id`);

--
-- Indexes for table `hobbies`
--
ALTER TABLE `hobbies`
  ADD PRIMARY KEY (`hobbie_id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `suggestedhobbies`
--
ALTER TABLE `suggestedhobbies`
  ADD PRIMARY KEY (`suggest_id`);

--
-- Indexes for table `userpictures`
--
ALTER TABLE `userpictures`
  ADD PRIMARY KEY (`picture_Id`);

--
-- Indexes for table `userpost`
--
ALTER TABLE `userpost`
  ADD PRIMARY KEY (`post_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `conversation`
--
ALTER TABLE `conversation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `friendrequest`
--
ALTER TABLE `friendrequest`
  MODIFY `request_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `friends`
--
ALTER TABLE `friends`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `hobbielist`
--
ALTER TABLE `hobbielist`
  MODIFY `hobbie_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `hobbies`
--
ALTER TABLE `hobbies`
  MODIFY `hobbie_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=510;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `suggestedhobbies`
--
ALTER TABLE `suggestedhobbies`
  MODIFY `suggest_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `userpictures`
--
ALTER TABLE `userpictures`
  MODIFY `picture_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `userpost`
--
ALTER TABLE `userpost`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
