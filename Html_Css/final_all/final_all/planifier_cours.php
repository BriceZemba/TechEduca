<?php
require "configi.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["Charger"])) {
        $message = "Nom du fichier : <b>" . $_FILES['monfichier']['name'] . "</b></br>";
        $message .= "Type du fichier : <b>" . $_FILES['monfichier']['type'] . "</b></br>";
        $message .= "Taille du fichier : <b>" . $_FILES['monfichier']['size'] . " octets</b></br>";

        $target_path = "C:\\Users\\brice\\OneDrive\\Bureau\\WorkSpace\\Frontend\\" . basename($_FILES['monfichier']['name']);

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
        } else {
            $message .= "<li>Échec du chargement du fichier</li>";
        }

        // Récupérer la date sélectionnée
        $selectedDate = strval($_POST['selectedDate']);
        $nomfor = $_POST["nom"];
        $heures = $_POST["heures"];

        // Insérer les informations dans la base de données Formation
        try {
            $sql = 'INSERT INTO "formation"  VALUES (:Nomfor, :selectedDate, :heures)';
            $stmt = $pdo->prepare($sql);

            $stmt->bindParam(':Nomfor', $nomfor, PDO::PARAM_STR);
            $stmt->bindParam(':heures', $heures, PDO::PARAM_INT);
            $stmt->bindParam(':selectedDate', $selectedDate, PDO::PARAM_STR); // Utilisez PDO::PARAM_STR pour une date SQL

            $stmt->execute();
        } catch (PDOException $e) {
            echo 'Error' . $e->getMessage();
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <link rel="shortcut icon" href="/img/fete-du-chapeau.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>PLANIFIER DES SEANCES</title>
    <script src="https://kit.fontawesome.com/1b87f3f8c9.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style_planifier_cours.css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200">
    <script src="planifier_cours_calendrier.js" defer></script>
    <style>
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
            margin: 10px auto;
            text-align: center;
            text-decoration: none;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
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
        <img src="images/logo_fichier_jpeg_copie.jpeg" alt="Logo" />
        <div class="navigation">
            <ul>
                <li><a href="acceuil.html">Home</a></li>
                <li><a href="about.html">About</a></li>
                <li><a href="lister_cours_final.html">Courses</a></li>
                <li><a href="contact.html">Contact</a></li>
            </ul>
        </div>
    </nav>

    <!-- Planificateur de formation -->
    <section id="features">
        <h1>Planifiez votre prochaine séance</h1>
        <p>Sélectionnez la date et les ressources à utiliser</p>
        <form action="planifier_cours.php" method="post" name="monfichier" enctype="multipart/form-data">

            <div class="fea-base">
                <div class="fea-box">
                    <input type="text" placeholder="Nom de la formation" name="nom" required />
                    <h3>Choisissez une date</h3>
                    <div id="calendar_container">
                        <div class="wrapper">
                            <header>
                                <p class="current-date"></p>
                                <div class="icons">
                                    <span id="prev" class="material-symbols-rounded">chevron_left</span>
                                    <span id="next" class="material-symbols-rounded">chevron_right</span>
                                </div>
                            </header>
                            <div class="calendar">
                                <ul class="weeks">
                                    <li>Sun</li>
                                    <li>Mon</li>
                                    <li>Tue</li>
                                    <li>Wed</li>
                                    <li>Thu</li>
                                    <li>Fri</li>
                                    <li>Sat</li>
                                    <input type="hidden" id="selectedDateInput" name="selectedDate">
                                </ul>
                                <ul class="days"></ul>

                            </div>

                        </div>
                        <input type="text" placeholder="Nombre d'heures" name="heures" required />
                    </div>
                </div>

                <div class="fea-box">
                    <h3>Sélectionner les ressources</h3>
                    <input type="file" name="monfichier" /><br>
                    <i class="fa-solid fa-plus"></i>
                </div>
            </div>
            <input type="submit" name="Charger" value="Ajouter" /><br>
        </form>
        <a href="acceuil.html" class="return-button">Retour</a>
    </section>

    <!-- Footer -->
    <footer>
        <div class="footer-col">
            <h3>Top products</h3>
            <li>Manage Reputation</li>
            <li>Power Tools</li>
            <li>Manage website</li>
            <li>Marketing Service</li>
        </div>
        <div class="footer-col">
            <h3>Quick links</h3>
            <li>Jobs</li>
            <li>Brand Assets</li>
            <li>Investor Relations</li>
            <li>Terms of Services</li>
        </div>
        <div class="footer-col">
            <h3>Features</h3>
            <li>Manage Reputation</li>
            <li>Power Tools</li>
            <li>Manage Website</li>
            <li>Marketing Services</li>
        </div>
        <div class="footer-col">
            <h3>Resources</h3>
            <li>Guides</li>
            <li>Research</li>
            <li>Experts</li>
            <li>Marketing Services</li>
        </div>
        <div class="footer-col">
            <h3>Newsletter</h3>
            <p>You can trust us. We won't send you mails.</p>
            <div class="suscribe">
                <input type="text" placeholder="Your email address">
                <a href="#" class="yellow">SUSCRIBE</a>
            </div>
        </div>
    </footer>
</body>

</html>
