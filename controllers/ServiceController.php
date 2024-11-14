<?php
class ServiceController {
    private $serviceModel;

    public function __construct($db) {
        $this->serviceModel = new ServiceModel($db);
    }

    public function listServices() {
        // Récupère tous les services
        $services = $this->serviceModel->getAllServices();
        
        // Vérifie si des services sont disponibles
        if ($services) {
            include 'views/service/index.php';
        } else {
            // Si aucun service n'est disponible, vous pouvez gérer cela avec un message d'erreur ou une vue vide
            echo "Aucun service disponible.";
        }
    }

    public function createService() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $description = $_POST['description'] ?? '';

            if (!empty($name) && !empty($description)) {
                $this->serviceModel->createService($name, $description);
                header("Location: /service");
            } else {
                $message = "Tous les champs sont obligatoires.";
                include 'views/service/create.php';
            }
        } else {
            include 'views/service/create.php';
        }
    }

    public function updateService($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $description = $_POST['description'] ?? '';

            if (!empty($name) && !empty($description)) {
                $this->serviceModel->updateService($id, $name, $description);
                header("Location: /service");
            } else {
                $message = "Tous les champs sont obligatoires.";
                $service = $this->serviceModel->getServiceById($id);
                include 'views/service/update.php';
            }
        } else {
            $service = $this->serviceModel->getServiceById($id);
            include 'views/service/update.php';
        }
    }

    public function deleteService($id) {
        $this->serviceModel->deleteService($id);
        header("Location: /service");
    }
}
?>