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
    <title>patient</title>
    
  </head>

    <body>
        <div class="container mb-4">
            <?php
                include '../Base/config.php';

                // Requête pour récupérer tous les patients avec le nom du médecin référent
                $sql = "SELECT p.idPatient, p.Civilite, p.Prenom, p.Nom, p.Adresse, p.Date_de_naissance, p.Lieu_de_naissance, p.Numero_Securite_Sociale, m.Nom AS Nommedecin, m.Prenom AS Prenommedecin
                        FROM patient p
                        LEFT JOIN medecin m ON p.idMedecin = m.idMedecin";

                $result = $conn->query($sql);

                // Affichage des patients dans un tableau HTML
                echo "<h2>Liste des patients</h2>";
                echo "<table class='table table-bordered'>
                    <tr>
                        <th>Civilité</th>
                        <th>Prénom</th>
                        <th>Nom</th>
                        <th>Adresse</th>
                        <th>Date de Naissance</th>
                        <th>Lieu de Naissance</th>
                        <th>Numéro Sécurité Sociale</th>
                        <th>Médecin Référent</th>
                        <th>Action</th>
                    </tr>";

                    while ($row = $result->fetch_assoc()) {
                        $civilite = ($row['Civilite'] == 1) ? 'Monsieur' : 'Madame';
                        echo "<tr>
                                <td>{$civilite}</td>
                                <td>{$row['Prenom']}</td>
                                <td>{$row['Nom']}</td>
                                <td>{$row['Adresse']}</td>
                                <td>" . date('d/m/Y', strtotime($row['Date_de_naissance'])) . "</td>
                                <td>{$row['Lieu_de_naissance']}</td>
                                <td>{$row['Numero_Securite_Sociale']}</td>
                                <td>{$row['Nommedecin']} {$row['Prenommedecin']}</td>
                                <td><a href='modification.php?id={$row['idPatient']}' class='btn btn-warning btn-sm'>Modifier</a> | <a href='suppression.php?id={$row['idPatient']}' class='btn btn-danger btn-sm'>Supprimer</a></td>
                              </tr>";
                    }

                echo "</table>";

                // Fermer la connexion
                $conn->close();
            ?>
            <a href="ajoutcontact.php">
                <input type="button" class="btn btn-primary" value="Ajouter un patient">
            </a>
        </div>

    </body>
    
</html>