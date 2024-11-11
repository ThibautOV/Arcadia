<?php
// Inclusion de la connexion à la base de données et du contrôleur
require_once __DIR__ . '/../../config/database.php'; // Connexion à la base de données (vérifiez ce fichier pour obtenir la connexion)
require_once __DIR__ . '/../../controllers/AdminController.php';

// Connexion à la base de données (assurez-vous que Database.php existe et fonctionne)
$database = new Database(); 
$db = $database->getConnection(); // Récupère la connexion PDO à la base de données

// Créer l'instance du contrôleur AdminController avec la connexion à la base de données
$controller = new AdminController($db);

$message = '';

// Gestion des actions de création et suppression d'utilisateur
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($_POST['action'] == 'create') {
        // Récupérer les données envoyées par le formulaire pour la création
        $firstName = $_POST['first_name'];
        $lastName = $_POST['last_name'];
        $email = $_POST['email'];
        $role = $_POST['role'];
        $password = $_POST['password'];

        // Appel de la méthode pour créer l'utilisateur
        $message = $controller->createUser($firstName, $lastName, $email, $role, $password);
    } elseif ($_POST['action'] == 'delete') {
        // Récupérer l'ID de l'utilisateur à supprimer
        $userId = $_POST['user_id'];
        
        // Appel de la méthode pour supprimer l'utilisateur
        $message = $controller->deleteUser($userId);
    }
}

// Récupérer les utilisateurs via le contrôleur
$users = $controller->getUsers();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des Utilisateurs</title>
    <link rel="stylesheet" href="../../components/css/user.css">
</head>
<body>
    <h2>Gestion des Utilisateurs</h2>

    <!-- Affichage des messages de confirmation ou d'erreur -->
    <?php if (!empty($message)) echo "<p>$message</p>"; ?>

    <h3>Liste des Utilisateurs</h3>
    <ul>
        <!-- Vérification si la variable $users est non vide avant d'afficher la liste -->
        <?php if (!empty($users)): ?>
            <?php foreach ($users as $user): ?>
                <li>
                    <?= htmlspecialchars($user['first_name'] . ' ' . $user['last_name']) ?> (<?= htmlspecialchars($user['role']) ?>)
                    <form action="manage_users.php" method="post" style="display:inline;">
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
                <option value="employee">Employé</option>
                <option value="vet">Vétérinaire</option>
            </select>
        </label><br>
        <label>Mot de passe: <input type="password" name="password" required></label><br>
        <input type="submit" value="Créer l'Utilisateur">
    </form>
</body>
</html>