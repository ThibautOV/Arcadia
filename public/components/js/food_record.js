document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('foodForm');
    const feedbackDiv = document.getElementById('feedback');

    form.addEventListener('submit', function (e) {
        e.preventDefault(); // Empêche la soumission classique du formulaire

        // Récupérer les données du formulaire
        const formData = new FormData(form);

        // Affichage dans la console pour déboguer
        console.log("Données envoyées : ", formData);

        // Envoyer les données via AJAX
        fetch('../../controllers/EmployeeController.php?action=recordFoodConsumption', {  // Mise à jour de l'URL pour inclure l'action
            method: 'POST',
            body: formData
        })
        .then(response => response.json()) // Réponse au format JSON
        .then(data => {
            console.log(data); // Afficher la réponse dans la console
            if (data.success) {
                feedbackDiv.innerHTML = `<p style="color: green;">${data.message}</p>`;
                form.reset(); // Réinitialiser le formulaire
            } else {
                feedbackDiv.innerHTML = `<p style="color: red;">Erreur: ${data.message}</p>`;
            }
        })
        .catch(error => {
            feedbackDiv.innerHTML = `<p style="color: red;">Erreur: ${error}</p>`;
            console.error("Erreur de requête AJAX :", error); // Afficher l'erreur dans la console
        });
    });
});