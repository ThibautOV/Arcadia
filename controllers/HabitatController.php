<?php
require_once __DIR__ . '/../models/HabitatModel.php';
require_once __DIR__ . '/../models/AnimalModel.php';

class HabitatController
{
    private $habitatModel;
    private $animalModel;

    public function __construct($db)
    {
        $this->habitatModel = new HabitatModel($db);
        $this->animalModel = new AnimalModel($db);
    }

    // Méthode pour gérer les requêtes d'action
    public function handleRequest()
    {
        $message = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $action = $_POST['action'] ?? '';

            switch ($action) {
                case 'create':
                    $name = $_POST['name'] ?? '';
                    $description = $_POST['description'] ?? '';
                    $images = $_POST['images'] ?? '';

                    if (!empty($name) && !empty($description) && !empty($images)) {
                        $this->habitatModel->createHabitat($name, $description, $images);
                        $message = "Habitat créé avec succès.";
                    } else {
                        $message = "Tous les champs sont requis pour créer un habitat.";
                    }
                    break;

                case 'delete':
                    $habitatId = $_POST['habitat_id'] ?? 0;
                    if ($habitatId) {
                        $this->habitatModel->deleteHabitat($habitatId);
                        $message = "Habitat supprimé avec succès.";
                    } else {
                        $message = "ID de l'habitat manquant pour la suppression.";
                    }
                    break;
            }
        }

        return $message;
    }

    // Méthode pour récupérer les habitats
    public function getHabitats()
    {
        return $this->habitatModel->getAllHabitats();
    }

    // Méthode pour afficher la liste des habitats
    public function listHabitats()
    {
        $this->showHabitats();
    }

    // Méthode pour afficher les détails des habitats
    public function showHabitats()
    {
        $habitats = $this->habitatModel->getAllHabitats();
        include 'views/habitat/index.php';
    }

    // Méthode pour récupérer les animaux en fonction de l'habitat avec une requête AJAX
    public function getAnimalsByHabitatAjax()
    {
        // Vérifie si la requête est une requête AJAX en POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = json_decode(file_get_contents("php://input"), true);
            $habitatName = $data['habitat'] ?? '';

            // Vérifie si le nom de l'habitat est spécifié
            if (!empty($habitatName)) {
                try {
                    // Récupère les animaux pour l'habitat spécifié
                    $animals = $this->animalModel->getAnimalsByHabitat($habitatName);

                    // Envoie une réponse JSON avec les données des animaux et le statut de succès
                    header('Content-Type: application/json');
                    echo json_encode([
                        'status' => 'success',
                        'data' => $animals,
                        'message' => count($animals) ? '' : 'Aucun animal trouvé pour cet habitat.'
                    ]);
                    exit;
                } catch (Exception $e) {
                    // En cas d'erreur, renvoie un message d'erreur
                    header('Content-Type: application/json');
                    echo json_encode([
                        'status' => 'error',
                        'message' => 'Erreur lors de la récupération des animaux : ' . $e->getMessage()
                    ]);
                    exit;
                }
            } else {
                // Envoie une réponse JSON avec un message d'erreur si le nom de l'habitat est manquant
                header('Content-Type: application/json');
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Nom de l\'habitat non spécifié.'
                ]);
                exit;
            }
        }

        // Envoie une réponse JSON avec un message d'erreur si la requête est invalide (pas en POST)
        header('Content-Type: application/json');
        echo json_encode([
            'status' => 'error',
            'message' => 'Requête invalide.'
        ]);
        exit;
    }

    // Méthode pour afficher la page des animaux avec le formulaire de filtrage
    public function showAnimalsPage()
    {
        $habitats = $this->habitatModel->getAllHabitats();
        include 'public/animal/list.php';
    }
}