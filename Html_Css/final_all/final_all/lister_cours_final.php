<?php
require "configi.php";

try {
    // Correction de la syntaxe des quotes pour les noms de table
    $sql = 'SELECT * FROM "FichierPDF"';
    $stmt = $pdo->query($sql);
    // Initialisation d'un tableau pour stocker les résultats
    $files = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="/img/fete-du-chapeau.png">
    <title>LISTER COURS</title>
    <script src="https://kit.fontawesome.com/1b87f3f8c9.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style_lister_formations.css">
    <style>
        .courses-container {
            display: flex;
            flex-wrap: wrap;
            gap: 100px;
            justify-content: center;
        }

        .course-item {
            border: 1px solid #ccc;
            padding: 20px;
            width: 200px;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s;
        }

        .course-item:hover {
            transform: scale(1.05);
        }

        .course-item img {
            max-width: 100%;
            height: auto;
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
                <li><a class="active" href="#">Courses</a></li>
                <li><a href="contact.html">Contact</a></li>
            </ul>
        </div>
    </nav>
<br><br><br><br>
    <!-- Lister les cours -->
    <section id="courses">
        <h1><center>Liste de vos Cours</center></h1><br>
        <div class="courses-container">
            <?php if (!empty($files)) : ?>
                <?php foreach ($files as $file) : ?>
                    <div class="course-item">
                        <img src="images/lettre_du_logo.jpg" alt="Course Image">
                        <h2><?php echo htmlspecialchars(str_replace('.pdf', '', $file['Nom'])); ?></h2>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <p>Aucun fichier trouvé.</p>
            <?php endif; ?>
        </div>
        <br>
        <h3><a href="acceuil.html" style="text-decoration: none; color:green; padding:60px">Retour</a></h3>
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
            <div class="subscribe">
                <input type="text" placeholder="Your email address">
                <a href="#" class="yellow">SUBSCRIBE</a>
            </div>
        </div>
        <div class="copyright">
            <p>Copyright 2024 All Rights Reserved | This is made by a group</p>
            <div class="pro-links">
                <i class="fab fa-facebook-f"></i>
                <i class="fab fa-instagram"></i>
                <i class="fab fa-linkedin-in"></i>
            </div>
        </div>
    </footer>
</body>

</html>
