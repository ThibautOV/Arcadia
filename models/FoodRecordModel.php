<?php

class FoodRecordModel {
    private $pdo;

    // Constructeur pour initialiser la connexion à la base de données
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Ajouter un enregistrement alimentaire
    public function addFoodRecord($animal_id, $food, $quantity, $feeding_time, $employee_id) {
        // Préparer l'insertion dans la base de données
        $stmt = $this->pdo->prepare("INSERT INTO food_records (animal_id, food_type, quantity, feeding_time, employee_id) 
                                     VALUES (?, ?, ?, ?, ?)");
        return $stmt->execute([$animal_id, $food, $quantity, $feeding_time, $employee_id]);
    }

    // Récupérer les enregistrements alimentaires pour un animal donné
    public function getFoodRecordsByAnimalId($animalId) {
        // Requête pour obtenir les enregistrements alimentaires par animal_id
        $query = "SELECT food_type, quantity, feeding_time, employee_id FROM food_records WHERE animal_id = :animal_id ORDER BY feeding_time DESC";
        
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(':animal_id', $animalId, PDO::PARAM_INT);
        $stmt->execute();
        
        // Retourner les résultats sous forme de tableau associatif
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
