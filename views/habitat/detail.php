<?php include_once __DIR__ . '/../menu/main_menu.php'; ?>

<div class="habitat-detail-page">
    <h1><?= $habitat['name']; ?></h1>
    <img src="path_to_image/<?= $habitat['image']; ?>" alt="<?= $habitat['name']; ?>" class="habitat-detail-image">
    <p><?= $habitat['description']; ?></p>

    <h2>Nos Animaux</h2>
    <div class="animal-list">
        <?php foreach ($animals as $animal): ?>
            <div class="animal-card">
                <a href="../animal/detail.php?id=<?= $animal['id']; ?>">
                    <img src="path_to_image/<?= $animal['image']; ?>" alt="<?= $animal['name']; ?>" class="animal-image">
                    <h3><?= $animal['name']; ?></h3>
                    <p><?= $animal['race']; ?></p>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
</div>