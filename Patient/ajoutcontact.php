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
    <h1>Ajout d'un patient</h1>
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
            echo '<a href="ajoutcontact.php">Accueil</a>';
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
        <form method="post" action="ajoutcontact.php">

            <label for="civilite">Civilite :</label>
            <select id="idPatient" name="civilite">
                <!-- Remplacez les options ci-dessous par les medecins de votre base de donnees -->
                <option value="1">Monsieur</option>
                <option value="2">Madame</option>
                <!-- Ajoutez d'autres options si necessaire -->
            </select>
            <br><br>
            <label for="nom">Nom :</label>
            <input type="text" id="nom" name="nom" required>
            <br>
            <label for="prenom">Prenom :</label>
            <input type="text" id="prenom" name="prenom" required>
            <br>
            <label for="adresse">Adresse :</label>
            <input type="text" id="adresse" name="adresse" required>
            <br>
            <!-- champ au format date de naissance -->
            <label for="date_de_naissance">Date de naissance :</label>
            <input type="date" id="date_de_naissance" name="date_de_naissance" required>
            <br><br>
            <label for="lieu_de_naissance">Lieu de naissance :</label>
            <input type="text" id="lieu_de_naissance" name="lieu_de_naissance" required>
            <br>
            <label for="numero_securite_sociale">Numero de securite sociale :</label>
            <input type="text" id="numero_securite_sociale" name="numero_securite_sociale" required>
            <br><br>

            <!-- Champ de selection du medecin referent -->
            <label for="idMedecin">Medecin Referent :</label>
            <select id="idMedecin" name="idMedecin">
                <?php
                // Affichage des options
                while ($row = $stmtMedecin->fetch(PDO::FETCH_ASSOC)) {
                    echo '<option value="' . $row['idMedecin'] . '">'. $row['Civilite'] . $row['Nom'] . '</option>';
                }
                ?>
            </select>
            <br><br>

            <input type="reset" value="Effacer">
            <input type="submit" value="Ajouter le patient">
            <input type="button" value="Rechercher" onclick="window.location.href='recherche.php'">
        </form>
    </div>
</body>
</html>