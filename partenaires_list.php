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

include 'config.php'; // Inclure la connexion PDO
session_start();

// Vérifier si l'utilisateur est connecté et a le rôle d'administrateur
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php'); // Rediriger vers la page de connexion si non autorisé
    exit();
}

// Initialiser la variable $partenaires_sponsors
$partenaires_sponsors = [];

try {
    // Requête SQL pour récupérer toutes les données des partenaires/sponsors
    $sql = "SELECT * FROM partenaires_sponsors";
    $stmt = $pdo->query($sql);
    $partenaires_sponsors = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Erreur lors de la récupération des partenaires_sponsors : " . $e->getMessage();
}
?> 

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Contacts</title>
    <link rel="stylesheet" href="partenaires_list.css">
</head>
<body>
<header>
    <a href="admin_dashboard.php" class="logo"><span>K</span>ACEL CONSULTING</a>
    <div class="menuToggle" onclick="toggleMenu();"></div>
    <ul class="navbar">
        <li><a href="#" onclick="toggleMenu();">Utilisateurs</a></li>
        <li><a href="contacts_list.php" onclick="toggleMenu();">Contact</a></li>
        <li><a href="formations_list.php" onclick="toggleMenu();">Formation</a></li>
        <li><a href="inscriptions_list.php" onclick="toggleMenu();">Inscription au Forum</a></li>
        <li><a href="partenaires_list.php" onclick="toggleMenu();">Partenaires et sponsors</a></li>
        <li><a href="logout.php" class="btn btn-logout">Déconnexion</a></li>
    </ul>
</header>

<main>
    <?php if (count($partenaires_sponsors) > 0): ?>
        <div class="table-container">
        <div class="titre"><h1><span>L</span>iste des Partenaires et Sponsors</h1></div>
            <table class="partenaires-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom de la Societe</th>
                        <th>Nom</th>
                        <th>Telephone</th>
                        <th>Email</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($partenaires_sponsors as $partenaires): ?>
                        <tr>
                            <td><?= htmlspecialchars($partenaires['id']); ?></td>
                            <td><?= htmlspecialchars($partenaires['nom_de_societe']); ?></td>
                            <td><?= htmlspecialchars($partenaires['nom_et_prenom']); ?></td>
                            <td><?= htmlspecialchars($partenaires['telephone']); ?></td>
                            <td><?= htmlspecialchars($partenaires['email']); ?></td>
                            <td>
                                <a href="delete_partenaire.php?id=<?= $partenaires['id']; ?>" class="btn-delete" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce contact ?');">Supprimer</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <p>Aucun Partenaires et Sponsors trouvé.</p>
    <?php endif; ?>
</main>

<script>
    function toggleMenu() {
        const menu = document.querySelector('.navbar');
        menu.classList.toggle('show');
    }
</script>
</body>
</html>
</html>
