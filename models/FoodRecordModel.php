<?php

class FoodRecordModel {
    private $pdo;

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
}
?>