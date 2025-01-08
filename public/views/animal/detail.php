<?php include_once __DIR__ . '/../menu/main_menu.php'; ?>

<div class="animal-detail-page">
    <?php if (isset($animal)) : ?>
        <h1><?= htmlspecialchars($animal['name']); ?></h1>
        <img src="path_to_image/<?= htmlspecialchars($animal['image_url']); ?>" alt="<?= htmlspecialchars($animal['name']); ?>" class="animal-detail-image">
        <p>Race: <?= htmlspecialchars($animal['species']); ?></p>

        <h2>Etat de l'Animal</h2>
        <p><?= htmlspecialchars($animal['health_status']); ?></p>

        <h2>Historique des Repas</h2>
        <p>Dernier repas donné : <?= htmlspecialchars($animal['last_food']); ?> (<?= htmlspecialchars($animal['food_weight']); ?>g)</p>

        <h2>Avis du Vétérinaire</h2>
        <p><?= htmlspecialchars($animal['vet_feedback']); ?></p>

        <h2>Laisser un Avis</h2>
        <form method="POST" action="/review/addReview.php">
            <label for="pseudo">Pseudo:</label>
            <input type="text" name="pseudo" id="pseudo" required>
            <label for="comment">Avis:</label>
            <textarea name="comment" id="comment" required></textarea>
            <button type="submit">Soumettre</button>
        </form>
    <?php else : ?>
        <p>Les informations de l'animal ne sont pas disponibles.</p>
    <?php endif; ?>
</div>
