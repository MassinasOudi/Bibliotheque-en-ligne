# Gestion de Bibliothèque en Ligne

## Description du Projet
Ce projet est une application web permettant la gestion des emprunts et des retours de livres dans une bibliothèque. Il propose des interfaces pour les administrateurs et les utilisateurs afin de faciliter la gestion des livres et des emprunts.

## Technologies Utilisées
- **Backend** : PHP (avec SQLite/MySQL pour la base de données)
- **Frontend** : HTML, CSS, JavaScript
- **Frameworks et Bibliothèques** : Aucun framework spécifique requis

## Structure du Projet
Le projet est organisé en plusieurs dossiers pour faciliter la gestion du code :

### 1. Page d’Accueil
Fichiers : `home.html`, `home.css`, `home.js`
- Contient une introduction de l'application.
- Permet d’accéder à l’interface administrateur et au profil utilisateur.

### 2. Connexion
Fichiers : `admin_login.php`, `user_login.php`, `login.css`
- Authentification des administrateurs et des utilisateurs.
- Sécurisation des accès.

### 3. Interface Administrateur
Fichiers : `admin_interface.php`, `admin_interface.css`, `admin_interface.js`
- Interface de gestion des utilisateurs et des livres.

### 4. Gestion des Livres et Utilisateurs
Fichiers : `manage_books.php`, `manage_users.php`, `manage.css`, `manage.js`
- Gestion des livres (ajout, suppression, modification du stock).
- Gestion des utilisateurs (ajout, suppression).

### 5. Profil Utilisateur
Fichiers : `user_profil.php`, `user_profil.css`, `user_profil.js`
- Visualisation des livres empruntés et de la date de retour.

### 6. Panier
Fichiers : `cart.php`, `cart.css`, `cart.js`
- Gestion des livres ajoutés et de la date de retour prévue.

### 7. Recherche
Fichiers : `book_search.php`, `book_search.css`
- Recherche et affichage des livres disponibles.
- Possibilité d'emprunt direct.

### 8. Renouvellement / Retour
Fichiers : `renouveler.php`, `rendre.php`
- Permet de prolonger la période d'emprunt d'une semaine.
- Permet de retourner les livres empruntés.

### 9. Modification du Mot de Passe
Fichiers : `modif_mdp.php`, `modif_mdp.css`, `modif_mdp.js`
- Permet à l'utilisateur de modifier son mot de passe.

### 10. Connexion à la Base de Données
Fichier : `db.php`
- Assure la connexion à la base de données.
- Gestion des sessions utilisateurs.

### 11. Recherche Avancée
Fichier : `search.php`
- Permet la recherche avancée avec tri par date et stock.
- Utilisé dans `manage_books.php` et `book_search.php`.

### 12. Déconnexion
Fichier : `logout.php`
- Fermeture de session et déconnexion de la base de données.

## Fonctionnalités Clés
### 1. Administration
- Ajout de nouveaux utilisateurs (vérification d'unicité, restriction d'âge à 16 ans minimum).
- Ajout de livres (vérification d'unicité).
- Suppression impossible si un livre est emprunté ou si un utilisateur a un emprunt actif.

### 2. Utilisateur
- Peut changer son mot de passe.
- Ne peut emprunter un livre déjà emprunté.
- Peut renouveler un emprunt.
- Peut retourner les livres.

## Améliorations Apportées
- Ajout d'un système de tri des résultats de recherche (par date de parution et stock, ordre croissant/décroissant).

## Défis Rencontrés
- Utilisation de la méthode **GET** pour rester sur la même page après suppression/ajout d'un livre.
- Manque de temps pour certaines améliorations proposées.

## Conclusion
Le projet atteint son objectif de fournir une plateforme fonctionnelle pour la gestion de bibliothèque en ligne. Toutes les fonctionnalités essentielles ont été implémentées et testées pour assurer une expérience fluide et sécurisée.

