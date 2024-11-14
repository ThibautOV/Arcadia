<?php
class UserModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Créer un utilisateur
    public function createUser($firstName, $lastName, $email, $role, $password) {
        $query = "INSERT INTO users (first_name, last_name, email, role, password) VALUES (:first_name, :last_name, :email, :role, :password)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':first_name', $firstName);
        $stmt->bindParam(':last_name', $lastName);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':role', $role);
        $stmt->bindParam(':password', $password);

        return $stmt->execute();
    }

    // Supprimer un utilisateur
    public function deleteUser($userId) {
        $query = "DELETE FROM users WHERE id = :user_id";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':user_id', $userId);

        return $stmt->execute();
    }

    // Vérifier si l'email existe déjà
    public function checkEmailExists($email) {
        $query = "SELECT id FROM users WHERE email = :email LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        return $stmt->rowCount() > 0;
    }

    // Récupérer tous les utilisateurs
    public function getAllUsers() {
        $query = "SELECT id, first_name, last_name, email, role FROM users";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}