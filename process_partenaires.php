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
    echo json_encode(['success' => false, 'message' => 'Erreur de connexion : ' . $e->getMessage()]);
    exit();
}

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['nom_de_societe']) && isset($_POST['nom_et_prenom']) && isset($_POST['telephone']) && isset($_POST['email'])) {
        // Récupérer les données du formulaire
        $nom_de_societe = $_POST['nom_de_societe'];
        $nom_et_prenom = $_POST['nom_et_prenom'];
        $telephone = $_POST['telephone'];
        $email = $_POST['email'];

        // Insérer les données dans la table 'partenaires_sponsors'
        $sql = "INSERT INTO partenaires_sponsors (nom_de_societe, nom_et_prenom, telephone, email) 
                VALUES (:nom_de_societe, :nom_et_prenom, :telephone, :email)";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nom_de_societe', $nom_de_societe);
        $stmt->bindParam(':nom_et_prenom', $nom_et_prenom);
        $stmt->bindParam(':telephone', $telephone);
        $stmt->bindParam(':email', $email);

        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Votre demande a été envoyée avec succès !']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Erreur lors de l\'envoi de votre demande.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Certains champs sont manquants.']);
    }
}
?>
