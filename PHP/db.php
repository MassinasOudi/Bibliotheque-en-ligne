<?php
  session_start();
  
  //Connexion à la base de donnèes
  try {
    $Base = "BIBLIOTHEQUE";
    $login = "root";
    $mdp = "";
    $connexion = new PDO("mysql:host=127.0.0.1;dbname=$Base", $login, $mdp);
  }
  catch(PDOException $e) {
    exit('Erreur : '.$e->getMessage());
  }
?>
