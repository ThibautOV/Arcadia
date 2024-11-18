<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des Habitats</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Liste des Habitats</h1>
    <ul>
        <?php foreach ($habitats as $habitat): ?>
            <li>
                <a href="index.php?action=habitatDetails&id=<?php echo htmlspecialchars($habitat['id']); ?>">
                    <?php echo htmlspecialchars($habitat['name']); ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
    <a href="index.php?action=home">Retour à l'accueil</a>
</body>
</html>