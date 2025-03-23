<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Profil - Bibliothèque en ligne</title>
    <link rel="stylesheet" href="../CSS/user_profil.css">
</head>
<body>
    <div class="profil">
        <h1>Profil de l'utilisateur</h1>
        <?php
        include 'db.php';

        if (isset($_SESSION['userid'])) {
          $userID = $_SESSION['userid'];
          try {
           $prep = $connexion->prepare("SELECT UserID, Nom, Prenom, 
           Email, NomUsage FROM Utilisateurs WHERE UserID = :user");
           $prep->bindParam(':user', $userID);
           $prep->execute();
           $user = $prep->fetch();
            // Affichage des informations de l'utilisateur 
            if ($user !== false) {
              echo "<p><strong>Nom Et Prenom:</strong> " 
              . htmlspecialchars($user['Nom']) . " "
              .htmlspecialchars($user['Prenom'])."</p>";
              echo "<p><strong>NomUsage:</strong> " 
              . htmlspecialchars($user['NomUsage']) . "</p>";
              echo "<p><strong>Email:</strong> " 
              . htmlspecialchars($user['Email']) . "</p>";
              
              // Affichage des emprunts
              echo "<h2>Emprunts en cours:</h2>";
              echo "<table><thead><tr><th>Titre</th>
              <th>Date d'emprunt</th><th>Date de retour</th>
              <th>Rendre/Renouveler</th></tr></thead><tbody>";
            
              $prep = $connexion->prepare("SELECT E.EmpruntID, L.Titre, 
              E.DateDebut, E.DateFin FROM Emprunts E JOIN Livres L 
              ON E.LivreID = L.LivreID WHERE E.UserID = :userid");
              $prep->bindParam(':userid', $user['UserID']);
              $prep->execute();

              while ($emprunt = $prep->fetch()) {
                echo "<tr><td>".$emprunt['Titre']."</td>
                <td>".$emprunt['DateDebut']."</td>
                <td>".$emprunt['DateFin']."</td>";
                echo "<td><button onclick=\"location.href='rendre.php?empruntID=" 
                . $emprunt['EmpruntID'] . "'\">Rendre</button> " .
                "<button onclick=\"location.href='renouveler.php?empruntID=" 
                . $emprunt['EmpruntID'] . "'\">Renouveler</button>" .
                "</td></tr>";
              }
              echo "</tbody></table>";
              } else {
                echo "<p>Utilisateur non trouvé.</p>";
              }
          } catch (PDOException $e) {
             echo "Erreur : " . $e->getMessage();
          }
        } else {
            echo "<p>Aucun utilisateur connecté</p>";
        }
        unset($prep);
        ?>
        </div>
        
        <div id ="liens">
          <button onclick="location.href='book_search.php';">
            Recherche de livres</button>
          
          <button onclick="location.href='cart.php';">
            Voir le panier</button>
      
      <button onclick="location.href='modif_mdp.php';">
            Modification du mot de passe</button>
          
          <button onclick="location.href='logout.php';">
            Déconnexion</button>
        </div>
      <script src = "../JS/user_profil.js"></script>
</body>
</html>
