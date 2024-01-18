<?php

session_start();

// Vérifier si l'utilisateur est authentifié
if (!isset($_SESSION["authenticated"]) || $_SESSION["authenticated"] !== true) {
    header("Location: /Base/login.php");
    exit();
}

include '../Base/header.php';
?>

<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- Ajoutez les liens vers les fichiers CSS Bootstrap ici -->
    <link href="../Base/bootstrap.min.css" rel="stylesheet" />
    
    <link href="../Base/style.css" rel="stylesheet" />
    <!-- Ajoutez les liens vers les fichiers JavaScript Bootstrap et jQuery ici -->
    <script src="../Base/jquery-3.2.1.slim.min.js"></script>
    <script src="../Base/popper.min.js"></script>
    <script src="../Base/bootstrap.bundle.min.js"></script>
    <title>Medecin</title>
    
  </head>

    <body>
    <div class="container mb-4">
      <?php
        include '../Base/config.php';

        // Requête pour récupérer tous les médecins avec le nom des patients associés
        $sql = "SELECT m.idMedecin, m.Civilite, m.Prenom, m.Nom FROM Medecin m";
        $result = $conn->query($sql);

        // Affichage des médecins dans un tableau HTML
        echo "<h2>Liste des médecins</h2>";
        echo "<table class='table table-bordered'>
                <tr>
                    <th>Civilité</th>
                    <th>Prénom</th>
                    <th>Nom</th>
                    <th>Action</th>
                </tr>";

        while ($row = $result->fetch_assoc()) {
            $civilite = ($row['Civilite'] == 1) ? 'Monsieur' : 'Madame';
            echo "<tr>
                    <td>{$civilite}</td>
                    <td>{$row['Prenom']}</td>
                    <td>{$row['Nom']}</td>
                    <td><a href='modification.php?id={$row['idMedecin']}'class='btn btn-warning btn-sm'>Modifier</a> | <a href='suppression.php?id={$row['idMedecin']}' class='btn btn-danger btn-sm'>Supprimer</a></td>
                  </tr>";
        }

        echo "</table>";

        // Fermer la connexion
        $conn->close();
      ?>
      <a href="ajoutmedecin.php">
        <input type="button" value="Ajouter un médecin" class="btn btn-primary">
      </a>
    </div>
    
    </body>
</html>
