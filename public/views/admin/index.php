<?php

// Utilisation de __DIR__ pour un chemin absolu correct
$configPath = __DIR__ . '/../../../config/config.php';

// Vérification de l'existence du fichier
if (file_exists($configPath)) {
    require_once $configPath;
} else {
    // Affiche un message d'erreur si le fichier n'est pas trouvé
    echo "Le fichier config.php est introuvable dans le chemin suivant : $configPath";
    exit;
}

require_once __DIR__ . '/../../../config/database.php';  // Assurez-vous de charger aussi le fichier database.php

// Connexion à la base de données
$dbConnection = Database::getConnection();

// Gestion des actions
$action = $_GET['action'] ?? 'home';

switch ($action) {
    case 'home':
        require_once __DIR__ . '/../../../controllers/HomeController.php';
        $controller = new HomeController($dbConnection);
        $controller->index();
        break;

    case 'registerUser':
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];
            $role = $_POST['role'];

            if (empty($username) || empty($password) || empty($role)) {
                echo json_encode(['status' => 'error', 'message' => 'Tous les champs sont requis.']);
                exit;
            }

            // Hachage du mot de passe
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

            // Enregistrement de l'utilisateur
            $userModel = new UserModel($dbConnection);
            if ($userModel->createUser($username, '', '', $role, $hashedPassword)) {
                echo json_encode(['status' => 'success', 'message' => 'Utilisateur enregistré avec succès.']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Erreur lors de l\'enregistrement de l\'utilisateur.']);
            }
        }
        break;

    default:
        echo "Page non trouvée.";
        break;
}

?>
