<?php
session_start(); // Démarrer la session

class EmployeeController {
    private $reviewModel;
    private $animalModel;
    private $foodRecordModel;

    public function __construct($pdo) {
        $this->reviewModel = new ReviewModel($pdo);
        $this->animalModel = new AnimalModel($pdo);
        $this->foodRecordModel = new FoodRecordModel($pdo);
    }

    // Enregistrer la consommation d'alimentation des animaux
    public function recordFoodConsumption() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Vérification de l'authentification de l'employé
            if (!isset($_SESSION['user_id'])) {
                echo json_encode(['success' => false, 'message' => 'Utilisateur non authentifié']);
                exit;
            }

            // Vérification des données
            $animal_id = $_POST['animal_id'];
            $food = $_POST['food'];
            $quantity = $_POST['quantity'];
            $date = $_POST['date'];
            $time = $_POST['time'];
            $employee_id = $_SESSION['user_id']; // Supposons que l'ID de l'employé est stocké dans la session

            if (empty($animal_id) || empty($food) || empty($quantity) || empty($date) || empty($time)) {
                echo json_encode(['success' => false, 'message' => 'Veuillez remplir tous les champs.']);
                exit;
            }

            // Combiner la date et l'heure en un seul champ datetime
            $feeding_time = $date . ' ' . $time;

            // Appel de la méthode d'ajout de la consommation alimentaire
            if ($this->foodRecordModel->addFoodRecord($animal_id, $food, $quantity, $feeding_time, $employee_id)) {
                echo json_encode([
                    'success' => true,
                    'message' => 'Alimentation enregistrée avec succès!'
                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'Erreur lors de l\'enregistrement de l\'alimentation.'
                ]);
            }
            exit; // Terminer l'exécution après la réponse AJAX
        }

        // Si la requête n'est pas une POST, renvoyer un message d'erreur
        echo json_encode(['success' => false, 'message' => 'Erreur de traitement']);
    }
}
?>