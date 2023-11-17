<!DOCTYPE HTML>
<html>
<head>
    <title>Suppression d'un patient</title>
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

        // Recuperation de l'identifiant du contact à supprimer depuis l'URL
        $idPatient = $_GET['idPatient'];

        // Vérifier l'identifiant du patient
        echo "ID du patient à supprimer : " . $idPatient . "<br>";

        // Requête SQL pour supprimer le contact
        $sql = "DELETE FROM patient WHERE idPatient = ?";

        // Preparation de la requête
        $stmt = $linkpdo->prepare($sql);

        // Execution de la requête avec l'identifiant du contact
        $stmt->execute([$idPatient]);

        // Vérifier les erreurs de la requête
        if ($stmt->rowCount() > 0) {
            echo "Le patient a été supprimé avec succès.";
        } else {
            echo "Aucun patient n'a été supprimé.";
        }

        // Fermeture de la connexion à la base de donnees
        $linkpdo = null;

        // Vérifier les erreurs de redirection
        header("Location: recherche.php") or die("Redirection vers recherche.php échouée");

    } catch (PDOException $e) {
        die('Erreur : ' . $e->getMessage());
    }
    ?>
</body>
</html>
