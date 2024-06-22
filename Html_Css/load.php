<?php

require 'config.php';

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
    echo $message;
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h1>Uploads</h1>
    <form action="" method="post" name="monfichier" enctype="multipart/form-data">
        <input type="file" name="monfichier" /><br>
        <input type="submit" name="Charger" value="Charger" /><br>
    </form>
</body>

</html>