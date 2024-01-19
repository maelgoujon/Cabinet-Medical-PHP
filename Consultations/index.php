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
    <title>consultations</title>
    <!-- Ajoutez les liens vers les fichiers CSS Bootstrap ici -->
    <link href="../Base/bootstrap.min.css" rel="stylesheet" />
    
    <link href="../Base/style.css" rel="stylesheet" />
    <!-- Ajoutez les liens vers les fichiers JavaScript Bootstrap et jQuery ici -->
    <script src="../Base/jquery-3.2.1.slim.min.js"></script>
    <script src="../Base/popper.min.js"></script>
    <script src="../Base/bootstrap.bundle.min.js"></script>     
  </head>

  <body>

    <div class="container mt-4">
      <?php
      include '../Base/config.php';

      // 1. Requête pour récupérer la liste des médecins
      $sqlmedecins = "SELECT idMedecin, Nom, Prenom FROM medecin";
      $resultmedecins = $conn->query($sqlmedecins);
      ?>

      <!-- 2. Formulaire avec menu déroulant pour filtrer par médecin -->
      <form action="" method="GET" class="mb-4">
        <div class="form-group">
          <label for="medecin">Filtrer par médecin :</label>
          <select name="medecin" id="medecin" class="form-control">
            <option value="">Tous les médecins</option>
            <?php
            while ($rowmedecin = $resultmedecins->fetch_assoc()) {
              $selected = ($_GET['medecin'] == $rowmedecin['idMedecin']) ? 'selected' : '';
              echo "<option value=\"{$rowmedecin['idMedecin']}\" $selected>{$rowmedecin['Nom']} {$rowmedecin['Prenom']}</option>";
            }
            ?>
          </select>
        </div>
        <br>
        <button type="submit" class="btn btn-primary">Filtrer</button>
      </form>


      <?php
      // 3. Modification de la requête principale en fonction de la sélection du menu déroulant
      $filtermedecin = isset($_GET['medecin']) ? $_GET['medecin'] : null;

      $sql = "SELECT c.idConsultation, c.DateConsultation, c.Heure, c.Duree, m.Nom AS Nommedecin, m.Prenom AS Prenommedecin, p.Nom AS Nompatient, p.Prenom AS Prenompatient
              FROM consultations c
              JOIN medecin m ON c.idMedecin = m.idMedecin
              JOIN patient p ON c.idPatient = p.idPatient";

      if ($filtermedecin) {
        $sql .= " WHERE m.idMedecin = $filtermedecin";
      }

      $sql .= " ORDER BY c.DateConsultation DESC";

      $result = $conn->query($sql);

      // Affichage des consultations dans un tableau HTML avec des classes Bootstrap
      echo "<h2>Liste des consultations</h2>";
      echo "<table class='table table-bordered'>
              <thead>
                  <tr>
                      <th>Date Consultation</th>
                      <th>Heure</th>
                      <th>Duree</th>
                      <th>medecin</th>
                      <th>patient</th>
                      <th>Action</th>
                  </tr>
              </thead>
              <tbody>";

              while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . date('d/m/Y', strtotime($row['DateConsultation'])) . "</td>
                        <td>{$row['Heure']}</td>
                        <td>{$row['Duree']}</td>
                        <td>{$row['Nommedecin']} {$row['Prenommedecin']}</td>
                        <td>{$row['Nompatient']} {$row['Prenompatient']}</td>
                        <td><a href='modification.php?id={$row['idConsultation']}' class='btn btn-warning btn-sm'>Modifier</a> | <a href='suppression.php?id={$row['idConsultation']}' class='btn btn-danger btn-sm'>Supprimer</a></td>
                      </tr>";
            }

      echo "</tbody></table>";

      // Fermer la connexion
      $conn->close();
      ?>

      <a href="ajout_consultation.php" class="btn btn-primary">Ajouter une consultation</a>
    </div>
  

  </body>
</html>