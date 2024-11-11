document.addEventListener("DOMContentLoaded", function() {
    const habitatSelect = document.getElementById("habitat-select");
    const animalsList = document.getElementById("animals-list");

    // Ajoute un écouteur d'événements pour les changements dans le menu de sélection
    habitatSelect.addEventListener("change", function() {
        const selectedHabitat = habitatSelect.value;

        if (selectedHabitat) {
            AnimalController.fetchAnimalsByHabitat(selectedHabitat)
                .then(animals => {
                    AnimalController.updateAnimalList(animals);
                })
                .catch(error => console.error('Erreur:', error));
        } else {
            animalsList.innerHTML = "<li>Sélectionnez un habitat pour voir les animaux.</li>";
        }
    });
});

const AnimalController = {
    // Fonction pour effectuer la requête fetch et obtenir les animaux par habitat
    fetchAnimalsByHabitat: function(habitat) {
        return fetch('/api/getAnimalsByHabitat', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ habitat: habitat })
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Erreur lors de la récupération des données');
            }
            return response.json();
        });
    },

    // Fonction pour mettre à jour le DOM avec les animaux reçus
    updateAnimalList: function(animals) {
        const animalsList = document.getElementById("animals-list");
        animalsList.innerHTML = ''; // Réinitialise la liste

        if (animals.length > 0) {
            animals.forEach(animal => {
                const animalItem = document.createElement("li");
                animalItem.textContent = `${animal.name} - ${animal.species}`;
                animalsList.appendChild(animalItem);
            });
        } else {
            animalsList.innerHTML = "<li>Aucun animal trouvé pour cet habitat.</li>";
        }
    }
};