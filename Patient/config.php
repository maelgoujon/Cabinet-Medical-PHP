<?php
$server = 'localhost';
$db = 'php_project';
$login = "etu";
$mdp = "\$iutinfo";

// Connexion à la base de données
$conn = new mysqli($server, $login, $mdp, $db);

// Vérification de la connexion
if ($conn->connect_error) {
    die("La connexion a échoué : " . $conn->connect_error);
}
?>
