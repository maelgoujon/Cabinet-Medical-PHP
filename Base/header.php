<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="../Images/logo.png" />
    <style>
        /* Style pour le header */
        body {
            margin: 0; /* Supprime la marge par défaut du corps du document */
            font-family: Arial, sans-serif; /* Utilisez une police de caractères lisible */
        }

        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
            background-color: #192E5B;
            color: white;
        }

        /* Style pour les liens */
        nav {
            display: flex;
        }

        nav a {
            color: white;
            text-decoration: none;
            margin-left: 15px;
        }

        nav a:first-child {
            margin-left: 0; 
            align-items: center;
        }

       
        nav a.logout-btn {
            background-color: #fff; 
            color: #192E5B;
            padding: 8px 15px; 
            border-radius: 40px; 
            text-decoration: none; 
        }

        /* Médias requêtes pour la convivialité mobile */
        @media only screen and (max-width: 600px) {
            header {
                flex-direction: column;
                align-items: flex-start;
            }

            nav {
                margin-top: 10px;
            }

            nav a {
                margin-left: 0;
                margin-right: 15px;
                margin-bottom: 5px;
            }
        }
    </style>
</head>
<body>

    <!-- Header -->
    <header>
        <img src="../Images/logo.png" alt="Logo" height="50">

        <nav>
            <a href="../Base/index.php">Accueil</a>
            <a href="../Patient/index.php">Patient</a>
            <a href="../Medecin/index.php">Medecin</a>
            <a href="../Consultations/index.php">Consultations</a>
            <a href="../Stats/statistiques.php">Statistiques</a>
            <a href="../Base/logout.php" class="logout-btn">Se déconnecter</a>
        </nav>
    </header>


</body>
</html>
