<?php include_once __DIR__ . '/../menu/main_menu.php'; ?>

<div class="contact-form-page">
    <h1>Contactez-nous</h1>
    <form action="contact/submit" method="post">
        <input type="text" name="name" placeholder="Votre nom" required><br>
        <input type="email" name="email" placeholder="Votre email" required><br>
        <textarea name="message" placeholder="Votre message" required></textarea><br>
        <button type="submit">Envoyer</button>
    </form>
</div>