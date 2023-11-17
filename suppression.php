<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Confirmation de suppression</title>
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
        }
    </style>
    <script>
        function confirmDelete() {
            if (confirm("Êtes-vous sûr de vouloir supprimer ce contact ?")) {
                // Si l'utilisateur confirme la suppression, rediriger vers suppressioncontact.php
                window.location.href = 'suppressioncontact.php?id=<?php echo $_GET['id']; ?>';
            } else {
                // Si l'utilisateur annule la suppression, retourner à la page recherche.php
                window.location.href = 'recherche.php';
            }
        }
    </script>
</head>
<body>
    <h1>Confirmation de suppression</h1>
    <p>Voulez-vous vraiment supprimer ce contact ?</p>
    <button onclick="confirmDelete()">Confirmer la suppression</button>
</body>
</html>
