<?php

// Utilisez __DIR__ pour éviter les problèmes de chemin relatifs
require_once __DIR__ . '/../models/ReportModel.php'; 
require_once __DIR__ . '/../models/UserModel.php'; 
require_once __DIR__ . '/../models/ConsultationModel.php'; 
require_once __DIR__ . '/../models/ServiceModel.php'; 

class AdminController {
    private $userModel;
    private $reportModel;
    private $consultationModel;
    private $serviceModel;

    public function __construct($db) {
        // Instanciation des modèles avec la connexion à la base de données
        $this->userModel = new UserModel($db);
        $this->reportModel = new ReportModel($db);
        $this->consultationModel = new ConsultationModel($db);
        $this->serviceModel = new ServiceModel($db);
    }

    // Récupérer tous les utilisateurs
    public function getUsers() {
        return $this->userModel->getAllUsers();
    }

    // Créer un utilisateur
    public function createUser($firstName, $lastName, $email, $role, $password) {
        if ($this->userModel->createUser($firstName, $lastName, $email, $role, $password)) {
            return "Utilisateur créé avec succès.";
        } else {
            return "Erreur lors de la création de l'utilisateur.";
        }
    }

    // Supprimer un utilisateur
    public function deleteUser($userId) {
        if ($this->userModel->deleteUser($userId)) {
            return "Utilisateur supprimé avec succès.";
        } else {
            return "Erreur lors de la suppression de l'utilisateur.";
        }
    }
}
?>