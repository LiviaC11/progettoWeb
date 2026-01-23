-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Gen 22, 2026 alle 20:57
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
  `isActive` tinyint(1) NOT NULL DEFAULT 1,
  `id_utente` int(11) DEFAULT NULL,
  `data_pubblicazione` timestamp NOT NULL DEFAULT current_timestamp(),
  `immagine` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `annunci`
--

INSERT INTO `annunci` (`id_annuncio`, `titolo`, `descrizione`, `prezzo`, `luogo`, `isActive`, `id_utente`, `data_pubblicazione`, `immagine`) VALUES
(1, 'Suite Imperiale in Centro', 'Stanza singola enorme con bagno privato e vista sui tetti. Solo per chi ha stile.', 550.00, 'Bologna', 1, 2, '2026-01-10 09:00:00', 'img/annuncio_suite.jpg'),
(2, 'Doppia per amanti del caos', 'Cerchiamo coinquilino socievole per condividere una doppia coloratissima.', 300.00, 'Cesena', 1, 5, '2026-01-12 10:30:00', 'img/annuncio_doppia.jpg'),
(3, 'Singola minimalista (molto)', 'Piccola ma accogliente. Praticamente un letto e una mensola.', 250.00, 'Forlì', 0, 2, '2026-01-15 08:00:00', 'img/nophoto.png');

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

--
-- Dump dei dati per la tabella `candidature`
--

INSERT INTO `candidature` (`id_candidatura`, `id_annuncio`, `nome`, `email`, `messaggio`, `foto`, `data_invio`) VALUES
(1, 1, 'Elena Galli', 'elena@cerca.it', 'Amo quella stanza è troppo nelle mie corde! Sono ordinata e porto sempre il caffè.', 'img/candidato_elena.jpg', '2026-01-21 14:00:00'),
(2, 1, 'Davide Foschi', 'davide@cerca.it', 'Ciao! Studio ingegneria e sono un tipo tranquillo. La stanza sembra perfetta.', 'img/nophoto.png', '2026-01-22 09:00:00');

-- --------------------------------------------------------

--
-- Struttura della tabella `case`
--

