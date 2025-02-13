<?php

class UserModel
{
    private $conn;
    private $db;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function createUser($firstName, $lastName, $email, $role, $password)
    {
        $query = "INSERT INTO users (first_name, last_name, email, role, password) 
                  VALUES (:first_name, :last_name, :email, :role, :password)";
        $stmt = $this->conn->prepare($query);

        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        $stmt->bindParam(':first_name', $firstName);
        $stmt->bindParam(':last_name', $lastName);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':role', $role);
        $stmt->bindParam(':password', $hashedPassword);

        return $stmt->execute();
    }

    public function deleteUser($userId)
    {
        $query = "DELETE FROM users WHERE id = :user_id";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function checkEmailExists($email)
    {
        $query = "SELECT id FROM users WHERE email = :email LIMIT 1";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':email', $email);
        $stmt->execute();

        return $stmt->rowCount() > 0;
    }

    public function getAllUsers()
    {
        $query = "SELECT id, first_name, last_name, email, role FROM users";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUserByEmail($email)
    {
        $query = "SELECT id, first_name, last_name, email, role, password 
                  FROM users WHERE email = :email LIMIT 1";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':email', $email);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function authenticate($email, $password)
    {
        $user = $this->getUserByEmail($email);
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return false;
    }

    public function getUserRole($email)
    {
        $query = "SELECT role FROM users WHERE email = :email LIMIT 1";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':email', $email);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        return $user['role'] ?? null;
    }

    public function updatePassword($userId, $newPassword)
    {
        $query = "UPDATE users SET password = :password WHERE id = :user_id";
        $stmt = $this->conn->prepare($query);

        $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);

        $stmt->bindParam(':password', $hashedPassword);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);

        return $stmt->execute();
    }
}
