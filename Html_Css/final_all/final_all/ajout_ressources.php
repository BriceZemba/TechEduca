<?php
require 'configi.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST["Charger"])) {
    // Chemin de destination du fichier
    $uploadDir = "C:\\Users\\brice\\OneDrive\\Bureau\\WorkSpace\\Frontend\\";
    $targetFile = $uploadDir . basename($_FILES['monfichier']['name']);

    // Vérification du type de fichier
    $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Vérifier si le fichier est un PDF
    if ($fileType != "pdf") {
        $message .= "<li>Seuls les fichiers PDF sont autorisés.</li>";
    } else {
        // Déplacer le fichier téléchargé
        if (move_uploaded_file($_FILES['monfichier']['tmp_name'], $targetFile)) {
            chmod($targetFile, 0644);
            $message .= "<li>Fichier chargé avec succès</li>";

            // Insérer les informations dans la base de données
            $fileName = $_FILES['monfichier']['name'];
            $fileType = $_FILES['monfichier']['type'];
            $fileSize = $_FILES['monfichier']['size'];

            $sql = 'INSERT INTO "FichierPDF"  VALUES (:Nom, :taille, :typefi)';
            $stmt = $pdo->prepare($sql);

            $stmt->bindParam(':Nom', $fileName, PDO::PARAM_STR);
            $stmt->bindParam(':taille', $fileSize, PDO::PARAM_INT);
            $stmt->bindParam(':typefi', $fileType, PDO::PARAM_STR);

            if ($stmt->execute()) {
                $message .= "<li>Informations du fichier enregistrées dans la base de données.</li>";
            } else {
                $message .= "<li>Échec de l'enregistrement dans la base de données.</li>";
            }
        } else {
            $message .= "<li>Échec du chargement du fichier.</li>";
        }
    }
    echo "<ul class='message'>{$message}</ul>";
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" href="/img/fete-du-chapeau.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PLANIFIER DES SEANCES</title>
    <script src="https://kit.fontawesome.com/1b87f3f8c9.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style_planifier_cours.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200">
    <script src="planifier_cours_calendrier.js" defer></script>

    <style>
        /* Styles de la navigation */
        nav {
            background-color: #f8f9fa;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        nav img {
            width: 100px;
            height: auto;
            margin-right: 20px;
        }

        .navigation ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .navigation ul li {
            display: inline-block;
            margin-right: 20px;
        }

        .navigation ul li a {
            text-decoration: none;
            color: #333;
            font-weight: bold;
            transition: color 0.3s;
        }

        .navigation ul li a:hover {
            color: #007bff;
        }

        /* Styles du formulaire et du conteneur */
        .container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        input[type="file"] {
            margin: 10px auto;
            display: block;
        }

        input[type="submit"] {
            padding: 10px 20px;
            color: #fff;
            background-color: #007bff;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s;
            display: block;
            margin: 0 auto;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        .message {
            margin-top: 20px;
            text-align: center;
        }

        .suscribe input[type="text"] {
            padding: 10px;
            width: 70%;
            margin-right: 10px;
            border: none;
        }

        .suscribe a.yellow {
            background-color: #ff0;
            padding: 10px 20px;
            color: #333;
            text-decoration: none;
            font-weight: bold;
        }
        .return-button {
            display: block;
            margin: 10px auto;
            padding: 8px 2px;
            color: #fff;
            background-color: #28a745;
            text-align: center;
            text-decoration: none;
            border-radius: 4px;
            width: 100px;
            transition: background-color 0.3s;
        }

        .return-button:hover {
            background-color: #218838;
        }
    </style>

</head>

<body>
    <!-- Navigation -->
    <nav>
        <img src="images/logo_fichier_jpeg_copie.jpeg" alt="Logo">
        <div class="navigation">
            <ul>
                <li><a href="acceuil.html">Home</a></li>
                <li><a href="about.html">About</a></li>
                <li><a href="blog.html">Blog</a></li>
                <li><a href="lister_cours_final.html">Courses</a></li>
                <li><a href="contact.html">Contact</a></li>
            </ul>
        </div>
    </nav>

    <!-- Titre -->
    <h1>Ajouter une nouvelle ressource</h1>

    <!-- Conteneur principal -->
    <div class="container">
        <form action="ajout_ressources.php" method="post" enctype="multipart/form-data">
            <input type="file" name="monfichier">
            <input type="submit" name="Charger" value="Charger"><br>
        </form>
        <a href="acceuil.html" class="return-button">Retour</a>
        <div class="message">
            <?php if (!empty($message)) echo $message; ?>
        </div>
    </div>
</body>

</html>
