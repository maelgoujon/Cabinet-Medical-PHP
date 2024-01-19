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
    <title>Modification d'un medecin</title>
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
                $idMedecin = $_POST['idMedecin'];
                $civilite = $_POST['civilite'];
                $prenom = $_POST['prenom'];
                $nom = $_POST['nom'];

                // Requête SQL de mise à jour
                $sql = "UPDATE medecin SET Civilite=?, Prenom=?, Nom=? WHERE idMedecin=?";

                $stmt = $linkpdo->prepare($sql);
                if ($stmt == false) {
                    die("Erreur prepare");
                }

                $test = $stmt->execute([$civilite, $prenom, $nom, $idMedecin]);

                if ($test == false) {
                    $stmt->debugDumpParams();
                    die("Erreur Execute");
                }
                // Vérification de la mise à jour
                if ($stmt->rowCount() > 0) {
                    $validationMessage = "Les informations du medecin ont ete modifiees avec succes.";
                } else {
                    $validationMessage = "Aucune modification effectuée pour le medecin.";
                } 

            } else {

                // Récupération de l'ID du medecin à partir de la requête GET
                if (isset($_GET['id'])) {
                    $idMedecin = $_GET['id'];

                    // Requête SQL pour récupérer les informations du medecin
                    $sql = "SELECT * FROM medecin WHERE idMedecin=?";
                    $stmt = $linkpdo->prepare($sql);
                    $stmt->execute([$idMedecin]);
                    $medecin = $stmt->fetch(PDO::FETCH_ASSOC);
                }
            }
        } catch (PDOException $e) {
            die("Erreur de connexion à la base de données: " . $e->getMessage());
        }
        ?>


        <form method="post" action="modification.php" class="container mt-5">
            <h1 class="mb-4">Modification d'un médecin</h1>
            <?php
            if ($stmt->rowCount() > 0) {
                echo '<p class="text-success">' . $validationMessage . '</p>';
                ?>
                <form method="post" action="modification.php">
                    <!-- Ajouter les valeurs par défaut dans les champs -->
                    <input type="hidden" name="idMedecin" value="<?php echo isset($medecin['idMedecin']) ? $medecin['idMedecin'] : ''; ?>">

                    <div class="mb-3">
                        <label for="civilite" class="form-label">Civilité:</label>
                        <select name="civilite" class="form-select">
                            <option value="1" <?php echo (isset($medecin['Civilite']) && $medecin['Civilite'] == 1) ? 'selected' : ''; ?>>Monsieur</option>
                            <option value="2" <?php echo (isset($medecin['Civilite']) && $medecin['Civilite'] == 2) ? 'selected' : ''; ?>>Madame</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="prenom" class="form-label">Prénom:</label>
                        <input type="text" name="prenom" value="<?php echo isset($medecin['Prenom']) ? $medecin['Prenom'] : ''; ?>" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label for="nom" class="form-label">Nom:</label>
                        <input type="text" name="nom" value="<?php echo isset($medecin['Nom']) ? $medecin['Nom'] : ''; ?>" class="form-control">
                    </div>

                    <button type="button" onclick="history.back()" class="btn btn-warning">Retour</button>
                    <button type="submit" class="btn btn-primary">Modifier le médecin</button>
                    <a href="../medecin">
                        <button type="button" class="btn btn-danger">Accueil Médecin</button>
                    </a>
                </form>
                <?php
            } else {
                echo "Médecin non trouvé.";
            }
            ?>
        </form>
        
    </div>
</body>
</html>
