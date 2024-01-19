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
    $sqlmedecins = "SELECT * FROM medecin";
    $resultmedecins = $conn->query($sqlmedecins);

    // Requête pour récupérer la liste des patients
    $sqlpatients = "SELECT * FROM patient";
    $resultpatients = $conn->query($sqlpatients);

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
                    <label for='idPatient' class='form-label'>patient:</label>
                    <select name='idPatient' class='form-select' required>
                        <option value='' selected disabled>Sélectionner un patient</option>";
                    while ($rowpatient = $resultpatients->fetch_assoc()) {
                        $idPatient = $rowpatient['idPatient'];
                        $nompatient = $rowpatient['Nom'];
                        $prenompatient = $rowpatient['Prenom'];
                        $sqlmedecinAssocie = "SELECT idMedecin FROM patient WHERE idPatient = $idPatient";
                        $resultmedecinAssocie = $conn->query($sqlmedecinAssocie);
                        $rowmedecinAssocie = $resultmedecinAssocie->fetch_assoc();
                        $idMedecinAssocie = $rowmedecinAssocie['idMedecin'];
                        echo "<option value='$idPatient' data-idMedecinAssocie='$idMedecinAssocie'>$nompatient $prenompatient</option>";
                    }
    echo "</select></div>
                <div class='col-md-6 mb-3'>
                    <label for='idMedecin' class='form-label'>Médecin:</label>
                    <select name='idMedecin' id='medecinSelect' class='form-select' required>
                        <option value='' selected disabled>Sélectionner un médecin</option>";
                    while ($rowmedecin = $resultmedecins->fetch_assoc()) {
                        echo "<option value='{$rowmedecin['idMedecin']}'>{$rowmedecin['Nom']} {$rowmedecin['Prenom']}</option>";
                    }
    echo "</select></div>
            </div>
            <div class='mb-3'>
                    <input type='submit' value='Ajouter la consultation' class='btn btn-primary'>
                    <input type='button' value='Retour' onclick='history.back()' class='btn btn-warning'>
                    <a href='../consultations/'>
                        <button type='button'  class='btn btn-danger'>Accueil consultations</button>
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
            var selectedpatient = patientSelect.options[patientSelect.selectedIndex];
            var idMedecinAssocie = selectedpatient.getAttribute("data-idMedecinAssocie");

            // Pré-sélectionner automatiquement le médecin associé
            if (idMedecinAssocie) {
                medecinSelect.value = idMedecinAssocie;
            }
        });
    });
</script>

</body>
</html>
