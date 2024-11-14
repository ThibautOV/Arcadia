<?php
require_once __DIR__ . '/../models/ReviewModel.php';

class ReviewController {
    private $reviewModel;

    public function __construct() {
        $this->reviewModel = new ReviewModel();
    }

    // Soumet un avis et vérifie les données
    public function submitReview() {
        $message = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $pseudo = $_POST['pseudo'] ?? '';
            $review = $_POST['review'] ?? '';

            if (!empty($pseudo) && !empty($review)) {
                $this->reviewModel->addReview($pseudo, $review);
                $message = "Merci, votre avis a été soumis pour validation.";
            } else {
                $message = "Tous les champs sont requis pour soumettre un avis.";
            }
        }
        include 'views/review/submit.php';
    }

    // Affiche les avis approuvés
    public function showReviews() {
        $reviews = $this->reviewModel->getApprovedReviews();
        include 'views/review/list.php';
    }
}
?>