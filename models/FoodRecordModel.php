<?php
class FoodRecordModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function addFoodRecord($animalId, $foodGiven, $quantity, $date) {
        // Ajouter un enregistrement de nourriture
        $stmt = $this->db->prepare("INSERT INTO food_records (animal_id, food_given, quantity, date) VALUES (:animal_id, :food_given, :quantity, :date)");
        $stmt->bindParam(':animal_id', $animalId);
        $stmt->bindParam(':food_given', $foodGiven);
        $stmt->bindParam(':quantity', $quantity);
        $stmt->bindParam(':date', $date);
        return $stmt->execute();
    }

    public function getFoodRecordsByAnimal($animalId) {
        $stmt = $this->db->prepare("SELECT * FROM food_records WHERE animal_id = :animal_id");
        $stmt->bindParam(':animal_id', $animalId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>