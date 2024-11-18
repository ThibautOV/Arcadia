<?php

class AnimalController
{
    private $model;


    public function __construct($model)
    {
        $this->model = $model;
    }


    public function getAllAnimals()
    {
        $animals = $this->model->getAllAnimals();
        return $animals;
    }


    public function getAnimalsByHabitat($habitat)
    {
        if ($habitat === "Tous les habitats") {

            $animals = $this->model->getAllAnimals();
        } else {

            $animals = $this->model->getAnimalsByHabitat($habitat);
        }

        return $animals;
    }


    public function handleRequest()
    {

        $selectedHabitat = isset($_GET['habitat']) ? $_GET['habitat'] : 'Tous les habitats';


        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $breed = $_POST['breed'];
            $health_status = $_POST['health_status'];
            $food = $_POST['food'];
            $image_url = $_POST['image_url'];
            $habitat = $_POST['habitat'];
            $description = $_POST['description'];


            $this->model->addAnimal($name, $breed, $health_status, $food, $image_url, $habitat, $description);
        }


        if (isset($_GET['delete'])) {
            $animalId = $_GET['delete'];

            $this->model->deleteAnimal($animalId);

            header("Location: manage_animals.php");
            exit;
        }


        $animals = $this->getAnimalsByHabitat($selectedHabitat);


        $habitats = ['Savane', 'Jungle', 'Marais'];

        return [
            'animals' => $animals,
            'habitats' => $habitats,
            'selectedHabitat' => $selectedHabitat
        ];
    }
}
