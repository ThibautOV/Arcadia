<?php

// Inclure le modèle HabitatModel et AnimalModel
require_once __DIR__ . '/../models/HabitatModel.php';  // Assurez-vous que le chemin vers HabitatModel.php est correct
require_once __DIR__ . '/../models/AnimalModel.php';   // Inclure AnimalModel

class HabitatController {
    private $habitatModel;
    private $animalModel;

    public function __construct($db) {
        $this->habitatModel = new HabitatModel($db);  // Utilisation de HabitatModel
        $this->animalModel = new AnimalModel($db);    // Utilisation de AnimalModel
    }

    // Liste des habitats : cette méthode récupère tous les habitats et les passe à la vue
    public function getHabitats() {
        return $this->habitatModel->getAllHabitats();  // Utilisation de la méthode getAllHabitats() de HabitatModel
    }

    // Méthode pour afficher la liste des habitats dans la vue habitat/index.php
    public function listHabitats() {
        $habitats = $this->getHabitats(); // Récupère tous les habitats
        include __DIR__ . '/../views/habitat/index.php'; // Affiche la vue
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
                $this->habitatModel->createHabitat($name, $description, $image_url);
                header("Location: /habitat");
                exit();
            } else {
                $message = "Tous les champs sont requis pour créer un habitat.";
            }
        }
        include __DIR__ . '/../views/habitat/create.php';  // Vue pour créer un habitat
    }

    // Mettre à jour un habitat
    public function updateHabitat($id) {
        $message = '';
        $habitat = $this->habitatModel->getHabitatById($id);  // Récupérer l'habitat existant

        if (!$habitat) {
            $message = "L'habitat spécifié est introuvable.";
            include __DIR__ . '/../views/errors/404.php';
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            $description = trim($_POST['description'] ?? '');
            $image_url = trim($_POST['image_url'] ?? '');

            if (!empty($name) && !empty($description) && !empty($image_url)) {
                $this->habitatModel->updateHabitat($id, $name, $description, $image_url);
                header("Location: /habitat");
                exit();
            } else {
                $message = "Tous les champs sont requis pour mettre à jour cet habitat.";
            }
        }
        include __DIR__ . '/../views/habitat/update.php';  // Vue pour mettre à jour un habitat
    }

    // Supprimer un habitat
    public function deleteHabitat($id) {
        $this->habitatModel->deleteHabitat($id);  // Suppression de l'habitat
        header("Location: /habitat");
        exit();
    }

    // Méthode pour afficher la liste des habitats sur la page d'accueil
    public function listHabitatsOnHomePage() {
        $habitats = $this->getHabitats();
        include __DIR__ . '/../views/home/index.php';  // Chemin de la vue de la page d'accueil
    }
}
?>