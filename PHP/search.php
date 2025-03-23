<?php

include 'db.php';

// Recherche des livres selon les categorires avec tri
if (isset($_GET['recherche']) && isset($_GET['motif']) && isset($_GET['tri']) 
  && isset($_GET['categorie']) && isset($_GET['search']) 
  && !empty($_GET['recherche'])) {
   
    $search = $_GET['recherche'];
    $motif = $_GET['motif'];
    $tri = $_GET['tri'];
    $categorie = $_GET['categorie'];
    $sql = "SELECT * FROM Livres ";

    switch ($motif) {
        case "auteur":
            $sql .= "WHERE Auteur LIKE ?";
            break;
        case "titre":
            $sql .= "WHERE Titre LIKE ?";
            break;
    }
    
    switch ($categorie) {
        case "roman":
            $sql .= "AND Categorie = 'ROMAN'";
            break;
        case "poes":
            $sql .= "AND Categorie = 'Poesie'";
            break;
        case "fict":
            $sql .= "AND Categorie = 'Fiction'";
            break;
        case "epop":
            $sql .= "AND Categorie = 'Epopee'";
            break;
         case "hist":
            $sql .= "AND Categorie = 'Historique'";
            break;  
        case "mang":
            $sql .= "AND Categorie = 'Manga'";
            break;  
        case "philo":
            $sql .= "AND Categorie = 'Philosophie'";
            break;
    }
    
    switch ($tri) {
        case "date_asc":
            $sql .= "ORDER BY AnneeParution ASC";
            break;
        case "date_desc":
            $sql .= "ORDER BY AnneeParution DESC";
            break;
        case "stock_asc":
            $sql .= "ORDER BY Stock ASC";
            break;
        case "stock_desc":
            $sql .= "ORDER BY Stock DESC";
            break;
    }

    $prep = $connexion->prepare($sql);
    $searchTerm = '%' . $search . '%';
    $prep->bindParam(1, $searchTerm);
    $prep->execute();
    $results = $prep->fetchAll();
    unset($prep);
}
?>
