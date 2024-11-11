<?php

class AnimalModel {
    private $pdo;

    // Constructeur pour injecter la connexion PDO
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Récupérer tous les animaux
    public function getAllAnimals() {
        $stmt = $this->pdo->query("SELECT * FROM animals");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Récupérer les animaux par habitat
    public function getAnimalsByHabitat($habitat) {
        $stmt = $this->pdo->prepare("SELECT * FROM animals WHERE habitat = :habitat");
        $stmt->execute(['habitat' => $habitat]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Ajouter un animal
    public function addAnimal($name, $breed, $health_status, $food, $image_url, $habitat, $description) {
        $stmt = $this->pdo->prepare("INSERT INTO animals (name, breed, health_status, food, image_url, habitat, description) 
                                     VALUES (:name, :breed, :health_status, :food, :image_url, :habitat, :description)");
        $stmt->execute([
            'name' => $name,
            'breed' => $breed,
            'health_status' => $health_status,
            'food' => $food,
            'image_url' => $image_url,
            'habitat' => $habitat,
            'description' => $description
        ]);
    }

    // Supprimer un animal par ID
    public function deleteAnimal($animalId) {
        $stmt = $this->pdo->prepare("DELETE FROM animals WHERE id = :id");
        $stmt->bindParam(':id', $animalId, PDO::PARAM_INT);
        $stmt->execute();
    }
}