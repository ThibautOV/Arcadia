<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Détails de l'Animal</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Détails de l'animal : <?php echo htmlspecialchars($animal['first_name']); ?></h1>
    <p><strong>Espèce:</strong> <?php echo htmlspecialchars($animal['species']); ?></p>
    <p><strong>Habitat:</strong> <?php echo htmlspecialchars($animal['habitat_id']); ?></p>
    <p><strong>Âge:</strong> <?php echo htmlspecialchars($animal['age']); ?> ans</p>
    <p><strong>Description:</strong> <?php echo htmlspecialchars($animal['description']); ?></p>
    <a href="index.php?action=listHabitats">Retour aux habitats</a>
</body>
</html>