<?php
class DatabaseHelper {
    private $db;

        // stabilisce la connessione al database
    public function __construct($servername, $username, $password, $dbname, $port) {
        $this->db = new mysqli($servername, $username, $password, $dbname, $port);
        if ($this->db->connect_error) {
            die("Connessione fallita: " . $this->db->connect_error); 
        }
        $this->db->set_charset("utf8mb4");
    }

    // --- AUTENTIFICAZIONE ---

    public function checkLogin($email, $password){
        $query = "SELECT id_utente, nome, cognome, email, password, ruolo, id_casa FROM utenti WHERE email = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows == 0) return false;
        $user = $result->fetch_assoc();
        if($password == $user['password']) return $user; // Controllo password in chiaro per test
        if(password_verify($password, $user['password'])) return $user; // Controllo password hashata
        return false;
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
        $codice = strtoupper(substr(md5(time()), 0, 8));
        $queryC = "INSERT INTO `case` (nome_casa, codice_invito) VALUES (?, ?)";
        $stmtC = $this->db->prepare($queryC);
        $stmtC->bind_param('ss', $nome_casa, $codice);
        $stmtC->execute();
        $id_casa = $this->db->insert_id;
        $queryU = "INSERT INTO utenti (nome, cognome, email, password, ruolo, id_casa) VALUES (?, ?, ?, ?, 'admin_casa', ?)";
        $stmtU = $this->db->prepare($queryU);
        $stmtU->bind_param('ssssi', $nome, $cognome, $email, $password, $id_casa);
        return $stmtU->execute() ? $this->db->insert_id : false;
    }

    public function registerUser($nome, $cognome, $email, $password) {
        $query = "INSERT INTO utenti (nome, cognome, email, password, ruolo, id_casa, dataIscrizione) VALUES (?, ?, ?, ?, 'studente', NULL, CURDATE())";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('ssss', $nome, $cognome, $email, $password);
        return $stmt->execute() ? $this->db->insert_id : false;
    }

