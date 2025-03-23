<?php
include 'search.php';

//Verification de connexion
if (!isset($_SESSION['userid'])) {
    header("Location: user_login.php");
    exit;
}

// Ajouter au panier avec la methode GET
if (isset($_GET['ajouter_au_panier'])) {
    $livreId = $_GET['ajouter_au_panier'];
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    if (!in_array($livreId, $_SESSION['cart'])) {
        $_SESSION['cart'][] = $livreId;
    }
    // Garder les informations de la recherche 
    header("Location: book_search.php?recherche=".urlencode($_GET['recherche']).
     "&motif=" . urlencode($_GET['motif']) . "&tri=" . urlencode($_GET['tri']) .
     "&categorie=" . urlencode($_GET['categorie']) ."&search=");
    exit;
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Recherche</title>
    <link rel="stylesheet" href="../CSS/book_search.css">
</head>
<body>
  <div>
  <!-- formulaire de recherche -->
    <form method="GET" action="book_search.php">
        <input type="text" name="recherche" placeholder="Rechercher un livre">
         <select name="motif">
          <option value="titre">Titre</option>
          <option value="auteur">Auteur</option>
        </select>
        <select name="categorie">
          <option value="roman">Roman</option>
          <option value="poes">Poesie</option>
          <option value="fict">Fiction</option>
          <option value="epop">Epopee</option>
          <option value="hist">Historique</option>
          <option value="mang">Manga</option>
          <option value="philo">Philosophie</option>
        </select>
        <select name="tri">
          <option value="date_asc">Date ↑</option>
          <option value="date_desc">Date ↓</option>
          <option value="stock_asc">Stock ↑</option>
          <option value="stock_desc">Stock ↓</option>
        </select>
        <button type="submit" name="search">Rechercher</button>
    </form>

  <!-- affichage des resultats -->
    <?php if (!empty($results)): ?>
    <table>
      <tr>
      <th>Titre</th>
      <th>Auteur</th>
      <th>Categorie</th>
      <th>Annee de parution</th>
      <th>Stock</th>
      <th>Ajout au panier</th></tr>
    <?php foreach ($results as $book): ?>
      <tr>
      <td><?= $book['Titre'] ?></td>
      <td><?= $book['Auteur'] ?></td>
      <td><?= $book['Categorie'] ?></td>
      <td><?= $book['AnneeParution'] ?></td>
      <td><?= $book['Stock'] ?></td>
      <td>
    <?php if ($book['Stock'] > 0): ?>

    <!-- Initialise le panier -->
      <?php if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
      }?>
      <?php 
      // Affichage des livres 
      $sql1 = "SELECT EmpruntID FROM Emprunts WHERE LivreID = ? AND UserID = ?";
      $prep1 = $connexion->prepare($sql1);
      $prep1->bindParam(1, $book['LivreID']);
      $prep1->bindParam(2, $_SESSION['userid']);
      $prep1->execute();
      if ($prep1->rowCount() > 0): ?>
      <button disabled>Déjà emprunté par vous</button>
      <?php elseif (in_array($book['LivreID'], $_SESSION['cart'])): ?>
      <button disabled>Ajouté</button>
      <?php else: ?>
      
      <button onclick="location.href=
      '?ajouter_au_panier=<?= urlencode($book['LivreID']) ?>' + 
      '&recherche=<?= urlencode($_GET['recherche']) ?>' + 
      '&motif=<?= urlencode($_GET['motif']) ?>' + 
      '&tri=<?= urlencode($_GET['tri']) ?>' + 
      '&categorie=<?= urlencode($_GET['categorie']) ?>' + 
      '&search=';">
      Ajouter au panier
      </button>
      <?php endif; ?>
      <?php else: ?>
          Indisponible
      <?php endif; ?>

      </td>
      </tr>
      <?php endforeach; ?>
    </table>
    <?php else: ?>
        <p>Aucun résultat trouvé.</p>
    <?php endif; ?>

      <div id ="liens">
        <button onclick="location.href='cart.php';">Voir le panier</button>
        <button onclick="location.href='user_profil.php';">
          Retour au profil</button>
      </div>
    </div>
</body>
</html>
