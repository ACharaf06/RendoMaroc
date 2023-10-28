<?php

$host = 'localhost';
$port = 3308;
$dbname = 'rendo_db';
$username = 'root';
$password = '';

try {
    $conn = new mysqli($host, $username, $password, $dbname, $port);
    $conn->set_charset("utf8");
} catch (Exception $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}

?>
