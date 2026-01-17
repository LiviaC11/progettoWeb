-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Gen 17, 2026 alle 10:29
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
-- Struttura della tabella `annunci`
--

CREATE TABLE `annunci` (
  `id_annuncio` int(11) NOT NULL,
  `titolo` varchar(255) NOT NULL,
  `descrizione` text DEFAULT NULL,
  `prezzo` decimal(10,2) DEFAULT NULL,
  `luogo` varchar(255) DEFAULT NULL,
  `id_utente` int(11) DEFAULT NULL,
  `data_pubblicazione` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `candidature`
--

CREATE TABLE `candidature` (
  `id_candidatura` int(11) NOT NULL,
  `id_annuncio` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `messaggio` text DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `data_invio` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `case`
--

CREATE TABLE `case` (
  `id_casa` int(11) NOT NULL,
  `nome_casa` varchar(255) NOT NULL,
  `codice_invito` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `lista_spesa`
--

CREATE TABLE `lista_spesa` (
  `id_prodotto` int(11) NOT NULL,
  `id_unita` int(11) NOT NULL,
  `nome_prodotto` varchar(100) NOT NULL,
  `preso` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `spese`
--

CREATE TABLE `spese` (
  `id_spesa` int(11) NOT NULL,
  `descrizione` varchar(255) NOT NULL,
  `importo` decimal(10,2) NOT NULL,
  `data_spesa` date NOT NULL,
  `chi_ha_pagato` int(11) NOT NULL,
  `id_casa` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `turni_pulizie`
--

CREATE TABLE `turni_pulizie` (
  `id_turno` int(11) NOT NULL,
  `compito` varchar(100) NOT NULL,
  `data_scadenza` date NOT NULL,
  `assegnato_a` int(11) NOT NULL,
  `id_casa` int(11) NOT NULL,
  `completato` tinyint(1) DEFAULT 0,
  `punti_assegnati` int(11) DEFAULT 10
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `utenti`
--

CREATE TABLE `utenti` (
  `id_utente` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `cognome` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `ruolo` enum('studente','admin_casa','super_admin') DEFAULT 'studente',
  `foto_profilo` varchar(255) DEFAULT 'default_user.png',
  `id_casa` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `annunci`
--
ALTER TABLE `annunci`
  ADD PRIMARY KEY (`id_annuncio`),
  ADD KEY `fk_annunci_utente` (`id_utente`);

--
-- Indici per le tabelle `candidature`
--
ALTER TABLE `candidature`
  ADD PRIMARY KEY (`id_candidatura`),
  ADD KEY `fk_annuncio` (`id_annuncio`);

--
-- Indici per le tabelle `case`
--
ALTER TABLE `case`
  ADD PRIMARY KEY (`id_casa`),
  ADD UNIQUE KEY `codice_invito` (`codice_invito`);

--
-- Indici per le tabelle `lista_spesa`
--
ALTER TABLE `lista_spesa`
  ADD PRIMARY KEY (`id_prodotto`);

--
-- Indici per le tabelle `spese`
--
ALTER TABLE `spese`
  ADD PRIMARY KEY (`id_spesa`),
  ADD KEY `fk_spese_utente` (`chi_ha_pagato`),
  ADD KEY `fk_spese_casa` (`id_casa`);

--
-- Indici per le tabelle `turni_pulizie`
--
ALTER TABLE `turni_pulizie`
  ADD PRIMARY KEY (`id_turno`),
  ADD KEY `fk_pulizie_utente` (`assegnato_a`),
  ADD KEY `fk_pulizie_casa` (`id_casa`);

--
-- Indici per le tabelle `utenti`
--
ALTER TABLE `utenti`
  ADD PRIMARY KEY (`id_utente`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `fk_utente_casa` (`id_casa`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `annunci`
--
ALTER TABLE `annunci`
  MODIFY `id_annuncio` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `candidature`
--
ALTER TABLE `candidature`
  MODIFY `id_candidatura` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `case`
--
ALTER TABLE `case`
  MODIFY `id_casa` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `lista_spesa`
--
ALTER TABLE `lista_spesa`
  MODIFY `id_prodotto` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `spese`
--
ALTER TABLE `spese`
  MODIFY `id_spesa` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `turni_pulizie`
--
ALTER TABLE `turni_pulizie`
  MODIFY `id_turno` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `utenti`
--
ALTER TABLE `utenti`
  MODIFY `id_utente` int(11) NOT NULL AUTO_INCREMENT;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `annunci`
--
ALTER TABLE `annunci`
  ADD CONSTRAINT `fk_annunci_utente` FOREIGN KEY (`id_utente`) REFERENCES `utenti` (`id_utente`) ON DELETE CASCADE;

--
-- Limiti per la tabella `candidature`
--
ALTER TABLE `candidature`
  ADD CONSTRAINT `fk_annuncio` FOREIGN KEY (`id_annuncio`) REFERENCES `annunci` (`id_annuncio`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `spese`
--
ALTER TABLE `spese`
  ADD CONSTRAINT `fk_spese_casa` FOREIGN KEY (`id_casa`) REFERENCES `case` (`id_casa`),
  ADD CONSTRAINT `fk_spese_utente` FOREIGN KEY (`chi_ha_pagato`) REFERENCES `utenti` (`id_utente`);

--
-- Limiti per la tabella `turni_pulizie`
--
ALTER TABLE `turni_pulizie`
  ADD CONSTRAINT `fk_pulizie_casa` FOREIGN KEY (`id_casa`) REFERENCES `case` (`id_casa`),
  ADD CONSTRAINT `fk_pulizie_utente` FOREIGN KEY (`assegnato_a`) REFERENCES `utenti` (`id_utente`);

--
-- Limiti per la tabella `utenti`
--
ALTER TABLE `utenti`
  ADD CONSTRAINT `fk_utente_casa` FOREIGN KEY (`id_casa`) REFERENCES `case` (`id_casa`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
