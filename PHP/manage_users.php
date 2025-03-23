<?php
include 'db.php';

//Verification de connexion
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: admin_login.php");
    exit;
}

// Suppression d'un utilisateur
if (isset($_GET['delete'])) {
    $userId = $_GET['delete'];
    // verifier s'il a empunter un livre
    $prep = $connexion -> prepare("SELECT EmpruntID FROM Emprunts 
      WHERE UserID = ?");
    $prep->bindParam(1, $userId);
    $prep->execute();
    if ($prep->rowCount() > 0) {
        $error_message = "Cet utilisateur a emprunté des livres et ne peut 
          pas être supprimé.";
    } else {
      $prep = $connexion->prepare("DELETE FROM Utilisateurs WHERE UserID = ?");
      $prep->bindParam(1, $userId);
      $ret = $prep->execute();
      if($ret === false){
          $error_message = "ERREUR lors de la suppression !";
      }
      header("Location: manage_users.php"); 
      exit;
    }
  unset($prep);
 }

// Récupérer les utilisateurs
$prep = $connexion->prepare("SELECT UserID, Prenom, Nom, Email FROM 
  Utilisateurs");
$prep->execute();
$users = $prep->fetchAll();
unset($prep);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des Utilisateurs</title>
    <link rel="stylesheet" href="../CSS/manage.css">
</head>
<body>
    <h1>Gestion des Utilisateurs</h1>
    <?php if (!empty($error_message)): ?>
        <div class="error"><?= $error_message ?></div>
    <?php endif; ?>
    
    <table>
        <thead>
            <tr>
                <th>Prénom</th>
                <th>Nom</th>
                <th>Email</th>
                <th>Supprimer</th>
            </tr>
        </thead>
        <tbody>
          <!--affichage des utilisateurs-->
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= htmlspecialchars($user['Prenom']) ?></td>
                    <td><?= htmlspecialchars($user['Nom']) ?></td>
                    <td><?= htmlspecialchars($user['Email']) ?></td>
                    <td>
                        <a href="manage_users.php?delete=<?= $user['UserID'] ?>" 
                        onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?');">Supprimer</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div id ="liens">
      <button onclick="location.href='admin_interface.php';">
          Retour</button>
    </div>
    <script src= "../JS/manage.js"></script>
</body>
</html>
