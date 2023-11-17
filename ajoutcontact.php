<!DOCTYPE HTML>
<html>
<head>
    <title>Ajout d'un contact</title>
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
                $civilite= $_POST['civilite'];
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
            <br>
            <label for="nom">Nom :</label>
            <input type="text" id="nom" name="nom" required>
            <br>
            <label for="prenom">Prenom :</label>
            <input type="text" id="prenom" name="prenom" required>
            <br>
            <label for="adresse">Adresse :</label>
            <input type="text" id="adresse" name="adresse" required>
            <br>
            <label for="date_de_naissance">Date de naissance :</label>
            <input type="text" id="date_de_naissance" name="date_de_naissance" required>
            <br>
            <label for="lieu_de_naissance">Lieu de naissance :</label>
            <input type="text" id="lieu_de_naissance" name="lieu_de_naissance" required>
            <br>
            <label for="numero_securite_sociale">Numero de securite sociale :</label>
            <input type="text" id="numero_securite_sociale" name="numero_securite_sociale" required>
            <br>
            <!-- Champ de selection du medecin referent -->
            <label for="idMedecin">Medecin Referent :</label>
            <select id="idMedecin" name="idMedecin">
                <!-- Remplacez les options ci-dessous par les medecins de votre base de donnees -->
                <option value="1">Medecin 1</option>
                <option value="2">Medecin 2</option>
                <!-- Ajoutez d'autres options si necessaire -->
            </select>
            <br>

            <input type="reset" value="Effacer">
            <input type="submit" value="Ajouter le patient">
            <input type="button" value="Rechercher" onclick="window.location.href='recherche.php'">
        </form>
    </div>
</body>
</html>