<?php
class ReviewController {
    public function submitReview($pseudo, $review) {
        // Logique de soumission de l'avis (ex. : insertion dans la base de données)
        echo "Merci, votre avis a été soumis pour validation.";
    }

    public function showReviews() {
        // Logique pour afficher les avis validés
        include 'views/home/reviews.php';
    }
}
?>