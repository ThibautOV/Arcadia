<?php 

// Inclusion de la configuration de la base de données
include_once __DIR__ . '/../../config/config.php';  // Inclure la configuration de la base de données
include_once __DIR__ . '/../menu/main_menu.php';  // Inclure le menu principal de l'application

// Création de la connexion à la base de données
try {
    $db = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  // Mode d'erreur
} catch (PDOException $e) {
    echo "Échec de la connexion à la base de données : " . $e->getMessage();
    exit();
}

// Inclusion du contrôleur HabitatController pour gérer la logique
include_once __DIR__ . '/../../controllers/HabitatController.php';
include_once __DIR__ . '/../menu/main_menu.php';  // Inclusion du menu principal de l'application

// Instantiation du contrôleur avec la connexion à la base de données
$habitatController = new HabitatController($db);

// Appel de la méthode pour récupérer les habitats
$habitats = $habitatController->getHabitats();

?>

<!-- Inclusion du fichier CSS pour le style -->
<link rel="stylesheet" href="../../components/css/habitat_card.css">

<div class="habitats-page">
    <h1>Nos Habitats</h1>
    <div class="habitat-list">
        <?php if (isset($habitats) && !empty($habitats)): ?>
            <?php foreach ($habitats as $habitat): ?>
                <div class="habitat-card">
                    <a href="detail.php?id=<?= htmlspecialchars($habitat['id']); ?>">
                        <?php if (!empty($habitat['image_url'])): ?>
                            <img src="path_to_images/<?= htmlspecialchars($habitat['image_url']); ?>" alt="<?= htmlspecialchars($habitat['name']); ?>" class="habitat-image">
                        <?php else: ?>
                            <img src="path_to_images/default_image.jpg" alt="Image par défaut" class="habitat-image"> <!-- Image par défaut si aucune image -->
                        <?php endif; ?>
                        <h2><?= htmlspecialchars($habitat['name']); ?></h2>
                        <p><?= htmlspecialchars(substr($habitat['description'], 0, 100)) . '...'; ?></p> <!-- Description tronquée -->
                    </a>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Aucun habitat disponible pour le moment.</p>
        <?php endif; ?>
    </div>
</div>