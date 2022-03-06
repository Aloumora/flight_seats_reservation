-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Giu 18, 2019 alle 00:14
-- Versione del server: 10.1.26-MariaDB
-- Versione PHP: 7.1.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `aloumora`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `map`
--

CREATE TABLE `map` (
  `seat` char(5) NOT NULL,
  `user` varchar(50) NOT NULL,
  `status` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `map`
--

INSERT INTO `map` (`seat`, `user`, `status`) VALUES
('01A', '', 'F'),
('01B', '', 'F'),
('01C', '', 'F'),
('01D', '', 'F'),
('01E', '', 'F'),
('01F', '', 'F'),
('02A', 'u1@p.it', 'F'),
('02B', 'u2@p.it', 'A'),
('02C', '', 'F'),
('02D', '', 'F'),
('02E', '', 'F'),
('02F', '', 'F'),
('03A', '', 'F'),
('03B', 'u2@p.it', 'A'),
('03C', '', 'F'),
('03D', '', 'F'),
('03E', '', 'F'),
('03F', '', 'F'),
('04A', 'u1@p.it', 'P'),
('04B', 'u2@p.it', 'A'),
('04C', '', 'F'),
('04D', 'u1@p.it', 'P'),
('04E', '', 'F'),
('04F', 'u2@p.it', 'P'),
('05A', '', 'F'),
('05B', '', 'F'),
('05C', '', 'F'),
('05D', '', 'F'),
('05E', '', 'F'),
('05F', '', 'F'),
('06A', '', 'F'),
('06B', '', 'F'),
('06C', '', 'F'),
('06D', '', 'F'),
('06E', '', 'F'),
('06F', '', 'F'),
('07A', '', 'F'),
('07B', '', 'F'),
('07C', '', 'F'),
('07D', '', 'F'),
('07E', '', 'F'),
('07F', '', 'F'),
('08A', '', 'F'),
('08B', '', 'F'),
('08C', '', 'F'),
('08D', '', 'F'),
('08E', '', 'F'),
('08F', '', 'F'),
('09A', '', 'F'),
('09B', '', 'F'),
('09C', '', 'F'),
('09D', '', 'F'),
('09E', '', 'F'),
('09F', '', 'F'),
('10A', '', 'F'),
('10B', '', 'F'),
('10C', '', 'F'),
('10D', '', 'F'),
('10E', '', 'F'),
('10F', '', 'F');

-- --------------------------------------------------------

--
-- Struttura della tabella `users`
--

CREATE TABLE `users` (
  `username` varchar(50) NOT NULL,
  `password` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `users`
--

INSERT INTO `users` (`username`, `password`) VALUES
('u1@p.it', 'ec6ef230f1828039ee794566b9c58adc'),
('u2@p.it', '1d665b9b1467944c128a5575119d1cfd');

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `map`
--
ALTER TABLE `map`
  ADD PRIMARY KEY (`seat`);

--
-- Indici per le tabelle `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`username`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
