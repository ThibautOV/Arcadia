<?php
class HabitatModel {
    private $db;

    // Le constructeur attend une connexion à la base de données
    public function __construct($db) {
        $this->db = $db;
    }

    // Méthode pour récupérer tous les habitats
    public function getAllHabitats() {
        $query = "SELECT * FROM habitats";
        $statement = $this->db->prepare($query);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    // Méthode pour créer un habitat
    public function createHabitat($name, $description, $images) {
        // Sérialisation des images en JSON
        $imagesJson = json_encode(explode(',', $images));

        $query = "INSERT INTO habitats (name, description, images) VALUES (:name, :description, :images)";
        $statement = $this->db->prepare($query);
        $statement->bindValue(':name', $name);
        $statement->bindValue(':description', $description);
        $statement->bindValue(':images', $imagesJson);
        $statement->execute();
    }

    // Méthode pour supprimer un habitat
    public function deleteHabitat($id) {
        $query = "DELETE FROM habitats WHERE id = :id";
        $statement = $this->db->prepare($query);
        $statement->bindValue(':id', $id, PDO::PARAM_INT);
        $statement->execute();
    }
}
?>