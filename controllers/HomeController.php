<?php

// Utilisation de __DIR__ pour obtenir le chemin absolu du répertoire courant
require_once __DIR__ . '/../config/Database.php';  // Le fichier Database.php se trouve dans le dossier config
require_once __DIR__ . '/../config/NoSql.php';  // Le fichier NoSql.php se trouve aussi dans le dossier config

class HomeController
{
    private $db;
    private $noSql;

    // Constructeur de la classe HomeController
    public function __construct($db)
    {
        $this->db = $db;
        $this->noSql = new NoSql();  // On crée l'instance de NoSql
    }

    // Fonction pour afficher la page d'accueil
    public function index()
    {
        // Récupération des habitats et affichage de la vue
        $habitats = $this->getHabitats();
        include __DIR__ . '/../public/views/home/index.php';  // Le chemin de la vue est aussi ajusté
    }

    // Fonction pour récupérer les habitats
    private function getHabitats()
    {
        // Préparation et exécution de la requête SQL pour récupérer les habitats
        $stmt = $this->db->prepare("SELECT id, name, description, image_url FROM habitats");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);  // Retour des résultats sous forme de tableau associatif
    }
}