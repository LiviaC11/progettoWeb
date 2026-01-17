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
}
?>