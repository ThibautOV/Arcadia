<?php
class AnimalModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // Récupérer tous les animaux
    public function getAllAnimals() {
        try {
            $query = "
                SELECT 
                    a.id, a.name, a.species, a.health_status, a.food, a.image_url, 
                    a.description, a.habitat_id, h.name AS habitat
                FROM animals a
                LEFT JOIN habitats h ON a.habitat_id = h.id
            ";
            $statement = $this->db->prepare($query);
            $statement->execute();
            $animals = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $animals;
        } catch (PDOException $e) {
            error_log("Erreur lors de la récupération des animaux : " . $e->getMessage());
            return [];
        }
    }

    // Récupérer les animaux par habitat
    public function getAnimalsByHabitat($habitatId) {
        try {
            $query = "
                SELECT 
                    a.id, a.name, a.species, a.health_status, a.food, a.image_url, 
                    a.description, a.habitat_id, h.name AS habitat
                FROM animals a
                LEFT JOIN habitats h ON a.habitat_id = h.id
                WHERE a.habitat_id = :habitat_id
            ";
            $statement = $this->db->prepare($query);
            $statement->bindValue(':habitat_id', $habitatId, PDO::PARAM_INT);
            $statement->execute();
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erreur lors de la récupération des animaux par habitat : " . $e->getMessage());
            return [];
        }
    }

    // Récupérer un animal par son identifiant
    public function getAnimalById($id) {
        try {
            $query = "
                SELECT 
                    a.id, a.name, a.species, a.health_status, a.food, a.image_url, 
                    a.description, a.habitat_id, h.name AS habitat
                FROM animals a
                LEFT JOIN habitats h ON a.habitat_id = h.id
                WHERE a.id = :id
            ";
            $statement = $this->db->prepare($query);
            $statement->bindValue(':id', $id, PDO::PARAM_INT);
            $statement->execute();
            return $statement->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erreur lors de la récupération de l'animal : " . $e->getMessage());
            return null;
        }
    }

    // Ajouter un animal
    public function addAnimal($name, $species, $health_status, $food, $image_url, $habitat_id, $description) {
        try {
            $query = "
                INSERT INTO animals (name, species, health_status, food, image_url, habitat_id, description) 
                VALUES (:name, :species, :health_status, :food, :image_url, :habitat_id, :description)
            ";
            $statement = $this->db->prepare($query);
            $statement->bindValue(':name', $name);
            $statement->bindValue(':species', $species);
            $statement->bindValue(':health_status', $health_status);
            $statement->bindValue(':food', $food);
            $statement->bindValue(':image_url', $image_url);
            $statement->bindValue(':habitat_id', $habitat_id, PDO::PARAM_INT);
            $statement->bindValue(':description', $description);
            $statement->execute();
        } catch (PDOException $e) {
            error_log("Erreur lors de l'ajout de l'animal : " . $e->getMessage());
        }
    }

    // Mettre à jour un animal
    public function updateAnimal($id, $name, $species, $health_status, $food, $image_url, $habitat_id, $description) {
        try {
            $query = "
                UPDATE animals 
                SET name = :name, species = :species, health_status = :health_status, 
                    food = :food, image_url = :image_url, habitat_id = :habitat_id, description = :description 
                WHERE id = :id
            ";
            $statement = $this->db->prepare($query);
            $statement->bindValue(':name', $name);
            $statement->bindValue(':species', $species);
            $statement->bindValue(':health_status', $health_status);
            $statement->bindValue(':food', $food);
            $statement->bindValue(':image_url', $image_url);
            $statement->bindValue(':habitat_id', $habitat_id, PDO::PARAM_INT);
            $statement->bindValue(':description', $description);
            $statement->bindValue(':id', $id, PDO::PARAM_INT);
            $statement->execute();
        } catch (PDOException $e) {
            error_log("Erreur lors de la mise à jour de l'animal : " . $e->getMessage());
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
            error_log("Erreur lors de la suppression de l'animal : " . $e->getMessage());
        }
    }

    // Récupérer tous les habitats
    public function getHabitats() {
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
}
?>
