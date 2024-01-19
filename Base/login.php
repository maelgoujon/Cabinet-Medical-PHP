<?php
// Démarrer la session
session_start();

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Vérifier les informations d'authentification
    if ($username == "admin" && $password == "admin") {
        // Authentification réussie, rediriger vers la page d'accueil
        // Authentification réussie
        $_SESSION["authenticated"] = true;
        header("Location: ../index.php");
        exit();
    } else {
        // Authentification échouée, afficher un message d'erreur
        $error_message = "Nom d'utilisateur ou mot de passe incorrect.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../Base/bootstrap.min.css" rel="stylesheet"/>
    <link href="../Base/accueil.css" rel="stylesheet"/>
    <link href="../Base/style.css" rel="stylesheet"/>
    <script src="../Base/jquery-3.2.1.slim.min.js"></script>
    <script src="../Base/popper.min.js"></script>
    <script src="../Base/bootstrap.bundle.min.js"></script>
    <link rel="icon" type="image/png" href="../Images/logo.png" />
    <title>Authentification</title>
</head>
<body> <!-- Ajout de la classe container -->
    <div class="container">
        <div class="text-center"> <!-- Centrer le contenu -->
            <h2 class="mt-5">Authentification</h2>
            <?php if (isset($error_message)) { ?>
                <div class="alert alert-danger"><?php echo $error_message; ?></div>
            <?php } ?>
            <form method="post" action="">
                <div class="form-outline mb-4">
                    <label class="form-label" for="username">Nom d'utilisateur :</label>
                    <input type="text" name="username" class="form-control" />
                </div>

                <!-- Password input -->
                <div class="form-outline mb-4">
                    <label class="form-label" for="password">Mot de passe :</label>
                    <input type="password" name="password" class="form-control" />
                </div>
                <br>
                <input type="submit" value="Se connecter" class="btn btn-primary">
            </form>
        </div>
    </div>

</body>
</html>

