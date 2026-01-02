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
}
?>