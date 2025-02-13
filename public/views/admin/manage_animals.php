<?php
require_once __DIR__ . '/../../../config/database.php';
require_once __DIR__ . '/../../../models/AnimalModel.php';
require_once __DIR__ . '/../../../models/FoodRecordModel.php';
require_once __DIR__ . '/../../../controllers/AnimalController.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$database = new Database();
$pdo = $database->getConnection();

$animalModel = new AnimalModel($pdo);
$foodRecordModel = new FoodRecordModel($pdo);
$controller = new AnimalController($animalModel);
$data = $controller->handleRequest();

$animals = $data['animals'];
$habitats = $data['habitats'];
$selectedHabitat = $data['selectedHabitat'] ?? null;
$editAnimal = $data['editAnimal'] ?? null;

// Créer un tableau associatif pour les habitats
$habitatMap = [];
foreach ($habitats as $habitat) {
    $habitatMap[$habitat['id']] = $habitat['name'];
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des Animaux</title>
    <link rel="stylesheet" href="../../components/css/manage_animals.css">
</head>
<body>
    <h1>Gestion des Animaux</h1>

    <form action="" method="POST">
        <input type="hidden" name="id" value="<?= htmlspecialchars($editAnimal['id'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
        <input type="text" name="name" placeholder="Nom" value="<?= htmlspecialchars($editAnimal['name'] ?? '', ENT_QUOTES, 'UTF-8') ?>" required>
        <input type="text" name="species" placeholder="Espèce" value="<?= htmlspecialchars($editAnimal['species'] ?? '', ENT_QUOTES, 'UTF-8') ?>" required>
        <input type="text" name="health_status" placeholder="État de santé" value="<?= htmlspecialchars($editAnimal['health_status'] ?? '', ENT_QUOTES, 'UTF-8') ?>" required>
        
        <select name="habitat" required>
            <option value="">Sélectionnez un habitat</option>
            <?php foreach ($habitats as $habitat): ?>
                <option value="<?= htmlspecialchars($habitat['id'], ENT_QUOTES, 'UTF-8') ?>" <?= ($selectedHabitat == $habitat['id'] || ($editAnimal['habitat_id'] ?? '') == $habitat['id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($habitat['name'], ENT_QUOTES, 'UTF-8') ?>
                </option>
            <?php endforeach; ?>
        </select>

        <input type="text" name="food" placeholder="Nourriture" value="<?= htmlspecialchars($editAnimal['food'] ?? '', ENT_QUOTES, 'UTF-8') ?>" required>
        <input type="text" name="image_url" placeholder="URL de l'image" value="<?= htmlspecialchars($editAnimal['image_url'] ?? '', ENT_QUOTES, 'UTF-8') ?>" required>
        <textarea name="description" placeholder="Description de l'animal" required><?= htmlspecialchars($editAnimal['description'] ?? '', ENT_QUOTES, 'UTF-8') ?></textarea>

        <button type="submit"><?= $editAnimal ? 'Modifier Animal' : 'Ajouter Animal' ?></button>
    </form>

    <h2>Liste des Animaux</h2>
    <table>
        <thead>
            <tr>
                <th>Nom</th>
                <th>Espèce</th>
                <th>État de santé</th>
                <th>Habitat</th>
                <th>Image</th>
                <th>Description</th>
                <th>Historique de l'Alimentation</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($animals as $animal): ?>
                <tr>
                    <td><?= htmlspecialchars($animal['name'], ENT_QUOTES, 'UTF-8') ?></td>
                    <td><?= htmlspecialchars($animal['species'], ENT_QUOTES, 'UTF-8') ?></td>
                    <td><?= htmlspecialchars($animal['health_status'], ENT_QUOTES, 'UTF-8') ?></td>
                    <td><?= htmlspecialchars($habitatMap[$animal['habitat_id']] ?? 'Non spécifié', ENT_QUOTES, 'UTF-8') ?></td>

                    <!-- Affichage de l'image -->
                    <td>
                        <?php if (!empty($animal['image_url'])): ?>
                            <img src="<?= htmlspecialchars($animal['image_url'], ENT_QUOTES, 'UTF-8') ?>" alt="<?= htmlspecialchars($animal['name'], ENT_QUOTES, 'UTF-8') ?>" width="100">
                        <?php else: ?>
                            <p>Aucune image disponible</p>
                        <?php endif; ?>
                    </td>

                    <!-- Affichage de la description -->
                    <td>
                        <p><?= htmlspecialchars($animal['description'], ENT_QUOTES, 'UTF-8') ?></p>
                    </td>

                    <!-- Affichage de l'historique alimentaire -->
                    <td>
                        <?php
                        // Récupérer l'historique alimentaire de l'animal
                        $foodRecords = $foodRecordModel->getFoodRecordsByAnimalId($animal['id']);
                        if ($foodRecords): 
                            foreach ($foodRecords as $record): 
                                // Formatage de la date et de l'heure
                                $formattedDateTime = !empty($record['date_time']) ? date("d-m-Y H:i:s", strtotime($record['date_time'])) : 'Date non disponible';
                                ?>
                                <p><strong><?= htmlspecialchars($record['food'] ?? 'Inconnue', ENT_QUOTES, 'UTF-8') ?></strong> 
                                - Quantité: <?= htmlspecialchars($record['quantity'] ?? 'Inconnue', ENT_QUOTES, 'UTF-8') ?> 
                                - Date: <?= htmlspecialchars($formattedDateTime, ENT_QUOTES, 'UTF-8') ?></p>
                            <?php endforeach; 
                        else: ?>
                            <p>Aucune alimentation enregistrée</p>
                        <?php endif; ?>
                    </td>

                    <td>
                        <a href="?delete=<?= $animal['id'] ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet animal ?')">Supprimer</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
