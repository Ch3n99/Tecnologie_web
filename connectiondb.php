<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
function connectdb()
{
    $link=mysqli_connect("localhost","root","admin","prova");

    if(!$link) {
        echo "Si e' verificato un errore: non riesco a collegarmi al database",PHP_EOL;
        exit(-1);
    }
    
    return $link;
}
?>

