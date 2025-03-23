<?php
include 'db.php';

//Verification de Connexion
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: admin_login.php");
    exit;
}

//Ajout de Livres
if (isset($_POST['add_book'])) {
  $titre = $_POST['titre'];
  $auteur = $_POST['auteur'];
  
  // Vérifier si le livre existe déjà
  $check = $connexion->prepare("SELECT Titre, Auteur FROM Livres WHERE 
  Auteur = ? AND Titre = ?");
  $check->bindParam(1, $auteur);
  $check->bindParam(2, $titre);
  $check->execute();
    
  if ($check->rowCount() > 0) {
    $error_message = "Le Livre existe déjà dans la base de données.";
  }else{
    $editeur = isset($_POST['editeur']) ? $_POST['editeur'] : null;
    $anneeParution = $_POST['anneeParution']; 
    $categorie = $_POST['categorie'];
    $stock = $_POST['stock'];
    $prep = $connexion->prepare("INSERT INTO Livres (Titre, Auteur, Editeur,
      AnneeParution, Categorie, Stock) VALUES (?, ?, ?, ?, ?, ?)");
    $prep->bindParam(1, $titre);
    $prep->bindParam(2, $auteur);
    $prep->bindParam(3, $editeur);
    $prep->bindParam(4, $anneeParution);
    $prep->bindParam(5, $categorie);
    $prep->bindParam(6, $stock);
    $ret = $prep->execute();
    if($ret === false){
      $error_message = "ERREUR lors de l'ajout !";
    }else{
      $success_message = "Livre ajouté avec succès.";
    }
    unset($prep);
    unset($check);
  }
}

//Ajout d'Utilisateur
if (isset($_POST['add_user'])) {
  $prenom = $_POST['prenom'];
  $nom = $_POST['nom'];
  $dateNaissance = $_POST['date_naissance'];
  $email = $_POST['email'];
  $mdp = $_POST['nom'].$_POST['prenom'];
  $NomUsage = substr($nom, 0, 5).substr($prenom, 0, 3);
  $password = password_hash($mdp, PASSWORD_DEFAULT);
  
  // Calculer l'âge
  $dateNaissance1 = new DateTime($dateNaissance);
  $now = new DateTime();
  $age = $now->diff($dateNaissance1)->y;

  if ($age < 16) {
    $error_message = "L'utilisateur doit avoir plus de 16 ans.";
  }else{
    // Vérifier si l'email de l'utilisateur existe déjà
    $check = $connexion->prepare("SELECT Email FROM Utilisateurs WHERE Email 
      = ?");
    $check->bindParam(1, $email);
    $check->execute();
      
    if ($check->rowCount() > 0) {
      $error_message = "L'utilisateur existe déjà dans la base de données.";
    } else {
      $prep = $connexion->prepare("INSERT INTO Utilisateurs (NomUsage, Prenom, 
      Nom, DateNaissance, Email, MotDePasse) VALUES (?, ?, ?, ?, ?, ?)");
      $prep->bindParam(1, $NomUsage);
      $prep->bindParam(2, $prenom);
      $prep->bindParam(3, $nom);
      $prep->bindParam(4, $dateNaissance);
      $prep->bindParam(5, $email);
      $prep->bindParam(6, $password);
      
      $ret = $prep->execute();
      if($ret === false){
        $error_message = "ERREUR lors de l'ajout !";
      }else{
        $success_message = "Utilisateur ajouté avec succès.";
      }
      unset($ret);
      unset($check);
    }
  }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Interface de Gestion - Administrateur</title>
    <link rel="stylesheet" href="../CSS/admin_interface.css">
</head>
<body>
    <h1>Interface de Gestion - Administrateur</h1>
        <?php if (!empty($error_message)): ?>
    <div class="error"><?= $error_message ?></div>
    <?php endif; ?>
    <?php if (!empty($success_message)): ?>
    <div class="success"><?= $success_message ?></div>
    <?php endif; ?>   

    <h2>Gestion des Livres</h2>
    <form method="post" action="admin_interface.php">
        <h3>Ajouter un Livre</h3>
        <input type="text" name="titre" placeholder="Titre du livre" required>
        <input type="text" name="auteur" placeholder="Auteur du livre" required>
        <input type="text" name="editeur" placeholder="Éditeur du livre">
        <input type="number" name="anneeParution" placeholder="Année de parution"
         min="0" max="2024" required>
        <select name="categorie">
          <option value="Roman">Roman</option>
          <option value="Poesie">Poésie</option>
          <option value="Fiction">Fiction</option>
          <option value="Epopee">Épopée</option>
          <option value="Historique">Historique</option>
          <option value="Manga">Manga</option>
          <option value="Philosophie">Philosophie</option>
        </select>
        <input type="number" name="stock" placeholder="Stock initial" 
          min="0" required>
        <button type="submit" name="add_book">Ajouter Livre</button>
    </form>

    <h2>Gestion des Utilisateurs</h2>
    <form method="post" action="admin_interface.php">
        <h3>Ajouter un Utilisateur</h3>
        <input type="text" name="prenom" placeholder="Prénom" required>
        <input type="text" name="nom" placeholder="Nom" required>
        <input type="date" name="date_naissance" required>
        <input type="email" name="email" placeholder="Email" required>
        <button type="submit" name="add_user">Ajouter Utilisateur</button>
    </form>
    
    <div id ="liens">
      <button onclick="location.href='manage_books.php';">
          Voir Les Livres</button>
          
      <button onclick="location.href='manage_users.php';">
          Voir Les Utilisateurs</button>

      <button onclick="location.href='logout.php';">
            Déconnexion</button>
    </div>
  <script src = "../JS/admin_interface.js"></script>
</body>
</html>
