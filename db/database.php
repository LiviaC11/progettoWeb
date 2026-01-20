<?php
class DatabaseHelper {
    private $db;

    // stabilisce la connessione al database
    public function __construct($servername, $username, $password, $dbname, $port) {
        $this->db = new mysqli($servername, $username, $password, $dbname, $port);
        if ($this->db->connect_error) {
            die("Connessione fallita: " . $this->db->connect_error);
        }
    }
    public function checkLogin($email, $password) {
        $query = "SELECT id_utente, nome, email, password, ruolo, id_casa FROM utenti WHERE email = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        // Verifichiamo l'hash della password
        if ($user && password_verify($password, $user['password'])) {
            return $user; // Ritorna i dati dell'utente (senza la password)
        }
        return false;
    }
    // inseririmento nuova candidatura
    public function insertCandidatura($id_annuncio, $nome, $email, $messaggio, $foto) {
        $query = "INSERT INTO candidature (id_annuncio, nome, email, messaggio, foto) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('issss', $id_annuncio, $nome, $email, $messaggio, $foto);
        
        return $stmt->execute();
    }
    
    public function getRandomAnnunci($n) {
    // Seleziona n annunci in ordine casuale
    $query = "SELECT a.*, u.nome as nome_proprietario 
                  FROM annunci a 
                  LEFT JOIN utenti u ON a.id_utente = u.id_utente 
                  ORDER BY RAND() LIMIT ?";
    $stmt = $this->db->prepare($query);
    $stmt->bind_param('i', $n);
    $stmt->execute();
    $result = $stmt->get_result();

    return $result->fetch_all(MYSQLI_ASSOC);
}
public function getPulizieByCasa($id_casa){
    $query= "SELECT t.*, u.nome as assegnato_a_nome
             FROM turni_pulizie t
             JOIN utenti u ON t.assegnato_a = u.id_utente
             WHERE t.id_casa = ?
             ORDER BY t.data_scadenza ASC";
    $stmt= $this->db->prepare($query);
    $stmt->bind_param('i', $id_casa);
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

}

public function registerToExistingHouse($nome, $cognome, $email, $password, $codice) {
    
    $queryCasa = "SELECT id_casa FROM `case` WHERE codice_invito = ?";
    $stmt = $this->db->prepare($queryCasa);
    $stmt->bind_param('s', $codice);
    $stmt->execute();
    $id_casa = $stmt->get_result()->fetch_assoc()['id_casa'] ?? null;

    if(!$id_casa) return false;

    
    $queryUser = "INSERT INTO utenti (nome, cognome, email, password, ruolo, id_casa) VALUES (?, ?, ?, ?, 'studente', ?)";
    $stmtU = $this->db->prepare($queryUser);
    $stmtU->bind_param('ssssi', $nome, $cognome, $email, $password, $id_casa);
    
    return $stmtU->execute() ? $this->db->insert_id : false;
}

public function registerWithNewHouse($nome, $cognome, $email, $password, $nome_casa) {
    // Alla casa creata viene assegnato un codice casuale
    $codice = strtoupper(substr(md5(time()), 0, 8));
    $queryC = "INSERT INTO `case` (nome_casa, codice_invito) VALUES (?, ?)";
    $stmtC = $this->db->prepare($queryC);
    $stmtC->bind_param('ss', $nome_casa, $codice);
    $stmtC->execute();
    $id_casa = $this->db->insert_id;

    // L'utente che carica la casa è l'admin
    $queryU = "INSERT INTO utenti (nome, cognome, email, password, ruolo, id_casa) VALUES (?, ?, ?, ?, 'admin_casa', ?)";
    $stmtU = $this->db->prepare($queryU);
    $stmtU->bind_param('ssssi', $nome, $cognome, $email, $password, $id_casa);
    
    return $stmtU->execute() ? $this->db->insert_id : false;
}

//Recupera tutti i dati di un utente partendo dal suo ID.
public function getUserById($id_utente) {
    $query = "SELECT * FROM utenti WHERE id_utente = ?";
    $stmt = $this->db->prepare($query);
    $stmt->bind_param('i', $id_utente);
    $stmt->execute();
    $result = $stmt->get_result();

    return $result->fetch_assoc();
    }

//aggiorna pw utente
public function updateUserPassword($id_utente, $password_hash) {
        $query = "UPDATE utenti SET password = ? WHERE id_utente = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('si', $password_hash, $id_utente);
        
        return $stmt->execute();
    }
//aggiorna foto profilo utente
public function updateUserPhoto($id_utente, $foto) {
        $query = "UPDATE utenti SET foto_profilo = ? WHERE id_utente = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('si', $foto, $id_utente);
        
        return $stmt->execute();
    }

// Recupera la classifica della casa (Punti)
public function getHouseRanking($id_casa) {
    $query = "SELECT nome, foto_profilo, punti FROM utenti WHERE id_casa = ? ORDER BY punti DESC";
    $stmt = $this->db->prepare($query);
    $stmt->bind_param('i', $id_casa);
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}

// Recupera le ultime spese della casa
public function getRecentExpenses($id_casa, $limit) {
    $query = "SELECT s.*, u.nome as nome_autore FROM spese s 
              JOIN utenti u ON s.chi_ha_pagato = u.id_utente 
              WHERE s.id_casa = ? ORDER BY s.data_spesa DESC LIMIT ?";
    $stmt = $this->db->prepare($query);
    $stmt->bind_param('ii', $id_casa, $limit);
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}

// Recupera il prossimo turno di pulizia
public function getNextCleaningTurn($id_casa) {
    $query = "SELECT t.*, u.nome FROM turni_pulizie t 
              JOIN utenti u ON t.assegnato_a = u.id_utente 
              WHERE t.id_casa = ? AND t.completato = 0 
              ORDER BY t.data_scadenza ASC LIMIT 1";
    $stmt = $this->db->prepare($query);
    $stmt->bind_param('i', $id_casa);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}
}
?>