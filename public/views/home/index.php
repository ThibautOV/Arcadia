<?php 
// Inclure le contrôleur HabitatController avec le chemin corrigé
require_once __DIR__ . '/../../controllers/HabitatController.php'; // Chemin corrigé

// Inclure le menu avec son propre CSS
include_once __DIR__ . '/../menu/main_menu.php'; 
?>

<!-- Lien vers le CSS spécifique de la page d'accueil -->
<link rel="stylesheet" href="../../components/css/index.css">

<div class="home-page">
    <h1>Bienvenue au Zoo</h1>
    <p>Découvrez notre zoo et ses incroyables habitants !</p>

    <!-- Introduction -->
    <div class="introduction">
        <p>Notre zoo abrite de nombreux animaux fascinants répartis dans des habitats divers. Venez explorer nos espaces et découvrez nos services.</p>
        <img src="path_to_image/zoo_intro.jpg" alt="Zoo Image" class="intro-image">
    </div>

    
    <!-- Section Avis des Visiteurs -->
    <h2>Avis des Visiteurs</h2>
    <div class="reviews">
        <?php if (!empty($reviews)): ?>
            <?php foreach ($reviews as $review): ?>
                <div class="review-card">
                    <h4><?= htmlspecialchars($review['pseudo']); ?> :</h4>
                    <p><?= htmlspecialchars($review['review_text']); ?></p>
                    <small><?= htmlspecialchars($review['date']); ?></small> <!-- Date de l'avis -->
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Aucun avis disponible pour le moment.</p>
        <?php endif; ?>
    </div>
</div>