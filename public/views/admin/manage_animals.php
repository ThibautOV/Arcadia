<?php
require_once __DIR__ . '/../../../config/database.php';
require_once __DIR__ . '/../../../models/AnimalModel.php';
require_once __DIR__ . '/../../../controllers/AnimalController.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$database = new Database();
$pdo = $database->getConnection();

$animalModel = new AnimalModel($pdo);
$controller = new AnimalController($animalModel);
$data = $controller->handleRequest();

$animals = $data['animals'];
$habitats = $data['habitats'];
$selectedHabitat = $data['selectedHabitat'];
$editAnimal = $data['editAnimal'] ?? null;

// Créer un tableau associatif pour les habitats pour faciliter l'affichage du nom des habitats
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
                <option value="<?= htmlspecialchars($habitat['id'], ENT_QUOTES, 'UTF-8') ?>" <?= ($selectedHabitat == $habitat['id'] || ($editAnimal['habitat_id'] ?? '') == $habitat['id']) ? 'selected' : '' ?>><?= htmlspecialchars($habitat['name'], ENT_QUOTES, 'UTF-8') ?></option>
            <?php endforeach; ?>
        </select>

        <input type="text" name="food" placeholder="Nourriture" value="<?= htmlspecialchars($editAnimal['food'] ?? '', ENT_QUOTES, 'UTF-8') ?>" required>
        <input type="text" name="image_url" placeholder="URL de l'image" value="<?= htmlspecialchars($editAnimal['image_url'] ?? '', ENT_QUOTES, 'UTF-8') ?>" required>
        <textarea name="description" placeholder="Description de l'animal" required><?= htmlspecialchars($editAnimal['description'] ?? '', ENT_QUOTES, 'UTF-8') ?></textarea>

        <button type="submit"><?= $editAnimal ? 'Modifier Animal' : 'Ajouter Animal' ?></button>
    </form>

    <h2>Liste des Animaux (Habitat: <?= htmlspecialchars($selectedHabitat ? ucfirst($selectedHabitat) : 'Tous les habitats', ENT_QUOTES, 'UTF-8') ?>)</h2>
    <ul>
        <?php foreach ($animals as $animal): ?>
            <li>
                <strong><?= htmlspecialchars($animal['name'], ENT_QUOTES, 'UTF-8') ?></strong> (<?= htmlspecialchars($animal['species'], ENT_QUOTES, 'UTF-8') ?>) - 
                État: <?= htmlspecialchars($animal['health_status'], ENT_QUOTES, 'UTF-8') ?> - 
                Habitat: <?= htmlspecialchars($habitatMap[$animal['habitat_id']] ?? 'Non spécifié', ENT_QUOTES, 'UTF-8') ?> - 
                Nourriture: <?= htmlspecialchars($animal['food'], ENT_QUOTES, 'UTF-8') ?> - 
                <?php if (filter_var($animal['image_url'], FILTER_VALIDATE_URL)): ?>
                    <img src="<?= htmlspecialchars($animal['image_url'], ENT_QUOTES, 'UTF-8') ?>" alt="<?= htmlspecialchars($animal['name'], ENT_QUOTES, 'UTF-8') ?>" width="100">
                <?php else: ?>
                    <img src="/public/images/default_image.png" alt="Image par défaut" width="100">
                <?php endif; ?>
                <p><strong>Description:</strong> <?= htmlspecialchars($animal['description'], ENT_QUOTES, 'UTF-8') ?></p>
                <a href="?edit=<?= htmlspecialchars($animal['id'], ENT_QUOTES, 'UTF-8') ?>">Modifier</a>
                <a href="?delete=<?= htmlspecialchars($animal['id'], ENT_QUOTES, 'UTF-8') ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet animal ?');">Supprimer</a>
            </li>
        <?php endforeach; ?>
    </ul>

</body>
</html>
