<?php
// NoSql.php

class NoSql {
    private $dataFile;

    public function __construct($file = 'consultations.json') {
        $this->dataFile = $file;
    }

    public function increaseConsultation($animalName) {
        $data = $this->getData();
        if (isset($data[$animalName])) {
            $data[$animalName]++;
        } else {
            $data[$animalName] = 1;
        }
        $this->saveData($data);
    }

    private function getData() {
        if (!file_exists($this->dataFile)) {
            return [];
        }
        return json_decode(file_get_contents($this->dataFile), true);
    }

    private function saveData($data) {
        file_put_contents($this->dataFile, json_encode($data, JSON_PRETTY_PRINT));
    }

    public function getConsultations() {
        return $this->getData();
    }

    // Nouvelle méthode pour récupérer les avis
    public function getReviews() {
        $data = $this->getData();
        return isset($data['reviews']) ? $data['reviews'] : [];
    }
}
?>