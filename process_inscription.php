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
    echo json_encode(["success" => false, "message" => "Erreur de connexion : " . $e->getMessage()]);
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérification de la présence des champs requis
    if (isset($_POST['nom_de_l_entreprise']) && isset($_POST['secteur_d_activite']) && isset($_POST['description_de_l_entreprise']) && 
        isset($_POST['poste_occupe']) && isset($_POST['nom']) && isset($_POST['prenom']) && 
        isset($_POST['email']) && isset($_POST['telephone'])) {

        // Récupérer les données du formulaire et les nettoyer
        $nom_de_l_entreprise = strip_tags($_POST['nom_de_l_entreprise']);
        $secteur_d_activite = strip_tags($_POST['secteur_d_activite']);
        $description_de_l_entreprise = strip_tags($_POST['description_de_l_entreprise']);
        $poste_occupe = strip_tags($_POST['poste_occupe']);
        $nom = strip_tags($_POST['nom']);
        $prenom = strip_tags($_POST['prenom']);
        $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
        $telephone = strip_tags($_POST['telephone']);
        $source = isset($_POST['source']) ? strip_tags($_POST['source']) : '';

        // Vérification du format de l'email
        if ($email === false) {
            echo json_encode(["success" => false, "message" => "Adresse email invalide."]);
            exit();
        }

        // Gérer les intérêts et B2B sous forme de tableau
        $thematiques_d_interet = isset($_POST['thematiques_d_interet']) && is_array($_POST['thematiques_d_interet']) ? implode(', ', $_POST['thematiques_d_interet']) : '';
        $b2b = isset($_POST['b2b']) && is_array($_POST['b2b']) ? implode(', ', $_POST['b2b']) : '';
        $autres = isset($_POST['autres']) ? strip_tags($_POST['autres']) : '';

        // Insérer les données dans la table 'inscriptions'
        $sql = "INSERT INTO inscriptions (nom_de_l_entreprise, secteur_d_activite, description_de_l_entreprise, poste_occupe, nom, prenom, email, telephone, source, thematiques_d_interet, b2b, autres) 
                VALUES (:nom_de_l_entreprise, :secteur_d_activite, :description_de_l_entreprise, :poste_occupe, :nom, :prenom, :email, :telephone, :source, :thematiques_d_interet, :b2b, :autres)";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nom_de_l_entreprise', $nom_de_l_entreprise);
        $stmt->bindParam(':secteur_d_activite', $secteur_d_activite);
        $stmt->bindParam(':description_de_l_entreprise', $description_de_l_entreprise);
        $stmt->bindParam(':poste_occupe', $poste_occupe);
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':prenom', $prenom);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':telephone', $telephone);
        $stmt->bindParam(':source', $source);
        $stmt->bindParam(':thematiques_d_interet', $thematiques_d_interet);
        $stmt->bindParam(':b2b', $b2b);
        $stmt->bindParam(':autres', $autres);

        // Exécuter la requête et gérer le résultat
        if ($stmt->execute()) {
            echo json_encode(["success" => true, "message" => "Inscription réussie !"]);
        } else {
            echo json_encode(["success" => false, "message" => "Erreur lors de l'inscription."]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "Certains champs sont manquants."]);
    }
}
?>
