<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../models/AnimalModel.php';
require_once __DIR__ . '/../../controllers/AnimalController.php';

$database = new Database();
$pdo = $database->getConnection();

$animalModel = new AnimalModel($pdo);
$controller = new AnimalController($animalModel);
$data = $controller->handleRequest();

$animals = $data['animals'];
$habitats = $data['habitats'];  // Liste d'habitats
$selectedHabitat = $data['selectedHabitat'];
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
        <input type="text" name="name" placeholder="Nom" required>
        <input type="text" name="breed" placeholder="Race" required>
        <input type="text" name="health_status" placeholder="État de santé" required>

        <!-- Sélectionner un habitat parmi les options fixes -->
        <select name="habitat" required>
            <option value="">Sélectionnez un habitat</option>
            <?php foreach ($habitats as $habitat): ?>
                <option value="<?= htmlspecialchars($habitat) ?>" <?= $selectedHabitat === $habitat ? 'selected' : '' ?>><?= htmlspecialchars($habitat) ?></option>
            <?php endforeach; ?>
        </select>

        <input type="text" name="food" placeholder="Nourriture" required>
        <input type="text" name="image_url" placeholder="URL de l'image" required>

        <!-- Champ pour la description -->
        <textarea name="description" placeholder="Description de l'animal" required></textarea>

        <button type="submit">Ajouter Animal</button>
    </form>

    <h2>Liste des Animaux (Habitat: <?= htmlspecialchars(ucfirst($selectedHabitat)) ?>)</h2>
    <ul>
        <?php foreach ($animals as $animal): ?>
            <li>
                <strong><?= htmlspecialchars($animal['name']) ?></strong> (<?= htmlspecialchars($animal['breed']) ?>) - 
                État: <?= htmlspecialchars($animal['health_status']) ?> - 
                Habitat: <?= htmlspecialchars($animal['habitat']) ?> - 
                Nourriture: <?= htmlspecialchars($animal['food']) ?> - 
                <?php if (filter_var($animal['image_url'], FILTER_VALIDATE_URL)): ?>
                    <img src="<?= htmlspecialchars($animal['image_url']) ?>" alt="<?= htmlspecialchars($animal['name']) ?>" width="100">
                <?php else: ?>
                    <img src="/public/images/default_image.png" alt="Image par défaut" width="100">
                <?php endif; ?>
                <p><strong>Description:</strong> <?= htmlspecialchars($animal['description']) ?></p>
                <a href="?delete=<?= htmlspecialchars($animal['id']) ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet animal ?');">Supprimer</a>
            </li>
        <?php endforeach; ?>
    </ul>

</body>
</html>