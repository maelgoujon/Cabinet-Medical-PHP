<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="../Images/logo.png" />
    <!-- Ajoutez les liens vers les fichiers CSS Bootstrap ici -->
    <link href="../Base/bootstrap.min.css" rel="stylesheet" />
    
    <!-- Ajoutez les liens vers les fichiers JavaScript Bootstrap et jQuery ici -->
    <script src="../Base/jquery-3.2.1.slim.min.js"></script>
    <script src="../Base/popper.min.js"></script>
    <script src="../Base/bootstrap.bundle.min.js"></script>  
    <style> 
        .navbar {
            background-color: plum; /* Couleur de fond en bleu */
        }

        .custom-header .nav-link {
            color: purple !important; /* Couleur du texte en blanc */
        }
    </style>

</head>
<body>

    <!-- Header -->
    <nav class="navbar navbar-expand-lg navbar-light custom-header">
        <img class="navbar-brand" src="Images/logo.png" href="#" alt="Logo" height="50"></img>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
            <li class="nav-item active">
                <a class="nav-link" href="">Accueil</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="patient/">Patient</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="medecin/">Medecin</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="consultations/">Consultations</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="Stats/statistiques.php">Statistiques</a>
            </li>
            <li class="nav-item">
                <a class="nav-link logout-btn" href="Base/logout.php">Se déconnecter</a>
            </li>
            
            </ul>
        </div>
    </nav>


</body>
</html>
