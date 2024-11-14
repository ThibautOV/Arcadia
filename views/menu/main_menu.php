<?php include_once __DIR__ . '/../menu/main_menu.php'; ?>

<link rel="stylesheet" href="/components/css/main_menu.css">

<nav class="navbar navbar-expand-lg custom-navbar">
  <div class="container-fluid">
    <!-- Logo à gauche -->
    <a href="/" class="navbar-brand">
      <img src="/components/img/logo.png" alt="Logo" class="logo">
    </a>

    <!-- Bouton mobile -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Liens centrés -->
    <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" href="/views/home/index.php">Accueil</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/views/service/index.php">Services</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/views/habitat/index.php">Habitats</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/views/auth/login.php">Connexion</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/views/contact/contact_form.php">Contact</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
