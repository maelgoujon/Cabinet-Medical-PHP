<!DOCTYPE html>
<html lang="fr">
<head>

<?php

    session_start();

    // Vérifier si l'utilisateur est authentifié
    if (!isset($_SESSION["authenticated"]) || $_SESSION["authenticated"] !== true) {
        header("Location: /Projet/projet_php/Base/login.php");
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
<title>Ajout d'une consultation</title>

</head>

<body>
<div class="container mt-4">
<?php
    include '../Base/config.php';

    // Requête pour récupérer la liste des médecins
    $sqlMedecins = "SELECT * FROM Medecin";
    $resultMedecins = $conn->query($sqlMedecins);

    // Requête pour récupérer la liste des patients
    $sqlPatients = "SELECT * FROM Patient";
    $resultPatients = $conn->query($sqlPatients);

    // Formulaire de saisie de consultation
    echo "<h2>Ajouter une consultation</h2>";
    echo "<form action='process_consultation.php' method='post' class='needs-validation' novalidate>
            <div class='row'>
                <div class='col-md-6 mb-3'>
                    <label for='dateConsultation' class='form-label'>Date Consultation:</label>
                    <input type='date' name='dateConsultation' class='form-control' required>
                </div>
                <div class='col-md-6 mb-3'>
                    <label for='heure' class='form-label'>Heure:</label>
                    <input type='time' name='heure' class='form-control' required>
                </div>
            </div>
            <div class='row'>
                <div class='col-md-6 mb-3'>
                    <label for='duree' class='form-label'>Durée:</label>
                    <select name='duree' class='form-select' required>
                        <option value='' disabled>--Choisissez une durée--</option>
                        <option value='15'>15 minutes</option>
                        <option value='30'>30 minutes</option>
                        <option value='45'>45 minutes</option>
                        <option value='60'>1 heure</option>
                        <option value='90'>1 heure 30 minutes</option>
                        <option value='120'>2 heures</option>
                    </select>
                </div>
                <div class='col-md-6 mb-3'>
                    <label for='idPatient' class='form-label'>Patient:</label>
                    <select name='idPatient' class='form-select' required>
                        <option value='' selected disabled>Sélectionner un patient</option>";
                    while ($rowPatient = $resultPatients->fetch_assoc()) {
                        $idPatient = $rowPatient['idPatient'];
                        $nomPatient = $rowPatient['Nom'];
                        $prenomPatient = $rowPatient['Prenom'];
                        $sqlMedecinAssocie = "SELECT idMedecin FROM Patient WHERE idPatient = $idPatient";
                        $resultMedecinAssocie = $conn->query($sqlMedecinAssocie);
                        $rowMedecinAssocie = $resultMedecinAssocie->fetch_assoc();
                        $idMedecinAssocie = $rowMedecinAssocie['idMedecin'];
                        echo "<option value='$idPatient' data-idMedecinAssocie='$idMedecinAssocie'>$nomPatient $prenomPatient</option>";
                    }
    echo "</select></div>
                <div class='col-md-6 mb-3'>
                    <label for='idMedecin' class='form-label'>Médecin:</label>
                    <select name='idMedecin' id='medecinSelect' class='form-select' required>
                        <option value='' selected disabled>Sélectionner un médecin</option>";
                    while ($rowMedecin = $resultMedecins->fetch_assoc()) {
                        echo "<option value='{$rowMedecin['idMedecin']}'>{$rowMedecin['Nom']} {$rowMedecin['Prenom']}</option>";
                    }
    echo "</select></div>
            </div>
            <div class='mb-3'>
                    <input type='submit' value='Ajouter la consultation' class='btn btn-primary'>
                    <input type='button' value='Retour' onclick='history.back()' class='btn btn-warning'>
                    <a href='../Consultations/'>
                        <button type='button'  class='btn btn-danger'>Accueil Consultations</button>
                    </a>
                </div>
        </form>";

    // Fermer la connexion
    $conn->close();
    ?>
</div>

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

</body>
</html>
