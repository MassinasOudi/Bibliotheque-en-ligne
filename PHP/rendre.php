<?php
include 'db.php';

if (!isset($_SESSION['userid'])) {
    header("Location: user_login.php");
    exit;
}

if (isset($_GET['empruntID'])) {
    $empruntID = $_GET['empruntID'];

    //Récupérer l'ID du livre emprunté
    $prep = $connexion->prepare("SELECT LivreID FROM Emprunts WHERE 
      EmpruntID = ?");
    $prep->bindParam(1, $empruntID);
    $prep->execute();
    $result = $prep->fetch();

    if ($result !== false) {
        $livreID = $result['LivreID'];

        // Mettre à jour le stock du livre
        $prep = $connexion->prepare("UPDATE Livres SET Stock = Stock + 1 
          WHERE LivreID = ?");
        $prep->bindParam(1, $livreID);
        $prep->execute();

        // Supprimer l'emprunt
        $prep = $connexion->prepare("DELETE FROM Emprunts WHERE EmpruntID = ?");
        $prep->bindParam(1, $empruntID);
        $prep->execute();
  } 
    unset($prep);
        header("Location: user_profil.php");
        exit;
} 
?>
