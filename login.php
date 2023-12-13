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
        header("Location: index.html");
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
    <title>Authentification</title>
</head>
<body>
    <h2>Authentification</h2>
    <?php if (isset($error_message)) { ?>
        <p style="color: red;"><?php echo $error_message; ?></p>
    <?php } ?>
    <form method="post" action="">
        <label>Nom d'utilisateur: <input type="text" name="username"></label><br>
        <label>Mot de passe: <input type="password" name="password"></label><br>
        <input type="submit" value="Se connecter">
    </form>
</body>
</html>
