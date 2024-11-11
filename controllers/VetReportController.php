<?php
// Controllers/VetReportController.php

require_once 'Models/VetReport.php';

class VetReportController {
    private $model;

    public function __construct() {
        global $pdo;
        $this->model = new VetReport($pdo);
    }

    public function listReports($animalId) {
        $reports = $this->model->getReportsByAnimal($animalId);
        require 'Views/reports/list.php';
    }

    public function createReport($animalId, $data) {
        // Créer un nouveau rapport vétérinaire
    }
}
?>