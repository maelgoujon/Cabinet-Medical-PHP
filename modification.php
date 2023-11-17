<?php
// Connexion au serveur MySQL
$server = 'localhost';
$db = 'php_project';
$login = "etu";
$mdp = "\$iutinfo";

try {
    $linkpdo = new PDO("mysql:host=$server;dbname=$db", $login, $mdp);
    // Définition du mode d'erreur PDO à exception
    $linkpdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Récupération de l'identifiant du contact depuis l'URL
    $id = $_GET['id'];

    // Requête SQL pour récupérer les données du contact
    $sql = "SELECT * FROM patient WHERE idPatient = ?";
    
    // Préparation de la requête
    $stmt = $linkpdo->prepare($sql);

    // Exécution de la requête avec l'identifiant du contact
    $stmt->execute([$id]);

    // Récupération des données du contact
    $patient = $stmt->fetch(PDO::FETCH_ASSOC);

    // Requête SQL pour récupérer les médecins référents
    $sqlMedecin = "SELECT idMedecin, Civilite, Nom, Prenom FROM medecin";
    $stmtMedecin = $linkpdo->query($sqlMedecin);

    // Fermeture de la connexion à la base de données
    $linkpdo = null;
} catch (PDOException $e) {
    die('Erreur : ' . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
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
<body>
    <h1>Modification de contact</h1>
    <form method="post" action="modifiercontact.php">
        <input type="hidden" name="idPatient" value="valeur_idPatient">
        <label for="civilite">Civilite :</label>
        <select id="idPatient" name="civilite">
            <option value="1" <?php echo ($patient['Civilite'] == '1') ? 'selected' : ''; ?>>Monsieur</option>
            <option value="2" <?php echo ($patient['Civilite'] == '2') ? 'selected' : ''; ?>>Madame</option>
        </select>
        <br><br>
        <label for="nom">Nom :</label>
        <input type="text" id="nom" name="nom" value="<?php echo $patient['Nom']; ?>" required>
        <br>
        <label for="prenom">Prenom :</label>
        <input type="text" id="prenom" name="prenom" value="<?php echo $patient['Prenom']; ?>" required>
        <br>
        <label for="adresse">Adresse :</label>
        <input type="text" id="adresse" name="adresse" value="<?php echo $patient['Adresse']; ?>" required>
        <br>
        <label for="date_de_naissance">Date de naissance :</label>
        <input type="date" id="date_de_naissance" name="date_de_naissance" value="<?php echo $patient['Date_de_naissance']; ?>" required>
        <br><br>
        <label for="lieu_de_naissance">Lieu de naissance :</label>
        <input type="text" id="lieu_de_naissance" name="lieu_de_naissance" value="<?php echo $patient['Lieu_de_naissance']; ?>" required>
        <br>
        <label for="numero_securite_sociale">Numero de securite sociale :</label>
        <input type="number" id="numero_securite_sociale" name="numero_securite_sociale" value="<?php echo $patient['Numero_Securite_Sociale']; ?>" required>
        <br><br>

        <label for="idMedecin">Medecin Referent :</label>
        <select id="idMedecin" name="idMedecin">
            <?php
            // Affichage des options
            while ($row = $stmtMedecin->fetch(PDO::FETCH_ASSOC)) {
                echo '<option value="' . $row['idMedecin'] . '" ' . ($patient['idMedecin'] == $row['idMedecin'] ? 'selected' : '') . '>'
                    . $row['Civilite'] . ' ' . $row['Nom'] . ' ' . $row['Prenom'] . '</option>';
            }
            ?>
        </select>
        <br><br>

        <input type="reset" value="Effacer">
        <input type="submit" value="Modifier le patient">
        <input type="button" value="Rechercher" onclick="window.location.href='recherche.php'">
    </form>
</body>
</html>