    // --- FUNZIONALITA' UTENTE ---

public function getUserById($id_utente) {
    $query = "SELECT u.*, c.codice_invito, c.nome_casa 
              FROM utenti u 
              LEFT JOIN `case` c ON u.id_casa = c.id_casa 
              WHERE u.id_utente = ?";
    $stmt = $this->db->prepare($query);
    $stmt->bind_param('i', $id_utente);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

    public function updateUserPassword($id_utente, $password_hash) {
        $query = "UPDATE utenti SET password = ? WHERE id_utente = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('si', $password_hash, $id_utente);
        return $stmt->execute();
    }

    public function updateUserPhoto($id_utente, $foto) {
        $query = "UPDATE utenti SET foto_profilo = ? WHERE id_utente = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('si', $foto, $id_utente);
        return $stmt->execute();
    }

    public function leaveHouse($id_utente) {
        $query = "UPDATE utenti SET id_casa = NULL WHERE id_utente = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $id_utente);
        return $stmt->execute();
    }

    //Token per recupero pw
    public function setRecoveryToken($email, $token) {
    // Il token scade dopo 1 ora
    $query = "UPDATE utenti SET recovery_token = ?, token_scadenza = DATE_ADD(NOW(), INTERVAL 1 HOUR) WHERE email = ?";
    $stmt = $this->db->prepare($query);
    $stmt->bind_param('ss', $token, $email);
    return $stmt->execute();
}

    // Verifica se il token è valido e non scaduto
    public function getUserByToken($token) {
    $query = "SELECT id_utente FROM utenti WHERE recovery_token = ? AND token_scadenza > NOW()";
    $stmt = $this->db->prepare($query);
    $stmt->bind_param('s', $token);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

    // Aggiorna la password e cancella il token usato
    public function updatePwAndRemoveToken($id_utente, $new_pwd) {
    // Nota: in produzione usa password_hash($new_pwd, PASSWORD_DEFAULT)
    $query = "UPDATE utenti SET password = ?, recovery_token = NULL, token_scadenza = NULL WHERE id_utente = ?";
    $stmt = $this->db->prepare($query);
    $stmt->bind_param('si', $new_pwd, $id_utente);
    return $stmt->execute();
}

    // --- DASHBOARD & CASA ---

    public function getHouseRanking($id_casa) {
        $query = "SELECT nome, foto_profilo, punti FROM utenti WHERE id_casa = ? ORDER BY punti DESC";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $id_casa);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getRecentExpenses($id_casa, $limit) {
        $query = "SELECT s.*, u.nome as nome_autore FROM spese s JOIN utenti u ON s.chi_ha_pagato = u.id_utente WHERE s.id_casa = ? ORDER BY s.data_spesa DESC LIMIT ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('ii', $id_casa, $limit);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getNextCleaningTurn($id_casa) {
        $query = "SELECT t.*, u.nome FROM turni_pulizie t JOIN utenti u ON t.assegnato_a = u.id_utente WHERE t.id_casa = ? AND t.completato = 0 ORDER BY t.data_scadenza ASC LIMIT 1";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $id_casa);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function joinHouseWithCode($id_utente, $codice) {
        $queryCasa = "SELECT id_casa FROM `case` WHERE codice_invito = ?";
        $stmtCasa = $this->db->prepare($queryCasa);
        $stmtCasa->bind_param('s', $codice);
        $stmtCasa->execute();
        $casa = $stmtCasa->get_result()->fetch_assoc();
        if ($casa) {
            $id_casa = $casa['id_casa'];
            $queryUpdate = "UPDATE utenti SET id_casa = ? WHERE id_utente = ?";
            $stmtUpdate = $this->db->prepare($queryUpdate);
            $stmtUpdate->bind_param('ii', $id_casa, $id_utente);
            return $stmtUpdate->execute() ? $id_casa : false;
        }
        return false;
    }

    // --- SPESE ---

    public function insertSpesa($descrizione, $importo, $data, $chi_ha_pagato, $id_casa) {
        $query = "INSERT INTO spese (descrizione, importo, data_spesa, chi_ha_pagato, id_casa) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('sdsii', $descrizione, $importo, $data, $chi_ha_pagato, $id_casa);
        return $stmt->execute();
    }

    public function getSpeseByCasa($id_casa) {
        $query = "SELECT s.*, u.nome FROM spese s JOIN utenti u ON s.chi_ha_pagato = u.id_utente WHERE s.id_casa = ? ORDER BY s.data_spesa DESC";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $id_casa);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function deleteSpesa($id_spesa) {
        $query = "DELETE FROM spese WHERE id_spesa = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $id_spesa);
        return $stmt->execute();
    }

    public function getNumeroMembriCasa($id_casa) {
        $query = "SELECT COUNT(*) as totale FROM utenti WHERE id_casa = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $id_casa);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc()['totale'];
    }

    public function getUtentiByCasa($id_casa) {
        $query = "SELECT id_utente, nome FROM utenti WHERE id_casa = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $id_casa);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    // --- ANNUNCI ---

    /**
     * RECUPERA SINGOLO ANNUNCIO PER ID (FIX PER FATAL ERROR)
     */
    public function getAnnuncioById($id_annuncio) {
        $stmt = $this->db->prepare("SELECT * FROM annunci WHERE id_annuncio = ?");
        $stmt->bind_param('i', $id_annuncio);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

public function getAnnunciByUtente($idUtente) {
    // Togliamo il filtro isActive = 1 per vederli tutti in questa pagina!
    $stmt = $this->db->prepare("SELECT * FROM annunci WHERE id_utente = ? ORDER BY data_pubblicazione DESC");
    $stmt->bind_param("i", $idUtente);
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}

 public function insertAnnuncio($titolo, $descrizione, $prezzo, $luogo, $id_utente, $immagine) {
    // Tabella: annunci | Colonne: titolo, descrizione, prezzo, luogo, id_utente, immagine
    $query = "INSERT INTO annunci (titolo, descrizione, prezzo, luogo, id_utente, immagine) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $this->db->prepare($query);
    
    // "ssdsis" -> string, string, double(prezzo è decimal), string, int, string
    $stmt->bind_param("ssdsis", $titolo, $descrizione, $prezzo, $luogo, $id_utente, $immagine);
    
    return $stmt->execute();
}

    public function updateAnnuncio($idAnnuncio, $titolo, $descrizione, $prezzo, $luogo, $immagine = null) {
        if($immagine) {
            // Se c'è una nuova immagine, aggiorniamo anche quella
            $stmt = $this->db->prepare("UPDATE annunci SET titolo=?, descrizione=?, prezzo=?, luogo=?, immagine=? WHERE id_annuncio=?");
            $stmt->bind_param("ssdsis", $titolo, $descrizione, $prezzo, $luogo, $immagine, $idAnnuncio);
        } else {
            // Altrimenti aggiorniamo solo i testi mantenendo la foto attuale
            $stmt = $this->db->prepare("UPDATE annunci SET titolo=?, descrizione=?, prezzo=?, luogo=? WHERE id_annuncio=?");
            $stmt->bind_param("ssdsi", $titolo, $descrizione, $prezzo, $luogo, $idAnnuncio);
        }
        return $stmt->execute();
    }

    public function deleteAnnuncio($id_annuncio) {
        $stmt = $this->db->prepare("DELETE FROM annunci WHERE id_annuncio = ?");
        $stmt->bind_param('i', $id_annuncio);
        return $stmt->execute();
    }

    public function getAnnunci() {
        $stmt = $this->db->prepare("SELECT * FROM annunci WHERE isActive = 1 ORDER BY data_pubblicazione DESC");
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getAllAnnunci() {
        $query = "SELECT a.*, u.nome FROM annunci a JOIN utenti u ON a.id_utente = u.id_utente ORDER BY data_pubblicazione DESC";
        return $this->db->query($query)->fetch_all(MYSQLI_ASSOC);
    }

public function deactivateAnnuncio($id_annuncio) {
    $stmt = $this->db->prepare("UPDATE annunci SET isActive = 0 WHERE id_annuncio = ?");
    $stmt->bind_param('i', $id_annuncio);
    return $stmt->execute();
}

public function activateAnnuncio($id_annuncio) {
    $stmt = $this->db->prepare("UPDATE annunci SET isActive = 1 WHERE id_annuncio = ?");
    $stmt->bind_param('i', $id_annuncio);
    return $stmt->execute();
}



    // --- ALTRE FUNZIONALITA' ---

    public function getNewUsersToday(){
        $query = "SELECT * FROM utenti WHERE dataIscrizione = CURDATE()";
        $result = $this->db->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function countUsers(){
        return $this->db->query("SELECT COUNT(*) as totale FROM utenti")->fetch_assoc()["totale"];
    }

    public function countAd(){
        return $this->db->query("SELECT COUNT(*) as totale FROM annunci WHERE isActive=1")->fetch_assoc()["totale"];
    }

    public function countReports(){
        return $this->db->query("SELECT COUNT(*) as totale FROM segnalazioni WHERE stato='aperta'")->fetch_assoc()["totale"];
    }

    public function getSegnalazioni($stato = 'aperta') {
        $query = "SELECT s.*, u_rep.email as email_autore, a.titolo as titolo_annuncio, a.id_utente as id_creatore_annuncio, u_cre.email as email_creatore_annuncio
                  FROM segnalazioni s
                  LEFT JOIN utenti u_rep ON s.id_autore = u_rep.id_utente
                  LEFT JOIN annunci a ON s.id_annuncio_segnalato = a.id_annuncio
                  LEFT JOIN utenti u_cre ON a.id_utente = u_cre.id_utente
                  WHERE s.stato = ?
                  ORDER BY s.data_segnalazione DESC";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('s', $stato);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function deleteUser($id_utente){
        $stmt = $this->db->prepare("DELETE FROM utenti WHERE id_utente = ?");
        $stmt->bind_param('i', $id_utente);
        return $stmt->execute();
    }

    public function resolveReport($id_segnalazione){
        $stmt = $this->db->prepare("UPDATE segnalazioni SET stato = 'risolta' WHERE id_segnalazione = ?");
        $stmt->bind_param('i', $id_segnalazione);
        return $stmt->execute();
    }

    public function getAllUsers(){
        return $this->db->query("SELECT * FROM utenti ORDER BY dataIscrizione DESC")->fetch_all(MYSQLI_ASSOC);
    }

    public function insertTurnoPulizia($compito, $data, $assegnato_a, $id_casa){
        $stmt = $this->db->prepare("INSERT INTO turni_pulizie (compito, data_scadenza, assegnato_a, id_casa) VALUES (?, ?, ?, ?)");
        $stmt->bind_param('ssii', $compito, $data, $assegnato_a, $id_casa);
        return $stmt->execute();
    }

    public function getTurniPulizie($id_casa){
        $stmt = $this->db->prepare("SELECT t.*, u.nome, u.cognome FROM turni_pulizie t JOIN utenti u ON t.assegnato_a = u.id_utente WHERE t.id_casa = ? ORDER BY t.data_scadenza ASC");
        $stmt->bind_param('i', $id_casa);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getTurniMeseSuccessivo($id_casa){
        $stmt = $this->db->prepare("SELECT t.*, u.nome, u.cognome FROM turni_pulizie t JOIN utenti u ON t.assegnato_a = u.id_utente WHERE t.id_casa = ? AND t.data_scadenza BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 30 DAY) ORDER BY t.data_scadenza ASC");
        $stmt->bind_param('i', $id_casa);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function updateTurnoStato($id_turno, $completato){
        $stmt = $this->db->prepare("UPDATE turni_pulizie SET completato = ? WHERE id_turno = ?");
        $stmt->bind_param('ii', $completato, $id_turno);
        return $stmt->execute();
    }

    public function insertCandidatura($id_annuncio, $nome, $email, $messaggio, $foto) {
        $query = "INSERT INTO candidature (id_annuncio, nome, email, messaggio, foto, data_invio) VALUES (?, ?, ?, ?, ?, CURRENT_TIMESTAMP)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('issss', $id_annuncio, $nome, $email, $messaggio, $foto);
        return $stmt->execute();
    }
        public function getCandidatureByAnnuncio($id_annuncio) {
        $stmt = $this->db->prepare("SELECT * FROM candidature WHERE id_annuncio = ? ORDER BY data_invio DESC");
        $stmt->bind_param("i", $id_annuncio);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function checkEmailExists($email) {
        $query = "SELECT id_utente FROM utenti WHERE email = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->num_rows > 0; // Ritorna true se l'email esiste
    }

    public function creaSegnalazione($id_annuncio, $id_segnalante, $id_segnalato, $motivo, $descrizione) {
        // La tabella segnalazioni usa: id_autore, id_annuncio_segnalato, id_utente_segnalato
        $query = "INSERT INTO segnalazioni (id_autore, id_annuncio_segnalato, id_utente_segnalato, motivo, descrizione, stato) 
                VALUES (?, ?, ?, ?, ?, 'aperta')";
        $stmt = $this->db->prepare($query);
        
        // 'iiiss' -> id_autore(int), id_annuncio_segnalato(int), id_utente_segnalato(int), motivo(string), descrizione(string)
        $stmt->bind_param('iiiss', $id_segnalante, $id_annuncio, $id_segnalato, $motivo, $descrizione);
        
        return $stmt->execute();
    }

// Recupera i coinquilini includendo il ruolo
    public function getCoinquilini($id_casa){
        $stmt = $this->db->prepare("SELECT id_utente, nome, cognome, ruolo FROM utenti WHERE id_casa = ?");
        $stmt->bind_param('i', $id_casa);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
    // Passa il ruolo di admin a un altro utente (Transazione SQL per sicurezza)
    public function passaAdmin($id_vecchio_admin, $id_nuovo_admin) {
        $this->db->begin_transaction();
        try {
            // 1. Il nuovo utente diventa admin
            $stmt1 = $this->db->prepare("UPDATE utenti SET ruolo = 'admin_casa' WHERE id_utente = ?");
            $stmt1->bind_param('i', $id_nuovo_admin);
            $stmt1->execute();
            
            // 2. Il vecchio admin torna studente
            $stmt2 = $this->db->prepare("UPDATE utenti SET ruolo = 'studente' WHERE id_utente = ?");
            $stmt2->bind_param('i', $id_vecchio_admin);
            $stmt2->execute();
            
            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollback();
            return false;
        }
    }

    public function updateHouse($id_casa, $nome_casa, $codice_invito) {
        $query = "UPDATE `case` SET nome_casa = ?, codice_invito = ? WHERE id_casa = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('ssi', $nome_casa, $codice_invito, $id_casa);
    return $stmt->execute();
}

    // Inserisce un messaggio nel forum della casa
    public function insertMessaggioCasa($id_casa, $id_utente, $testo, $is_anonimo, $parent_id = null) {
        $query = "INSERT INTO messaggi_casa (id_casa, id_utente, testo, is_anonimo, parent_id) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('iisii', $id_casa, $id_utente, $testo, $is_anonimo, $parent_id);
        return $stmt->execute();
    }

    // Recupera i messaggi del forum ordinati per data
    public function getMessaggiForum($id_casa) {
        $query = "SELECT m.*, u.nome, u.cognome, u.foto_profilo 
                FROM messaggi_casa m 
                JOIN utenti u ON m.id_utente = u.id_utente 
                WHERE m.id_casa = ? 
                ORDER BY m.data_invio DESC";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $id_casa);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}
?>