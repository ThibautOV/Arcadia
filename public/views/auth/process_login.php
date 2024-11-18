<?php
session_start();

// Inclure la configuration de la base de données et le modèle d'authentification
require_once '../../config/database.php'; // Ajustez le chemin si nécessaire
require_once '../../models/UserModel.php'; // Inclure le modèle des utilisateurs

// Connexion à la base de données
$database = new Database();
$db = $database->getConnection();

// Créer une instance du modèle utilisateur
$userModel = new UserModel($db);

$message = '';

// Vérifier si le formulaire de connexion a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    // Authentifier l'utilisateur
    if ($userModel->authenticate($email, $password)) {
        // Récupérer le rôle de l'utilisateur
        $role = $userModel->getUserRole($email);

        // Enregistrer les informations dans la session
        $_SESSION['user_role'] = $role;
        $_SESSION['user_email'] = $email;

        // Redirection en fonction du rôle
        if ($role == 'admin') {
            // Si l'utilisateur est un administrateur, rediriger vers le tableau de bord
            header("Location: ../admin/dashboard.php");
        } elseif ($role == 'employe') {
            // Si l'utilisateur est un employé, rediriger vers la gestion des avis
            header("Location: index.php?action=manageReviews"); // Redirection vers index.php avec l'action manageReviews
        } elseif ($role == 'veterinaire') {
            // Si l'utilisateur est un vétérinaire, rediriger vers la page d'accueil du vétérinaire
            header("Location: ../veterinaire/home.php");
        } else {
            // Si le rôle est inconnu, rediriger vers la page de connexion avec un message d'erreur
            $message = "Rôle inconnu. Veuillez contacter un administrateur.";
        }
        exit();
    } else {
        $message = "Identifiants invalides. Veuillez réessayer.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
</head>
<body>
    <h2>Connexion</h2>
    <?php if (!empty($message)) echo "<p>$message</p>"; ?>
    <form action="process_login.php" method="post">
        <label>Email: <input type="email" name="email" required></label><br>
        <label>Mot de passe: <input type="password" name="password" required></label><br>
        <input type="submit" value="Se connecter">
    </form>
</body>
</html>