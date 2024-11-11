<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des Services</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Liste des Services</h1>
    <ul>
        <?php foreach ($services as $service): ?>
            <li><?php echo htmlspecialchars($service['name']); ?>: <?php echo htmlspecialchars($service['description']); ?></li>
        <?php endforeach; ?>
    </ul>
    <a href="index.php?action=home">Retour à l'accueil</a>
</body>
</html>