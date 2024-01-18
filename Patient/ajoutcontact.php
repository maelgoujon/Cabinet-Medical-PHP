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
    <title>Ajout d'un patient</title>
    <!-- Ajoutez les liens vers les fichiers CSS Bootstrap ici -->
    <link href="../Base/bootstrap.min.css" rel="stylesheet" />
    
    <link href="../Base/style.css" rel="stylesheet" />
    <!-- Ajoutez les liens vers les fichiers JavaScript Bootstrap et jQuery ici -->
    <script src="../Base/jquery-3.2.1.slim.min.js"></script>
    <script src="../Base/popper.min.js"></script>
    <script src="../Base/bootstrap.bundle.min.js"></script>
    
  </head>

    <body>

    
            <?php
                $server = 'localhost';
                $db = 'php_project';
                $login = "etu";
                $mdp = "\$iutinfo";

                try {
                    $linkpdo = new PDO("mysql:host=$server;dbname=$db", $login, $mdp);
                    $linkpdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                        // Recuperation des donnees du formulaire HTML
                        $civilite = $_POST['civilite'];
                        $prenom = $_POST['prenom'];
                        $nom = $_POST['nom'];
                        $adresse = $_POST['adresse'];
                        $date_de_naissance = $_POST['date_de_naissance'];
                        $lieu_de_naissance = $_POST['lieu_de_naissance'];
                        $numero_securite_sociale = $_POST['numero_securite_sociale'];
                        $idMedecin = $_POST['idMedecin']; // Ajoutez le champ de selection du medecin referent

                        $sql = "INSERT INTO patient (`Civilite`, `Prenom`, `Nom`, `Adresse`, `Date_de_naissance`, `Lieu_de_naissance`, `Numero_Securite_Sociale`, `idMedecin`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

                        $stmt = $linkpdo->prepare($sql);
                        if ($stmt == false) {
                            die("Erreur prepare");
                        }
                        $test = $stmt->execute([$civilite, $prenom, $nom, $adresse, $date_de_naissance, $lieu_de_naissance, $numero_securite_sociale, $idMedecin]);

                        if ($test == false) {
                            $stmt->debugDumpParams();
                            die("Erreur Execute");
                        }

                        // Verification de l'insertion
                        if ($stmt->rowCount() > 0) {
                            echo "Le patient a ete ajoute avec succes. <br>";
                        } else {
                            echo "Une erreur s'est produite lors de l'ajout du patient.";
                        }
                    }

                    // Récupération des médecins depuis la table "Medecin"
                    $sqlMedecin = "SELECT idMedecin, Nom FROM Medecin";
                    $stmtMedecin = $linkpdo->query($sqlMedecin);

                } catch (PDOException $e) {
                    die('Erreur : ' . $e->getMessage());
                }
            ?>

        <!-- Formulaire HTML pour saisir un nouveau patient -->
        <form method="post" action="ajoutcontact.php" class="container mt-5">
            <h1 class="mb-4">Ajout d'un patient</h1>

            <div class="mb-3">
                <label for="civilite" class="form-label">Civilité :</label>
                <select id="idPatient" name="civilite" class="form-select" required>
                    <option value="1">Monsieur</option>
                    <option value="2">Madame</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="nom" class="form-label">Nom :</label>
                <input type="text" id="nom" name="nom" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="prenom" class="form-label">Prenom :</label>
                <input type="text" id="prenom" name="prenom" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="adresse" class="form-label">Adresse :</label>
                <input type="text" id="adresse" name="adresse" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="date_de_naissance" class="form-label">Date de naissance :</label>
                <input type="date" id="date_de_naissance" name="date_de_naissance" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="lieu_de_naissance" class="form-label">Lieu de naissance :</label>
                <input type="text" id="lieu_de_naissance" name="lieu_de_naissance" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="numero_securite_sociale" class="form-label">Numero de securite sociale :</label>
                <input type="text" id="numero_securite_sociale" name="numero_securite_sociale" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="idMedecin" class="form-label">Medecin Referent :</label>
                <select id="idMedecin" name="idMedecin" class="form-select" required>
                    <?php
                    // Affichage des options
                    while ($row = $stmtMedecin->fetch(PDO::FETCH_ASSOC)) {
                        echo '<option value="' . $row['idMedecin'] . '">' . $row['Civilite'] . $row['Nom'] . '</option>';
                    }
                    ?>
                </select>
            </div>

            <div class="mb-3">
                <input type="submit" value="Ajouter le patient" class="btn btn-primary">
                <input type="button" value="Retour" onclick="history.back()" class="btn btn-warning">
                <a href="../Patient/">
                    <button type="button" class="btn btn-danger">Accueil Patient</button>
                </a>
            </div>
        </form>

    </div>
</body>
</html>