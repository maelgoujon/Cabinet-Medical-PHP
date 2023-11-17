<!DOCTYPE HTML>
<html>
<head>
    <title>Modification d'un patient</title>
    <style>
            
            body {
                font-family: Arial, sans-serif;
                background-color: #f0f0f0;
                margin: 0;
                padding: 0;
            }

            h1 {
                background-color: #FF0000;
                color: #fff;
                padding: 20px;
                text-align: center;
            }

            form {
                width: 80%;
                max-width: 600px;
                margin: 20px auto;
                padding: 50px;
                background-color: #fff;
                box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
            }

            label {
                display: block;
                margin-bottom: 5px;
            }

            input[type="text"],
            input[type="tel"],
            input[type="submit"],
            input[type="reset"],
            input[type="button"] {
                width: 100%;
                padding: 10px;
                margin-bottom: 10px;
                border: 1px solid #ccc;
                border-radius: 5px;
            }

            input[type="submit"] {
                background-color: #333;
                color: #fff;
                cursor: pointer;
            }

            input[type="submit"]:hover {
                background-color: #555;
            }

            input[type="reset"],
            input[type="button"] {
                background-color: #FF0000;
                color: #fff;
                cursor: pointer;
            }

            input[type="reset"]:hover,
            input[type="button"]:hover {
                background-color: #FF3333;
            }
    </style>
</head>
<body>
    <h1>Modification d'un patient</h1>
    <div class="container">
        <?php
        $server = 'localhost';
        $db = 'php_project';
        $login = "etu";
        $mdp = "\$iutinfo";

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
                    echo "Les informations du patient ont été modifiées avec succès. <br>";
                    echo '<a href="ajoutcontact.php">Accueil</a>';
                } else {
                    echo "Aucune modification effectuée pour le patient.";
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

                    // Affichage du formulaire pré-rempli avec les données existantes du patient
                    include 'form_patient.php'; // Vous pouvez créer un fichier séparé pour le formulaire
                } else {
                    echo "ID du patient non spécifié.";
                }
            }
        } catch (PDOException $e) {
            die('Erreur : ' . $e->getMessage());
        }
        ?>

        <!-- Formulaire HTML pour modifier un patient -->
        <!-- Utilisez le même formulaire que dans ajoutcontact.php -->
        <form method="post" action="modification.php">
            <!-- Inclure le formulaire du patient ici -->
            <?php
            if (isset($patient)) {
                include 'form_patient.php';
            } else {
                echo "Patient non trouvé.";
            }
            ?>
            <input type="hidden" name="idPatient" value="<?php echo isset($patient['idPatient']) ? $patient['idPatient'] : ''; ?>">
            <input type="submit" value="Modifier le patient">
        </form>
    </div>
</body>
</html>
