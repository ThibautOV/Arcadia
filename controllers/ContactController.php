<?php
// Controllers/ContactController.php

class ContactController {
    public function showForm() {
        require 'Views/contact/form.php';
    }

    public function submitContact() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST['title'];
            $description = $_POST['description'];
            $email = $_POST['email'];

            // Envoyer l'email (à implémenter)
            // mail($to, $title, $description, $headers);

            // Redirection après soumission
            header("Location: index.php?action=home");
            exit();
        }
    }
}
?>