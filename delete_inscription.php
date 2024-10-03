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
    die("Erreur de connexion : " . $e->getMessage());
}

// Vérifier si un ID est passé dans l'URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Requête SQL pour supprimer l'inscription avec l'ID donné
    $sql = "DELETE FROM inscriptions WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    // Exécuter la requête et vérifier si la suppression a réussi
    if ($stmt->execute()) {
        header('Location: inscriptions_list.php');
        exit();
    } else {
        echo "Erreur lors de la suppression de l'inscription.";
    }
} else {
    echo "ID de l'inscription non fourni.";
}
?>
