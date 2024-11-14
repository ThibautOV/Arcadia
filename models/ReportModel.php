<?php
class ReportModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Ajouter un rapport vétérinaire
    public function createReport($animalName, $reportDate, $reportText, $vetId) {
        $query = "INSERT INTO vet_reports (animal_name, report_date, report_text, vet_id) 
                  VALUES (:animal_name, :report_date, :report_text, :vet_id)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':animal_name', $animalName);
        $stmt->bindParam(':report_date', $reportDate);
        $stmt->bindParam(':report_text', $reportText);
        $stmt->bindParam(':vet_id', $vetId);

        return $stmt->execute();
    }

    // Récupérer les rapports vétérinaires
    public function getReports($filters = []) {
        $query = "SELECT * FROM vet_reports WHERE 1=1";

        if (!empty($filters['animal_name'])) {
            $query .= " AND animal_name = :animal_name";
        }
        if (!empty($filters['report_date'])) {
            $query .= " AND report_date = :report_date";
        }

        $stmt = $this->conn->prepare($query);

        if (!empty($filters['animal_name'])) {
            $stmt->bindParam(':animal_name', $filters['animal_name']);
        }
        if (!empty($filters['report_date'])) {
            $stmt->bindParam(':report_date', $filters['report_date']);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>