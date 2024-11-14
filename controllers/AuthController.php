<?php
require_once 'models/User.php';  // Inclure le modèle User

class AuthController {
    private $model;

    public function __construct($db) {
        $this->model = new User($db);
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];

            // Vérifier les identifiants dans la base de données
            $stmt = $this->model->getUserByEmail($email);
            if ($stmt && password_verify($password, $stmt['password'])) {
                // Authentification réussie
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