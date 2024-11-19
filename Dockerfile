# Utiliser une image PHP avec Apache
FROM php:8.1-apache

# Installer les dépendances nécessaires dans une seule couche pour optimiser la taille de l'image
RUN apt-get update && apt-get install -y \
    gnupg \
    wget \
    curl \
    unzip \
    ca-certificates \
    lsb-release \
    git \
    && rm -rf /var/lib/apt/lists/* \
    && apt-get clean

# Activer le module Apache rewrite
RUN a2enmod rewrite

# Copier le fichier php.ini personnalisé dans le répertoire principal de configuration PHP
COPY php.ini /usr/local/etc/php/

# Copier l'application dans le répertoire public d'Apache
COPY . /var/www/html/

# Définir les droits d'accès pour les fichiers copiés (important pour Apache)
RUN chown -R www-data:www-data /var/www/html

# Exposer le port 80 pour le serveur Apache
EXPOSE 80

# Lancer Apache en mode foreground
CMD ["apache2-foreground"]