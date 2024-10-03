<?php
// Connexion à la base de données
$host = 'localhost';
$dbname = 'kacel_consulting'; 
$username = 'root'; 
$password = ''; 

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die(json_encode(["success" => false, "message" => "Erreur de connexion : " . $e->getMessage()]));
}

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $nom = $_POST['nom'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    // Requête SQL pour insérer les données dans la table contacts
    $sql = "INSERT INTO contacts (nom, email, message) VALUES (:nom, :email, :message)";

    // Préparer et exécuter la requête
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':nom', $nom);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':message', $message);

    // Exécuter la requête
    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Votre message a été envoyé avec succès !"]);
    } else {
        echo json_encode(["success" => false, "message" => "Erreur lors de l'envoi de votre message."]);
    }
}
?>
