?php
require_once '../../models/ReportModel.php'; // Chemin ajusté pour accéder au fichier
require_once '../../config/database.php'; // Connexion à la base de données

// Connexion à la base de données
$database = new Database();
$db = $database->getConnection();

// Création d'une instance de ReportModel
$reportModel = new ReportModel($db);

// Traitement des filtres
$animalId = isset($_GET['animal']) ? $_GET['animal'] : null;
$date = isset($_GET['date']) ? $_GET['date'] : null;

// Récupération des comptes rendus avec filtres
$reports = $reportModel->getReports($animalId, $date);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Comptes Rendus Vétérinaires</title>
</head>
<body>
    <h2>Comptes Rendus Vétérinaires</h2>

    <h3>Filtrer les Comptes Rendus</h3>
    <form method="GET" action="reports.php">
        <label>Filtrer par Animal:
            <input type="text" name="animal" placeholder="Nom de l'animal">
        </label>
        <label>Filtrer par Date:
            <input type="date" name="date">
        </label>
        <input type="submit" value="Filtrer">
    </form>

    <h3>Liste des Comptes Rendus</h3>
    <ul>
        <?php if (!empty($reports)): ?>
            <?php foreach ($reports as $report): ?>
                <li>
                    <?php echo htmlspecialchars($report['animal_name']) . ' - ' . htmlspecialchars($report['date']); ?>
                    <br>
                    Détails: <?php echo htmlspecialchars($report['details']); ?>
                </li>
            <?php endforeach; ?>
        <?php else: ?>
            <li>Aucun compte rendu trouvé.</li>
        <?php endif; ?>
    </ul>

    <a href="../auth/logout.php">Se Déconnecter</a>
</body>
</html>