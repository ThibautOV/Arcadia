<?php

class HabitatModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function createHabitat($name, $description, $image_url) {
        try {
            $query = "INSERT INTO habitats (name, description, image_url) VALUES (:name, :description, :image_url)";
            $statement = $this->db->prepare($query);
            $statement->bindValue(':name', $name);
            $statement->bindValue(':description', $description);
            $statement->bindValue(':image_url', $image_url);
            $statement->execute();
        } catch (PDOException $e) {
            error_log("Erreur lors de l'ajout de l'habitat : " . $e->getMessage());
        }
    }

    public function getAllHabitats() {
        try {
            $query = "SELECT * FROM habitats";
            $statement = $this->db->prepare($query);
            $statement->execute();
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erreur lors de la récupération des habitats : " . $e->getMessage());
            return [];
        }
    }

    public function getHabitatById($id) {
        try {
            $query = "SELECT * FROM habitats WHERE id = :id";
            $statement = $this->db->prepare($query);
            $statement->bindValue(':id', $id, PDO::PARAM_INT);
            $statement->execute();
            return $statement->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erreur lors de la récupération de l'habitat par ID : " . $e->getMessage());
            return null;
        }
    }

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