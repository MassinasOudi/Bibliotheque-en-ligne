<?php
include 'db.php';

if (!isset($_SESSION['userid'])) {
    header("Location: user_login.php");
    exit;
}

if (isset($_POST['mdp']) && isset($_POST['newMdp1']) && isset($_POST['newMdp'])){
    $mdp = $_POST['mdp'];
    $newMdp = $_POST['newMdp'];
    $newMdp1 = $_POST['newMdp1'];

    $userId = $_SESSION['userid'];
    $sql = "SELECT MotDePasse FROM Utilisateurs WHERE UserID = ?";
    $prep = $connexion->prepare($sql);
    $prep->bindParam(1, $userId);
    $prep->execute();
    $user = $prep->fetch();
    // Verification du mot de passe actuel
    if ($user && password_verify($mdp, $user['MotDePasse'])) {
        $hashedNewMdp = password_hash($newMdp, PASSWORD_DEFAULT);
        $sql = "UPDATE Utilisateurs SET MotDePasse = ? WHERE UserID = ?";
        $prep = $connexion->prepare($sql);
        $prep->bindParam(1, $hashedNewMdp);
        $prep->bindParam(2, $userId);
        $prep->execute();
        $success_message = 'Mot de passe modifié avec succès.';
    } else {
        $message = 'Mot de passe actuel incorrect.';
    }
    unset($prep);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Changer de mot de passe</title>
    <link rel="stylesheet" href="../CSS/modif_mdp.css">
    <script src = "../JS/modif_mdp.js"></script>
</head>
<body>
  <div class="formulaire">
    <form action="modif_mdp.php" method="post" onsubmit="return testMdp();">
        <h1>Changer votre mot de passe</h1>
        <?php if (!empty($message)): ?>
            <div class="error"><?= $message ?></div>
        <?php endif; ?>
        <?php if (!empty($success_message)): ?>
            <div class="success"><?= $success_message ?></div>
        <?php endif; ?>   

        <label for="mdp">Mot de passe actuel:</label>
        <input type="password" id="mdp" name="mdp" required>

        <label for="newMdp">Nouveau mot de passe:</label>
        <input type="password" id="newMdp" name="newMdp" required>
        <div id="message"></div>

        <label for="newMdp1">Confirmer le mot de passe:</label>
        <input type="password" id="newMdp1" name="newMdp1" required>
        <div id="message1"></div>
        
        <button type="submit">Modifier le mot de passe</button>
    </form>
  </div>
  <div id ="liens">
    <button onclick="location.href='user_profil.php';">Retour</button>
  </div>
</body>
</html>
