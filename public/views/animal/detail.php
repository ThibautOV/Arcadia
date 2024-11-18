<?php include_once __DIR__ . '/../menu/main_menu.php'; ?>

<div class="animal-detail-page">
    <h1><?= $animal['name']; ?></h1>
    <img src="path_to_image/<?= $animal['image']; ?>" alt="<?= $animal['name']; ?>" class="animal-detail-image">
    <p>Race: <?= $animal['race']; ?></p>

    <h2>Etat de l'Animal</h2>
    <p><?= $animal['health_status']; ?></p>

    <h2>Historique des Repas</h2>
    <p>Dernier repas donné : <?= $animal['last_food']; ?> (<?= $animal['food_weight']; ?>g)</p>

    <h2>Avis du Vétérinaire</h2>
    <p><?= $animal['vet_feedback']; ?></p>

    <h2>Laisser un Avis</h2>
    <form method="POST" action="/review/addReview.php">
        <label for="pseudo">Pseudo:</label>
        <input type="text" name="pseudo" id="pseudo" required>
        <label for="comment">Avis:</label>
        <textarea name="comment" id="comment" required></textarea>
        <button type="submit">Soumettre</button>
    </form>
</div>