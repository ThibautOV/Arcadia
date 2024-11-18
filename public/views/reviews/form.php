<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Soumettre un Avis</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>Soumettez votre Avis</h2>
    <form action="index.php?action=submitReview" method="post">
        <label>Pseudonyme: <input type="text" name="pseudo" required></label><br>
        <label>Avis: <textarea name="avis" required></textarea></label><br>
        <input type="submit" value="Envoyer">
    </form>
</body>
</html>