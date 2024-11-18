<?php include_once __DIR__ . '/../menu/main_menu.php'; ?>

<div class="services-page">
    <h1>Nos Services</h1>
    <div class="service-list">
        <?php if (isset($services) && !empty($services)): ?>
            <?php foreach ($services as $service): ?>
                <div class="service-card">
                    <h2><?= htmlspecialchars($service['name']); ?></h2>
                    <p><?= htmlspecialchars($service['description']); ?></p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Aucun service disponible pour le moment.</p>
        <?php endif; ?>
    </div>
</div>