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
    <title>Statistiques</title>
    
  </head>

    <body>

    
    <h1>Recherche de Medecin</h1>
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
            $whereConditions = '(' . implode(' OR ', array_fill(0, count($params), 'Civilite LIKE ? OR Prenom LIKE ? OR Nom LIKE ? ')) . ')';

            // Requête SQL de recherche
            $sql = "SELECT * FROM Medecin WHERE $whereConditions";

            // Preparation de la requête
            $stmt = $linkpdo->prepare($sql);

            // Construire un tableau de valeurs de paramètres
            $paramValues = array();
            foreach ($params as $param) {
                for ($i = 0; $i < 3; $i++) {
                    $paramValues[] = $param;
                }
            }

            // Execution de la requête
            $stmt->execute($paramValues);

            // Affichage des resultats sous forme d'un tableau HTML
            echo '<h2>Resultats de la recherche :</h2>';
            echo '<table border="1">';
            echo '<tr><th>Civilite</th><th>Prenom</th><th>Nom</th>';

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo '<tr>';
                echo '<td>' . $row['Civilite'] . '</td>';
                echo '<td>' . $row['Prenom'] . '</td>';
                echo '<td>' . $row['Nom'] . '</td>';

                echo '<td><a href="modification.php?id=' . $row['idMedecin'] . '">Modifier</a> | <a href="suppression.php?id=' . $row['idMedecin'] . '">Supprimer</a></td>';
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
</body>
</html>