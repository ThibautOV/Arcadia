<?php
// models/ConsultationModel.php

class ConsultationModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getConsultationStats() {
        $query = "SELECT animal_name, COUNT(*) as count FROM consultations GROUP BY animal_name";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}