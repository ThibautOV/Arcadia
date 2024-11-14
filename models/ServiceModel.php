<?php

class ServiceModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // Récupère tous les services
    public function getAllServices() {
        try {
            $query = "SELECT * FROM services";
            $statement = $this->db->prepare($query);
            $statement->execute();
            // Retourner les résultats sous forme de tableau associatif
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Si une erreur survient lors de la récupération des services, renvoyer un tableau vide
            return [];
        }
    }

    // Récupère un service par son ID
    public function getServiceById($id) {
        try {
            $query = "SELECT * FROM services WHERE id = :id";
            $statement = $this->db->prepare($query);
            $statement->bindValue(':id', $id, PDO::PARAM_INT);
            $statement->execute();

            // Retourner le service s'il existe
            if ($statement->rowCount() > 0) {
                return $statement->fetch(PDO::FETCH_ASSOC);
            } else {
                return null; // Aucun service trouvé
            }
        } catch (PDOException $e) {
            // En cas d'erreur lors de la récupération, retourner null
            return null;
        }
    }

    // Créer un nouveau service
    public function createService($name, $description) {
        try {
            $query = "INSERT INTO services (name, description) VALUES (:name, :description)";
            $statement = $this->db->prepare($query);
            $statement->bindValue(':name', $name);
            $statement->bindValue(':description', $description);
            $statement->execute();
        } catch (PDOException $e) {
            // Gestion des erreurs d'insertion
            throw new Exception("Error creating service: " . $e->getMessage());
        }
    }

    // Met à jour un service existant
    public function updateService($id, $name, $description) {
        try {
            $query = "UPDATE services SET name = :name, description = :description WHERE id = :id";
            $statement = $this->db->prepare($query);
            $statement->bindValue(':id', $id);
            $statement->bindValue(':name', $name);
            $statement->bindValue(':description', $description);
            $statement->execute();
        } catch (PDOException $e) {
            // Gestion des erreurs de mise à jour
            throw new Exception("Error updating service: " . $e->getMessage());
        }
    }

    // Supprime un service
    public function deleteService($id) {
        try {
            $query = "DELETE FROM services WHERE id = :id";
            $statement = $this->db->prepare($query);
            $statement->bindValue(':id', $id);
            $statement->execute();
        } catch (PDOException $e) {
            // Gestion des erreurs de suppression
            throw new Exception("Error deleting service: " . $e->getMessage());
        }
    }
}
?>