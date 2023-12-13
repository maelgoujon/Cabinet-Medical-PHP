<!DOCTYPE html>
<html lang="fr">
  <head>
  <?php

session_start();

// Vérifier si l'utilisateur est authentifié
if (!isset($_SESSION["authenticated"]) || $_SESSION["authenticated"] !== true) {
    header("Location: /Projet/projet_php/login.php");
    exit();
}

?>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Statistiques</title>
    <style>
        @import url("https://fonts.googleapis.com/css?family=DM+Sans:500,700&display=swap");

* {
  box-sizing: border-box;
}

.body {
  text-align: center;
  height: 100vh;
  width: 100%;
  justify-content: center;
  align-items: center;
  padding: 0 20px;
}

.nav {
  display: inline-flex;
  position: relative;
  overflow: hidden;
  max-width: 100%;
  background-color: #fff;
  padding: 0 20px;
  border-radius: 40px;
  box-shadow: 0 10px 40px rgba(159, 162, 177, 0.8);
}

.nav-item {
  color: #83818c;
  padding: 20px;
  text-decoration: none;
  transition: 0.3s;
  margin: 0 6px;
  z-index: 1;
  font-family: "DM Sans", sans-serif;
  font-weight: 500;
  position: relative;
}

.nav-item:before {
  content: "";
  position: absolute;
  bottom: -6px;
  left: 0;
  width: 100%;
  height: 5px;
  border-radius: 8px 8px 0 0;
  opacity: 0;
  transition: 0.3s;
}

.nav-item.is-active:before {
  background-color: orange; /* couleur spéciale pour Accueil */
}

.nav-item.is-active:hover:before {
  opacity: 0; /* désactiver la barre lorsque le lien actif est survolé */
}

.nav-item:not(.is-active):hover:before,
.nav-item:first-child:hover:before {
  opacity: 1;
  bottom: 0;
}

.nav-item:nth-child(2):before {
  background-color: green; /* couleur spéciale pour A propos */
}

.nav-item:nth-child(3):before {
  background-color: blue; /* couleur spéciale pour Liste */
}

.nav-item:nth-child(4):before {
  background-color: red; /* couleur spéciale pour Blog */
}

.nav-item:nth-child(5):before {
  background-color: rebeccapurple; /* couleur spéciale pour Contact */
}

.nav-item:nth-child(6):before {
  background-color: pink; /* couleur spéciale pour Contact */
}

@media (max-width: 580px) {
  .nav {
    overflow: auto;
  }
}

/* Ajoutez ces styles à votre fichier css.css */

.body {
  text-align: center;
    }  

    .nav {
    display: flex;
    background-color: #fff;
    padding: 10px 20px;
    border-radius: 10px;
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    margin-bottom: 20px; /* Ajout d'une marge en bas pour séparer la barre de navigation du contenu */
    }

    .nav-item {
    color: #83818c;
    padding: 10px;
    text-decoration: none;
    transition: 0.3s;
    margin: 0 6px;
    font-family: "DM Sans", sans-serif;
    font-weight: 500;
    position: relative;
    }

    .nav-item:before {
    content: "";
    position: absolute;
    bottom: -3px;
    left: 0;
    width: 100%;
    height: 3px;
    border-radius: 4px 4px 0 0;
    opacity: 0;
    transition: 0.3s;
    }

    .nav-item.is-active:before {
    background-color: orange;
    }

    .nav-item.is-active:hover:before {
    opacity: 0;
    }

    .nav-item:not(.is-active):hover:before,
    .nav-item:first-child:hover:before {
    opacity: 1;
    bottom: 0;
    }

    /* Ajoutez un style pour le tableau */
    table {
    width: 100%;
    margin-top: 20px; /* Ajout d'une marge en haut du tableau */
    }

    th,
    td {
    padding: 10px;
    text-align: center;
    }

    th {
    background-color: #f2f2f2;
    }

    /* Ajoutez un style pour le titre du tableau */
    h2 {
    margin-top: 20px; /* Ajout d'une marge en haut du titre */
    }

    </style>
  </head>

    <body>

    <nav class="nav">
      <a href="../index.html" class="nav-item is-active" active-color="orange"
        >Accueil</a
      >
      <a
        href="/Projet/projet_php/Patient/ajoutcontact.php"
        class="nav-item"
        active-color="green"
        >Patient</a
      >
      <a
        href="/Projet/projet_php/Medecin/ajoutmedecin.php"
        class="nav-item"
        active-color="blue"
        >Medecin</a
      >
      <a
        href="/Projet/projet_php/Consultations/index.php"
        class="nav-item"
        active-color="red"
        >Consultations</a
      >
      <a
        href="/Projet/projet_php/Stats/statistiques.php"
        class="nav-item"
        active-color="rebeccapurple"
        >Statistiques</a
      >
      <a href="planning.php" class="nav-item" active-color="pink">Planning</a>
      <span class="nav-indicator"></span>
    </nav>
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
    <a href="/../Projet/projet_php/index.html" class="accueil-link">Accueil</a>
</body>
</html>