<!DOCTYPE HTML>
<head>
    <title>Modification</title>
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
            padding: 20px;
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
            cursor: pointer;
        }

        .bouton-cancel {
            background-color: #FF0000;
            color: #fff;
            cursor: pointer;
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .bouton-cancel:hover {
            background-color: #FF3333;
        }
    </style>
</head>
<?php
// Connexion au serveur MySQL
$server = 'localhost';
$db = 'PHP_Project';
$login = "etu";
$mdp = "\$iutinfo";

try {
    $linkpdo = new PDO("mysql:host=$server;dbname=$db", $login, $mdp);
    // Definition du mode d'erreur PDO à exception
    $linkpdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Recuperation des donnees du formulaire HTML
    $civilite= $_POST['civilite'];
    $prenom = $_POST['prenom'];
    $nom = $_POST['nom'];
    $adresse = $_POST['adresse'];
    $date_de_naissance = $_POST['date_de_naissance'];
    $lieu_de_naissance = $_POST['lieu_de_naissance'];
    $numero_securite_sociale = $_POST['numero_securite_sociale'];
    $idMedecin = $_POST['idMedecin'];

    // Requête SQL d'insertion
    $sql = "INSERT INTO patient (`Civilite`, `Prenom`, `Nom`, `Adresse`, `Date_de_naissance`, `Lieu_de_naissance`, `Numero_Securite_Sociale`, `idMedecin`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    // Preparation de la requête
    $stmt = $linkpdo->prepare($sql);

    // Execution de la requête avec les donnees du formulaire
    $stmt->execute([$civilite, $prenom, $nom, $adresse, $date_de_naissance, $lieu_de_naissance, $numero_securite_sociale, $idMedecin]);

    // Verification de l'insertion
    if ($stmt->rowCount() > 0) {
        echo "Le patient a ete modifie avec succes. <br>";
        // Bouton "Accueil" pour revenir à la page HTML de base
        echo '<a href="ajoutcontact.php">Accueil</a>';
    } else {
        echo "Une erreur s'est produite lors de l'ajout du patient.";
    }

    // Fermeture de la connexion à la base de donnees
    $linkpdo = null;
} catch (PDOException $e) {
    die('Erreur : ' . $e->getMessage());
}
?>
</html>