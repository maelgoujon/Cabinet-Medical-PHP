<!DOCTYPE html>
<html lang="fr">
  <head>

    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Statistiques</title>
    
  </head>

    <body>

    

<?php
include'../Base/config.php';

$sqlmedecin = "SELECT idMedecin, Nom FROM medecin";
$stmtmedecin = $linkpdo->query($sqlmedecin);
?>



            <label for="civilite">Civilite :</label>
            <select id="idMedecin" name="civilite">
                <!-- Remplacez les options ci-dessous par les medecins de votre base de donnees -->
                <option value="1">Monsieur</option>
                <option value="2">Madame</option>
                <!-- Ajoutez d'autres options si necessaire -->
            </select>
            <br><br>
            <label for="nom">Nom :</label>
            <input type="text" id="nom" name="nom" required>
            <br>
            <label for="prenom">Prenom :</label>
            <input type="text" id="prenom" name="prenom" required>
            <br><br>

