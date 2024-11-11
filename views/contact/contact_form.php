<?php
require_once '../Models/ContactModel.php';

// Connexion à la base de données
$db = new PDO('mysql:host=localhost;dbname=zoo_db', 'username', 'password');

// Gérer le formulaire de contact
$message = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $contactModel = new ContactModel($db);
    $contactModel->sendContactMessage($_POST['title'], $_POST['description'], $_POST['email']);
    $message = "Votre message a été envoyé avec succès.";
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Formulaire de Contact</title>
</head>
<body>
    <h2>Contactez-nous</h2>

    <?php if (isset($message)) echo "<p>$message</p>"; ?>

    <form action="contact_form.php" method="post">
        <label>Titre: <input type="text" name="title" required></label><br>
        <label>Email: <input type="email" name="email" required></label><br>
        <label>Description: <textarea name="description" required></textarea></label><br>
        <input type="submit" value="Envoyer">
    </form>
</body>
</html>
