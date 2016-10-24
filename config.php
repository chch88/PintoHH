<?php
$dbhost = 'localhost';
$dbname = 'pinto';
$dbuser = "root";
$dbpassword = 'root';

try {
    $bdd = new PDO('mysql:host='.$dbhost. ';dbname='.$dbname, $dbuser, $dbpassword  );
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
}

catch (Exception $e){
    die('Erreur : ' . $e->getMessage());
}

ini_set('display_errors', 1);
?>
