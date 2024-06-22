<?php
$host = 'localhost';
$db = 'Users';
$user = 'postgres';
$pass = '0000';

try {
    $pdo = new PDO("pgsql:host=localhost; port = 5432 ;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //echo "Connexion Etablie";
} catch (PDOException $e) {
    die("Could not connect to the database $db :" . $e->getMessage());
}
?>
