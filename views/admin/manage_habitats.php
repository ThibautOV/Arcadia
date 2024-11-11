<?php
// Inclusion des fichiers nécessaires pour la connexion à la base de données et le contrôleur
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../controllers/HabitatController.php';

// Connexion à la base de données
$db = getDatabaseConnection(); // Utilisation de la fonction globale définie dans config/database.php
$controller = new HabitatController($db);

// Gérer la requête et récupérer les messages de confirmation ou d'erreur
$message = $controller->handleRequest();

// Récupérer la liste des habitats via le contrôleur
$habitats = $controller->getHabitats();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des Habitats</title>
</head>
<body>
    <h2>Gestion des Habitats</h2>
    
    <!-- Affichage des messages de confirmation ou d'erreur -->
    <?php if (!empty($message)) echo "<p>$message</p>"; ?>

    <h3>Liste des Habitats</h3>
    <ul>
        <!-- Boucle pour afficher chaque habitat avec option de suppression -->
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
    <!-- Formulaire pour ajouter un nouvel habitat -->
    <form action="manage_habitats.php" method="post">
        <input type="hidden" name="action" value="create">
        <label>Nom: <input type="text" name="name" required></label><br>
        <label>Description: <textarea name="description" required></textarea></label><br>
        <label>Images (URL, séparés par des virgules): <input type="text" name="images" required></label><br>
        <input type="submit" value="Créer l'Habitat">
    </form>
</body>
</html>