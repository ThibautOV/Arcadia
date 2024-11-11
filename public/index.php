<?php
// index.php
require_once 'config.php';

// Récupérer l'action de la requête, ou par défaut 'home'
$action = $_GET['action'] ?? 'home';

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
        // Inclure le fichier du modèle HabitatModel
        require 'models/HabitatModel.php';

        // Créer une connexion à la base de données
        $dbConnection = getDatabaseConnection();

        // Instancier le modèle des habitats avec la connexion à la base de données
        $habitatModel = new HabitatModel($dbConnection);  // Le modèle est maintenant bien instancié

        // Inclure le fichier du contrôleur HabitatController
        require 'Controllers/HabitatController.php';

        // Instancier le contrôleur des habitats et lui passer le modèle
        $habitatController = new HabitatController($dbConnection);  // Le modèle est bien passé ici

        // Appeler la méthode listHabitats et récupérer les données
        $habitatController->showHabitats();  // Appel direct à la méthode du contrôleur
        break;

    // Nouveau cas pour la gestion des animaux
    case 'listAnimals':
        require 'models/AnimalModel.php';

        // Créer une connexion à la base de données
        $dbConnection = getDatabaseConnection();

        // Instancier le modèle des animaux avec la connexion à la base de données
        $animalModel = new AnimalModel($dbConnection);  // Le modèle est maintenant bien instancié

        // Inclure le fichier du contrôleur AnimalController
        require 'Controllers/AnimalController.php';

        // Instancier le contrôleur des animaux et lui passer le modèle
        $animalController = new AnimalController($animalModel);  // Le modèle est bien passé ici

        // Appeler la méthode handleRequest et récupérer les données
        $data = $animalController->handleRequest();  // Le modèle est déjà passé au constructeur
        $animals = $data['animals'];
        $habitats = $data['habitats'];
        $selectedHabitat = $data['selectedHabitat'];

        // Charger la vue des animaux
        require 'views/animal/list.php';
        break;

    // Ajoutez d'autres routes pour chaque fonctionnalité si nécessaire
    default:
        echo "Page non trouvée.";
        break;
}
?>