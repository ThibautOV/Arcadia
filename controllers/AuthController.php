<?php
require_once 'models/UserModel.php';  // Remplacer User par UserModel

class AuthController {
    private $model;

    public function __construct($db) {
        $this->model = new UserModel($db);  // Utilisation de UserModel
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];

            // Utilisation d'une méthode de UserModel pour récupérer un utilisateur par email
            $stmt = $this->model->getUserByEmail($email);  // Ajouter cette méthode dans UserModel si elle n'existe pas encore
            if ($stmt && password_verify($password, $stmt['password'])) {
                session_start();
                $_SESSION['user_id'] = $stmt['id'];
                $_SESSION['role'] = $stmt['role'];
                header("Location: index.php?action=home");
                exit();
            } else {
                $error = "Identifiants invalides.";
            }
        }
        require 'views/auth/login.php';
    }

    public function logout() {
        session_start();
        session_destroy();
        header("Location: index.php?action=home");
        exit();
    }
}
?>