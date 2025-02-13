<?php
require_once __DIR__ . '/../models/AnimalModel.php'; 
require_once __DIR__ . '/../config/database.php';

class AnimalController {
    private $model;

    public function __construct($model) {
        $this->model = $model;
    }

    public function handleRequest() {
        $selectedHabitat = $_GET['habitat'] ?? 'Tous les habitats';
        $animalId = $_GET['id'] ?? null;

        if ($animalId) {
            $animal = $this->model->getAnimalById($animalId);
            if ($animal) {
                include __DIR__ . '/../views/animal/detail.php';
            } else {
                echo "Animal non trouvé.";
            }
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;
            $name = $_POST['name'] ?? 'Non spécifié';
            $species = $_POST['species'] ?? 'Non spécifié';
            $health_status = $_POST['health_status'] ?? 'Non spécifié';
            $food = $_POST['food'] ?? 'Non spécifié';
            $image_url = $_POST['image_url'] ?? '';
            $habitat_id = $_POST['habitat'] ?? null;
            $description = $_POST['description'] ?? 'Pas de description disponible';

            if ($id) {
                $this->model->updateAnimal($id, $name, $species, $health_status, $food, $image_url, $habitat_id, $description);
            } else {
                $this->model->addAnimal($name, $species, $health_status, $food, $image_url, $habitat_id, $description);
            }

            header("Location: manage_animals.php");
            exit;
        }

        if (isset($_GET['delete'])) {
            $this->model->deleteAnimal($_GET['delete']);
            header("Location: manage_animals.php");
            exit;
        }

        $animals = $this->model->getAllAnimals();
        $habitats = $this->model->getHabitats();

        return [
            'animals' => $animals,
            'habitats' => $habitats,
            'selectedHabitat' => $selectedHabitat
        ];
    }
}

$controller = new AnimalController(new AnimalModel((new Database())->getConnection()));
$controller->handleRequest();
?>
