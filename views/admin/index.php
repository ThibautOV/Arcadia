<?php
// index.php
require_once 'config.php';

// Récupérer l'action de la requête, ou par défaut 'home'
$action = $_GET['action'] ?? 'home';

// Créer une connexion à la base de données
$dbConnection = getDatabaseConnection();

switch ($action) {
    case 'home':
        require 'Controllers/HomeController.php';
        $controller = new HomeController();
        $controller->index();
        break;
    
    case 'listServices':
        require 'Controllers/ServiceController.php';
        $controller = new ServiceController();
        $controller->listServices();
        break;

    case 'listHabitats':
        require 'models/HabitatModel.php';
        require 'Controllers/HabitatController.php';

        // Instancier le modèle Habitat avec la connexion à la base de données
        $habitatModel = new HabitatModel($dbConnection);
        $habitatController = new HabitatController($dbConnection);

        // Récupérer la liste des habitats
        $habitats = $habitatModel->getAllHabitats();

        // Afficher les habitats
        $habitatController->showHabitats();
        break;

    case 'listAnimals':
        require 'models/AnimalModel.php';
        require 'Controllers/AnimalController.php';

        // Instancier le modèle Animal avec la connexion à la base de données
        $animalModel = new AnimalModel($dbConnection);

        // Créer une instance du contrôleur AnimalController
        $animalController = new AnimalController($animalModel);

        // Vérifier si un habitat est sélectionné
        $selectedHabitat = $_GET['habitat'] ?? '';

        // Récupérer les animaux en fonction de l'habitat sélectionné
        if ($selectedHabitat) {
            $animalsData = $animalController->getAnimalsByHabitat($selectedHabitat);
        } else {
            $animalsData = $animalController->getAllAnimals();
        }

        $animals = $animalsData['animals'];
        $habitats = $animalsData['habitats'];  // La liste des habitats disponibles

        // Charger la vue des animaux
        require 'views/animal/list.php';
        break;

    default:
        echo "Page non trouvée.";
        break;
}
?>