<?php
session_start();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
</head>
<body>
    <div class="login-container">
        <h1>Connexion</h1>
        
        <?php if (isset($_SESSION['error'])): ?>
            <div class="error">
                <?= htmlspecialchars($_SESSION['error']) ?>
            </div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>
        
        <form action="/public/views/auth/process_login.php" method="post">
            <label for="email">Email :</label>
            <input type="email" name="email" id="email" required>
            
            <label for="password">Mot de passe :</label>
            <input type="password" name="password" id="password" required>
            
            <button type="submit">Se connecter</button>
        </form>
    </div>
</body>
</html>
