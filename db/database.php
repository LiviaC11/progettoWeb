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

    //AUTENTIFICAZIONE

    //verifica pw ed email ed avvia sessione
    public function checkLogin($email, $password){
        $query = "SELECT id_utente, nome, cognome, email, password, ruolo, id_casa FROM utenti WHERE email = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if($result->num_rows == 0){
            return false; // Utente non trovato
        }

        $user = $result->fetch_assoc();
        

        if($password == $user['password']){
            // Password in chiaro corrispondente
            return $user;
        } 
        
        return false;
    }

    //registra un utente grazie al codice di invito in una casa già creata
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

//crea una nuova casa e registra l'utente come admin
public function registerWithNewHouse($nome, $cognome, $email, $password, $nome_casa) {
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

//FUNZIONALITA' UTENTE

//Recupera tutti i dati di un utente partendo dal suo ID.
public function getUserById($id_utente) {
    $query = "SELECT u.*, c.codice_invito 
              FROM utenti u 
              LEFT JOIN `case` c ON u.id_casa = c.id_casa 
              WHERE u.id_utente = ?";
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

//lascia unità abitativa
public function leaveHouse($id_utente) {
    $query = "UPDATE utenti SET id_casa = NULL WHERE id_utente = ?";
    $stmt = $this->db->prepare($query);
    $stmt->bind_param('i', $id_utente);
    return $stmt->execute();
}

//DASHBOARD

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

//permette ad un utente già registrato ma senza casa di usare un codice invito
public function joinHouseWithCode($id_utente, $codice) {
    // verifichiamo se esista una casa con un determinato codice invito
    $queryCasa = "SELECT id_casa FROM casa WHERE codice_invito = ?";
    $stmtCasa = $this->db->prepare($queryCasa);
    $stmtCasa->bind_param('s', $codice);
    $stmtCasa->execute();
    $result = $stmtCasa->get_result();
    $casa = $result->fetch_assoc();

    if ($casa) {
        $id_casa = $casa['id_casa'];
        // Aggiorniamo l'utente con l'id_casa trovato
        $queryUpdate = "UPDATE utenti SET id_casa = ? WHERE id_utente = ?";
        $stmtUpdate = $this->db->prepare($queryUpdate);
        $stmtUpdate->bind_param('ii', $id_casa, $id_utente);
        
        if($stmtUpdate->execute()){
            return $id_casa; // Ritorna l'ID casa per aggiornare la sessione
        }
    }
    return false; // Codice errato o errore aggiornamento
}

//SPESE

public function insertSpesa($descrizione, $importo, $data, $chi_ha_pagato, $id_casa) {
    $query = "INSERT INTO spese (descrizione, importo, data_spesa, chi_ha_pagato, id_casa) VALUES (?, ?, ?, ?, ?)";
    $stmt = $this->db->prepare($query);
    $stmt->bind_param('sdsii', $descrizione, $importo, $data, $chi_ha_pagato, $id_casa);
    
    return $stmt->execute();
}

//x recuperare storico delle spese
public function getSpeseByCasa($id_casa) {
    $query = "SELECT s.*, u.nome FROM spese s 
              JOIN utenti u ON s.chi_ha_pagato = u.id_utente 
              WHERE s.id_casa = ? ORDER BY s.data_spesa DESC";
    $stmt = $this->db->prepare($query);
    $stmt->bind_param('i', $id_casa);
    $stmt->execute();
    
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}

//eliminare spesa
public function deleteSpesa($id_spesa) {
    $query = "DELETE FROM spese WHERE id_spesa = ?";
    $stmt = $this->db->prepare($query);
    $stmt->bind_param('i', $id_spesa);
    return $stmt->execute();
}

//utile per calcolare quote delle spese
public function getNumeroMembriCasa($id_casa) {
    $query = "SELECT COUNT(*) as totale FROM utenti WHERE id_casa = ?";
    $stmt = $this->db->prepare($query);
    $stmt->bind_param('i', $id_casa);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    return $row['totale'];
}

//elenco utenti per le quote delle spese
public function getUtentiByCasa($id_casa) {
    $query = "SELECT id_utente, nome FROM utenti WHERE id_casa = ?";
    $stmt = $this->db->prepare($query);
    $stmt->bind_param('i', $id_casa);
    $stmt->execute();
    $result = $stmt->get_result();
    
    return $result->fetch_all(MYSQLI_ASSOC);
}
//ANNUNCI

    // risposta ad un annuncio
    // inseririmento nuova candidatura
    public function insertCandidatura($id_annuncio, $nome, $email, $messaggio, $foto) {
        $query = "INSERT INTO candidature (id_annuncio, nome, email, messaggio, foto) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('issss', $id_annuncio, $nome, $email, $messaggio, $foto);
        
        return $stmt->execute();
    }
    
    public function getRandomAnnunci($n) {
    // Seleziona n annunci in ordine casuale
    $query = "SELECT * FROM annunci ORDER BY RAND() LIMIT ?";
    $stmt = $this->db->prepare($query);
    $stmt->bind_param('i', $n);
    $stmt->execute();
    $result = $stmt->get_result();

    return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getNewUsersToday(){
        // Se non hai la colonna data_iscrizione, questa query fallirà.
        // Assicurati di aver fatto: ALTER TABLE utenti ADD COLUMN data_iscrizione DATE DEFAULT CURRENT_DATE;
        
        // Selezioniamo TUTTO (*) così hai anche ruolo, email, foto, ecc.
        $query = "SELECT * FROM utenti WHERE dataIscrizione = CURDATE()";
        
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        
        // Restituisce un array associativo completo (esattamente come getRandomAnnunci)
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function countUsers(){
        $query = "SELECT COUNT(*) as totale FROM utenti";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row["totale"];
    }

//creare un annuncio per utenti registrati
public function insertAnnuncio($titolo, $descrizione, $prezzo, $luogo, $id_utente, $immagine) {
    $query = "INSERT INTO annunci (titolo, descrizione, prezzo, luogo, id_utente, immagine) VALUES (?, ?, ?, ?, ?)";
    $stmt = $this->db->prepare($query);
    $stmt->bind_param('ssdsi', $titolo, $descrizione, $prezzo, $luogo, $id_utente, $immagine);
    return $stmt->execute();
}
//eliminare un annuncio
public function deleteAnnuncioUtente($id_annuncio, $id_utente) {
    $query = "DELETE FROM annunci WHERE id_annuncio = ? AND id_utente = ?";
    $stmt = $this->db->prepare($query);
    $stmt->bind_param('ii', $id_annuncio, $id_utente);
    return $stmt->execute();
}

 public function deleteAnnuncio($id_annuncio){
        // 1. Prima eliminiamo tutte le segnalazioni collegate a questo annuncio
        // Così non rimangono segnalazioni 'orfane' o 'risolte' inutilmente.
        $queryReports = "DELETE FROM segnalazioni WHERE id_annuncio_segnalato = ?";
        $stmtReports = $this->db->prepare($queryReports);
        $stmtReports->bind_param('i', $id_annuncio);
        $stmtReports->execute();

        // 2. Poi eliminiamo l'annuncio vero e proprio
        $queryAnnuncio = "DELETE FROM annunci WHERE id_annuncio = ?";
        $stmtAnnuncio = $this->db->prepare($queryAnnuncio);
        $stmtAnnuncio->bind_param('i', $id_annuncio);
        return $stmtAnnuncio->execute();
    }
    public function countAd(){
        $query = "SELECT COUNT(*) as totale FROM annunci WHERE isActive=1";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row["totale"];
    }

    public function countReports(){
        $query = "SELECT COUNT(*) as totale FROM segnalazioni WHERE stato='aperta'";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row["totale"];
    }
    
   public function getSegnalazioni() {
        $query = "SELECT 
                    s.id_segnalazione, 
                    s.motivo, 
                    s.descrizione, 
                    s.stato, 
                    s.data_segnalazione, 
                    s.id_annuncio_segnalato,    -- FONDAMENTALE PER I BOTTONI
                    s.id_utente_segnalato,      -- FONDAMENTALE PER I BOTTONI
                    u_rep.email as email_autore, 
                    a.titolo as titolo_annuncio,
                    a.id_utente as id_creatore_annuncio, -- FONDAMENTALE PER IL BAN
                    u_cre.email as email_creatore_annuncio
                FROM segnalazioni s
                LEFT JOIN utenti u_rep ON s.id_autore = u_rep.id_utente
                LEFT JOIN annunci a ON s.id_annuncio_segnalato = a.id_annuncio
                LEFT JOIN utenti u_cre ON a.id_utente = u_cre.id_utente
                WHERE s.stato = 'aperta'
                ORDER BY s.data_segnalazione DESC";
    
    $stmt = $this->db->prepare($query);
    $stmt->execute();
    $result = $stmt->get_result();
    
    return $result->fetch_all(MYSQLI_ASSOC);
    }


    /**
     * Elimina un utente.
     * NOTA: Grazie al vincolo ON DELETE CASCADE nel database, 
     * eliminando l'utente si elimineranno automaticamente tutti i suoi annunci,
     * le sue segnalazioni e i suoi messaggi. Pulizia totale! 🧹
     */
    public function deleteUser($id_utente){
        $query = "DELETE FROM utenti WHERE id_utente = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $id_utente);
        return $stmt->execute();
    }

    /**
     * Segna una segnalazione come risolta.
     */
    public function resolveReport($id_segnalazione){
        $query = "UPDATE segnalazioni SET stato = 'risolta' WHERE id_segnalazione = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $id_segnalazione);
        return $stmt->execute();
    }

    /**
     * Aggiorna lo stato di una segnalazione (es. da 'aperta' a 'risolta').
     */
    public function updateSegnalazioneStatus($id_segnalazione, $stato){
        $query = "UPDATE segnalazioni SET stato = ? WHERE id_segnalazione = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("risolta", $stato, $id_segnalazione);
        return $stmt->execute();
    }

    public function getAllUsers(){
        $stmt = $this->db->prepare("SELECT * FROM utenti ORDER BY dataIscrizione DESC");
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    //mostra gli annunci creati dall'utente
public function getAnnunciByUtente($id_utente) {
    $query = "SELECT a.*, u.nome FROM annunci a 
              JOIN utenti u ON a.id_utente = u.id_utente 
              WHERE a.isActive = 1 
              ORDER BY data_pubblicazione DESC";
    $stmt = $this->db->prepare($query);
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}

//recupera gli annunci di ogni utente pubblicati
public function getAllAnnunci() {
    $query = "SELECT a.*, u.nome FROM annunci a JOIN utenti u ON a.id_utente = u.id_utente ORDER BY data_pubblicazione DESC";
    return $this->db->query($query)->fetch_all(MYSQLI_ASSOC);
}

}
?>