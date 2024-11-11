<?php

class UserModel {
    private $conn;
    private $table_name = "users"; // Nom de la table des utilisateurs

    public function __construct($db) {
        $this->conn = $db;
    }

    // Récupérer tous les utilisateurs
    public function getAllUsers() {
        $query = "SELECT id, first_name, last_name, email, role FROM " . $this->table_name;
        
        // Préparer et exécuter la requête
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        // Récupérer les résultats
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC); // Stocker le résultat dans une variable
        
        // Retourner le tableau des utilisateurs
        return $users;
    }

    // Créer un utilisateur
    public function createUser($firstName, $lastName, $email, $role, $password) {
        $query = "INSERT INTO " . $this->table_name . " (first_name, last_name, email, role, password) 
                  VALUES (:first_name, :last_name, :email, :role, :password)";

        $stmt = $this->conn->prepare($query);

        // Sécuriser les données en les liant avec les paramètres
        $stmt->bindParam(':first_name', $firstName);
        $stmt->bindParam(':last_name', $lastName);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':role', $role);
        
        // Créer une variable pour stocker le mot de passe hashé
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        
        // Lier la variable $hashedPassword à la requête
        $stmt->bindParam(':password', $hashedPassword);

        // Exécuter la requête et vérifier le succès
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    // Supprimer un utilisateur
    public function deleteUser($userId) {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $userId);

        // Exécuter la requête et vérifier le succès
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }
}
?>