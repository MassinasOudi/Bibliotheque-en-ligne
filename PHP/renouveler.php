<?php
include 'db.php';

if (!isset($_SESSION['userid'])) {
    header("Location: user_login.php");
    exit;
}

if (isset($_GET['empruntID'])) {
    $empruntID = $_GET['empruntID'];
    // Mettre à jour la date de retour
    $prep = $connexion->prepare("UPDATE Emprunts SET DateFin = 
      DATE_ADD(DateFin, INTERVAL 1 WEEK) WHERE EmpruntID = ?");
    $prep->bindParam(1, $empruntID);
    $prep->execute();
    unset($prep);
    header("Location: user_profil.php");
    exit;
}

?>
