<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Recherche de Patient</title>
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
        }

        .accueil-link {
            display: block;
            margin: 20px auto;
            text-align: center;
            text-decoration: underline;
            color: #FF0000;
        }

        table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
        border: 1px solid #ccc;
        }

        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ccc;
        }

        th {
            background-color: #333;
            color: #fff;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .actions {
            text-align: center;
        }

        .actions a {
            text-decoration: none;
            margin-right: 5px;
            color: #FF0000;
        }

        .actions a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <h1>Recherche de patient</h1>
    <form action="recherche.php" method="POST">
        <label for="keywords">Mots-cles :</label>
        <input type="text" id="keywords" name="keywords" required placeholder="Exemple : 'Toto' ou 'Toto, Tata'">
        <input type="submit" value="Rechercher">
    </form>

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

        // Recuperation des mots-cles saisis dans le formulaire
        if (isset($_POST['keywords'])) {
            $keywords = explode(',', $_POST['keywords']); // Separe les mots-cles par des virgules

            // Prepare les paramètres de la requête SQL pour chaque mot-cle
            $params = array();

            foreach ($keywords as $keyword) {
                $param = '%' . trim($keyword) . '%';
                $params[] = $param;
            }

            // Construire la clause WHERE dynamique pour chaque mot-cle
            $whereConditions = '(' . implode(' OR ', array_fill(0, count($params), 'Civilite LIKE ? OR Prenom LIKE ? OR Nom LIKE ? OR Adresse LIKE ? OR Date_de_naissance LIKE ? OR Lieu_de_naissance LIKE ? OR Numero_Securite_Sociale LIKE ?')) . ')';

            // Requête SQL de recherche
            $sql = "SELECT * FROM Patient WHERE $whereConditions";

            // Preparation de la requête
            $stmt = $linkpdo->prepare($sql);

            // Construire un tableau de valeurs de paramètres
            $paramValues = array();
            foreach ($params as $param) {
                for ($i = 0; $i < 7; $i++) {
                    $paramValues[] = $param;
                }
            }

            // Execution de la requête
            $stmt->execute($paramValues);

            // Affichage des resultats sous forme d'un tableau HTML
            echo '<h2>Resultats de la recherche :</h2>';
            echo '<table border="1">';
            echo '<tr><th>Civilite</th><th>Prenom</th><th>Nom</th><th>Adresse</th><th>Date de naissance</th><th>Lieu de naissance</th><th>Numero de securite sociale</th></tr>';

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo '<tr>';
                echo '<td>' . $row['Civilite'] . '</td>';
                echo '<td>' . $row['Prenom'] . '</td>';
                echo '<td>' . $row['Nom'] . '</td>';
                echo '<td>' . $row['Adresse'] . '</td>';
                echo '<td>' . $row['Date_de_naissance'] . '</td>';
                echo '<td>' . $row['Lieu_de_naissance'] . '</td>';
                echo '<td>' . $row['Numero_Securite_Sociale'], '</td>';
                echo '<td><a href="modification.php?id=' . $row['idPatient'] . '">Modifier</a> | <a href="suppression.php?id=' . $row['idPatient'] . '">Supprimer</a></td>';
                echo '</tr>';
            }

            echo '</table>';
        }

        // Fermeture de la connexion à la base de donnees
        $linkpdo = null;
    } catch (PDOException $e) {
        die('Erreur : ' . $e->getMessage());
    }
    ?>


    <!-- Bouton pour revenir à la page "ajoutcontact.php" -->
    <a href="ajoutcontact.php" class="accueil-link">Accueil</a>
</body>
</html>