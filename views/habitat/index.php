<?php include_once __DIR__ . '/../menu/main_menu.php'; ?>

<div class="habitats-page">
    <h1>Nos Habitats</h1>
    <div class="habitat-list">
        <?php if (isset($habitats) && !empty($habitats)): ?>
            <?php foreach ($habitats as $habitat): ?>
                <div class="habitat-card">
                    <a href="detail.php?id=<?= htmlspecialchars($habitat['id']); ?>">
                        <img src="path_to_image/<?= htmlspecialchars($habitat['image']); ?>" alt="<?= htmlspecialchars($habitat['name']); ?>" class="habitat-image">
                        <h2><?= htmlspecialchars($habitat['name']); ?></h2>
                    </a>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Aucun habitat disponible pour le moment.</p>
        <?php endif; ?>
    </div>
</div>