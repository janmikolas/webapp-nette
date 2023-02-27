-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Počítač: 127.0.0.1:3307
-- Vytvořeno: Pon 27. úno 2023, 06:41
-- Verze serveru: 10.10.2-MariaDB
-- Verze PHP: 8.1.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databáze: `jm_webapp`
--
CREATE DATABASE IF NOT EXISTS `jm_webapp` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_czech_ci;
USE `jm_webapp`;

-- --------------------------------------------------------

--
-- Struktura tabulky `manufacturer`
--

DROP TABLE IF EXISTS `manufacturer`;
CREATE TABLE IF NOT EXISTS `manufacturer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_3D0AE6DC5E237E06` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci;

--
-- Vypisuji data pro tabulku `manufacturer`
--

INSERT INTO `manufacturer` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Nike', '2023-02-27 07:40:50', NULL),
(2, 'Adidas', '2023-02-27 07:40:50', NULL),
(3, 'Puma', '2023-02-27 07:40:50', NULL),
(4, 'Carraa', '2023-02-27 07:40:50', NULL),
(5, 'Keller', '2023-02-27 07:40:50', NULL),
(6, 'Harrows', '2023-02-27 07:40:50', NULL),
(7, 'Champion', '2023-02-27 07:40:50', NULL),
(8, 'City', '2023-02-27 07:40:50', NULL),
(9, 'Trixie', '2023-02-27 07:40:50', NULL),
(10, 'Start', '2023-02-27 07:40:50', NULL),
(11, 'Andy', '2023-02-27 07:40:50', NULL),
(12, 'Veru', '2023-02-27 07:40:50', NULL),
(13, 'Dominique', '2023-02-27 07:40:50', NULL);

-- --------------------------------------------------------

--
-- Struktura tabulky `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `surname` varchar(128) NOT NULL,
  `email` varchar(128) NOT NULL,
  `username` varchar(128) NOT NULL,
  `state` int(11) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL,
  `last_logged_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`),
  UNIQUE KEY `UNIQ_8D93D649F85E0677` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci;

--
-- Vypisuji data pro tabulku `user`
--

INSERT INTO `user` (`id`, `name`, `surname`, `email`, `username`, `state`, `password`, `role`, `last_logged_at`, `created_at`, `updated_at`) VALUES
(1, 'Test', 'Admin', 'test@test.cz', 'test@test.cz', 2, '$2y$10$40uKt4z7aUu2XP0Ma1d2Xet7LV3LIEhWcueBtYvr8hTuCl3vfqwmS', 'admin', NULL, '2023-02-27 07:40:50', NULL);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
