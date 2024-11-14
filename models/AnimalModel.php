<?php
class AnimalModel {
    private $db;

    public function __construct($db) {
        // Assurer que la connexion à la base de données est bien initialisée
        $this->db = $db;
    }

    // Récupérer tous les animaux
    public function getAllAnimals() {
        try {
            $query = "SELECT * FROM animals";
            $statement = $this->db->prepare($query);
            $statement->execute();
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Log l'erreur et retourne un tableau vide en cas d'erreur
            error_log("Erreur lors de la récupération des animaux : " . $e->getMessage());
            return [];
        }
    }

    // Récupérer les animaux par habitat
    public function getAnimalsByHabitat($habitatId) {
        try {
            $query = "SELECT * FROM animals WHERE habitat_id = :habitat_id";
            $statement = $this->db->prepare($query);
            $statement->bindValue(':habitat_id', $habitatId, PDO::PARAM_INT);
            $statement->execute();
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Log l'erreur et retourne un tableau vide en cas d'erreur
            error_log("Erreur lors de la récupération des animaux par habitat : " . $e->getMessage());
            return [];
        }
    }

    // Ajouter un animal
    public function addAnimal($name, $breed, $health_status, $food, $image_url, $habitat_id, $description) {
        try {
            $query = "INSERT INTO animals (name, breed, health_status, food, image_url, habitat_id, description) 
                      VALUES (:name, :breed, :health_status, :food, :image_url, :habitat_id, :description)";
            $statement = $this->db->prepare($query);
            $statement->bindValue(':name', $name);
            $statement->bindValue(':breed', $breed);
            $statement->bindValue(':health_status', $health_status);
            $statement->bindValue(':food', $food);
            $statement->bindValue(':image_url', $image_url);
            $statement->bindValue(':habitat_id', $habitat_id, PDO::PARAM_INT);
            $statement->bindValue(':description', $description);
            $statement->execute();
        } catch (PDOException $e) {
            // Log l'erreur et ne rien supprimer
            error_log("Erreur lors de l'ajout de l'animal : " . $e->getMessage());
        }
    }

    // Supprimer un animal
    public function deleteAnimal($id) {
        try {
            $query = "DELETE FROM animals WHERE id = :id";
            $statement = $this->db->prepare($query);
            $statement->bindValue(':id', $id, PDO::PARAM_INT);
            $statement->execute();
        } catch (PDOException $e) {
            // Log l'erreur et ne rien supprimer
            error_log("Erreur lors de la suppression de l'animal : " . $e->getMessage());
        }
    }
}
?>