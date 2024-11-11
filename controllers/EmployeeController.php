<?php
// Controllers/EmployeeController.php

require_once 'Models/User.php';

class EmployeeController {
    private $model;

    public function __construct() {
        global $pdo;
        $this->model = new User($pdo);
    }

    public function validateReview($reviewId) {
        // Validation d'un avis par l'employé
        // Mettre à jour le statut de l'avis dans la base de données
    }

    public function invalidateReview($reviewId) {
        // Invalidater un avis par l'employé
        // Mettre à jour le statut de l'avis dans la base de données
    }

    public function manageServices() {
        // Gestion des services
    }
}
?>