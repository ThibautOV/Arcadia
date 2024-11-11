<?php
// Models/VetReport.php

class VetReport {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getReportsByAnimal($animalId) {
        $stmt = $this->db->prepare("SELECT * FROM vet_reports WHERE animal_id = :animal_id");
        $stmt->bindParam(':animal_id', $animalId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>