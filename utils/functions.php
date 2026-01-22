<?php
// Funzione per capire in che pagina siamo e illuminare il menu
function isActive($pagename){
    if(basename($_SERVER['PHP_SELF']) == $pagename){
        echo " active ";
    }
}

function getIdFromName($name){
    return preg_replace("/[^a-z]/", '', strtolower($name));
}
?>