<?php
require_once dirname(__DIR__, 3) . '/config/database.php';
require_once dirname(__DIR__, 3) . '/models/HabitatModel.php';
require_once dirname(__DIR__, 3) . '/models/AnimalModel.php';

$database = new Database();
$db = $database->getConnection();

$habitatModel = new HabitatModel($db);
$habitats = $habitatModel->getAllHabitats();

$animals = [];
$selectedHabitat = isset($_POST['habitat']) ? $_POST['habitat'] : '';
if ($selectedHabitat) {
    $animalModel = new AnimalModel($db);
    $animals = $animalModel->getAnimalsByHabitat($selectedHabitat);
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Liste des Animaux</title>
    <script src="../js/script.js" defer></script>
    <link rel="stylesheet" href="../../components/css/list_animals.css">
</head>

<body>
    <h2>Choisissez un habitat pour voir les résidents associés</h2>

    <!-- Sélection de l'habitat -->
    <form method="POST" action="">
        <select name="habitat" id="habitat-select" onchange="this.form.submit()">
            <option value="">Sélectionnez un habitat</option>
            <?php foreach ($habitats as $habitat) : ?>
                <option value="<?= htmlspecialchars($habitat['id']) ?>" <?= $selectedHabitat == $habitat['id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($habitat['name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </form>

    <h3>Liste des animaux</h3>

    <!-- Affichage des animaux sous forme de cartes -->
    <div class="animal-cards">
        <?php if (!empty($animals)): ?>
            <?php foreach ($animals as $animal): ?>
                <div class="card">
                    <img src="<?= htmlspecialchars($animal['image_url']) ?>" alt="<?= htmlspecialchars($animal['name']) ?>" class="animal-image">
                    <div class="card-body">
                        <h3 class="animal-name"><?= htmlspecialchars($animal['name']) ?></h3>
                        <p><strong>Race:</strong> <?= htmlspecialchars($animal['species']) ?></p>
                        <p><strong>État de santé:</strong> <?= htmlspecialchars($animal['health_status']) ?></p>
                        <p><strong>Nourriture:</strong> <?= htmlspecialchars($animal['food']) ?></p>
                        <p><strong>Habitat:</strong> <?= htmlspecialchars($habitat['name']) ?></p>
                        <p><strong>Description:</strong> <?= htmlspecialchars($animal['description']) ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Aucun animal trouvé dans cet habitat.</p>
        <?php endif; ?>
    </div>
</body>

</html>
