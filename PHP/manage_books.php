<?php
include 'search.php';

//Verification de connexion
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: admin_login.php");
    exit;
}

// Suppression d'un livre
if (isset($_GET['delete'])) {
    $bookId = $_GET['delete'];

    // Vérifier s'il y a des emprunts en cours
    $prep = $connexion->prepare("SELECT * FROM Emprunts WHERE LivreID = ?");
    $prep->bindParam(1, $bookId);
    $prep->execute();
    if ($prep->rowCount() > 0) {
        $error_message = "Ce livre est actuellement emprunté et ne peut 
          pas être supprimé.";
    } else {
        $prep = $connexion->prepare("DELETE FROM Livres WHERE LivreID = ?");
        $prep->bindParam(1, $bookId);
        $ret = $prep->execute();
        if ($ret === false) {
            $error_message = "ERREUR lors de la suppression !";
        } else {
            header("Location: manage_books.php?recherche=" 
            . urlencode($_GET['recherche']) . "&motif=" 
            . urlencode($_GET['motif']) . "&tri=" . urlencode($_GET['tri']) .
            "&categorie=" . urlencode($_GET['categorie']) . "&search=");
            exit;
        }
    }
    unset($prep);
}

// Mise à jour du stock
if (isset($_POST['update_stock'])) {
    $bookId = $_POST['book_id'];
    $newStock = $_POST['new_stock'];
    $prep = $connexion->prepare("UPDATE Livres SET Stock = ? WHERE LivreID = ?");
    $prep->bindParam(1, $newStock);
    $prep->bindParam(2, $bookId);
    $ret = $prep->execute();
    if ($ret === false) {
        $error_message = "ERREUR lors de la mise à jour !";
    }
    unset($prep);
    header("Location: manage_books.php?recherche=".urlencode($_POST['recherche']) .
      "&motif=" . urlencode($_POST['motif']) . "&tri=" . urlencode($_POST['tri']) .
      "&categorie=" . urlencode($_POST['categorie']) . "&search=");
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des Livres</title>
    <link rel="stylesheet" href="../CSS/manage.css">
</head>
<body>
    <h1>Gestion des Livres</h1>
    <?php if (!empty($error_message)): ?>
        <div class="error"><?= $error_message ?></div>
    <?php endif; ?>
    <!-- Formulaire de recherche -->
    <form method="GET" action="manage_books.php" id = "formulaire">
        <input type="text" name="recherche" placeholder="Rechercher un livre">
        <select name="motif">
            <option value="titre">Titre</option>
            <option value="auteur">Auteur</option>
        </select>
        <select name="categorie">
            <option value="roman">Roman</option>
            <option value="poes">Poésie</option>
            <option value="fict">Fiction</option>
            <option value="epop">Épopée</option>
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
    <?php if (!empty($results)): ?>
      <table> 
        <thead>
          <tr>
          <th>Titre</th>
          <th>Auteur</th>
          <th>Éditeur</th>
          <th>Année de Parution</th>
          <th>Categorie</th>
          <th>Stock</th>
          <th>Supprimer / Mettre à jour</th>
          </tr>
        </thead>
      <tbody>
      <?php 
      //Affichage des resultats de la recherche
      if (isset($results)): 
        foreach ($results as $result): ?>
        <tr>
        <td><?= htmlspecialchars($result['Titre']) ?></td>
        <td><?= htmlspecialchars($result['Auteur']) ?></td>
        <td><?= htmlspecialchars($result['Editeur']) ?></td>
        <td><?= htmlspecialchars($result['AnneeParution']) ?></td>
        <td><?= htmlspecialchars($result['Categorie']) ?></td>
        <td><?= htmlspecialchars($result['Stock']) ?></td>
        <td>
        <a href="manage_books.php?delete=<?= $result['LivreID'] ?>&recherche=<?= urlencode($_GET['recherche']) ?>&motif=<?= urlencode($_GET['motif']) ?>&tri=<?= urlencode($_GET['tri']) ?>&categorie=<?= urlencode($_GET['categorie']) ?>&search=" 
        onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce livre ?');">Supprimer</a>
      <form method="post" action="manage_books.php">
        <input type="hidden" name="book_id" 
        value="<?= $result['LivreID'] ?>">
        <input type="hidden" name="recherche" 
        value="<?= htmlspecialchars($_GET['recherche']) ?>">
        <input type="hidden" name="motif" 
        value="<?= htmlspecialchars($_GET['motif']) ?>">
        <input type="hidden" name="tri" 
        value="<?= htmlspecialchars($_GET['tri']) ?>">
        <input type="hidden" name="categorie" 
        value="<?= htmlspecialchars($_GET['categorie']) ?>">
        <input type="number" name="new_stock" min="0" 
        placeholder="Nouveau stock" required>
        <button type="submit" name="update_stock">Mettre à jour</button>
      </form>
      </td>
      </tr>
      <?php endforeach; 
      endif; ?>
    </tbody>
  </table>
  <?php else: ?>
      <p>Aucun résultat trouvé.</p>
  <?php endif; ?>
    <div id="liens">
        <button onclick="location.href='admin_interface.php';">Retour</button>
    </div>
    <script src="../JS/manage.js"></script>
</body>
</html>
