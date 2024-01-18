<!DOCTYPE html>
<html lang="fr">
  <head>
  <?php

session_start();

// Vérifier si l'utilisateur est authentifié
if (!isset($_SESSION["authenticated"]) || $_SESSION["authenticated"] !== true) {
    header("Location: /Base/login.php");
    exit();
}

include '../Base/header.php';

?>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- Ajoutez les liens vers les fichiers CSS Bootstrap ici -->
    <link href="../Base/bootstrap.min.css" rel="stylesheet" />
    <link href="../Base/accueil.css" rel="stylesheet" />
    <link href="../Base/style.css" rel="stylesheet" />
    <!-- Ajoutez les liens vers les fichiers JavaScript Bootstrap et jQuery ici -->
    <script src="../Base/jquery-3.2.1.slim.min.js"></script>
    <script src="../Base/popper.min.js"></script>
    <script src="../Base/bootstrap.bundle.min.js"></script>
    <title>Suppression</title>
    
    <script>
            function confirmDelete() {
                    // Si l'utilisateur confirme la suppression, rediriger vers suppressioncontact.php
                    window.location.href = 'suppressioncontact.php?id=<?php echo $_GET['id']; ?>';
            }
        </script>
  </head>

    <body>

    <div class="bg-light d-flex align-items-center justify-content-center vh-100">
        <div class='container bg-white p-4 border border-success'>
            <p class='lead'>Voulez vous vraiment supprimer ce patient ?</p>
            <div class='mt-3'>
                <button onclick="confirmDelete()" class='btn btn-primary'>Confirmer la suppression</button>
                <a href='javascript:history.go(-1)'><input type='button' value='Retour'  class='btn btn-primary'></a>
            </div>
        </div>
    </div>
</body>
</html>
