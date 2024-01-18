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
    <title>Modification d'un patient</title>
    <!-- Ajoutez les liens vers les fichiers CSS Bootstrap ici -->
    <link href="../Base/bootstrap.min.css" rel="stylesheet" />
    
    <link href="../Base/style.css" rel="stylesheet" />
    <!-- Ajoutez les liens vers les fichiers JavaScript Bootstrap et jQuery ici -->
    <script src="../Base/jquery-3.2.1.slim.min.js"></script>
    <script src="../Base/popper.min.js"></script>
    <script src="../Base/bootstrap.bundle.min.js"></script>
</head>
<body>
    <h1>Modification d'un patient</h1>
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
                $idPatient = $_POST['idPatient'];
                $civilite = $_POST['civilite'];
                $prenom = $_POST['prenom'];
                $nom = $_POST['nom'];
                $adresse = $_POST['adresse'];
                $date_de_naissance = $_POST['date_de_naissance'];
                $lieu_de_naissance = $_POST['lieu_de_naissance'];
                $numero_securite_sociale = $_POST['numero_securite_sociale'];
                $idMedecin = $_POST['idMedecin'];

                // Requête SQL de mise à jour
                $sql = "UPDATE patient SET Civilite=?, Prenom=?, Nom=?, Adresse=?, Date_de_naissance=?, Lieu_de_naissance=?, Numero_Securite_Sociale=?, idMedecin=? WHERE idPatient=?";

                $stmt = $linkpdo->prepare($sql);
                if ($stmt == false) {
                    die("Erreur prepare");
                }

                $test = $stmt->execute([$civilite, $prenom, $nom, $adresse, $date_de_naissance, $lieu_de_naissance, $numero_securite_sociale, $idMedecin, $idPatient]);

                if ($test == false) {
                    $stmt->debugDumpParams();
                    die("Erreur Execute");
                }
                // Vérification de la mise à jour
                if ($stmt->rowCount() > 0) {
                    $validationMessage = "Les informations du patient ont ete modifiees avec succes.";
                } else {
                    $validationMessage = "Aucune modification effectuée pour le patient.";
                } 

            } else {

                // Récupération de l'ID du patient à partir de la requête GET
                if (isset($_GET['id'])) {
                    $idPatient = $_GET['id'];

                    // Requête SQL pour récupérer les informations du patient
                    $sql = "SELECT * FROM patient WHERE idPatient=?";
                    $stmt = $linkpdo->prepare($sql);
                    $stmt->execute([$idPatient]);
                    $patient = $stmt->fetch(PDO::FETCH_ASSOC);
                }
            }
        } catch (PDOException $e) {
            die("Erreur de connexion à la base de données: " . $e->getMessage());
        }
        ?>

        <form method="post" action="modification.php" class="container mt-5">
            <?php
            if ($stmt->rowCount() > 0) {
                echo '<p class="text-success">' . $validationMessage . '</p>';
                ?>
                <form>
                    <input type="hidden" name="idPatient" value="<?php echo isset($patient['idPatient']) ? $patient['idPatient'] : ''; ?>">

                    <div class="mb-3">
                        <label for="civilite" class="form-label">Civilité:</label>
                        <select name="civilite" class="form-select">
                            <option value="1" <?php echo (isset($patient['Civilite']) && $patient['Civilite'] == 1) ? 'selected' : ''; ?>>Monsieur</option>
                            <option value="2" <?php echo (isset($patient['Civilite']) && $patient['Civilite'] == 2) ? 'selected' : ''; ?>>Madame</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="prenom" class="form-label">Prénom:</label>
                        <input type="text" name="prenom" value="<?php echo isset($patient['Prenom']) ? $patient['Prenom'] : ''; ?>" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label for="nom" class="form-label">Nom:</label>
                        <input type="text" name="nom" value="<?php echo isset($patient['Nom']) ? $patient['Nom'] : ''; ?>" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label for="adresse" class="form-label">Adresse:</label>
                        <input type="text" name="adresse" value="<?php echo isset($patient['Adresse']) ? $patient['Adresse'] : ''; ?>" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label for="date_de_naissance" class="form-label">Date de naissance :</label>
                        <input type="date" name="date_de_naissance" value="<?php echo isset($patient['Date_de_naissance']) ? $patient['Date_de_naissance'] : ''; ?>" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label for="lieu_de_naissance" class="form-label">Lieu de naissance :</label>
                        <input type="text" name="lieu_de_naissance" value="<?php echo isset($patient['Lieu_de_naissance']) ? $patient['Lieu_de_naissance'] : ''; ?>" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label for="numero_securite_sociale" class="form-label">Numéro de sécurité sociale :</label>
                        <input type="text" name="numero_securite_sociale" value="<?php echo isset($patient['Numero_Securite_Sociale']) ? $patient['Numero_Securite_Sociale'] : ''; ?>" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label for="medecin_referent" class="form-label">Médecin référent :</label>
                        <select name="idMedecin" class="form-select">
                            <?php
                            // Récupérer la liste des médecins depuis la base de données
                            $sqlDoctors = "SELECT * FROM medecin";
                            $stmtDoctors = $linkpdo->query($sqlDoctors);
                            $doctors = $stmtDoctors->fetchAll(PDO::FETCH_ASSOC);

                            // Remplir les options dans l'élément select
                            foreach ($doctors as $doctor) {
                                $selected = (isset($patient['idMedecin']) && $patient['idMedecin'] == $doctor['idMedecin']) ? 'selected' : '';
                                echo "<option value='{$doctor['idMedecin']}' $selected>{$doctor['Nom']} {$doctor['Prenom']}</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <input type="hidden" name="idPatient" value="<?php echo isset($patient['idPatient']) ? $patient['idPatient'] : ''; ?>">
                    <button type="button" onclick="history.back()" class="btn btn-danger">Retour</button>
                    <button type="submit" class="btn btn-primary">Modifier le patient</button>
                    <a href="../Patient">
                        <button type="button" class="btn btn-warning">Accueil Patient</button>
                    </a>
                </form>
            <?php
            } else {
                echo "Patient non trouvé.";
            }
            ?>
        </form>

        
    </div>
</body>
</html>
