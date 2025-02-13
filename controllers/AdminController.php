<?php

require_once __DIR__ . '/../utils/MailUtils.php';
require_once __DIR__ . '/../models/UserModel.php';

class AdminController
{
    private $db;
    private $userModel;

    public function __construct($db)
    {
        $this->db = $db;
        $this->userModel = new UserModel($db);
    }

    public function createUser($firstName, $lastName, $email, $role, $password)
    {
        if (!in_array($role, ['employee', 'veterinarian'])) {
            return 'Rôle invalide.';
        }

        // Hashage du mot de passe
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        // Utilise la méthode createUser du modèle UserModel
        if ($this->userModel->createUser($firstName, $lastName, $email, $role, $hashedPassword)) {
            $subject = 'Bienvenue sur notre plateforme';
            $body = "Bonjour $firstName $lastName,\n\nMerci de vous être inscrit en tant que $role.\n\nBien cordialement,\nL'équipe";

            return MailUtils::sendEmail($email, $subject, $body);
        } else {
            return 'Erreur lors de la création de l\'utilisateur.';
        }
    }

    public function deleteUser($userId)
    {
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
        $query = "SELECT * FROM users";
        $stmt = $this->db->prepare($query);
        $stmt->execute();

        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($users as $user) {
            echo "Utilisateur : " . $user['first_name'] . " " . $user['last_name'] . " - Rôle : " . $user['role'] . "<br>";
        }

        return $users;
    }

    public function getConsultationsCount()
    {
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
        $query = "SELECT consultations.*, animals.name AS animal 
                  FROM consultations 
                  INNER JOIN animals ON consultations.animal_id = animals.id
                  WHERE 1";

        if ($animal) {
            $query .= " AND animals.name = :animal";
        }

        if ($date) {
            $query .= " AND consultations.date = :date";
        }

        $stmt = $this->db->prepare($query);

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
