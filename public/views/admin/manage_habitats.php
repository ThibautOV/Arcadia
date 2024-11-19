<?php


require_once __DIR__ . '/../../../config/database.php';
require_once __DIR__ . '/../../../controllers/HabitatController.php';


$db = Database::getConnection();


$controller = new HabitatController($db);


$message = $controller->handleRequest();


$habitats = $controller->getHabitats();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Gestion des Habitats</title>
    <link rel="stylesheet" href="../../components/css/manage_habitats.css">
</head>

<body>
    <h2>Gestion des Habitats</h2>
    <?php if (!empty($message)) echo "<p>$message</p>"; ?>

    <ul>
        <?php foreach ($habitats as $habitat): ?>
            <li>
                <?= htmlspecialchars($habitat['name']) ?>
                <form action="manage_habitats.php" method="post" style="display:inline;">
                    <input type="hidden" name="action" value="delete">
                    <input type="hidden" name="habitat_id" value="<?= htmlspecialchars($habitat['id']) ?>">
                    <input type="submit" value="Supprimer">
                </form>
            </li>
        <?php endforeach; ?>
    </ul>

    <h3>Ajouter un Habitat</h3>

    <form action="manage_habitats.php" method="post">
        <input type="hidden" name="action" value="create">
        <label>Nom: <input type="text" name="name" required></label><br>
        <label>Description: <textarea name="description" required></textarea></label><br>
        <label>Image URL: <input type="text" name="image_url" required></label><br> <!-- Utilisation de image_url -->
        <input type="submit" value="Créer l'Habitat">
    </form>
</body>

</html>