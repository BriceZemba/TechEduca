<?php
require 'config.php';

$message = ''; // Initialisation du message

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm-password']; // Nouveau champ pour le mot de passe confirmé
    if (move_uploaded_file($_FILES['monfichier']['tmp_name'], $target_path)) {
        chmod($target_path, 0644);
        $message .= "<li>Fichier chargé avec succès</li>";

        // Insérer les informations dans la base de données
        $nom_fichier = $_FILES['monfichier']['name'];
        $type_fichier = $_FILES['monfichier']['type'];
        $taille_fichier = $_FILES['monfichier']['size'];

        $sql = 'INSERT INTO "FichierPDF" VALUES (:Nom, :taille, :typefi)';
        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(':Nom', $nom_fichier, PDO::PARAM_STR);
        $stmt->bindParam(':taille', $taille_fichier, PDO::PARAM_INT);
        $stmt->bindParam(':typefi', $type_fichier, PDO::PARAM_STR);

        $stmt->execute();
    }
    // Vérification si les mots de passe sont identiques
    if ($password === $confirmPassword && strlen($password) >= 8) {
        // Utilisez des requêtes préparées pour éviter les injections SQL
        $sql = 'INSERT INTO users (name, password) VALUES (:name, :password)';
        $stmt = $pdo->prepare($sql);

        // Lier les paramètres
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':password', $password);

        // Exécuter la requête
        $stmt->execute();

        // Redirection vers la page de connexion après l'enregistrement réussi
        header("Location: pageconn.php");
        exit;
    } else {
        // Afficher un message d'erreur si les mots de passe ne correspondent pas
        $message = "Les mots de passe ne correspondent pas ou de taille au moins égale à huit.";
    }
}
?>


<!DOCTYPE html>
<html lang='en'>

<head>
    <title>Register</title>
    <style>
        .hidden {
            opacity: 0;
            transform: scale(0.8);
            /* Réduction de la taille */
            transition: opacity 0.5s ease-in-out, transform 0.5s ease-in;
            /* Transition pour l'opacité et la taille */
        }

        #welcome-message {
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            background-color: #C9C5C5;
            color: #4481eb;
            padding: 10px 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0px 0px 10px rgba(12, 0, 0, 0.1);
            z-index: 10;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var welcomeMessage = document.getElementById('welcome-message');
            welcomeMessage.classList.remove('hidden');

            setTimeout(function() {
                welcomeMessage.classList.add('hidden');
            }, 2000); // Durée en millisecondes (5000 ms = 5 secondes)
        });
    </script>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="./img/la-cyber-securite.png" type="image/svg+xml">
    <title>Page de connexion</title>
    <link rel="stylesheet" type="text/css" href="./style/conn.css" />
    <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>
</head>

<body>
    <div id="welcome-message" class="hidden">
        <p>Bienvenue dans la page d'inscription!</p>
    </div>
    <div class="container">
        <div class="forms-container">
            <div class="signin-signup">
                <form method="post" action="register.php" class="sign-in-form">
                    <h2 class="title">S'enregistrer</h2>
                    <div class="input-field">
                        <i class="fas fa-user"></i>
                        <input type="text" placeholder="Nom d'utilisateur" name="name" required />
                    </div>
                    <div class="input-field">
                        <i class="fas fa-lock"></i>
                        <input type="password" id="password" placeholder="Mot de passe" name="password" required />
                    </div>
                    <div class="input-field">
                        <i class="fas fa-lock"></i>
                        <input type="password" id="confirm-password" placeholder="Confirmer le mot de passe" name="confirm-password" required />
                    </div>
                    <div id="password-match-message"><?php echo "<h3 style='color: red'>" . $message . "</h3>"; ?></div> <!-- Affichage du message d'erreur -->
                    <input type="submit" value="S'enregistrer" class="btn solid" />
                </form>
            </div>
        </div>
        <div class="panels-container">
            <div class="panel left-panel">
                <div class="content">
                    <h3>Vous avez déjà un compte</h3> <br>
                    <button class="btn transparent"><a href="pageconn.php" style="text-decoration: none ; color:white">Connectez-vous</a></button>
                </div>
                <img src="./img/register.svg" class="image" alt="">
            </div>
            <script src="./conn.js"></script>
        </div>
    </div>
</body>

</html>