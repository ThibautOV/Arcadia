<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Enregistrement de l'Alimentation</title>
    <link rel="stylesheet" href="../../components/css/record_food.css">
    <script src="../../components/js/food_record.js"></script> <!-- Ajout du script JavaScript -->
</head>
<body>
    <h2>Enregistrer l'Alimentation des Animaux</h2>

    <!-- Formulaire pour enregistrer l'alimentation -->
    <form id="foodForm">
        <label>Animal :</label>
        <select name="animal_id" required>
            <option value="">Sélectionner un animal</option>
            <?php foreach ($animals as $animal): ?>
                <option value="<?php echo htmlspecialchars($animal['id']); ?>">
                    <?php echo htmlspecialchars($animal['name']); ?>
                </option>
            <?php endforeach; ?>
        </select><br>

        <label>Date :</label>
        <input type="date" name="date" required><br>

        <label>Heure :</label>
        <input type="time" name="time" required><br>

        <label>Nourriture :</label>
        <input type="text" name="food" required><br>

        <label>Quantité :</label>
        <input type="number" name="quantity" required><br>

        <input type="submit" value="Enregistrer l'Alimentation">
    </form>

    <div id="feedback"></div> <!-- Zone de retour d'information -->
</body>
</html>