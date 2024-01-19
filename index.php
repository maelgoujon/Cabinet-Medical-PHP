<?php
session_start();

// Vérifier si l'utilisateur est authentifié
if (!isset($_SESSION["authenticated"]) || $_SESSION["authenticated"] !== true) {
    header("Location: /Base/login.php");
    exit();
}

include '/Base/header_accueil.php';
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil</title>
    <!-- Ajoutez les liens vers les fichiers CSS Bootstrap ici -->
    <link href="Base/bootstrap.min.css" rel="stylesheet" />
    <link href="Base/accueil.css" rel="stylesheet" />
    <link href="Base/style.css" rel="stylesheet" />
    <!-- Ajoutez les liens vers les fichiers JavaScript Bootstrap et jQuery ici -->
    <script src="Base/jquery-3.2.1.slim.min.js"></script>
    <script src="Base/popper.min.js"></script>
    <script src="Base/bootstrap.bundle.min.js"></script>
</head>

<body>
    <div class="container">
        <br>
        <p class="h3 text-primary font-weight-bold text-center">Bienvenue sur l'espace de gestion de vôtre cabinet médical !</p>
        <br>

        <div class="container row shadow-lg">
            <div class="col-md-3">
                <img src="Images/patient.png" alt="Logo" width="150" height="150"/>
            </div>
            <div class="col-md-9">
                <h3>Liste des patients</h3>
                <p>
                    Cliquez ici pour voir la liste des patients :
                    <br />
                    <a href="patient/">patients</a>
                </p>
            </div>
        </div>
        <br>

        <div class="container row shadow-lg">
            <div class="col-md-3">
                <img src="Images/docteur.png" alt="Logo" width="150" height="150"/>
            </div>
            <div class="col-md-9">
                <h3>Liste des médecins</h3>
                <p>
                    Cliquez ici pour voir la liste des médeicns :
                    <br />
                    <a href="medecin/">Médecins</a>
                </p>
            </div>
        </div>
        <br>

        <div class="container row shadow-lg">
            <div class="col-md-3">
                <img src="Images/consult.png" alt="Logo" width="150" height="150"/>
            </div>
            <div class="col-md-9">
                <h3>Voir vos consultaions</h3>
                <p>
                    Découvrez vos consultations :
                    <br />
                    <a href="consultations/">consultations</a>
                </p>
            </div>
        </div>
        <br>

        <div class="container row shadow-lg">
            <div class="col-md-3">
                <img src="Images/stat.png" alt="Logo" width="150" height="150"/>
            </div>
            <div class="col-md-9">
                <h3>Statistiques</h3>
                <p>
                    Sur cette page découvrez quelques statistiques concernenant vôtre cabinet médical :
                    <br />
                    <a href="Stats/statistiques.php">Statistiques</a>
                </p>
            </div>
        </div>
        <br>
    </div>
</body>

</html>

