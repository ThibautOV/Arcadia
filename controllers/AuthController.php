<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../models/UserModel.php';
require_once __DIR__ . '/../config/database.php';

class AuthController {
    private $model;

    public function __construct($db) {
        $this->model = new UserModel($db);
    }

    private function redirectUserBasedOnRole($role) {
        switch ($role) {
            case 'employee':
                header("Location: /public/views/employee/dashboard_employee.php");
                break;
            case 'veterinarian':
                header("Location: /public/views/veterinarian/manage_animals.php");
                break;
            case 'admin':
                header("Location: /public/views/admin/dashboard.php");
                break;
            default:
                die("Rôle inconnu. Contactez un administrateur.");
        }
        exit();
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
            $password = $_POST['password'] ?? '';

            $user = $this->model->getUserByEmail($email);

            if ($user && password_verify($password, $user['password'])) {
                session_start();
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['role'] = $user['role'];
                $_SESSION['user_email'] = $email;

                $this->redirectUserBasedOnRole($user['role']);
            } else {
                $message = "Identifiants invalides. Veuillez réessayer.";
                require_once __DIR__ . '/../public/views/auth/login.php';
            }
        } else {
            require_once __DIR__ . '/../public/views/auth/login.php';
        }
    }

    public function logout() {
        session_start();
        session_destroy();
        header("Location: /public/views/auth/login.php");
        exit();
    }
}

$database = Database::getConnection();
$authController = new AuthController($database);
$authController->login();
?>
