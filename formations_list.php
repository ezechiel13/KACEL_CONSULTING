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

// Initialiser la variable $formations_demandees
$formations_demandees = [];

try {
    // Requête SQL pour récupérer toutes les demandes de formation
    $sql = "SELECT * FROM formations_demandees";
    $stmt = $pdo->query($sql);
    $formations_demandees = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Erreur lors de la récupération des formations : " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Demandes de Formation</title>
    <link rel="stylesheet" href="formation_list.css">
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
        <li><a href="partenaires_list.php" onclick="toggleMenu();">Partenaires et Sponsors</a></li>
        <li><a href="logout.php" class="btn btn-logout">Déconnexion</a></li>
    </ul>
</header>

<main>
    <?php if (count($formations_demandees) > 0): ?>
        <div class="table-container">
        <div class="titre"><h1><span>L</span>iste des Demandes de Formation</h1></div>
            <table class="formation-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Email</th>
                        <th>Telephone</th>
                        <th>Formation Demandée</th>
                        <th>Message</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($formations_demandees as $formations): ?>
                        <tr>
                        <td><?= htmlspecialchars($formations['id']); ?></td>
                        <td><?= htmlspecialchars($formations['nom_complet']); ?></td>
                        <td><?= htmlspecialchars($formations['email']); ?></td>
                        <td><?= htmlspecialchars($formations['telephone']); ?></td>
                        <td><?= htmlspecialchars(string: $formations['type_formation']); ?></td>
                        <td><?= htmlspecialchars(string: $formations['message']); ?></td>
                            <td>
                                <a href="delete_formation.php?id=<?= $formations['id']; ?>" class="btn-delete" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette demande de formation ?');">Supprimer</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <p>Aucune demande de formation trouvée.</p>
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
