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

// Vérifier si l'ID est passé dans l'URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Requête SQL pour supprimer la demande avec l'ID donné
    $sql = "DELETE FROM formations_demandees WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    // Exécuter la requête et vérifier si la suppression a réussi
    if ($stmt->execute()) {
        // Rediriger vers la liste des demandes de formation après suppression
        header('Location: formations_list.php');
        exit();
    } else {
        echo "Erreur lors de la suppression de la demande.";
    }
} else {
    echo "ID de la demande non fourni.";
}
?>
