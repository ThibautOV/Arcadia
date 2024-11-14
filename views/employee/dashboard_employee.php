<?php
require_once '../../models/ReviewModel.php';
require_once '../../models/AnimalModel.php';
require_once '../../models/FoodRecordModel.php';
require_once '../../controllers/EmployeeController.php';

$reviewModel = new ReviewModel();
$animalModel = new AnimalModel(Database::getConnection());
$foodRecordModel = new FoodRecordModel(Database::getConnection());

$pendingReviews = $reviewModel->getPendingReviews();
$animals = $animalModel->getAllAnimals();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Espace Employé - Zoo Arcadia</title>
    <link rel="stylesheet" href="../../components/css/dashboard_employee.css">
    <script src="../../public/js/food_record.js" defer></script>
</head>

<body>
    <div class="container">
        <header>
            <h1>Bienvenue dans votre espace employé</h1>
            <nav>
                <ul>
                    <li><a href="dashboard_employee.php">Tableau de bord</a></li>
                    <li><a href="manage_reviews.php">Gérer les avis</a></li>
                    <li><a href="manage_services.php">Gérer les services</a></li>
                    <li><a href="food_records.php">Enregistrer alimentation</a></li>
                </ul>
            </nav>
        </header>

        <section>
            <h2>Gestion de l'Alimentation des Animaux</h2>
            <div class="food-record-section">
                <h3>Enregistrer l'alimentation des animaux</h3>
                <form id="foodForm">
                    <label for="animal">Sélectionner un animal :</label>
                    <select name="animal_id" id="animal">
                        <?php foreach ($animals as $animal): ?>
                            <option value="<?= $animal['id'] ?>"><?= htmlspecialchars($animal['name']) ?> (<?= htmlspecialchars($animal['habitat']) ?>)</option>
                        <?php endforeach; ?>
                    </select>
                    <br>
                    <label for="food">Alimentation donnée :</label>
                    <input type="text" name="food" id="food" required>
                    <br>
                    <label for="quantity">Quantité :</label>
                    <input type="number" name="quantity" id="quantity" required>
                    <br>
                    <label for="date">Date :</label>
                    <input type="date" name="date" id="date" required>
                    <br>
                    <label for="time">Heure :</label>
                    <input type="time" name="time" id="time" required>
                    <br>
                    <button type="submit">Enregistrer l'alimentation</button>
                </form>
                <div id="feedback"></div> <!-- Zone de message de retour -->
            </div>
        </section>
    </div>
</body>

</html>