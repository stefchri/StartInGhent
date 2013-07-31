-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Machine: 127.0.0.1
-- Genereertijd: 31 jul 2013 om 12:54
-- Serverversie: 5.5.27
-- PHP-versie: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Databank: `startinghent`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `datasets`
--

CREATE TABLE IF NOT EXISTS `datasets` (
  `dataset_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `url` varchar(500) NOT NULL,
  `value` longtext NOT NULL,
  `modifieddate` datetime DEFAULT NULL,
  PRIMARY KEY (`dataset_id`),
  UNIQUE KEY `dataset_id_UNIQUE` (`dataset_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` char(64) NOT NULL,
  `email` varchar(255) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `surname` varchar(255) NOT NULL,
  `gender` enum('m','f') NOT NULL,
  `description` longtext,
  `avatar` varchar(500) DEFAULT NULL,
  `answers` longtext,
  `createddate` datetime NOT NULL,
  `modifieddate` datetime DEFAULT NULL,
  `deleteddate` datetime DEFAULT NULL,
  `lastloggedindate` datetime DEFAULT NULL,
  `activationkey` char(64) DEFAULT NULL,
  `activationdate` datetime DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user_username_UNIQUE` (`username`),
  UNIQUE KEY `user_id_UNIQUE` (`user_id`),
  UNIQUE KEY `email_UNIQUE` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Triggers `users`
--
DROP TRIGGER IF EXISTS `users_BINS`;
DELIMITER //
CREATE TRIGGER `users_BINS` BEFORE INSERT ON `users`
 FOR EACH ROW -- Edit trigger body code below this line. Do not edit lines above this one
SET NEW.createddate = NOW()
//
DELIMITER ;
DROP TRIGGER IF EXISTS `users_BUPD`;
DELIMITER //
CREATE TRIGGER `users_BUPD` BEFORE UPDATE ON `users`
 FOR EACH ROW -- Edit trigger body code below this line. Do not edit lines above this one
SET NEW.modifieddate = NOW()
//
DELIMITER ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
