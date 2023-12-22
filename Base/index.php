<?php
  include 'header.php';

session_start();

// Vérifier si l'utilisateur est authentifié
if (!isset($_SESSION["authenticated"]) || $_SESSION["authenticated"] !== true) {
    header("Location: /Projet/projet_php/Base/login.php");
    exit();
}



?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Accueil</title>
  <style>
    body {
      background-color: #72a2c0;
      margin: 0;
    }

    .content {
      color: whitesmoke; /* Couleur du texte */
      text-align: center; /* Centre le texte horizontalement */
      font-size: 50px; /* Taille du texte */
    }
  </style>
</head>
<body>
  <div class="content">
    <p>Accueil</p>
  </div>
</body>
</html>
