<?php
// Démarrer la session pour utiliser $_SESSION
session_start();

// Inclure le fichier de configuration et la classe de la base de données
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/database.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/models/UserModel.php';

// Récupérer les informations de connexion envoyées via le formulaire
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

// Vérifier si les informations sont présentes
if (empty($email) || empty($password)) {
    $_SESSION['error'] = "Veuillez remplir tous les champs.";
    header("Location: login.php");
    exit();
}

// Connexion à la base de données
$db = Database::getConnection();
$userModel = new UserModel($db);

// Vérifier si l'email existe et récupérer les informations de l'utilisateur
$user = $userModel->getUserByEmail($email);

if ($user && password_verify($password, $user['password'])) {
    // L'authentification a réussi, stocker les informations dans la session
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['user_name'] = $user['first_name'] . ' ' . $user['last_name'];
    $_SESSION['user_email'] = $user['email'];
    $_SESSION['user_role'] = $user['role'];

    // Redirection en fonction du rôle de l'utilisateur
    if ($user['role'] === 'employee') {
        header("Location: ../../views/employee/dashboard_employee.php");
        exit();
    } elseif ($user['role'] === 'veterinarian') {
        header("Location: ../../views/veterinarian/manage_animals.php");
        exit();
    } else {
        $_SESSION['error'] = "Rôle utilisateur inconnu.";
        header("Location: login.php");
        exit();
    }
} else {
    // L'authentification a échoué
    $_SESSION['error'] = "Identifiants incorrects.";
    header("Location: login.php");
    exit();
}
?>
