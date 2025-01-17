<?php
$rootDirectory = realpath(__DIR__ . '/../../../');  // remonte trois niveaux jusqu'à la racine du projet

require_once $rootDirectory . '/models/ReportModel.php'; 
require_once $rootDirectory . '/config/database.php'; 

$database = new Database();
$db = $database->getConnection();

$reportModel = new ReportModel($db);

$animalId = isset($_GET['animal']) ? $_GET['animal'] : null;
$date = isset($_GET['date']) ? $_GET['date'] : null;

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
