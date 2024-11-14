<?php

require_once __DIR__ . '/../utils/MailUtils.php';  // Inclure MailUtils

class AdminController {

    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // Méthode pour créer un utilisateur
    public function createUser($firstName, $lastName, $email, $role, $password) {
        // Validation du rôle
        if (!in_array($role, ['employe', 'veterinaire'])) {
            return 'Rôle invalide.';
        }

        // Hash du mot de passe
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        // Requête pour insérer l'utilisateur dans la base de données
        $query = "INSERT INTO users (first_name, last_name, email, role, password) 
                  VALUES (:first_name, :last_name, :email, :role, :password)";

        // Préparation de la requête
        $stmt = $this->db->prepare($query);
        
        // Liaison des paramètres
        $stmt->bindParam(':first_name', $firstName);
        $stmt->bindParam(':last_name', $lastName);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':role', $role);
        $stmt->bindParam(':password', $hashedPassword);

        // Exécution de la requête
        if ($stmt->execute()) {
            // Envoi de l'email après la création de l'utilisateur
            $subject = 'Bienvenue sur notre plateforme';
            $body = "Bonjour $firstName $lastName,\n\nMerci de vous être inscrit en tant que $role.\n\nBien cordialement,\nL'équipe";
            
            // Utilisation de MailUtils pour envoyer l'email
            return MailUtils::sendEmail($email, $subject, $body);
        } else {
            return 'Erreur lors de la création de l\'utilisateur.';
        }
    }

    // Méthode pour supprimer un utilisateur
    public function deleteUser($userId) {
        // Requête pour supprimer un utilisateur
        $query = "DELETE FROM users WHERE id = :user_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':user_id', $userId);

        // Exécution de la requête
        if ($stmt->execute()) {
            return 'Utilisateur supprimé avec succès.';
        } else {
            return 'Erreur lors de la suppression de l\'utilisateur.';
        }
    }

    // Méthode pour obtenir tous les utilisateurs
    public function getUsers() {
        $query = "SELECT * FROM users";
        $stmt = $this->db->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Méthode pour obtenir le nombre de consultations par animal
    public function getConsultationsCount() {
        $query = "SELECT animal, COUNT(*) AS consultation_count FROM consultations GROUP BY animal";
        $stmt = $this->db->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Méthode pour obtenir les consultations avec filtres sur animal et date
    public function getFilteredConsultations($animal = null, $date = null) {
        $query = "SELECT * FROM consultations WHERE 1";

        // Ajouter les filtres
        if ($animal) {
            $query .= " AND animal = :animal";
        }
        if ($date) {
            $query .= " AND date = :date";
        }

        // Préparer la requête
        $stmt = $this->db->prepare($query);

        // Lier les paramètres
        if ($animal) {
            $stmt->bindParam(':animal', $animal);
        }
        if ($date) {
            $stmt->bindParam(':date', $date);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>