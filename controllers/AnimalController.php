<?php
require_once __DIR__ . '/../models/AnimalModel.php'; 
require_once __DIR__ . '/../config/database.php';

class AnimalController {
    private $model;

    public function __construct($model) {
        $this->model = $model;
    }

    public function handleRequest() {
        $selectedHabitat = isset($_GET['habitat']) ? $_GET['habitat'] : 'Tous les habitats';

        // Récupérer l'ID de l'animal à partir des paramètres GET
        $animalId = isset($_GET['id']) ? $_GET['id'] : null;

        if ($animalId) {
            // Créer une instance de la base de données et du modèle
            $database = new Database();
            $db = $database->getConnection();
            $animalModel = new AnimalModel($db);

            // Récupérer les détails de l'animal
            $animal = $animalModel->getAnimalById($animalId);

            if ($animal) {
                // Inclure la vue et passer les détails de l'animal
                include __DIR__ . '/../views/animal/detail.php';
            } else {
                echo "Animal non trouvé.";
            }
        } else {
            echo "ID d'animal non fourni.";
        }

        // Gestion de l'ajout ou de la mise à jour d'un animal
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = isset($_POST['id']) ? $_POST['id'] : null;
            $name = $_POST['name'];
            $species = $_POST['species'];
            $health_status = $_POST['health_status'];
            $food = $_POST['food'];
            $image_url = $_POST['image_url'];
            $habitat_id = $_POST['habitat'];
            $description = $_POST['description'];

            error_log("POST data: " . print_r($_POST, true));

            if ($id) {
                $this->model->updateAnimal($id, $name, $species, $health_status, $food, $image_url, $habitat_id, $description);
            } else {
                $this->model->addAnimal($name, $species, $health_status, $food, $image_url, $habitat_id, $description);
            }

            header("Location: manage_animals.php");
            exit;
        }

        // Gestion de la suppression d'un animal
        if (isset($_GET['delete'])) {
            $animalId = $_GET['delete'];
            $this->model->deleteAnimal($animalId);
            header("Location: manage_animals.php");
            exit;
        }

        // Récupération d'un animal pour la modification
        $editAnimal = null;
        if (isset($_GET['edit'])) {
            $editAnimal = $this->model->getAnimalById($_GET['edit']);
        }

        // Récupération des animaux par habitat
        if ($selectedHabitat === "Tous les habitats") {
            $animals = $this->model->getAllAnimals();
        } else {
            $animals = $this->model->getAnimalsByHabitat($selectedHabitat);
        }

        $habitats = $this->model->getHabitats();

        return [
            'animals' => $animals,
            'habitats' => $habitats,
            'selectedHabitat' => $selectedHabitat,
            'editAnimal' => $editAnimal
        ];
    }

    public function listAnimalsByHabitat() {
        $habitatId = isset($_GET['habitat']) ? $_GET['habitat'] : null;
        if ($habitatId) {
            $animals = $this->model->getAnimalsByHabitat($habitatId);
            include __DIR__ . '/../views/animal/list.php';
        } else {
            echo "Veuillez sélectionner un habitat.";
        }
    }

    // Autres méthodes...
}

$controller = new AnimalController(new AnimalModel((new Database())->getConnection()));
$controller->handleRequest();
?>
