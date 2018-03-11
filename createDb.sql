-- phpMyAdmin SQL Dump
-- version 4.7.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 10, 2018 at 05:42 PM
-- Server version: 5.6.35
-- PHP Version: 7.1.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `moviedb`
--
CREATE DATABASE IF NOT EXISTS `moviedb` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `moviedb`;

-- --------------------------------------------------------

--
-- Table structure for table `GENRE`
--

DROP TABLE IF EXISTS `GENRE`;
CREATE TABLE `GENRE` (
  `genreId` int(11) NOT NULL,
  `genreName` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `GENRE`
--

INSERT INTO `GENRE` (`genreId`, `genreName`) VALUES
(12, 'Adventure'),
(14, 'Fantasy'),
(16, 'Animation'),
(18, 'Drama'),
(27, 'Horror'),
(28, 'Action'),
(35, 'Comedy'),
(36, 'History'),
(37, 'Western'),
(53, 'Thriller'),
(80, 'Crime'),
(99, 'Documentary'),
(878, 'Science Fiction'),
(9648, 'Mystery'),
(10402, 'Music'),
(10749, 'Romance'),
(10751, 'Family'),
(10752, 'War'),
(10770, 'TV Movie');

-- --------------------------------------------------------

--
-- Table structure for table `MOVIE`
--

DROP TABLE IF EXISTS `MOVIE`;
CREATE TABLE `MOVIE` (
  `movieId` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` varchar(10000) DEFAULT NULL,
  `genreId` int(11) DEFAULT NULL,
  `releaseYear` int(11) DEFAULT NULL,
  `imdbId` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `MOVIE`
--

INSERT INTO `MOVIE` (`movieId`, `title`, `description`, `genreId`, `releaseYear`, `imdbId`) VALUES
(151, 'Beauty and the Beast', 'A live-action adaptation of Disney\'s version of the classic tale of a cursed prince and a beautiful young woman who helps him break the spell.', NULL, 2017, 'tt2771200'),
(152, 'Coco', 'Despite his family’s baffling generations-old ban on music, Miguel dreams of becoming an accomplished musician like his idol, Ernesto de la Cruz. Desperate to prove his talent, Miguel finds himself in the stunning and colorful Land of the Dead following a mysterious chain of events. Along the way, he meets charming trickster Hector, and together, they set off on an extraordinary journey to unlock the real story behind Miguel\'s family history.', NULL, 2017, 'tt2380307'),
(153, 'The Shape of Water', 'An other-worldly story, set against the backdrop of Cold War era America circa 1962, where a mute janitor working at a lab falls in love with an amphibious man being held captive there and devises a plan to help him escape.', NULL, 2017, 'tt5580390'),
(154, 'The Maze Runner', 'Set in a post-apocalyptic world, young Thomas is deposited in a community of boys after his memory is erased, soon learning they\'re all trapped in a maze that will require him to join forces with fellow “runners” for a shot at escape.', NULL, 2014, 'tt1790864');

-- --------------------------------------------------------

--
-- Table structure for table `MOVIE_GENRE`
--

DROP TABLE IF EXISTS `MOVIE_GENRE`;
CREATE TABLE `MOVIE_GENRE` (
  `movieId` int(11) NOT NULL,
  `genreId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `MOVIE_GENRE`
--

INSERT INTO `MOVIE_GENRE` (`movieId`, `genreId`) VALUES
(151, 10751),
(151, 14),
(151, 10749),
(152, 12),
(152, 16),
(152, 35),
(152, 10751),
(153, 18),
(153, 14),
(153, 10749),
(154, 28),
(154, 9648),
(154, 878),
(154, 53);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `GENRE`
--
ALTER TABLE `GENRE`
  ADD PRIMARY KEY (`genreId`);

--
-- Indexes for table `MOVIE`
--
ALTER TABLE `MOVIE`
  ADD PRIMARY KEY (`movieId`);

--
-- Indexes for table `MOVIE_GENRE`
--
ALTER TABLE `MOVIE_GENRE`
  ADD KEY `fk_movieId_idx` (`movieId`),
  ADD KEY `fk_genreId_idx` (`genreId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `MOVIE`
--
ALTER TABLE `MOVIE`
  MODIFY `movieId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=156;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `MOVIE_GENRE`
--
ALTER TABLE `MOVIE_GENRE`
  ADD CONSTRAINT `fk_genreId` FOREIGN KEY (`genreId`) REFERENCES `GENRE` (`genreId`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_movieId` FOREIGN KEY (`movieId`) REFERENCES `MOVIE` (`movieId`) ON DELETE CASCADE ON UPDATE NO ACTION;
