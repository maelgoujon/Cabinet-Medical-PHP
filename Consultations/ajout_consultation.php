<!DOCTYPE html>
<html lang="fr">
  <head>

  <?php

      session_start();

      // Vérifier si l'utilisateur est authentifié
      if (!isset($_SESSION["authenticated"]) || $_SESSION["authenticated"] !== true) {
          header("Location: /Projet/projet_php/login.php");
          exit();
      }

    ?>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Statistiques</title>
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

    <nav class="nav">
      <a href="../index.html" class="nav-item is-active" active-color="orange"
        >Accueil</a
      >
      <a
        href="/Projet/projet_php/Patient/ajoutcontact.php"
        class="nav-item"
        active-color="green"
        >Patient</a
      >
      <a
        href="/Projet/projet_php/Medecin/ajoutmedecin.php"
        class="nav-item"
        active-color="blue"
        >Medecin</a
      >
      <a
        href="/Projet/projet_php/Consultations/index.php"
        class="nav-item"
        active-color="red"
        >Consultations</a
      >
      <a
        href="/Projet/projet_php/Stats/statistiques.php"
        class="nav-item"
        active-color="rebeccapurple"
        >Statistiques</a
      >
      <a href="planning.php" class="nav-item" active-color="pink">Planning</a>
      <span class="nav-indicator"></span>
    </nav>

<?php
include 'config.php';

// Requête pour récupérer la liste des médecins
$sqlMedecins = "SELECT * FROM Medecin";
$resultMedecins = $conn->query($sqlMedecins);

// Requête pour récupérer la liste des patients
$sqlPatients = "SELECT * FROM Patient";
$resultPatients = $conn->query($sqlPatients);

// Formulaire de saisie de consultation
echo "<h2>Ajouter une consultation</h2>";
echo "<form action='process_consultation.php' method='post'>
    Date Consultation: <input type='date' name='dateConsultation'><br>
    Heure: <input type='text' name='heure'><br>
    Duree: <input type='text' name='duree'><br>
    Patient: <select name='idPatient'>
        <option value='' selected disabled>Selectionner un patient</option>";
while ($rowPatient = $resultPatients->fetch_assoc()) {
    $idPatient = $rowPatient['idPatient'];
    $nomPatient = $rowPatient['Nom'];
    $prenomPatient = $rowPatient['Prenom'];

    // Requête pour récupérer le médecin associé au patient
    $sqlMedecinAssocie = "SELECT idMedecin FROM Patient WHERE idPatient = $idPatient";
    $resultMedecinAssocie = $conn->query($sqlMedecinAssocie);
    $rowMedecinAssocie = $resultMedecinAssocie->fetch_assoc();
    $idMedecinAssocie = $rowMedecinAssocie['idMedecin'];

    echo "<option value='$idPatient' data-idMedecinAssocie='$idMedecinAssocie'>$nomPatient $prenomPatient</option>";
}
echo "</select><br>
    Medecin: <select name='idMedecin' id='medecinSelect'>
        <option value='' selected disabled>Selectionner un medecin</option>";
while ($rowMedecin = $resultMedecins->fetch_assoc()) {
    echo "<option value='{$rowMedecin['idMedecin']}'>{$rowMedecin['Nom']} {$rowMedecin['Prenom']}</option>";
}
echo "</select><br>
    <input type='submit' value='Ajouter'>
</form>";

// Fermer la connexion
$conn->close();
?>




<script>
    document.addEventListener("DOMContentLoaded", function() {
        var patientSelect = document.querySelector("select[name='idPatient']");
        var medecinSelect = document.querySelector("#medecinSelect");

        // Écouter les changements dans le menu déroulant des patients
        patientSelect.addEventListener("change", function() {
            // Récupérer l'ID du médecin associé au patient sélectionné
            var selectedPatient = patientSelect.options[patientSelect.selectedIndex];
            var idMedecinAssocie = selectedPatient.getAttribute("data-idMedecinAssocie");

            // Pré-sélectionner automatiquement le médecin associé
            if (idMedecinAssocie) {
                medecinSelect.value = idMedecinAssocie;
            }
        });
    });
</script>
