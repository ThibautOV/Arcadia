<?php

class AnimalController {
    private $model;

    // Constructeur qui reçoit une instance de AnimalModel
    public function __construct($model) {
        $this->model = $model;
    }

    // Récupérer tous les animaux
    public function getAllAnimals() {
        $animals = $this->model->getAllAnimals();  // Récupérer tous les animaux
        return $animals;
    }

    // Récupérer les animaux par habitat
    public function getAnimalsByHabitat($habitat) {
        if ($habitat === "Tous les habitats") {
            // Si "Tous les habitats" est sélectionné, on retourne tous les animaux
            $animals = $this->model->getAllAnimals();
        } else {
            // Sinon, on filtre les animaux par habitat
            $animals = $this->model->getAnimalsByHabitat($habitat);
        }

        return $animals;
    }

    // Gérer la requête et l'ajout d'un animal
    public function handleRequest() {
        // Vérifier l'habitat sélectionné dans la requête
        $selectedHabitat = isset($_GET['habitat']) ? $_GET['habitat'] : 'Tous les habitats';

        // Si un animal est ajouté
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $breed = $_POST['breed'];
            $health_status = $_POST['health_status'];
            $food = $_POST['food'];
            $image_url = $_POST['image_url'];
            $habitat = $_POST['habitat'];
            $description = $_POST['description'];  // Récupérer la description

            // Ajouter l'animal dans la base de données
            $this->model->addAnimal($name, $breed, $health_status, $food, $image_url, $habitat, $description);
        }

        // Si un animal doit être supprimé
        if (isset($_GET['delete'])) {
            $animalId = $_GET['delete'];
            // Appel à la méthode du modèle pour supprimer l'animal
            $this->model->deleteAnimal($animalId);
            // Redirection après suppression pour éviter le rechargement de la page avec l'URL contenant le paramètre 'delete'
            header("Location: manage_animals.php");
            exit; // Assurez-vous que le script s'arrête après la redirection
        }

        // Récupérer les animaux en fonction de l'habitat sélectionné
        $animals = $this->getAnimalsByHabitat($selectedHabitat);

        // Liste d'habitats statiques
        $habitats = ['Savane', 'Jungle', 'Marais'];

        return [
            'animals' => $animals,
            'habitats' => $habitats,  // Ajouter la liste des habitats
            'selectedHabitat' => $selectedHabitat
        ];
    }
}