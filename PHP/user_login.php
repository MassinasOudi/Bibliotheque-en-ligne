<?php
include "db.php";

//Verification de l'id et le mot de passe de l'utilisateur
if (isset($_POST['NomUsage']) && isset($_POST['password'])) {
    $NomUsage = $_POST['NomUsage'];
    $mot_de_passe = $_POST['password'];
    
    $sql = "SELECT UserID, MotDePasse FROM Utilisateurs WHERE 
      NomUsage = :NomUsage";
    $prep = $connexion->prepare($sql);
    $prep->bindParam(":NomUsage", $NomUsage);
    $prep->execute();
    $user = $prep->fetch();

    if ($user) {
        if (password_verify($mot_de_passe, $user['MotDePasse'])) {
            $_SESSION['NomUsage'] = $NomUsage;
            $_SESSION['userid'] = $user['UserID'];
            header("Location: user_profil.php");
            exit;
        } else {
            $message = "Identifiant ou mot de passe incorrect.";
        }
    } else {
        $message = "Aucun utilisateur trouvé avec ce nom d'utilisateur.";
    }
  unset($prep);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion - Bibliothèque en ligne</title>
    <link rel="stylesheet" href="../CSS/login.css">
</head>
<body>
    <div class="formulaire">
        <form action="user_login.php" method="POST">
            <h1>Connexion</h1>
              <div>
        <?php if (!empty($message)): ?>
          <div class="error"><?= $message ?></div>
        <?php endif; ?>
              </div>
            
            <label for="nomUsage">NomUsage:</label>
            <input type="text" id="nomUsage" name="NomUsage" required>

            <label for="password">Mot de passe:</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Connexion</button>
            <p class="lien"><a href="../HTML/home.html">
              Retour à la page d'accueil</a></p>
        </form>
    </div>
</body>
</html>
