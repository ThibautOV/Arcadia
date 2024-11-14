<?php
// index.php

// Inclure le fichier config.php en corrigeant le chemin d'accès
require_once '../../config/config.php';  // Remonter deux niveaux pour accéder à config/config.php

// Récupérer l'action de la requête, ou par défaut 'home'
$action = $_GET['action'] ?? 'home';

// Créer une connexion à la base de données
$dbConnection = getDatabaseConnection();  // Appel à la fonction définie dans config.php

// Traitement des actions demandées
switch ($action) {
    case 'home':
        require 'Controllers/HomeController.php';
        $controller = new HomeController();
        $controller->index();
        break;

    case 'registerUser':
        // Formulaire d'enregistrement d'utilisateur (employé/vétérinaire)
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];
            $role = $_POST['role'];  // Exemple : 'employe' ou 'veterinaire'

            // Vérification des données
            if (empty($username) || empty($password) || empty($role)) {
                echo json_encode(['status' => 'error', 'message' => 'Tous les champs sont requis.']);
                exit;
            }

            // Hachage du mot de passe avant de l'enregistrer
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

            // Préparer la requête pour insérer un nouvel utilisateur
            $stmt = $dbConnection->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
            $stmt->execute([$username, $hashedPassword, $role]);

            // Répondre en JSON après l'enregistrement
            echo json_encode(['status' => 'success', 'message' => 'Utilisateur enregistré avec succès.']);
        }
        break;

    default:
        echo "Page non trouvée.";  // Cas par défaut si l'action n'est pas reconnue
        break;
}
?>