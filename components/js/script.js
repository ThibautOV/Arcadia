document.addEventListener("DOMContentLoaded", function() {
    const habitatSelect = document.getElementById("habitat-select");
    const animalsList = document.getElementById("animals-list");

    habitatSelect.addEventListener("change", function() {
        const selectedHabitat = habitatSelect.value;

        if (!selectedHabitat) {
            animalsList.innerHTML = "<li>Veuillez sélectionner un habitat.</li>";
            return;
        }

        fetch('HabitatController.php?action=getAnimalsByHabitatAjax', { // Assurez-vous que le chemin est correct
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ habitat: selectedHabitat })
        })
        .then(response => response.json())
        .then(data => {
            animalsList.innerHTML = '';

            if (data.length > 0) {
                data.forEach(animal => {
                    const animalItem = document.createElement("li");
                    animalItem.textContent = `${animal.name} - ${animal.species}`;
                    animalsList.appendChild(animalItem);
                });
            } else {
                animalsList.innerHTML = "<li>Aucun animal trouvé pour cet habitat.</li>";
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
            animalsList.innerHTML = "<li>Erreur lors de la récupération des animaux.</li>";
        });
    });
});