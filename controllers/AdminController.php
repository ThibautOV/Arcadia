<?php

require_once __DIR__ . '/../utils/MailUtils.php';

class AdminController
{

    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function createUser($firstName, $lastName, $email, $role, $password)
    {
        if (!in_array($role, ['employe', 'veterinaire'])) {
            return 'Rôle invalide.';
        }

        // Hashage du mot de passe
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        // Requête pour insérer un utilisateur
        $query = "INSERT INTO users (first_name, last_name, email, role, password) 
                  VALUES (:first_name, :last_name, :email, :role, :password)";

        $stmt = $this->db->prepare($query);

        $stmt->bindParam(':first_name', $firstName);
        $stmt->bindParam(':last_name', $lastName);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':role', $role);
        $stmt->bindParam(':password', $hashedPassword);

        if ($stmt->execute()) {
            $subject = 'Bienvenue sur notre plateforme';
            $body = "Bonjour $firstName $lastName,\n\nMerci de vous être inscrit en tant que $role.\n\nBien cordialement,\nL'équipe";

            return MailUtils::sendEmail($email, $subject, $body);
        } else {
            return 'Erreur lors de la création de l\'utilisateur.';
        }
    }

    public function deleteUser($userId)
    {
        // Requête pour supprimer un utilisateur
        $query = "DELETE FROM users WHERE id = :user_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':user_id', $userId);

        if ($stmt->execute()) {
            return 'Utilisateur supprimé avec succès.';
        } else {
            return 'Erreur lors de la suppression de l\'utilisateur.';
        }
    }

    public function getUsers()
    {
        // Requête pour récupérer tous les utilisateurs
        $query = "SELECT * FROM users";
        $stmt = $this->db->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getConsultationsCount()
    {
        // Requête modifiée pour obtenir le nombre de consultations par animal avec jointure sur la table animals
        $query = "SELECT animals.name AS animal, COUNT(consultations.id) AS consultation_count
                  FROM consultations
                  INNER JOIN animals ON consultations.animal_id = animals.id
                  GROUP BY animals.id";

        $stmt = $this->db->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getFilteredConsultations($animal = null, $date = null)
    {
        // Base de la requête SQL avec jointure pour récupérer le nom de l'animal
        $query = "SELECT consultations.*, animals.name AS animal 
                  FROM consultations 
                  INNER JOIN animals ON consultations.animal_id = animals.id
                  WHERE 1";

        // Ajouter un filtre sur l'animal si précisé
        if ($animal) {
            $query .= " AND animals.name = :animal";  // Recherche par nom d'animal
        }

        // Ajouter un filtre sur la date si précisé
        if ($date) {
            $query .= " AND consultations.date = :date";
        }

        $stmt = $this->db->prepare($query);

        // Lier les paramètres si nécessaires
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