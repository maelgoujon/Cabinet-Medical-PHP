<!DOCTYPE HTML>
<html>
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
    <title>Modification d'un patient</title>
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

        <form method="post" action="modification.php">
            <?php
            if ($stmt->rowCount() > 0) {
                echo '<p style="color: green;">' . $validationMessage . '</p>';
                include 'form_patient.php';
            } else {
                echo "Patient non trouve.";
            }
            ?>
            <input type="hidden" name="idPatient" value="<?php echo isset($patient['idPatient']) ? $patient['idPatient'] : ''; ?>">
            <input type="button" value="Retour" onclick="history.back()">
            <input type="submit" value="Modifier le patient">
            <a href="ajoutcontact.php">
                <input type="button" value="Accueil">
            </a>
        </form>

        
    </div>
</body>
</html>