CREATE TABLE `case` (
  `id_casa` int(11) NOT NULL,
  `nome_casa` varchar(255) NOT NULL,
  `codice_invito` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `case`
--

INSERT INTO `case` (`id_casa`, `nome_casa`, `codice_invito`) VALUES
(1, 'Penthouse delle Baddies', 'BADGIRLS'),
(2, 'Villa Smeralda Bologna', 'VILLA777'),
(3, 'Loft degli Artisti Cesena', 'ARTISTI9');

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

--
-- Dump dei dati per la tabella `lista_spesa`
--

INSERT INTO `lista_spesa` (`id_prodotto`, `id_unita`, `nome_prodotto`, `preso`) VALUES
(1, 1, 'Latte di Mandorla', 0),
(2, 2, 'Avocado per toast iconici', 1),
(3, 1, 'Sapone piatti bio', 0);

-- --------------------------------------------------------

--
-- Struttura della tabella `segnalazioni`
--

CREATE TABLE `segnalazioni` (
  `id_segnalazione` int(11) NOT NULL,
  `id_autore` int(11) NOT NULL,
  `id_annuncio_segnalato` int(11) DEFAULT NULL,
  `id_utente_segnalato` int(11) DEFAULT NULL,
  `motivo` varchar(255) NOT NULL,
  `descrizione` text DEFAULT NULL,
  `stato` enum('aperta','in_lavorazione','risolta','archiviata') DEFAULT 'aperta',
  `data_segnalazione` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `segnalazioni`
--

INSERT INTO `segnalazioni` (`id_segnalazione`, `id_autore`, `id_annuncio_segnalato`, `id_utente_segnalato`, `motivo`, `descrizione`, `stato`, `data_segnalazione`) VALUES
(1, 3, 2, NULL, 'Spam', 'Questo annuncio è un fake, non risponde nessuno.', 'aperta', '2026-01-21 17:00:00'),
(2, 6, NULL, 7, 'Comportamento inappropriato', 'L utente scrive messaggi strani in privato.', 'in_lavorazione', '2026-01-22 08:00:00');

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

--
-- Dump dei dati per la tabella `spese`
--

INSERT INTO `spese` (`id_spesa`, `descrizione`, `importo`, `data_spesa`, `chi_ha_pagato`, `id_casa`) VALUES
(1, 'Carta igienica 4 veli (Lusso)', 15.50, '2026-01-18', 3, 1),
(2, 'Bolletta Luce Dicembre', 120.00, '2026-01-10', 2, 1),
(3, 'Detersivi e spugne', 22.30, '2026-01-15', 5, 2),
(4, 'Pizza di gruppo', 45.00, '2026-01-20', 6, 2);

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
  `completato` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `turni_pulizie`
--

INSERT INTO `turni_pulizie` (`id_turno`, `compito`, `data_scadenza`, `assegnato_a`, `id_casa`, `completato`) VALUES
(1, 'Pulizia Bagno Principale', '2026-01-25', 3, 1, 0),
(2, 'Cucina e Fornelli', '2026-01-24', 4, 1, 1),
(3, 'Pavimenti Salone', '2026-01-26', 2, 1, 0),
(4, 'Buttare il vetro', '2026-01-23', 6, 2, 0);

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
  `id_casa` int(11) DEFAULT NULL,
  `dataIscrizione` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `utenti`
--

INSERT INTO `utenti` (`id_utente`, `nome`, `cognome`, `email`, `password`, `ruolo`, `foto_profilo`, `id_casa`, `dataIscrizione`) VALUES
(1, 'Morgana', 'Super', 'admin@cohappy.it', 'pass123', 'super_admin', 'img/admin.png', NULL, '2025-12-01'),
(2, 'Francesca', 'Rossi', 'francesca@baddies.it', '$2y$10$h5rxcmBrwYzRAWyTc8lNSOlbNKevlmHOMKhRD8xHdc/ds8tDPgUgu', 'admin_casa', 'img/fra_queen.png', 1, '2026-01-01'),
(3, 'Giulia', 'Neri', 'giulia@studenti.it', '$2y$10$h5rxcmBrwYzRAWyTc8lNSOlbNKevlmHOMKhRD8xHdc/ds8tDPgUgu', 'studente', 'img/giulia_vibe.png', 1, '2026-01-05'),
(4, 'Beatrice', 'Sartori', 'bea@studenti.it', '$2y$10$h5rxcmBrwYzRAWyTc8lNSOlbNKevlmHOMKhRD8xHdc/ds8tDPgUgu', 'studente', 'img/bea_icon.png', 1, '2026-01-10'),
(5, 'Matteo', 'Rizzi', 'matteo@villa.it', '$2y$10$h5rxcmBrwYzRAWyTc8lNSOlbNKevlmHOMKhRD8xHdc/ds8tDPgUgu', 'admin_casa', 'img/matteo_king.png', 2, '2026-01-02'),
(6, 'Luca', 'Verdi', 'luca@erasmus.it', '$2y$10$h5rxcmBrwYzRAWyTc8lNSOlbNKevlmHOMKhRD8xHdc/ds8tDPgUgu', 'studente', 'img/luca_erasmus.png', 2, '2026-01-15'),
(7, 'Davide', 'Foschi', 'davide@cerca.it', '$2y$10$h5rxcmBrwYzRAWyTc8lNSOlbNKevlmHOMKhRD8xHdc/ds8tDPgUgu', 'studente', 'default_user.png', NULL, '2026-01-20'),
(8, 'Elena', 'Galli', 'elena@cerca.it', '$2y$10$h5rxcmBrwYzRAWyTc8lNSOlbNKevlmHOMKhRD8xHdc/ds8tDPgUgu', 'studente', 'default_user.png', NULL, '2026-01-21');

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
-- Indici per le tabelle `segnalazioni`
--
ALTER TABLE `segnalazioni`
  ADD PRIMARY KEY (`id_segnalazione`),
  ADD KEY `fk_segnalazione_autore` (`id_autore`),
  ADD KEY `fk_segnalazione_annuncio` (`id_annuncio_segnalato`),
  ADD KEY `fk_segnalazione_utente` (`id_utente_segnalato`);

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
  MODIFY `id_annuncio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT per la tabella `candidature`
--
ALTER TABLE `candidature`
  MODIFY `id_candidatura` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT per la tabella `case`
--
ALTER TABLE `case`
  MODIFY `id_casa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT per la tabella `lista_spesa`
--
ALTER TABLE `lista_spesa`
  MODIFY `id_prodotto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT per la tabella `segnalazioni`
--
ALTER TABLE `segnalazioni`
  MODIFY `id_segnalazione` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT per la tabella `spese`
--
ALTER TABLE `spese`
  MODIFY `id_spesa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT per la tabella `turni_pulizie`
--
ALTER TABLE `turni_pulizie`
  MODIFY `id_turno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT per la tabella `utenti`
--
ALTER TABLE `utenti`
  MODIFY `id_utente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

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
-- Limiti per la tabella `segnalazioni`
--
ALTER TABLE `segnalazioni`
  ADD CONSTRAINT `fk_segnalazione_annuncio` FOREIGN KEY (`id_annuncio_segnalato`) REFERENCES `annunci` (`id_annuncio`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_segnalazione_autore` FOREIGN KEY (`id_autore`) REFERENCES `utenti` (`id_utente`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_segnalazione_utente` FOREIGN KEY (`id_utente_segnalato`) REFERENCES `utenti` (`id_utente`) ON DELETE SET NULL ON UPDATE CASCADE;

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
