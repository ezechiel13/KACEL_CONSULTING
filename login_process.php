<?php
session_start();
include 'config.php'; // Inclure le fichier de connexion PDO

// Récupérer les données du formulaire
$email = $_POST['email'];
$mot_de_passe = $_POST['mot_de_passe'];

// Préparer la requête pour vérifier l'utilisateur
$sql = "SELECT * FROM utilisateurs WHERE email = :email";
$stmt = $pdo->prepare($sql);
$stmt->execute(['email' => $email]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user && password_verify($mot_de_passe, $user['mot_de_passe'])) {
    // Mot de passe correct
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['role'] = $user['role'];

    // Rediriger en fonction du rôle
    if ($user['role'] === 'admin') {
        echo json_encode(['redirect' => 'admin_dashboard.php']); // Rediriger vers le tableau de bord admin
    } else {
        echo json_encode(['redirect' => 'user_dashboard.php']); // Rediriger vers l'espace utilisateur
    }
} else {
    // Mot de passe incorrect ou utilisateur non trouvé
    echo json_encode(['message' => 'Utilisateur ou mot de passe incorrect.']);
}
?>
