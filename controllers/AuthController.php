<?php
// Utilisation du chemin correct pour inclure UserModel
require_once __DIR__ . '/../models/UserModel.php';  // Le dossier 'models' est à un niveau supérieur à 'controllers'

class AuthController {
    private $model;

    public function __construct($db) {
        $this->model = new UserModel($db);  // Création d'une instance de UserModel
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];

            // Utilisation d'une méthode de UserModel pour récupérer un utilisateur par email
            $stmt = $this->model->getUserByEmail($email);  // Assure-toi que cette méthode existe dans UserModel
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
        require 'views/auth/login.php';  // Inclut la vue du formulaire de connexion
    }

    public function logout() {
        session_start();
        session_destroy();
        header("Location: index.php?action=home");
        exit();
    }
}
?>