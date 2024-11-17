<?php
class HabitatModel {
    private $db;

    public function __construct($db) {
        // Assurer que la connexion à la base de données est bien initialisée
        $this->db = $db;
    }

    // Récupérer tous les habitats
    public function getAllHabitats() {
        try {
            $query = "SELECT * FROM habitats";
            $statement = $this->db->prepare($query);
            $statement->execute();
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Log l'erreur et retourne un tableau vide en cas d'erreur
            error_log("Erreur lors de la récupération des habitats : " . $e->getMessage());
            return [];
        }
    }

    // Récupérer un habitat par son ID
    public function getHabitatById($id) {
        try {
            $query = "SELECT * FROM habitats WHERE id = :id";
            $statement = $this->db->prepare($query);
            $statement->bindValue(':id', $id, PDO::PARAM_INT);
            $statement->execute();
            return $statement->fetch(PDO::FETCH_ASSOC);  // Récupère un seul habitat
        } catch (PDOException $e) {
            // Log l'erreur et retourne false en cas d'erreur
            error_log("Erreur lors de la récupération de l'habitat par ID : " . $e->getMessage());
            return false;
        }
    }

    // Créer un habitat
    public function createHabitat($name, $description, $image_url) {
        try {
            $query = "INSERT INTO habitats (name, description, image_url) VALUES (:name, :description, :image_url)";
            $statement = $this->db->prepare($query);
            $statement->bindValue(':name', $name);
            $statement->bindValue(':description', $description);
            $statement->bindValue(':image_url', $image_url);
            $statement->execute();
        } catch (PDOException $e) {
            error_log("Erreur lors de la création d'un habitat : " . $e->getMessage());
        }
    }

    // Mettre à jour un habitat
    public function updateHabitat($id, $name, $description, $image_url) {
        try {
            $query = "UPDATE habitats SET name = :name, description = :description, image_url = :image_url WHERE id = :id";
            $statement = $this->db->prepare($query);
            $statement->bindValue(':id', $id, PDO::PARAM_INT);
            $statement->bindValue(':name', $name);
            $statement->bindValue(':description', $description);
            $statement->bindValue(':image_url', $image_url);
            $statement->execute();
        } catch (PDOException $e) {
            error_log("Erreur lors de la mise à jour de l'habitat : " . $e->getMessage());
        }
    }

    // Supprimer un habitat
    public function deleteHabitat($id) {
        try {
            $query = "DELETE FROM habitats WHERE id = :id";
            $statement = $this->db->prepare($query);
            $statement->bindValue(':id', $id, PDO::PARAM_INT);
            $statement->execute();
        } catch (PDOException $e) {
            error_log("Erreur lors de la suppression de l'habitat : " . $e->getMessage());
        }
    }
}
?>