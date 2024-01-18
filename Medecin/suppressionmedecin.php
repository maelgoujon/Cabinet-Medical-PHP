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

?>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Statistiques</title>
    
  </head>

    <body>

    
    <?php
    // Connexion au serveur MySQL
    include'../Base/config.php';

    try {
        $linkpdo = new PDO("mysql:host=$server;dbname=$db", $login, $mdp);
        // Définition du mode d'erreur PDO à exception
        $linkpdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
        // Récupération de l'identifiant du contact à supprimer depuis l'URL
        $idMedecin = $_GET['id'];
    
        // Requête SQL pour supprimer le contact
        $sql = "DELETE FROM medecin WHERE idMedecin = ?";
        
        // Préparation de la requête
        $stmt = $linkpdo->prepare($sql);
    
        // Exécution de la requête avec l'identifiant du contact
        $stmt->execute([$idMedecin]);
    
        // Fermeture de la connexion à la base de données
        $linkpdo = null;
    
        // Redirection vers la page recherche.php après la suppression
        header("Location: index.php");
    } catch (PDOException $e) {
        die('Erreur : ' . $e->getMessage());
    }
    ?>
</body>
</html>
