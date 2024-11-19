<?php

require_once __DIR__ . '/../models/HabitatModel.php';
require_once __DIR__ . '/../models/AnimalModel.php';

class HabitatController
{
    private $habitatModel;
    private $animalModel;
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
        $this->habitatModel = new HabitatModel($this->db);
        $this->animalModel = new AnimalModel($this->db);
    }

    public function getHabitats()
    {
        return $this->habitatModel->getAllHabitats();
    }

    public function listHabitats()
    {
        $habitats = $this->getHabitats();

        if (!$habitats) {
            $message = "Aucun habitat trouvé.";
            // Correction du chemin d'inclusion de 404.php
            include __DIR__ . '/../public/views/error/404.php';  // Correction ici
            return;
        }

        include __DIR__ . '/../views/habitat/index.php';
    }

    public function listHabitatsOnHomePage()
    {
        $habitats = $this->getHabitats();

        if (!$habitats) {
            $message = "Aucun habitat trouvé.";
            // Correction du chemin d'inclusion de 404.php
            include __DIR__ . '/../public/views/error/404.php';  // Correction ici
            return;
        }

        include __DIR__ . '/../views/home/index.php';
    }

    public function handleRequest()
    {
        $message = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $action = $_POST['action'] ?? null;

            switch ($action) {
                case 'create':
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

    public function createHabitat()
    {
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

        include __DIR__ . '/../views/habitat/create.php';
    }

    public function updateHabitat($id)
    {
        $message = '';

        $habitat = $this->habitatModel->getHabitatById($id);

        if (!$habitat) {
            $message = "L'habitat spécifié est introuvable.";
            // Correction du chemin d'inclusion de 404.php
            include __DIR__ . '/../public/views/error/404.php';  // Correction ici
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

        include __DIR__ . '/../views/habitat/update.php';
    }

    public function deleteHabitat($id)
    {
        $this->habitatModel->deleteHabitat($id);
        header("Location: /habitat");
        exit();
    }

    public function showHabitatDetails($id)
    {
        if (!is_numeric($id) || $id <= 0) {
            $message = "ID d'habitat invalide.";
            // Correction du chemin d'inclusion de 404.php
            include __DIR__ . '/../public/views/error/404.php';  // Correction ici
            return;
        }

        $habitat = $this->habitatModel->getHabitatById($id);

        if (!$habitat) {
            $message = "L'habitat spécifié est introuvable.";
            // Correction du chemin d'inclusion de 404.php
            include __DIR__ . '/../public/views/error/404.php';  // Correction ici
            return;
        }

        // Récupérer les animaux associés à l'habitat
        $animals = $this->animalModel->getAnimalsByHabitat($id);

        // Passer les variables à la vue
        include __DIR__ . '/../views/habitat/detail.php';
    }

    public function showHabitats()
    {
        $habitats = $this->getHabitats();
        include __DIR__ . '/../views/habitat/index.php';
    }
}
?>