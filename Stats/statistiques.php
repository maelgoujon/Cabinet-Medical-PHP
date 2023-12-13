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

        <?php
        include 'config.php';

        // Requête pour récupérer la répartition des usagers selon leur sexe et leur âge
        $sql = "SELECT 
                    CASE WHEN Civilite = '1' THEN 'Homme'
                        WHEN Civilite = '2' THEN 'Femme'
                        ELSE 'Autre' END AS Sexe,
                    SUM(CASE WHEN YEAR(CURDATE()) - YEAR(Date_de_naissance) < 25 THEN 1 ELSE 0 END) AS MoinsDe25,
                    SUM(CASE WHEN YEAR(CURDATE()) - YEAR(Date_de_naissance) BETWEEN 25 AND 50 THEN 1 ELSE 0 END) AS Entre25Et50,
                    SUM(CASE WHEN YEAR(CURDATE()) - YEAR(Date_de_naissance) > 50 THEN 1 ELSE 0 END) AS PlusDe50
                FROM Patient
                GROUP BY Civilite";

        $result = $conn->query($sql);

        // Affichage du tableau à double entrée
        echo "<h2>Repartition des usagers selon leur sexe et leur age</h2>";
        echo "<table border='1'>
            <tr>
                <th>Sexe</th>
                <th>Moins de 25 ans</th>
                <th>Entre 25 et 50 ans</th>
                <th>Plus de 50 ans</th>
            </tr>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                <td>{$row['Sexe']}</td>
                <td>{$row['MoinsDe25']}</td>
                <td>{$row['Entre25Et50']}</td>
                <td>{$row['PlusDe50']}</td>
            </tr>";
        }

        echo "</table>";

        // Fermer la connexion
        $conn->close();
        ?>

        <?php
        include 'config.php';

        // Requête pour récupérer la durée totale des consultations par médecin
        $sql = "SELECT m.idMedecin, 
                    CASE WHEN m.Civilite = '1' THEN 'Monsieur' 
                            WHEN m.Civilite = '2' THEN 'Madame' 
                            ELSE 'Autre' END AS CiviliteMedecin,
                    m.Prenom, m.Nom,
                    SEC_TO_TIME(SUM(c.Duree * 60)) AS DureeTotale
                FROM Medecin m
                LEFT JOIN Consultations c ON m.idMedecin = c.idMedecin
                GROUP BY m.idMedecin, CiviliteMedecin, m.Prenom, m.Nom";

        $result = $conn->query($sql);

        // Affichage du tableau de la durée totale des consultations par médecin
        echo "<h2>Durée totale des consultations par médecin (en nombre d'heures)</h2>";
        echo "<table border='1'>
            <tr>
                <th>Medecin</th>
                <th>Duree Totale (heures)</th>
            </tr>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                <td>{$row['CiviliteMedecin']} {$row['Prenom']} {$row['Nom']}</td>
                <td>{$row['DureeTotale']}</td>
            </tr>";
        }

        echo "</table>";

        // Fermer la connexion
        $conn->close();
        ?>


    </body>
</html>
