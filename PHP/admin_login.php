<?php
session_start();

// Mot de passe et mail administrateur
$adminEmail = 'admin@example.com';
$mdp = password_hash("Password", PASSWORD_DEFAULT);

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    //Verification de l'id et le mot de passe de l'admin
    if ($email === $adminEmail && password_verify($password, $mdp)) {
        $_SESSION['email'] = $email;
        $_SESSION['role'] = 'admin';
        header("Location: admin_interface.php");
        exit;
    } else {
        $message = "Identifiant ou mot de passe incorrect.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion Admin</title>
    <link rel="stylesheet" href="../CSS/login.css"> 
</head>
<body>
        <div class="formulaire">
        <form action="admin_login.php" method="POST">
            <h1>Connexion Admin</h1>
              <div>
        <?php if (!empty($message)): ?>
          <div class="error"><?= $message ?></div>
        <?php endif; ?>
              </div>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Mot de passe:</label>
            <input type="password" id="password" name="password" required>

            <button type="submit" name="login">Connexion</button>
            <p class="lien"><a href="../HTML/home.html">
              Retour à la page d'accueil</a></p>
        </form>
    </div>
</body>
</html>
