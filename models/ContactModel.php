<?php
class ContactModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function sendContactMessage($title, $description, $email) {
        // Envoi du message de contact à la base de données
        $stmt = $this->db->prepare("INSERT INTO contacts (title, description, email) VALUES (:title, :description, :email)");
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':email', $email);
        return $stmt->execute();
    }
}
?>