<?php
// Configuration de la base de données
$host = 'localhost';  // Adresse du serveur MySQL
$db = 'kacel_consulting';  // Nom de la base de données
$user = 'root';  // Nom d'utilisateur MySQL
$pass = '';  // Mot de passe (par défaut vide pour WampServer)

try {
    // Connexion à la base de données avec PDO
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    // Activer les erreurs PDO
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}
?>
