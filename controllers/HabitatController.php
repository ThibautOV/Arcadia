<?php

// Inclure les modèles HabitatModel et AnimalModel
require_once __DIR__ . '/../models/HabitatModel.php';  // Assurez-vous que le chemin vers HabitatModel.php est correct
require_once __DIR__ . '/../models/AnimalModel.php';   // Inclure AnimalModel

class HabitatController {
    private $habitatModel;
    private $animalModel;
    private $db;

    // Constructeur : Ajout de la connexion DB
    public function __construct($db) {
        $this->db = $db;  // Connexion à la base de données
        $this->habitatModel = new HabitatModel($this->db);  // Utilisation de HabitatModel
        $this->animalModel = new AnimalModel($this->db);    // Utilisation de AnimalModel
    }

    // Liste des habitats : cette méthode récupère tous les habitats et les passe à la vue
    public function getHabitats() {
        return $this->habitatModel->getAllHabitats();  // Utilisation de la méthode getAllHabitats() de HabitatModel
    }

    // Méthode pour afficher la liste des habitats dans la vue habitat/index.php
    public function listHabitats() {
        // Récupérer tous les habitats via la méthode getHabitats
        $habitats = $this->getHabitats();

        // Vérifier si la récupération des habitats a fonctionné
        if (!$habitats) {
            $message = "Aucun habitat trouvé.";
            include __DIR__ . '/../views/errors/404.php';  // Afficher un message d'erreur si aucun habitat trouvé
            return;
        }

        // Inclure la vue habitat/index.php qui affichera les habitats
        include __DIR__ . '/../views/habitat/index.php'; 
    }

    // Gérer les différentes actions (création, suppression d'habitat, etc.)
    public function handleRequest() {
        $message = '';

        // Vérifier si une requête POST a été envoyée
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $action = $_POST['action'] ?? null;

            switch ($action) {
                case 'create':
                    // Créer un habitat
                    $name = trim($_POST['name'] ?? '');
                    $description = trim($_POST['description'] ?? '');
                    $image_url = trim($_POST['image_url'] ?? '');

                    if (!empty($name) && !empty($description) && !empty($image_url)) {
                        // Création de l'habitat via le modèle
                        $this->habitatModel->createHabitat($name, $description, $image_url);
                        header("Location: manage_habitats.php");
                        exit();
                    } else {
                        $message = "Tous les champs sont requis pour créer un habitat.";
                    }
                    break;

                case 'delete':
                    // Supprimer un habitat
                    $habitat_id = (int) ($_POST['habitat_id'] ?? 0);
                    if ($habitat_id > 0) {
                        $this->habitatModel->deleteHabitat($habitat_id);
                        header("Location: manage_habitats.php");
                        exit();
                    } else {
                        $message = "Identifiant de l'habitat non valide pour la suppression.";
                    }
                    break;

                default:
                    $message = "Action non définie.";
                    break;
            }
        }

        return $message;
    }

    // Créer un habitat
    public function createHabitat() {
        $message = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            $description = trim($_POST['description'] ?? '');
            $image_url = trim($_POST['image_url'] ?? '');

            if (!empty($name) && !empty($description) && !empty($image_url)) {
                // Créer l'habitat via le modèle
                $this->habitatModel->createHabitat($name, $description, $image_url);
                header("Location: /habitat");
                exit();
            } else {
                $message = "Tous les champs sont requis pour créer un habitat.";
            }
        }

        // Affichage de la vue de création d'habitat
        include __DIR__ . '/../views/habitat/create.php';  
    }

    // Mettre à jour un habitat
    public function updateHabitat($id) {
        $message = '';
        // Récupérer l'habitat existant
        $habitat = $this->habitatModel->getHabitatById($id);

        if (!$habitat) {
            $message = "L'habitat spécifié est introuvable.";
            include __DIR__ . '/../views/errors/404.php';  // Afficher une erreur 404 si l'habitat n'existe pas
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            $description = trim($_POST['description'] ?? '');
            $image_url = trim($_POST['image_url'] ?? '');

            if (!empty($name) && !empty($description) && !empty($image_url)) {
                // Mise à jour de l'habitat
                $this->habitatModel->updateHabitat($id, $name, $description, $image_url);
                header("Location: /habitat");
                exit();
            } else {
                $message = "Tous les champs sont requis pour mettre à jour cet habitat.";
            }
        }
        // Affichage de la vue de mise à jour d'habitat
        include __DIR__ . '/../views/habitat/update.php';  
    }

    // Supprimer un habitat
    public function deleteHabitat($id) {
        // Suppression de l'habitat
        $this->habitatModel->deleteHabitat($id);
        header("Location: /habitat");
        exit();
    }

    // Afficher les détails d'un habitat spécifique
    public function showHabitatDetails($id) {
        // Vérifier si l'id est un entier valide
        if (!is_numeric($id) || $id <= 0) {
            $message = "ID d'habitat invalide.";
            include __DIR__ . '/../views/errors/404.php';  // Afficher une erreur si l'ID n'est pas valide
            return;
        }

        // Récupérer l'habitat par ID
        $habitat = $this->habitatModel->getHabitatById($id);

        // Vérifier si l'habitat existe
        if (!$habitat) {
            $message = "L'habitat spécifié est introuvable.";
            include __DIR__ . '/../views/errors/404.php';  // Afficher une erreur 404 si l'habitat n'existe pas
            return;
        }

        // Récupérer les animaux associés à l'habitat
        $animals = $this->animalModel->getAnimalsByHabitat($id);

        // Passer les variables à la vue
        include __DIR__ . '/../views/habitat/detail.php'; // S'assurer que $habitat et $animals sont envoyés à la vue
    }

    // Méthode pour récupérer les habitats et les transmettre à la vue
    public function showHabitats() {
        $habitats = $this->getHabitats(); // Récupérer tous les habitats
        include __DIR__ . '/../views/habitat/index.php'; // Afficher la vue avec les habitats
    }
}
?>