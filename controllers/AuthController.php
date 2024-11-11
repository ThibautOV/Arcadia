<?php
// Controllers/AuthController.php

require_once 'Models/User.php';

class AuthController {
    private $model;

    public function __construct() {
        global $pdo;
        $this->model = new User($pdo);
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
        require 'Views/auth/login.php';
    }

    public function logout() {
        session_start();
        session_destroy();
        header("Location: index.php?action=home");
        exit();
    }
}
?>