<?php
require_once '../Models/HabitatModel.php';

// Connexion à la base de données
$db = new PDO('mysql:host=localhost;dbname=zoo_db', 'username', 'password');

// Création d'une instance du modèle d'habitat
$habitatModel = new HabitatModel($db);
$habitats = $habitatModel->getAllHabitats();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Habitats</title>
</head>
<body>
    <h2>Habitats</h2>

    <ul>
        <?php foreach ($habitats as $habitat): ?>
            <li>
                <?= htmlspecialchars($habitat['name']) ?>: <?= htmlspecialchars($habitat['description']) ?>
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>