-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Gen 23, 2026 alle 18:33
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
  `immagine` varchar(255) DEFAULT 'img/nophoto.png',
  `data_pubblicazione` timestamp NOT NULL DEFAULT current_timestamp(),
  `isActive` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `annunci`
--

INSERT INTO `annunci` (`id_annuncio`, `titolo`, `descrizione`, `prezzo`, `luogo`, `id_utente`, `immagine`, `data_pubblicazione`, `isActive`) VALUES
(1, 'Cercasi 2 coinquilini', 'Casa a 10 min dalla stazione e dall&#039;università, posizione strategica. Sono disponibili due singole. La casa ha un piccolo cortile dove poter riporre le bici o altri mezzi di trasporto, c&#039;è una sala-cucina in comune molto grande ed un bagno da condividere al piano superiore, sempre al piano superiore si trovano 2 delle tre camere da letto totali. ', 250.00, '0', 2, 'img/nophoto.png', '2026-01-20 17:14:47', 0),
(4, 'stanza singola', 'o\r\no\r\no\r\no', 150.00, 'Bologna', 6, 'img/img_69729e81bbfbb.png', '2026-01-22 22:02:41', 1);

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
(1, 1, 'Lucia', 'liviacico91@gmail.com', 'ciao', 'img/nophoto.png', '2026-01-22 20:26:05'),
(2, 1, 'Giuditta', 'giudi.blabla@libero.it', 'email di prova', 'img/nophoto.png', '2026-01-23 08:01:37'),
(3, 1, 'Giuditta', 'giudi.blabla@libero.it', 'email di prova', 'img/nophoto.png', '2026-01-23 08:21:53');

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
(2, 'AP007', '99BD152E'),
(4, 'Ap009', '33015F05'),
(5, 'AP02ViaOrti', '6D4379A1');

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
(1, 'Televisore', 200.00, '2026-01-21', 2, 2);

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

--
-- Dump dei dati per la tabella `turni_pulizie`
--

INSERT INTO `turni_pulizie` (`id_turno`, `compito`, `data_scadenza`, `assegnato_a`, `id_casa`, `completato`, `punti_assegnati`) VALUES
(1, 'Pulire bagno', '2026-01-23', 4, 2, 0, 10);

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
  `punti` int(11) DEFAULT 0,
  `dataIscrizione` date NOT NULL DEFAULT curdate(),
  `token_scadenza` datetime DEFAULT NULL,
  `recovery_token` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `utenti`
--

INSERT INTO `utenti` (`id_utente`, `nome`, `cognome`, `email`, `password`, `ruolo`, `foto_profilo`, `id_casa`, `punti`, `dataIscrizione`, `token_scadenza`, `recovery_token`) VALUES
(2, 'Margherita', 'Bianchi', 'marghe.bianchi@libero.it', '$2y$10$oO.UDFC0yO5zgIZ/hbPX2eE1BrBwX4kkOtt.y9ejqqqU2zQtY64Li', 'admin_casa', 'default_user.png', 2, 0, '2026-01-20', NULL, NULL),
(4, 'Marco', 'Marchi', 'marco.marchi@libero.it', '$2y$10$7iiiMAvYLAMD/EZXO0Dki.OqoAMYEPZSSznYtO..ONKQxAJ3g6orm', 'studente', 'default_user.png', 2, 0, '2026-01-21', NULL, NULL),
(5, 'Lu', 'Lulu', 'lu.lulu@libero.it', '$2y$10$GT1Vbm6ajYkgK4AbXZ8XB.nPT9OAoJIhfNwnrWFZpNaB6V8Gl/ub6', 'studente', 'default_user.png', 2, 0, '2026-01-22', NULL, NULL),
(6, 'Carlo', 'Verdi', 'carlo.verdi@libero.it', '$2y$10$460pAHgfpnKV1yknWbIZQuZLqBzGh5KoobiI6pRooJ2WPu5pxpGLe', 'admin_casa', 'default_user.png', 4, 0, '2026-01-22', NULL, NULL),
(7, 'Anna', 'Bianchi', 'anna.bianchi@libero.it', '$2y$10$OmPN5d9Lhtk1w5ZyUk5OP.FhuE3MP7quE97EfkJzthfY.ClezHFY6', 'studente', 'default_user.png', 4, 0, '2026-01-22', NULL, NULL),
(8, 'Filippo', 'Nati', 'filo.nati@libero.it', '12345678', 'admin_casa', 'default_user.png', 5, 0, '2026-01-23', NULL, NULL);

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
  MODIFY `id_annuncio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT per la tabella `candidature`
--
ALTER TABLE `candidature`
  MODIFY `id_candidatura` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT per la tabella `case`
--
ALTER TABLE `case`
  MODIFY `id_casa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT per la tabella `lista_spesa`
--
ALTER TABLE `lista_spesa`
  MODIFY `id_prodotto` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `segnalazioni`
--
ALTER TABLE `segnalazioni`
  MODIFY `id_segnalazione` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `spese`
--
ALTER TABLE `spese`
  MODIFY `id_spesa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT per la tabella `turni_pulizie`
--
ALTER TABLE `turni_pulizie`
  MODIFY `id_turno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT per la tabella `utenti`
--
ALTER TABLE `utenti`
  MODIFY `id_utente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

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
