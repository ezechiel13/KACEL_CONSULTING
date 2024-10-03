<?php
include 'config.php'; // Inclure le fichier de connexion PDO

// Vérifiez si un administrateur existe déjà
$sql = "SELECT * FROM utilisateurs WHERE role = :role";
$stmt = $pdo->prepare($sql);
$stmt->execute(['role' => 'admin']);
$result = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$result) {
    // Si aucun administrateur n'existe, en créer un
    $nom = 'admin'; // Nom d'utilisateur
    $email = 'admin@example.com'; // Email
    $mot_de_passe = password_hash('Admin2024', PASSWORD_DEFAULT); // Hachage du mot de passe
    $role = 'admin';

    $sql = "INSERT INTO utilisateurs (nom, email, mot_de_passe, role) VALUES (:nom, :email, :mot_de_passe, :role)";
    $stmt = $pdo->prepare($sql);
    $params = [
        'nom' => $nom,
        'email' => $email,
        'mot_de_passe' => $mot_de_passe,
        'role' => $role
    ];

    if ($stmt->execute($params)) {
        echo "Administrateur créé avec succès.";
    } else {
        echo "Erreur lors de la création de l'administrateur.";
    }
} else {
    echo "Un administrateur existe déjà.";
}
?>
