<?php
// Models/Review.php

class ReviewModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function submitReview($pseudo, $avis) {
        $stmt = $this->db->prepare("INSERT INTO reviews (pseudo, avis, status) VALUES (:pseudo, :avis, 'pending')");
        $stmt->bindParam(':pseudo', $pseudo);
        $stmt->bindParam(':avis', $avis);
        return $stmt->execute();
    }

    public function getAllReviews() {
        $stmt = $this->db->query("SELECT * FROM reviews WHERE status = 'approved'");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>