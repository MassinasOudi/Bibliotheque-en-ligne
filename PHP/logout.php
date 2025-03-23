<?php 
  //Déconnexion
  include 'db.php';
  unset($connexion);
  session_destroy();
  header("Location: ../HTML/home.html");
  exit;
?>
