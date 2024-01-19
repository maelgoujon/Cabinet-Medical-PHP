<?php
$server = 'mysql-goujondardetphp.alwaysdata.net';
$db = 'goujondardetphp_sql';
$login = "344089";
$mdp = "\$iutinfo";

// Connexion à la base de données
$conn = new mysqli($server, $login, $mdp, $db);

// Vérification de la connexion
if ($conn->connect_error) {
    die("La connexion a échoué : " . $conn->connect_error);
}
?>
