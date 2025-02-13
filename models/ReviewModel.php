<?php
// Inclure la classe Database avec un chemin absolu basé sur __DIR__
require_once __DIR__ . '/../config/database.php'; // Utilisation du chemin absolu pour éviter les erreurs de chemin

class ReviewModel {
    private $db;

    public function __construct() {
        try {
            // Obtenir la connexion à la base de données
            $this->db = (new Database())->getConnection();
        } catch (PDOException $e) {
            // Gestion des erreurs si la connexion échoue
            die("Connection failed: " . $e->getMessage());
        }
    }

    // Récupérer les avis en attente de validation
    public function getPendingReviews() {
        try {
            $query = "SELECT * FROM reviews WHERE status = 'pending'";
            $stmt = $this->db->query($query);
            
            // Vérifier s'il y a des résultats
            if ($stmt) {
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
            return [];
        } catch (PDOException $e) {
            // Gestion des erreurs de requêtes
            die("Error fetching pending reviews: " . $e->getMessage());
        }
    }

    // Approuver un avis
    public function approveReview($id) {
        try {
            $query = "UPDATE reviews SET status = 'approved' WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
        } catch (PDOException $e) {
            // Gestion des erreurs de mise à jour
            die("Error approving review: " . $e->getMessage());
        }
    }

    // Supprimer un avis
    public function deleteReview($id) {
        try {
            $query = "DELETE FROM reviews WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
        } catch (PDOException $e) {
            // Gestion des erreurs de suppression
            die("Error deleting review: " . $e->getMessage());
        }
    }

    // Ajouter un avis dans la base de données
    public function addReview($pseudo, $review) {
        try {
            // Préparer la requête d'insertion d'un nouvel avis
            $query = "INSERT INTO reviews (pseudo, review_text, status) VALUES (:pseudo, :review, 'pending')";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':pseudo', $pseudo, PDO::PARAM_STR);
            $stmt->bindParam(':review', $review, PDO::PARAM_STR);
            
            // Exécuter la requête d'insertion
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            // Gestion des erreurs d'insertion
            die("Error adding review: " . $e->getMessage());
        }
    }

    // Récupérer les avis approuvés
    public function getApprovedReviews() {
        try {
            $query = "SELECT * FROM reviews WHERE status = 'approved'";
            $stmt = $this->db->query($query);
            
            // Vérifier s'il y a des résultats
            if ($stmt) {
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
            return [];
        } catch (PDOException $e) {
            // Gestion des erreurs de requêtes
            die("Error fetching approved reviews: " . $e->getMessage());
        }
    }
}
?>
