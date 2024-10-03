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
    header('Location: login.php');
    exit();
}

$inscriptions = [];

try {
    // Requête SQL pour récupérer toutes les inscriptions
    $sql = "SELECT * FROM inscriptions";
    $stmt = $pdo->query($sql);
    $inscriptions = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Erreur lors de la récupération des inscriptions : " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Inscriptions</title>
    <link rel="stylesheet" href="inscription_list.css">
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

<main>

    <?php if (count($inscriptions) > 0): ?>
        <div class="table-container">
        <div class="titre"><h1><span>L</span>iste des Inscriptions</h1></div>
        <table class="inscriptions-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom de l'Entreprise</th>
                    <th>Secteur</th>
                    <th>Description</th>
                    <th>Position</th>
                    <th>Prénom</th>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Téléphone</th>
                    <th>Source</th>
                    <th>Intérêts</th>
                    <th>B2B</th>
                    <th>Autre</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($inscriptions as $inscription): ?>
                    <tr>
                        <td><?= htmlspecialchars($inscription['id']); ?></td>
                        <td><?= htmlspecialchars($inscription['nom_de_l_entreprise']); ?></td>
                        <td><?= htmlspecialchars($inscription['secteur_d_activite']); ?></td>
                        <td><?= htmlspecialchars($inscription['description_de_l_entreprise']); ?></td>
                        <td><?= htmlspecialchars($inscription['poste_occupe']); ?></td>
                        <td><?= htmlspecialchars($inscription['prenom']); ?></td>
                        <td><?= htmlspecialchars($inscription['nom']); ?></td>
                        <td><?= htmlspecialchars($inscription['email']); ?></td>
                        <td><?= htmlspecialchars($inscription['telephone']); ?></td>
                        <td><?= htmlspecialchars($inscription['source']); ?></td>
                        <td><?= htmlspecialchars($inscription['thematiques_d_interet']); ?></td>
                        <td><?= htmlspecialchars($inscription['b2b']); ?></td>
                        <td><?= htmlspecialchars($inscription['autres']); ?></td>
                        <td>
                            <a href="delete_inscription.php?id=<?= $inscription['id']; ?>" class="btn-delete" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette inscription ?');">Supprimer</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        </div>
       
    <?php else: ?>
        <p>Aucune inscription trouvée.</p>
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
