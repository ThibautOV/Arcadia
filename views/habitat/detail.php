<?php include_once __DIR__ . '/../menu/main_menu.php'; ?>

<div class="habitat-detail-page">
    <?php if (isset($habitat) && is_array($habitat)): ?>
        <h1><?= htmlspecialchars($habitat['name']); ?></h1>
        <img src="<?= htmlspecialchars($habitat['image_url']); ?>" alt="<?= htmlspecialchars($habitat['name']); ?>" class="habitat-detail-image">
        <p><?= nl2br(htmlspecialchars($habitat['description'])); ?></p>

        <h2>Nos Animaux</h2>
        <div class="animal-list">
            <?php if (!empty($animals)): ?>
                <?php foreach ($animals as $animal): ?>
                    <div class="animal-card">
                        <a href="../animal/detail.php?id=<?= htmlspecialchars($animal['id']); ?>">
                            <img src="<?= htmlspecialchars($animal['image_url']); ?>" alt="<?= htmlspecialchars($animal['name']); ?>" class="animal-image">
                            <h3><?= htmlspecialchars($animal['name']); ?></h3>
                            <p><?= htmlspecialchars($animal['breed']); ?></p>
                        </a>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Aucun animal n'est associé à cet habitat.</p>
            <?php endif; ?>
        </div>
    <?php else: ?>
        <p>Habitat introuvable ou erreur dans les données.</p>
    <?php endif; ?>
</div>