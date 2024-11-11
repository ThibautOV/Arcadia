<?php
require_once '../Models/ReviewModel.php';

// Connexion à la base de données
$db = new PDO('mysql:host=localhost;dbname=zoo_db', 'username', 'password');

// Création d'une instance du modèle d'avis
$reviewModel = new ReviewModel($db);
$reviews = $reviewModel->getAllReviews();

$message = "";

// Gérer les actions pour ajouter ou supprimer un avis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        if ($_POST['action'] === 'delete') {
            $reviewModel->deleteReview($_POST['review_id']);
            $message = "Avis supprimé avec succès.";
        } elseif ($_POST['action'] === 'create') {
            $reviewModel->createReview($_POST['animal_id'], $_POST['review'], $_POST['rating']);
            $message = "Avis créé avec succès.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des Avis</title>
</head>
<body>
    <h2>Gestion des Avis</h2>

    <?php if (!empty($message)) echo "<p>$message</p>"; ?>

    <h3>Liste des avis</h3>
    <ul>
        <?php foreach ($reviews as $review): ?>
            <li>
                <?= htmlspecialchars($review['review']) ?> (<?= htmlspecialchars($review['rating']) ?>)
                <form action="manage_reviews.php" method="post" style="display:inline;">
                    <input type="hidden" name="action" value="delete">
                    <input type="hidden" name="review_id" value="<?= $review['id'] ?>">
                    <input type="submit" value="Supprimer">
                </form>
            </li>
        <?php endforeach; ?>
    </ul>

    <h3>Ajouter un avis</h3>
    <form action="manage_reviews.php" method="post">
        <input type="hidden" name="action" value="create">
        <label>ID de l'Animal: <input type="text" name="animal_id" required></label><br>
        <label>Avis: <textarea name="review" required></textarea></label><br>
        <label>Évaluation: <input type="number" name="rating" min="1" max="5" required></label><br>
        <input type="submit" value="Créer l'avis">
    </form>
</body>
</html>