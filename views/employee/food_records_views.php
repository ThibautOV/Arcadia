<?php
require_once '../Models/FoodRecordModel.php';

// Connexion à la base de données
$db = new PDO('mysql:host=localhost;dbname=zoo_db', 'username', 'password');

// Gérer l'affichage des enregistrements de nourriture
$animalId = $_GET['animal_id'] ?? null;
$foodRecordModel = new FoodRecordModel($db);
$foodRecords = $foodRecordModel->getFoodRecordsByAnimal($animalId);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Enregistrements de Nourriture</title>
</head>
<body>
    <h2>Enregistrements de Nourriture pour l'Animal ID: <?= htmlspecialchars($animalId) ?></h2>

    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nourriture donnée</th>
            <th>Quantité</th>
            <th>Date</th>
        </tr>
        <?php foreach ($foodRecords as $record): ?>
        <tr>
            <td><?= htmlspecialchars($record['id']) ?></td>
            <td><?= htmlspecialchars($record['food_given']) ?></td>
            <td><?= htmlspecialchars($record['quantity']) ?></td>
            <td><?= htmlspecialchars($record['date']) ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>