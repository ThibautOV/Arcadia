<?php
class ServiceController {
    public function listServices() {
        // Utiliser showServices pour afficher la liste des services
        $this->showServices();
    }

    public function showServices() {
        // Exemple de services en dur (peut être remplacé par une récupération depuis la base de données)
        $services = [
            ['name' => 'Restauration', 'description' => 'Service de restauration avec diverses options.'],
            ['name' => 'Visite guidée', 'description' => 'Visite des habitats avec un guide expérimenté.'],
            ['name' => 'Petit train', 'description' => 'Tour du zoo en petit train.']
        ];
        include 'views/service/index.php';
    }
}
?>