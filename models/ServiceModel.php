<?php
class ServiceModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getAllServices() {
        $query = "SELECT * FROM services";
        $statement = $this->db->prepare($query);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createService($name, $description) {
        $query = "INSERT INTO services (name, description) VALUES (:name, :description)";
        $statement = $this->db->prepare($query);
        $statement->bindValue(':name', $name);
        $statement->bindValue(':description', $description);
        $statement->execute();
    }

    public function updateService($id, $name, $description) {
        $query = "UPDATE services SET name = :name, description = :description WHERE id = :id";
        $statement = $this->db->prepare($query);
        $statement->bindValue(':id', $id);
        $statement->bindValue(':name', $name);
        $statement->bindValue(':description', $description);
        $statement->execute();
    }

    public function deleteService($id) {
        $query = "DELETE FROM services WHERE id = :id";
        $statement = $this->db->prepare($query);
        $statement->bindValue(':id', $id);
        $statement->execute();
    }
}
?>