<?php
session_start();
include "config/base.php";



if(isset($_POST['submit'])) {

    $oldPassword = sha1($_POST['old_password']);
    var_dump($oldPassword);
    $newPassword = sha1($_POST['password']);
    var_dump($newPassword);
    $confirmNewPassword = sha1($_POST['confirm_password']);
    var_dump($confirmNewPassword);

    if ($_SESSION['userPassword'] == $oldPassword) {
        var_dump($_SESSION['userPassword']);

     if ($newPassword == $confirmNewPassword) {
         $Database = getPDO();
         
         var_dump($Database);
         
         $request = $Database->prepare("UPDATE utilisateur SET motDePasse = ? WHERE email = ? ");
        $request->execute([
            $newPassword,
            $_SESSION['userEmail']
            ]);
            $succesMessage = "Votre mot de passe à bien été modifié !";
            header('Location: index.php');


        }else {
            $errorMessage = 'Les mots de passes ne sont pas identiques';
        }

    }else{
        $errorMessage = "Le mot de passe est incorrect..." ;
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="assets/css/style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BLOGPHP</title>
</head>
<body>
    <header> 
    <h2>Vivre avec le corona : Mon combat</h2>
    </header>
    <div class="container">
        <div class="">
            <h3>Accueil</h3>
            <a href="/articles.php">Articles</a>
            <a href="/inscription.php">S'inscrire</a>
            <a href="/connexion.php">Se connecter</a>
        </div>
        <p>Statut : </p>

            <?php if (isset($_SESSION['userEmail'])) { ?>
                <p>Bonjour, <?= $_SESSION['userPseudo'] ?> !</p>
                <p>Email: <?= $_SESSION['userEmail'] ?> </p>
                <a href="deconnexion.php">Se déconnecter</a> <br>
                <h3>Changer de mot de passe</h3>
                <?php  if(isset($errorMessage)) { ?> <p style="color: red;"><?= $errorMessage ?></p><?php } ?>
                <?php if (isset($succesMessage)) { ?> <p style="color: green;"><?= $succesMessage ?></p><?php } ?>
        
                <form method="post" action="">
                    <span>Pseudo : </span> <br>
                    <input type="text" name="pseudo" placeholder="Pseudo"> <br>

                    <span>Email :</span> <br>
                    <input type="email" name="email" placeholder="Email"><br>

                    <span>Ancien mot de passe :</span><br>
                    <input type="password" name="old_password" placeholder="Mot de passe"><br>

                    <span>Nouveau de mot de passe :</span><br>
                    <input type="password" name="password" placeholder="Mot de passe"><br>

                    <span>Confirmation du nouveau mot de passe :</span><br>
                    <input type="password" name="confirm_password" placeholder="Confirmation mot de passe"><br>

                    <input type="submit" name="submit" value="Valider">
            </form>
            <?php } else { ?>
            <p>Vous n'êtes pas encore connecté !</p>
            <?php }?>
        </div>
    </div>
</body>
</html>