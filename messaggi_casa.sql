-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Feb 02, 2026 alle 15:08
-- Versione del server: 10.4.32-MariaDB
-- Versione PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cohappy_db`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `messaggi_casa`
--

CREATE TABLE `messaggi_casa` (
  `id_messaggio` int(11) NOT NULL,
  `id_casa` int(11) NOT NULL,
  `id_utente` int(11) NOT NULL,
  `testo` text NOT NULL,
  `is_anonimo` tinyint(1) DEFAULT 0,
  `data_invio` timestamp NOT NULL DEFAULT current_timestamp(),
  `parent_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `messaggi_casa`
--

INSERT INTO `messaggi_casa` (`id_messaggio`, `id_casa`, `id_utente`, `testo`, `is_anonimo`, `data_invio`, `parent_id`) VALUES
(1, 6, 9, 'ciao', 0, '2026-02-02 13:47:58', NULL),
(2, 6, 9, 'coglione', 0, '2026-02-02 13:48:06', 1),
(3, 6, 9, 'sasosososo', 1, '2026-02-02 13:48:12', NULL),
(4, 6, 9, 'cx <c l', 0, '2026-02-02 13:48:18', 3),
(5, 6, 9, 'c\'è', 0, '2026-02-02 13:48:23', NULL),
(6, 6, 9, 'mn', 0, '2026-02-02 13:56:23', NULL);

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `messaggi_casa`
--
ALTER TABLE `messaggi_casa`
  ADD PRIMARY KEY (`id_messaggio`),
  ADD KEY `fk_msg_casa` (`id_casa`),
  ADD KEY `fk_msg_utente` (`id_utente`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `messaggi_casa`
--
ALTER TABLE `messaggi_casa`
  MODIFY `id_messaggio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `messaggi_casa`
--
ALTER TABLE `messaggi_casa`
  ADD CONSTRAINT `fk_msg_casa` FOREIGN KEY (`id_casa`) REFERENCES `case` (`id_casa`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_msg_utente` FOREIGN KEY (`id_utente`) REFERENCES `utenti` (`id_utente`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
