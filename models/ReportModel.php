<?php
class ReportModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getAllReports() {
        $query = "SELECT * FROM reports";
        $statement = $this->db->prepare($query);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    // Ajoutez cette méthode pour récupérer les rapports avec des filtres
    public function getReports($animalId = null, $date = null) {
        $query = "SELECT * FROM reports WHERE 1=1"; // Commencer la requête
        if ($animalId) {
            $query .= " AND animal_id = :animal_id"; // Ajouter filtre animal
        }
        if ($date) {
            $query .= " AND date = :date"; // Ajouter filtre date
        }
        $statement = $this->db->prepare($query);
        
        // Lier les valeurs si elles existent
        if ($animalId) {
            $statement->bindValue(':animal_id', $animalId);
        }
        if ($date) {
            $statement->bindValue(':date', $date);
        }

        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>