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


        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);


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

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function getConsultationsCount()
    {
        $query = "SELECT animal, COUNT(*) AS consultation_count FROM consultations GROUP BY animal";
        $stmt = $this->db->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function getFilteredConsultations($animal = null, $date = null)
    {
        $query = "SELECT * FROM consultations WHERE 1";


        if ($animal) {
            $query .= " AND animal = :animal";
        }
        if ($date) {
            $query .= " AND date = :date";
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
