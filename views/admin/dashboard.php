<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Espace Administrateur</title>
    <link rel="stylesheet" href="../../public/css/styles.css">
</head>
<body>
    <h1>Espace Administrateur</h1>

    <?php if (!empty($message)): ?>
        <div class="alert"><?php echo htmlspecialchars($message); ?></div>
    <?php endif; ?>

    <h2>Créer un Compte Utilisateur</h2>
    <form method="POST" action="index.php?action=create_user">
        <label>Prénom: <input type="text" name="firstName" required></label><br>
        <label>Nom: <input type="text" name="lastName" required></label><br>
        <label>Email (username): <input type="email" name="email" required></label><br>
        <label>Rôle:
            <select name="role" required>
                <option value="employee">Employé</option>
                <option value="vet">Vétérinaire</option>
            </select>
        </label><br>
        <label>Mot de passe: <input type="password" name="password" required></label><br>
        <input type="submit" value="Créer l'Utilisateur">
    </form>

    <h2>Liste des Utilisateurs</h2>
    <ul>
        <?php if (!empty($users)): ?>
            <?php foreach ($users as $user): ?>
                <li><?php echo htmlspecialchars($user['email']); ?> - <?php echo htmlspecialchars($user['role']); ?></li>
            <?php endforeach; ?>
        <?php else: ?>
            <li>Aucun utilisateur trouvé.</li>
        <?php endif; ?>
    </ul>

    <h2>Comptes Rendus Vétérinaires</h2>
    <form method="GET" action="index.php?action=view_reports">
        <label>Filtrer par Animal:
            <input type="text" name="animal" placeholder="Nom de l'animal">
        </label>
        <label>Filtrer par Date:
            <input type="date" name="date">
        </label>
        <input type="submit" value="Filtrer">
    </form>
    
    <ul>
        <?php if (!empty($reports)): ?>
            <?php foreach ($reports as $report): ?>
                <li>
                    <?php echo htmlspecialchars($report['animal_name']) . ' - ' . htmlspecialchars($report['date']); ?>
                    <br>
                    Détails: <?php echo htmlspecialchars($report['details']); ?>
                </li>
            <?php endforeach; ?>
        <?php else: ?>
            <li>Aucun compte rendu trouvé.</li>
        <?php endif; ?>
    </ul>

    <h2>Dashboard des Consultations</h2>
    <p>Nombre de consultations par animal :</p>
    <ul>
        <?php 
        // Assurez-vous que la variable est définie
        if (isset($consultationStats) && !empty($consultationStats)): 
            foreach ($consultationStats as $consultation): ?>
                <li><?php echo htmlspecialchars($consultation['animal_name']) . ": " . htmlspecialchars($consultation['count']); ?></li>
            <?php endforeach; 
        else: ?>
            <li>Aucune consultation enregistrée.</li>
        <?php endif; ?>
    </ul>

    <a href="../auth/logout.php">Se Déconnecter</a>
</body>
</html>