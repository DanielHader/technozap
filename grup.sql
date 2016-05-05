-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 05, 2016 at 12:07 PM
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
(2, 'john123', 'John Cena is the best!!! - anon', 7, '2016-05-05 16:27:41'),
(3, 'gamer123', 'Anyone up for hexakill?', 8, '2016-05-05 16:48:11'),
(4, 'gamer123', 'How 2 play Tracer? Someone help plz', 9, '2016-05-05 16:48:52'),
(5, 'gamer123', 'As Karin, you could do a quick side-switch reset using Ex Orochi into an Ex Dash. Could also do a regular dash to stay on the same side for a meaty incoming setup.', 10, '2016-05-05 16:57:12');

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
(5, 'Street Fighter V', 5);

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
(5, 'gamer123', '8d14209979e72ca2dab21de9ff36f0f1af672ab118a74342ca56f1a4812f225c', 'Joseph', 'Zhang', 'jz020@email.uark.edu', 'https://cdn3.iconfinder.com/data/icons/black-easy/512/535112-game_512x512.png');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `uglink`
--
ALTER TABLE `uglink`
  MODIFY `linkid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
