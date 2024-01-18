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
    <!-- Ajoutez les liens vers les fichiers CSS Bootstrap ici -->
    <link href="../Base/bootstrap.min.css" rel="stylesheet" />
    
    <!-- Ajoutez les liens vers les fichiers JavaScript Bootstrap et jQuery ici -->
    <script src="../Base/jquery-3.2.1.slim.min.js"></script>
    <script src="../Base/popper.min.js"></script>
    <script src="../Base/bootstrap.bundle.min.js"></script> 
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>

    <?php
    include '../Base/config.php';

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

    // Fetch data and store it in a PHP array
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    // Affichage du tableau à double entrée avec Bootstrap
    echo "<div class='container mt-4'>
        <h2>Repartition des usagers selon leur sexe et leur age</h2>
        <table class='table table-bordered'>
            <thead class='thead-dark'>
                <tr>
                    <th>Sexe</th>
                    <th>Moins de 25 ans</th>
                    <th>Entre 25 et 50 ans</th>
                    <th>Plus de 50 ans</th>
                </tr>
            </thead>
            <tbody>";

    foreach ($data as $row) {
        echo "<tr>
            <td>{$row['Sexe']}</td>
            <td>{$row['MoinsDe25']}</td>
            <td>{$row['Entre25Et50']}</td>
            <td>{$row['PlusDe50']}</td>
          </tr>";
    }

    echo "</tbody></table>";

    echo "</div>";

    // Fermer la connexion
    $conn->close();
    ?>


    <?php
    include '../Base/config.php';

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

    // Affichage du tableau de la durée totale des consultations par médecin avec Bootstrap
    echo "<div class='container mt-4'>
        <h2>Durée totale des consultations par médecin (en nombre d'heures)</h2>
        <table class='table table-bordered'>
            <thead class='thead-dark'>
                <tr>
                    <th>Médecin</th>
                    <th>Durée Totale (heures)</th>
                </tr>
            </thead>
            <tbody>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>
            <td>{$row['CiviliteMedecin']} {$row['Prenom']} {$row['Nom']}</td>
            <td>{$row['DureeTotale']}</td>
          </tr>";
    }

    echo "</tbody></table></div>";

    // Fermer la connexion
    $conn->close();
    ?>

</body>

</html>
