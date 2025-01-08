<?php

require_once '../config/config.php';
require_once '../controllers/HomeController.php';
require_once '../controllers/ServiceController.php';
require_once '../controllers/HabitatController.php'; 
require_once '../controllers/AnimalController.php';
require_once '../controllers/AuthController.php';
require_once '../controllers/ContactController.php';

$database = new Database();
$db = $database->getConnection(); 

function loadView($viewPath, $data = []) {
    extract($data);
    include "../views/{$viewPath}";
}

$action = isset($_GET['action']) ? $_GET['action'] : 'home'; 

switch ($action) {
    case 'home':
        $habitatController = new HabitatController($db);
        $habitatController->listHabitatsOnHomePage(); 
        break;

    case 'service':
        $controller = new ServiceController($db);
        $controller->listServices(); 
        break;

    case 'habitat':
        $controller = new HabitatController($db);
        $controller->listHabitats();
        break;

    case 'contact':
        $controller = new ContactController();
        $controller->showForm();
        break;

    case 'login':
        $controller = new AuthController($db);
        $controller->login();
        break;

    case 'animal':
        if (isset($_GET['id'])) {
            $controller = new AnimalController(new AnimalModel($db));
            $controller->handleRequest();
        } else {
            $controller = new AnimalController(new AnimalModel($db));
            $controller->listAnimalsByHabitat();
        }
        break;

    default:
        loadView('errors/404.php');
        break;
}
?>
