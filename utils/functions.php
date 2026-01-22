<?php
function isUserLoggedIn() {
    return isset($_SESSION['id_utente']);
}

function isCookieAccepted() {
    return isset($_COOKIE['cohappy_cookie_consent']);
}



function isActive($pagename) {
    if (basename($_SERVER['PHP_SELF']) == $pagename) {
        echo "active";
    }
}


function cleanInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function handleImageUpload($file, $isUpdate = false, $prefix = 'img_') {
    if(isset($file) && $file['error'] == 0){
        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        // Nome univoco per non fare confusione tra coinquilini
        $fileName = uniqid($prefix) . "." . $ext;
        
        // DESTINAZIONE: Tutto nella cartella img/ come concordato ✨
        $targetPath = "img/" . $fileName; 
        
        if(move_uploaded_file($file['tmp_name'], $targetPath)){
            return $targetPath; // Questo è il percorso che salviamo nel database
        }
    }
    
    // Se non caricano nulla:
    // In fase di modifica (update) ritorniamo null per non sovrascrivere la foto vecchia
    // In fase di inserimento nuovo, mettiamo la nostra fidata foto di default
    return $isUpdate ? null : "img/nophoto.png";
}
?>