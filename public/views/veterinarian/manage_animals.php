<?php
require_once '../Models/AnimalModel.php';

// Connexion à la base de données
$db = new PDO('mysql:host=localhost;dbname=zoo_db', 'username', 'password');

// Création d'une instance du modèle d'animal
$animalModel = new AnimalModel($db);
$animals = $animalModel->getAllAnimals();

$message = "";

// Gérer les actions pour ajouter ou supprimer un animal
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        if ($_POST['action'] === 'delete') {
            $animalModel->deleteAnimal($_POST['animal_id']);
            $message = "Animal supprimé avec succès.";
        } elseif ($_POST['action'] === 'create') {
            $animalModel->createAnimal($_POST['name'], $_POST['species'], $_POST['age'], $_POST['habitat']);
            $message = "Animal créé avec succès.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des Animaux</title>
</head>
<body>
    <h2>Gestion des Animaux</h2>
    <?php if (!empty($message)) echo "<p>$message</p>"; ?>

    <h3>Liste des Animaux</h3>
    <ul>
        <?php foreach ($animals as $animal): ?>
            <li>
                <?= htmlspecialchars($animal['name']) ?> (<?= htmlspecialchars($animal['species']) ?>)
                <form action="manage_animals.php" method="post" style="display:inline;">
                    <input type="hidden" name="action" value="delete">
                    <input type="hidden" name="animal_id" value="<?= $animal['id'] ?>">
                    <input type="submit" value="Supprimer">
                </form>
            </li>
        <?php endforeach; ?>
    </ul>

    <h3>Ajouter un Animal</h3>
    <form action="manage_animals.php" method="post">
        <input type="hidden" name="action" value="create">
        <label>Nom: <input type="text" name="name" required></label><br>
        <label>Espèce: <input type="text" name="species" required></label><br>
        <label>Âge: <input type="number" name="age" required></label><br>
        <label>Habitat: <input type="text" name="habitat" required></label><br>
        <input type="submit" value="Créer l'Animal">
    </form>
</body>
</html>