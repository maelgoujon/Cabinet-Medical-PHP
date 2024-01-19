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
    <title>Statistiques</title>
    
  </head>

    <body>

    
      <div class="bg-light d-flex align-items-center justify-content-center vh-100">
        <?php
            include '../Base/config.php';

            // Récupérer les données du formulaire
            $dateConsultation = $_POST['dateConsultation'];
            $heure = $_POST['heure'];
            $duree = $_POST['duree'];
            $idPatient = $_POST['idPatient'];
            $idMedecin = $_POST['idMedecin'];

            // Vérifier si le médecin est libre
            $sqlCheckAvailability = "SELECT * FROM consultations 
                                    WHERE idMedecin = $idMedecin 
                                    AND DateConsultation = '$dateConsultation' 
                                    AND (
                                        (Heure < ADDTIME('$heure', SEC_TO_TIME($duree*60)) AND ADDTIME(Heure, SEC_TO_TIME(Duree*60)) > '$heure')
                                        OR
                                        (Heure < ADDTIME('$heure', SEC_TO_TIME($duree*60)) AND ADDTIME(Heure, SEC_TO_TIME(Duree*60)) >= ADDTIME('$heure', SEC_TO_TIME($duree*60)))
                                    )";

            $resultCheckAvailability = $conn->query($sqlCheckAvailability);

            if ($resultCheckAvailability->num_rows > 0) {
                // Le médecin n'est pas libre pendant ce créneau
                echo "<div class='container bg-white p-4 border border-success'>
                            <p class='lead'>Erreur : Le médecin n'est pas disponible pendant ce créneau. Choisissez un autre créneau</p>
                            <div class='mt-3'>
                                <a href='javascript:history.go(-1)'><input type='button' value='Retour'  class='btn btn-primary'></a>
                            </div>
                           </div>";
            } else {
                // Le médecin est libre, ajouter la consultation
                $sqlAddConsultation = "INSERT INTO consultations (DateConsultation, Heure, Duree, idMedecin, idPatient) 
                                    VALUES ('$dateConsultation', '$heure', $duree, $idMedecin, $idPatient)";
                
                if ($conn->query($sqlAddConsultation) === TRUE) {
                    echo "<div class='container bg-white p-4 border border-success'>
                            <p class='lead'>Consultation ajoutée avec succès!</p>
                            <div class='mt-3'>
                                <a href='../consultations/' class='btn btn-primary'>Accueil consultation</a>
                            </div>
                           </div>";
                } else {
                    echo "Erreur lors de l'ajout de la consultation, les champs sont vides ";
                }
            }

            // Fermer la connexion
            $conn->close();
        ?>
      </div>
    </body>
</html>