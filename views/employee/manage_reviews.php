<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des Avis</title>
    <link rel="stylesheet" href="../../components/css/manage_reviews.css">
</head>
<body>
    <h2>Gestion des Avis</h2>
    <?php if (!empty($reviews)): ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Avis</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($reviews as $review): ?>
                    <tr>
                        <td><?php echo $review['id']; ?></td>
                        <td><?php echo htmlspecialchars($review['content']); ?></td>
                        <td><?php echo $review['status'] == 0 ? 'En attente' : 'Validé'; ?></td>
                        <td>
                            <a href="index.php?action=validateReview&reviewId=<?php echo $review['id']; ?>&isValid=1">Valider</a> |
                            <a href="index.php?action=validateReview&reviewId=<?php echo $review['id']; ?>&isValid=0">Refuser</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Aucun avis en attente.</p>
    <?php endif; ?>
</body>
</html>