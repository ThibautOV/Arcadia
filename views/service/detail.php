!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails du Service</title>
    <!-- Ajouter vos liens vers des fichiers CSS ici -->
</head>
<body>
    <h1>Détails du Service</h1>

    <?php if ($service): ?>
        <table>
            <tr>
                <th>ID</th>
                <td><?php echo htmlspecialchars($service['id']); ?></td>
            </tr>
            <tr>
                <th>Nom</th>
                <td><?php echo htmlspecialchars($service['name']); ?></td>
            </tr>
            <tr>
                <th>Description</th>
                <td><?php echo htmlspecialchars($service['description']); ?></td>
            </tr>
        </table>

        <a href="service/edit/<?php echo $service['id']; ?>">Modifier</a>
        <a href="service/delete/<?php echo $service['id']; ?>">Supprimer</a>
    <?php else: ?>
        <p>Le service demandé n'existe pas.</p>
    <?php endif; ?>

    <a href="services">Retour à la liste des services</a>
</body>
</html>