<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../../../config/database.php';
require_once __DIR__ . '/../../../models/ReviewModel.php';
require_once __DIR__ . '/../../../models/AnimalModel.php';
require_once __DIR__ . '/../../../models/FoodRecordModel.php';
require_once __DIR__ . '/../../../controllers/EmployeeController.php';

$database = new Database();
$db = $database->getConnection();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'employee') {
    header('Location: ../auth/login.php');
    exit();
}

$employee_id = $_SESSION['user_id'];

$reviewModel = new ReviewModel($db);
$animalModel = new AnimalModel($db);
$foodRecordModel = new FoodRecordModel($db);

$pendingReviews = $reviewModel->getPendingReviews();
$animals = $animalModel->getAllAnimals();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['action']) && isset($_POST['review_id'])) {
        $action = $_POST['action'];
        $reviewId = $_POST['review_id'];

        if ($action == 'approve') {
            $reviewModel->approveReview($reviewId);
        } elseif ($action == 'delete') {
            $reviewModel->deleteReview($reviewId);
        }

        $pendingReviews = $reviewModel->getPendingReviews();
    }

    if (isset($_POST['animal_id'], $_POST['food'], $_POST['quantity'], $_POST['date'], $_POST['time'])) {
        $animal_id = $_POST['animal_id'];
        $food = $_POST['food'];
        $quantity = $_POST['quantity'];
        $date = $_POST['date'];
        $time = $_POST['time'];

        $dateTime = $date . ' ' . $time;

        $query = "INSERT INTO food_records (animal_id, food_type, quantity, feeding_time, employee_id) VALUES (:animal_id, :food, :quantity, :feeding_time, :employee_id)";
        $stmt = $db->prepare($query);
        $stmt->bindValue(':animal_id', $animal_id, PDO::PARAM_INT);
        $stmt->bindValue(':food', $food, PDO::PARAM_STR);
        $stmt->bindValue(':quantity', $quantity, PDO::PARAM_INT);
        $stmt->bindValue(':feeding_time', $dateTime, PDO::PARAM_STR);
        $stmt->bindValue(':employee_id', $employee_id, PDO::PARAM_INT);
        $stmt->execute();

        $feedbackMessage = "L'alimentation a été enregistrée avec succès.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Espace Employé - Zoo Arcadia</title>
    <link rel="stylesheet" href="../../components/css/dashboard_employee.css">
    <script src="../../js/food_record.js" defer></script>
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
                <form id="foodForm" method="POST">
                    <label for="animal">Sélectionner un animal :</label>
                    <select name="animal_id" id="animal" required>
                        <?php foreach ($animals as $animal): ?>
                            <option value="<?= htmlspecialchars($animal['id'], ENT_QUOTES, 'UTF-8') ?>">
                                <?= htmlspecialchars($animal['name'], ENT_QUOTES, 'UTF-8') ?> 
                                (<?= htmlspecialchars($animal['habitat'] ?? 'Habitat inconnu', ENT_QUOTES, 'UTF-8') ?>)
                            </option>
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

                <?php if (isset($feedbackMessage)): ?>
                    <div id="feedback"><?= htmlspecialchars($feedbackMessage, ENT_QUOTES, 'UTF-8') ?></div>
                <?php endif; ?>
            </div>
        </section>

        <section>
            <h2>Avis en Attente</h2>
            <div class="pending-reviews-section">
                <h3>Liste des Avis en Attente</h3>
                <ul>
                    <?php foreach ($pendingReviews as $review): ?>
                        <li>
                            <?= htmlspecialchars($review['author'], ENT_QUOTES, 'UTF-8') ?> : <?= htmlspecialchars($review['content'], ENT_QUOTES, 'UTF-8') ?>
                            <form action="dashboard_employee.php" method="post" style="display:inline;">
                                <input type="hidden" name="action" value="approve">
                                <input type="hidden" name="review_id" value="<?= htmlspecialchars($review['id'], ENT_QUOTES, 'UTF-8') ?>">
                                <input type="submit" value="Approuver">
                            </form>
                            <form action="dashboard_employee.php" method="post" style="display:inline;">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="review_id" value="<?= htmlspecialchars($review['id'], ENT_QUOTES, 'UTF-8') ?>">
                                <input type="submit" value="Supprimer">
                            </form>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </section>
    </div>
</body>
</html>
