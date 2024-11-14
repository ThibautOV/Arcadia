<?php
// HomeController.php

require_once 'model/Database.php';
require_once 'NoSql.php'; // Pour les avis NoSQL

class HomeController {
    private $db;
    private $noSql;

    public function __construct($db) {
        $this->db = $db;
        $this->noSql = new NoSql(); // Initialiser la classe NoSQL
    }

    public function index() {
        // Récupération des habitats depuis la base de données
        $habitats = $this->getHabitats();
        
        // Récupération des avis depuis le fichier NoSQL
        $reviews = $this->noSql->getReviews();

        // Chargement de la vue avec les données
        include 'views/home/index.php';
    }

    private function getHabitats() {
        $stmt = $this->db->prepare("SELECT id, name, description, image_url FROM habitats");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>