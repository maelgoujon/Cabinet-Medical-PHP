<!DOCTYPE HTML>
<html>
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
    <title>Modification d'une consultation</title>
    <!-- Ajoutez les liens vers les fichiers CSS Bootstrap ici -->
    <link href="../Base/bootstrap.min.css" rel="stylesheet" />
    
    <link href="../Base/style.css" rel="stylesheet" />
    <!-- Ajoutez les liens vers les fichiers JavaScript Bootstrap et jQuery ici -->
    <script src="../Base/jquery-3.2.1.slim.min.js"></script>
    <script src="../Base/popper.min.js"></script>
    <script src="../Base/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="container">
        <?php
        $server = 'localhost';
        $db = 'php_project';
        $login = "etu";
        $mdp = "\$iutinfo";

        $validationMessage = '';

        try {
            $linkpdo = new PDO("mysql:host=$server;dbname=$db", $login, $mdp);
            $linkpdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $idConsultation = $_POST['idConsultation'];
                $dateConsultation = $_POST['dateConsultation'];
                $heure = $_POST['heure'];
                $duree = $_POST['duree'];

                // Requête SQL de mise à jour
                $sql = "UPDATE consultations SET DateConsultation=?, Heure=?, Duree=? WHERE idConsultation=?";

                $stmt = $linkpdo->prepare($sql);
                if ($stmt == false) {
                    die("Erreur prepare");
                }

                $test = $stmt->execute([$dateConsultation, $heure, $duree, $idConsultation]);

                if ($test == false) {
                    $stmt->debugDumpParams();
                    die("Erreur Execute");
                }
                // Vérification de la mise à jour
                if ($stmt->rowCount() > 0) {
                    $validationMessage = "Les informations de la consultation ont ete modifiees avec succes.";
                } else {
                    $validationMessage = "Aucune modification effectuée pour le consultation.";
                } 

            } else {

                // Récupération de l'ID du consultation à partir de la requête GET
                if (isset($_GET['id'])) {
                    $idConsultation = $_GET['id'];

                    // Requête SQL pour récupérer les informations du consultation
                    $sql = "SELECT * FROM consultations WHERE idConsultation=?";
                    $stmt = $linkpdo->prepare($sql);
                    $stmt->execute([$idConsultation]);
                    $consultation = $stmt->fetch(PDO::FETCH_ASSOC);
                }
            }
        } catch (PDOException $e) {
            die("Erreur de connexion à la base de données: " . $e->getMessage());
        }
        ?>


        <form method="post" action="modification.php" class="container mt-5">
            <h1 class="mb-4">Modification d'une consultation</h1>

            <?php
            if ($stmt->rowCount() > 0) {
                echo '<p style="color: green;">' . $validationMessage . '</p>';
            ?>
                <form method="post" action="modification.php">
                    <!-- Ajouter les valeurs par défaut dans les champs -->
                    <input type="hidden" name="idConsultation" value="<?php echo isset($consultation['idConsultation']) ? $consultation['idConsultation'] : ''; ?>">

                    <div class="mb-3">
                        <label for="dateConsultation" class="form-label">Date de la consultation :</label>
                        <input type="date" name="dateConsultation" style="width: auto;" class="form-control form-control-sm" value="<?php echo isset($consultation['DateConsultation']) ? $consultation['DateConsultation'] : ''; ?>">
                    </div>

                    <div class="mb-3">
                        <label for="heure" class="form-label">Heure :</label>
                        <input type="time" style="width: auto;" name="heure" class="form-control form-control-sm" value="<?php echo isset($consultation['Heure']) ? $consultation['Heure'] : ''; ?>">
                    </div>

                    <div class="mb-3">
                        <label for="duree" class="form-label">Durée :</label>
                        <select name="duree" style="width: auto;" class="form-select form-select-sm">
                            <option value=''>--Choisissez une durée--</option>
                            <option value='15'>15 minutes</option>
                            <option value='30'>30 minutes</option>
                            <option value='45'>45 minutes</option>
                            <option value='60'>1 heure</option>
                            <option value='90'>1 heure 30 minutes</option>
                            <option value='120'>2 heures</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <input type="button" value="Retour" onclick="history.back()" class="btn btn-warning">
                        <input type="submit" value="Modifier la consultation" class="btn btn-primary">
                        <a href="../consultations">
                            <button type="button" class="btn btn-danger">Accueil consultations</button>
                        </a>
                    </div>
                </form>
            <?php
            } else {
                echo "Consultation non trouvée.";
            }
            ?>

        </form>
        
    </div>
</body>
</html>