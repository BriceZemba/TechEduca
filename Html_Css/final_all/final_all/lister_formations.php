<?php

require "configi.php";

try {
    // Correction de la syntaxe des quotes pour les noms de table
    $sql = 'SELECT * FROM "formation"';
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
    <title>CONSULTER LES FORMATIONS</title>
    <script src="https://kit.fontawesome.com/1b87f3f8c9.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style_lister_formations.css">
</head>

<body>
    <!-- Navigation -->
    <nav>
        <img src="images/logo_fichier_jpeg_copie.jpeg" alt="Logo">
        <div class="navigation">
            <ul>
                <li><a href="acceuil.html">Home</a></li>
                <li><a href="about.html">About</a></li>
                <li><a href="lister_cours_final.html">Courses</a></li>
                <li><a href="contact.html">Contact</a></li>
            </ul>
        </div>
    </nav>

    <!-- Lister formations-->
    <section id="formations">
        <h1>Vos futures formations</h1>

                <?php if (!empty($files)) : ?>
                    <?php foreach ($files as $file) : ?>
        <ul class="formation-list">
            <li class="formation-item">
                        <h2><?php echo htmlspecialchars($file['Nomfor']) ?></h2>
                        <p><?php echo htmlspecialchars($file['datefor']) ?></p>
                        <p><?php echo htmlspecialchars($file['heures']) ?> heures</p>
                        
            </li>
        </ul><br>
                    <?php endforeach; ?>
                <?php else : ?>
                    <p>Aucun fichier trouvé.</p>
                <?php endif; ?>
                <h3><a href="acceuil.html" style="text-decoration: none; color:green ;">Retour</a></h3>
                <div class="dropdown">
                    <i class="fa-solid fa-ellipsis"></i>
                    <div class="dropdown-content">
                        <a href="#">Supprimer</a>
                    </div>
                </div>
            </li>
            <!-- Ajoutez d'autres formations ici -->
        </ul>
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
            <h3>Resouces</h3>
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