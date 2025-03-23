<?php
include 'db.php';

// Retirer un livre du panier
if (isset($_GET['remove'])) {
    $livreId = $_GET['remove'];
    if (($key = array_search($livreId, $_SESSION['cart'])) !== false) {
        unset($_SESSION['cart'][$key]);
    }
    header("Location: cart.php");
    exit;
}

// Confirmer les emprunts
if (isset($_POST['confirm'])) {
    foreach ($_SESSION['cart'] as $livreId) {
        $prep = $connexion->prepare("SELECT Stock FROM Livres WHERE LivreID = ?");
        $prep->bindParam(1, $livreId);
        $prep->execute();
        $stock = $prep->fetchColumn();

        if ($stock > 0) {
            $prep = $connexion->prepare("INSERT INTO Emprunts (LivreID, UserID, 
            DateDebut, DateFin) VALUES (?, ?, CURDATE(), DATE_ADD(CURDATE(), 
            INTERVAL 14 DAY))");
            $prep->bindParam(1, $livreId);
            $prep->bindParam(2, $_SESSION['userid']);
            $prep->execute();

            $prep = $connexion->prepare("UPDATE Livres SET Stock = Stock - 1 
            WHERE LivreID = ?");
            $prep->bindParam(1, $livreId);
            $prep->execute();
        }
        unset($prep);
    }
     // Vider le panier après confirmation
    $_SESSION['cart'] = [];
    header("Location: cart.php");
    exit;
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Panier</title>
    <link rel="stylesheet" href="../CSS/cart.css">
</head>
<body>
    <h1>Votre Panier</h1>
    <form method="post" action="cart.php">
      
        <?php
        if (!empty($_SESSION['cart'])) {
            // Afficher la liste des livres ajoutès
            echo "<ul>";
            foreach ($_SESSION['cart'] as $livreId) {
                $prep = $connexion->prepare("SELECT Titre, Auteur FROM Livres 
                WHERE LivreID = ?");
                $prep->bindParam(1, $livreId);
                $prep->execute();
                $livre = $prep->fetch();
                
                // La date du retour
                $date = new DateTime();
                $date->add(new DateInterval('P14D'));
                $rendre = $date->format('d-m-Y');

                echo "<li>" . htmlspecialchars($livre['Titre']) . " par " 
                . htmlspecialchars($livre['Auteur']) . " à rendre le ". $rendre  
                . " <a href='cart.php?remove=" . $livreId . "'>Retirer</a></li>";
            }
            echo "</ul>";
            echo "<button type='submit' name='confirm'>
            Confirmer les emprunts</button>";
        } else {
            echo "<p>Votre panier est vide.</p>";
        }
        ?>
    </form>
    <div id ="liens">
      <button onclick="location.href='book_search.php';">
      Retour aux recherches</button>

      <button onclick="location.href='user_profil.php';">
      Retour au Profil</button>
    </div>
    <script src = "../JS/cart.js"></script>
</body>
</html>
