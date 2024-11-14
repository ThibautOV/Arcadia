<?php
class AnimalConsultationModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Incrémenter le compteur de consultations pour un animal
    public function increaseConsultation($animalName) {
        $query = "INSERT INTO animal_consultations (animal_name, consultation_count) 
                  VALUES (:animal_name, 1) 
                  ON DUPLICATE KEY UPDATE consultation_count = consultation_count + 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':animal_name', $animalName);
        return $stmt->execute();
    }

    // Récupérer toutes les consultations
    public function getAllConsultations() {
        $query = "SELECT * FROM animal_consultations";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>