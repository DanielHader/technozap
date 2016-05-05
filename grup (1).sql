-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 05, 2016 at 01:57 PM
-- Server version: 5.7.12-0ubuntu1
-- PHP Version: 7.0.4-7ubuntu2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `grup`
--

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `description` text NOT NULL,
  `image` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `name`, `description`, `image`) VALUES
(7, 'John Cena Fan Club', 'We idolize John Cena!', 'http://1.bp.blogspot.com/-Hsashvym-N4/TzvQtsAzFHI/AAAAAAAAAZE/za9iP3v_6Ig/s640/Logo.jpg'),
(8, 'League of Legends', 'Speculate on strategies, updates, and the competitive scene for LoL.', 'http://assets1.ignimgs.com/2014/12/02/league-of-legends-champions-art-1280x720jpg-14aa17_1280w.jpg'),
(9, 'Overwatch', 'Talk about how much we want to play Overwatch!', 'http://www.edropian.com/wp-content/uploads/Esports-Overwatch-Banner-Edropian-.png'),
(10, 'Street Fighter V', 'Share your mixups, frame traps, resets, combos, and tech here!', 'http://cdn.akamai.steamstatic.com/steam/apps/310950/header.jpg?t=1461968083');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `userName` text NOT NULL,
  `content` text NOT NULL,
  `groupid` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `userName`, `content`, `groupid`, `date`) VALUES
(2, 'john123', 'John Cena is the best!!! - anon', 7, '2016-05-05 18:13:31'),
(3, 'gamer1', 'Anyone up for hexakill?', 8, '2016-05-05 18:13:34'),
(4, 'gamer1', 'How 2 play Tracer? Someone help plz', 9, '2016-05-05 18:13:41'),
(5, 'gamer1', 'As Karin, you could do a quick side-switch reset using Ex Orochi into an Ex Dash. Could also do a regular dash to stay on the same side for a meaty incoming setup.', 10, '2016-05-05 18:13:44'),
(6, 'john123', '<iframe width="560" height="315" src="https://www.youtube.com/embed/2G2w77jrayw" frameborder="0" allowfullscreen></iframe>', 7, '2016-05-05 18:10:55'),
(7, 'gamer2', 'OMG check out this combo!\r\n<iframe width="560" height="315" src="https://www.youtube.com/embed/lCOGV-mzN-4" frameborder="0" allowfullscreen></iframe>', 10, '2016-05-05 18:39:36'),
(8, 'gamer2', '<iframe width="560" height="315" src="https://www.youtube.com/embed/YaLopjibdOY" frameborder="0" allowfullscreen></iframe>', 9, '2016-05-05 18:43:54'),
(9, 'gamer3', '<iframe width="560" height="315" src="https://www.youtube.com/embed/KDIAGsCOWD8" frameborder="0" allowfullscreen></iframe>', 8, '2016-05-05 18:47:16');

-- --------------------------------------------------------

--
-- Table structure for table `uglink`
--

CREATE TABLE `uglink` (
  `linkid` int(11) NOT NULL,
  `groupName` text NOT NULL,
  `userid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `uglink`
--

INSERT INTO `uglink` (`linkid`, `groupName`, `userid`) VALUES
(2, 'John Cena Fan Club', 4),
(3, 'League of Legends', 5),
(4, 'Overwatch', 5),
(5, 'Street Fighter V', 5),
(13, 'Street Fighter V', 6),
(16, 'League of Legends', 6),
(17, 'Overwatch', 6),
(18, 'Street Fighter V', 7),
(19, 'Overwatch', 7),
(20, 'League of Legends', 8);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `first name` text NOT NULL,
  `last name` text NOT NULL,
  `email` text NOT NULL,
  `image` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `first name`, `last name`, `email`, `image`) VALUES
(4, 'john123', 'e1fbff69a27f6b4bd83fc206fbb1b67a5f4b7575293660187febed28a21f90cb', 'John', 'Cena', 'jcena@uark.edu', 'https://pbs.twimg.com/profile_images/661041286942584832/a5SW7Qz5.jpg'),
(6, 'gamer1', '0fcfaa4c3f25da043c5edc2931d2b8af6c618eb7b62c83793088b3b1386638c8', 'Joseph', 'Zhang', 'jz020@email.uark.edu', 'https://cdn3.iconfinder.com/data/icons/black-easy/512/535112-game_512x512.png'),
(7, 'gamer2', '0c7b852c25bd501433abd862fe3e7c8bf0d559cb582bd3349925c7e6b141b523', 'Jeffrey', 'Johnson', 'jlj@uark.edu', 'https://cdn3.iconfinder.com/data/icons/objects/512/Gamer-512.png'),
(8, 'gamer3', 'd75416393877510b6c3c09e46b16ade21d64dca0797c8297dc3a75fdc54f9bbc', 'Ben', 'Maxwell', 'bt@uark.edu', 'http://orig12.deviantart.net/ce60/f/2016/004/8/d/wii_remote_smash_bros__series_icon_by_mrthatkidalex24-d9mqt28.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `id_2` (`id`),
  ADD KEY `id_3` (`id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `uglink`
--
ALTER TABLE `uglink`
  ADD PRIMARY KEY (`linkid`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `uglink`
--
ALTER TABLE `uglink`
  MODIFY `linkid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
