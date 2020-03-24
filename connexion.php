<?php
session_start();
include 'config/base.php';

if (isset($_SESSION['userEmail'])) {
    header('location:index.php');
}

if (isset($_POST['submit'])) {
    $email = htmlspecialchars(($_POST['email']));
    $password = sha1($_POST['motDePasse']);

    if ((!empty($email)) && (!empty($password))) {
        $Database = getPDO();
        $reqUser = $Database->prepare("SELECT * FROM Utilisateur WHERE email = ? AND motDePasse = ?");
         
        $reqUser->execute(array($email, $password));
            $userInfo = $reqUser->fetch(); 
        

        if (!empty($userInfo)) {
            $_SESSION['userID'] = $userInfo['idUtilisateur'];
            $_SESSION['userNom'] = $userInfo['nom'];
            $_SESSION['userPseudo'] = $userInfo['pseudo'];
            $_SESSION['userEmail'] = $userInfo['email'];
            $_SESSION['userPassword'] = $userInfo['motDePasse'];
            $_SESSION['userAdmin'] = $userInfo['_role'];
            $succesMessage = "Connexion réussie. Vous allez être redirigé dans quelques secondes";
            header('refresh:3;url=index.php');


        }else {
            $errorMessage = "Email ou mot de passe incorrect";
        }

    }else {
        $errorMessage = 'Veuillez remplir tous les champs';
    }
}


?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Connexion</title>
</head>
<body>
    <div class="container">
        <div class="">
            <h3>Blog</h3>
            <a href="index.php">Accueil</a>
            <a href="inscription.php">S'inscrire</a>
        </div>
        <div class="">
        <h3>Connexion</h3>
        <?php  if(isset($errorMessage)) { ?> <p style="color: red;"><?= $errorMessage ?></p><?php } ?>
        <?php if (isset($succesMessage)) { ?> <p style="color: green;"><?= $succesMessage ?></p><?php } ?>
        
        <form method="post" action="">
            <span>Adresse Email :</span><br>
            <input type="email" name="email" placeholder="Email"> <br>

            <span>Mot de passe :</span><br>
            <input type="password" name="password" placeholder="Mot de passe"> <br>

            <input type="submit" name="submit" value="Envoyer">
        </form>
        </div>
    </div>
</body>
</html>