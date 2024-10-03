<?php
include 'config.php'; // Inclure la connexion PDO
session_start();

// Vérifier si l'utilisateur est connecté et a le rôle d'administrateur
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php'); // Rediriger vers la page de connexion si non autorisé
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="admin_dashboard.css">
    <title>Tableau de Bord Administrateur</title>
</head>
<body>
<header>
    <a href="admin_dashboard.php" class="logo"><span>K</span>ACEL CONSULTING</a>
    <div class="menuToggle" onclick="toggleMenu();"></div>
    <ul class="navbar">
        <li><a href="#">Utilisateurs</a></li>
        <li><a href="contacts_list.php">Contact</a></li>
        <li><a href="formations_list.php">Formation</a></li>
        <li><a href="inscriptions_list.php">Inscription au Forum</a></li>
        <li><a href="partenaires_list.php">Partenaires et sponsors</a></li>
        <li><a href="logout.php" class="btn btn-logout">Déconnexion</a></li>
    </ul>
</header>
<div class="container">
    <h1>Bienvenue, Administrateur</h1>
    <p>Gérez les utilisateurs, les données, et plus encore.</p>
</div>
<script>
    function toggleMenu() {
        const navbar = document.querySelector('.navbar');
        navbar.classList.toggle('show');
    }
</script>
</body>
</html>
