<?php
// Inclure les fichiers nécessaires
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../controllers/AdminController.php';
require_once __DIR__ . '/../../utils/MailUtils.php';

// Connexion à la base de données
$database = new Database();
$db = $database->getConnection();

if (!$db) {
    die("Erreur de connexion à la base de données");
}

// Initialiser le contrôleur
$controller = new AdminController($db);
$message = '';

// Gestion de la création ou suppression d'utilisateur
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        if ($_POST['action'] === 'create') {
            $firstName = $_POST['first_name'];
            $lastName = $_POST['last_name'];
            $email = $_POST['email'];
            $role = $_POST['role']; // Récupération du rôle
            $password = $_POST['password'];

            // Créer un utilisateur et envoyer un e-mail
            $message = $controller->createUser($firstName, $lastName, $email, $role, $password);
        } elseif ($_POST['action'] === 'delete') {
            $userId = $_POST['user_id'];
            $message = $controller->deleteUser($userId);
        }
    } catch (Exception $e) {
        $message = "Erreur : " . $e->getMessage();
    }
}

// Récupérer tous les utilisateurs
$users = $controller->getUsers();

// Récupérer le nombre de consultations par animal
$consultationsCount = $controller->getConsultationsCount();

// Récupérer les consultations filtrées si un filtre est appliqué
$animalFilter = $_GET['animal'] ?? null;
$dateFilter = $_GET['date'] ?? null;
$consultations = $controller->getFilteredConsultations($animalFilter, $dateFilter);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des Utilisateurs</title>
    <link rel="stylesheet" href="../../components/css/dashboard_admin.css">
</head>
<body>
    <h2>Gestion des Utilisateurs</h2>

    <?php if (!empty($message)) echo "<p>$message</p>"; ?>

    <h3>Liste des Utilisateurs</h3>
    <ul>
        <?php if (!empty($users)): ?>
            <?php foreach ($users as $user): ?>
                <li>
                    <!-- Affichage du nom et du rôle avec traduction du rôle -->
                    <?= htmlspecialchars($user['first_name'] . ' ' . $user['last_name']) ?> 
                    (<?= htmlspecialchars($user['role'] === 'employe' ? 'Employé' : 'Vétérinaire') ?>)
                    
                    <!-- Formulaire de suppression avec confirmation -->
                    <form action="manage_users.php" method="post" style="display:inline;" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?');">
                        <input type="hidden" name="action" value="delete">
                        <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                        <input type="submit" value="Supprimer">
                    </form>
                </li>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Aucun utilisateur trouvé.</p>
        <?php endif; ?>
    </ul>

    <h3>Ajouter un Utilisateur</h3>
    <form action="manage_users.php" method="post">
        <input type="hidden" name="action" value="create">
        <label>Prénom: <input type="text" name="first_name" required></label><br>
        <label>Nom: <input type="text" name="last_name" required></label><br>
        <label>Email: <input type="email" name="email" required></label><br>
        <label>Rôle:
            <select name="role">
                <option value="employe">Employé</option>
                <option value="veterinaire">Vétérinaire</option>
            </select>
        </label><br>
        <label>Mot de passe: <input type="password" name="password" required></label><br>
        <input type="submit" value="Créer l'Utilisateur">
    </form>

    <h3>Tableau de Bord - Nombre de Consultations par Animal</h3>
    <ul>
        <?php foreach ($consultationsCount as $consultation): ?>
            <li>
                <?= htmlspecialchars($consultation['animal']) ?>: <?= htmlspecialchars($consultation['consultation_count']) ?> consultations
            </li>
        <?php endforeach; ?>
    </ul>

    <h3>Consultations</h3>
    <form method="get">
        <label for="animal">Filtrer par animal: </label>
        <input type="text" id="animal" name="animal" value="<?= htmlspecialchars($animalFilter) ?>"><br>
        <label for="date">Filtrer par date: </label>
        <input type="date" id="date" name="date" value="<?= htmlspecialchars($dateFilter) ?>"><br>
        <input type="submit" value="Filtrer">
    </form>

    <ul>
        <?php if (!empty($consultations)): ?>
            <?php foreach ($consultations as $consultation): ?>
                <li>
                    Animal: <?= htmlspecialchars($consultation['animal']) ?><br>
                    Date: <?= htmlspecialchars($consultation['date']) ?><br>
                    Description: <?= htmlspecialchars($consultation['description']) ?><br>
                </li>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Aucune consultation trouvée.</p>
        <?php endif; ?>
    </ul>
</body>
</html>