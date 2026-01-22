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
}
?>