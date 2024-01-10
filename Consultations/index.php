<?php

session_start();

// Vérifier si l'utilisateur est authentifié
if (!isset($_SESSION["authenticated"]) || $_SESSION["authenticated"] !== true) {
    header("Location: /Projet/projet_php/Base/login.php");
    exit();
}

include '../Base/header.php';
?>

<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Consultations</title>
    <style>
        @import url("https://fonts.googleapis.com/css?family=DM+Sans:500,700&display=swap");

* {
  box-sizing: border-box;
}

.body {
  text-align: center;
  height: 100vh;
  width: 100%;
  justify-content: center;
  align-items: center;
  padding: 0 20px;
}

.nav {
  display: inline-flex;
  position: relative;
  overflow: hidden;
  max-width: 100%;
  background-color: #fff;
  padding: 0 20px;
  border-radius: 40px;
  box-shadow: 0 10px 40px rgba(159, 162, 177, 0.8);
}

.nav-item {
  color: #83818c;
  padding: 20px;
  text-decoration: none;
  transition: 0.3s;
  margin: 0 6px;
  z-index: 1;
  font-family: "DM Sans", sans-serif;
  font-weight: 500;
  position: relative;
}

.nav-item:before {
  content: "";
  position: absolute;
  bottom: -6px;
  left: 0;
  width: 100%;
  height: 5px;
  border-radius: 8px 8px 0 0;
  opacity: 0;
  transition: 0.3s;
}

.nav-item.is-active:before {
  background-color: orange; /* couleur spéciale pour Accueil */
}

.nav-item.is-active:hover:before {
  opacity: 0; /* désactiver la barre lorsque le lien actif est survolé */
}

.nav-item:not(.is-active):hover:before,
.nav-item:first-child:hover:before {
  opacity: 1;
  bottom: 0;
}

.nav-item:nth-child(2):before {
  background-color: green; /* couleur spéciale pour A propos */
}

.nav-item:nth-child(3):before {
  background-color: blue; /* couleur spéciale pour Liste */
}

.nav-item:nth-child(4):before {
  background-color: red; /* couleur spéciale pour Blog */
}

.nav-item:nth-child(5):before {
  background-color: rebeccapurple; /* couleur spéciale pour Contact */
}

.nav-item:nth-child(6):before {
  background-color: pink; /* couleur spéciale pour Contact */
}

@media (max-width: 580px) {
  .nav {
    overflow: auto;
  }
}

/* Ajoutez ces styles à votre fichier css.css */

.body {
  text-align: center;
    }  

    .nav {
    display: flex;
    background-color: #fff;
    padding: 10px 20px;
    border-radius: 10px;
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    margin-bottom: 20px; /* Ajout d'une marge en bas pour séparer la barre de navigation du contenu */
    }

    .nav-item {
    color: #83818c;
    padding: 10px;
    text-decoration: none;
    transition: 0.3s;
    margin: 0 6px;
    font-family: "DM Sans", sans-serif;
    font-weight: 500;
    position: relative;
    }

    .nav-item:before {
    content: "";
    position: absolute;
    bottom: -3px;
    left: 0;
    width: 100%;
    height: 3px;
    border-radius: 4px 4px 0 0;
    opacity: 0;
    transition: 0.3s;
    }

    .nav-item.is-active:before {
    background-color: orange;
    }

    .nav-item.is-active:hover:before {
    opacity: 0;
    }

    .nav-item:not(.is-active):hover:before,
    .nav-item:first-child:hover:before {
    opacity: 1;
    bottom: 0;
    }

    /* Ajoutez un style pour le tableau */
    table {
    width: 100%;
    margin-top: 20px; /* Ajout d'une marge en haut du tableau */
    }

    th,
    td {
    padding: 10px;
    text-align: center;
    }

    th {
    background-color: #f2f2f2;
    }

    /* Ajoutez un style pour le titre du tableau */
    h2 {
    margin-top: 20px; /* Ajout d'une marge en haut du titre */
    }

    </style>
  </head>

    <body>

    

<?php
    include '../Base/config.php';

// 1. Requête pour récupérer la liste des médecins
$sqlMedecins = "SELECT idMedecin, Nom, Prenom FROM Medecin";
$resultMedecins = $conn->query($sqlMedecins);
?>

<!-- 2. Formulaire avec menu déroulant pour filtrer par médecin -->
<form action="" method="GET">
  <label for="medecin">Filtrer par médecin :</label>
  <select name="medecin" id="medecin">
    <option value="">Tous les médecins</option>
    <?php
    while ($rowMedecin = $resultMedecins->fetch_assoc()) {
      echo "<option value=\"{$rowMedecin['idMedecin']}\">{$rowMedecin['Nom']} {$rowMedecin['Prenom']}</option>";
    }
    ?>
  </select>
  <input type="submit" value="Filtrer">
</form>

<?php
// 3. Modification de la requête principale en fonction de la sélection du menu déroulant
$filterMedecin = isset($_GET['medecin']) ? $_GET['medecin'] : null;

$sql = "SELECT c.idConsultation, c.DateConsultation, c.Heure, c.Duree, m.Nom AS NomMedecin, m.Prenom AS PrenomMedecin, p.Nom AS NomPatient, p.Prenom AS PrenomPatient
      FROM Consultations c
      JOIN Medecin m ON c.idMedecin = m.idMedecin
      JOIN Patient p ON c.idPatient = p.idPatient";

if ($filterMedecin) {
  $sql .= " WHERE m.idMedecin = $filterMedecin";
}

$sql .= " ORDER BY c.DateConsultation DESC";

$result = $conn->query($sql);

// Affichage des consultations dans un tableau HTML
echo "<h2>Liste des consultations</h2>";
echo "<table border='1'>
    <tr>
        <th>Date Consultation</th>
        <th>Heure</th>
        <th>Duree</th>
        <th>Medecin</th>
        <th>Patient</th>
        <th>Action</th>
    </tr>";

while ($row = $result->fetch_assoc()) {
    echo "<tr>
        <td>{$row['DateConsultation']}</td>
        <td>{$row['Heure']}</td>
        <td>{$row['Duree']}</td>
        <td>{$row['NomMedecin']} {$row['PrenomMedecin']}</td>
        <td>{$row['NomPatient']} {$row['PrenomPatient']}</td>
        <td><a href='modification.php?id={$row['idConsultation']}'>Modifier</a> | <a href='suppression.php?id={$row['idConsultation']}'>Supprimer</a></td>
    </tr>";
}

echo "</table>";

// Fermer la connexion
$conn->close();
?>

<html>
    <a href="ajout_consultation.php">
        <input type="button" value="Ajouter une consultation">
    </a>
</html>
