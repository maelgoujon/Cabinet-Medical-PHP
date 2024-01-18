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
    <title>Ajouter un médecin</title>
    <!-- Ajoutez les liens vers les fichiers CSS Bootstrap ici -->
    <link href="../Base/bootstrap.min.css" rel="stylesheet" />
    <link href="../Base/accueil.css" rel="stylesheet" />
    <link href="../Base/style.css" rel="stylesheet" />
    <!-- Ajoutez les liens vers les fichiers JavaScript Bootstrap et jQuery ici -->
    <script src="../Base/jquery-3.2.1.slim.min.js"></script>
    <script src="../Base/popper.min.js"></script>
    <script src="../Base/bootstrap.bundle.min.js"></script>
    
  </head>

    <div>

    <div class="container mt-5">
        <h1 class="mb-4">Ajout d'un médecin</h1>
        <?php
        include'../Base/config.php';

        try {
            $linkpdo = new PDO("mysql:host=$server;dbname=$db", $login, $mdp);
            $linkpdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                // Recuperation des donnees du formulaire HTML
                $civilite = $_POST['civilite'];
                $prenom = $_POST['prenom'];
                $nom = $_POST['nom'];

                $sql = "INSERT INTO medecin (`Civilite`, `Prenom`, `Nom`) VALUES (?, ?, ?)";

                $stmt = $linkpdo->prepare($sql);
                if ($stmt == false) {
                    die("Erreur prepare");
                }
                $test = $stmt->execute([$civilite, $prenom, $nom]);

                if ($test == false) {
                    $stmt->debugDumpParams();
                    die("Erreur Execute");
                }

                // Verification de l'insertion
                if ($stmt->rowCount() > 0) {
                    echo '<style="color : green">Le médecin a été ajouté avec succès. <br></style>';
                } else {
                    echo "Une erreur s'est produite lors de l'ajout du medecin.";
                }
            }

            // Récupération des médecins depuis la table "Medecin"
            $sqlMedecin = "SELECT idMedecin, Nom FROM Medecin";
            $stmtMedecin = $linkpdo->query($sqlMedecin);

        } catch (PDOException $e) {
            die('Erreur : ' . $e->getMessage());
        }
        ?>

            <!-- Formulaire HTML pour saisir un nouveau medecin -->
            <form method="post" action="ajoutmedecin.php">
                <div class="mb-3">
                    <label for="civilite" class="form-label">Civilité :</label>
                    <select id="civilite" name="civilite" class="form-select" required>
                        <option value="1">Monsieur</option>
                        <option value="2">Madame</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="nom" class="form-label">Nom :</label>
                    <input type="text" id="nom" name="nom" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="prenom" class="form-label">Prénom :</label>
                    <input type="text" id="prenom" name="prenom" class="form-control" required>
                </div>

                <div class="mb-3">
                    <input type="submit" value="Ajouter le médecin" class="btn btn-primary">
                    <input type="button" value="Retour" onclick="history.back()" class="btn btn-warning">
                    <a href="../Medecin/">
                        <button type="button"  class="btn btn-danger">Accueil Médecin</button>
                    </a>
                </div>
            </form>
        </div>
</div>
</body>
</html>