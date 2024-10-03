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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $nom_complet = $_POST['nom_complet'];
    $email = $_POST['email'];
    $telephone = $_POST['telephone'];
    $type_formation = $_POST['type_formation'];
    $message = $_POST['message'];

    // Insérer les données dans la table 'formations_demandees'
    $sql = "INSERT INTO formations_demandees (nom_complet, email, telephone, type_formation, message) 
            VALUES (:nom_complet, :email, :telephone, :type_formation, :message)";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':nom_complet', $nom_complet);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':telephone', $telephone);
    $stmt->bindParam(':type_formation', $type_formation);
    $stmt->bindParam(':message', $message);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Demande de formation envoyée avec succès !"]);
    } else {
        echo json_encode(["success" => false, "message" => "Erreur lors de l'envoi."]);
    }
}
?>
