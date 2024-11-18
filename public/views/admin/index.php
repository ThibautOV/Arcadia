<?php

require_once '../../config/config.php';
require_once '../../config/database.php';


$dbConnection = Database::getConnection();

$action = $_GET['action'] ?? 'home';

switch ($action) {
    case 'home':

        require_once '../../controllers/HomeController.php';
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


            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);


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
}
