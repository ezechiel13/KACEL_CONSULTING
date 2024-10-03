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

    // Requête SQL pour supprimer le contact avec l'ID donné
    $sql = "DELETE FROM contacts WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    // Exécuter la requête et vérifier si la suppression a réussi
    if ($stmt->execute()) {
        // Rediriger vers la liste des contacts après suppression
        header('Location: contacts_list.php');
        exit();
    } else {
        echo "Erreur lors de la suppression du contact.";
    }
} else {
    echo "ID du contact non fourni.";
}
?>
