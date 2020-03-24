<?php

session_start();
include 'config/base.php';


if (isset($_POST['submit'])){
    
    $pseudo = htmlspecialchars($_POST['pseudo']);
    $email = htmlspecialchars($_POST['email']);
    $password = sha1($_POST['password']);
    $password_confirm = sha1($_POST['password_confirm']);
    date_default_timezone_set('Europe/Paris');
    $date = date('d/m/Y à H:i/s');

    if ( (!empty($pseudo)) && (!empty($email)) && (!empty($password_confirm)) && (!empty($password)) ) {
        if (strlen($pseudo) <= 16) {
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                if($password == $password_confirm) {
                    
                    
                    $Database = getPDO();
                    var_dump($Database);
                    
                    
                    $rowEmail = countDatabaseValue($Database, 'email', $email);
                        if($rowEmail == 0) {
                            
                            $rowPseudo = countDatabaseValue($Database, 'pseudo', $pseudo);
                        if($rowPseudo == 0) {
                            $insertMember = $Database->prepare("INSERT INTO Utilisateur(nom, pseudo, email, motDePasse, _role) VALUES (?, ?, ?, ?, ?)");
                            $insertMember->execute([
                            $pseudo,
                            $email,
                            $password,
                            1,
                        ]);
                            
                            $succesMessage = "Votre compte à bien été créé !";
                            header("location:connexion.php");

                        }else {
                            $errorMessage = "Ce pseudo est déjà utilisé";
                        }
                    }else {
                            $errorMessage = "Cet email est déjà utilisé";
                    }  
                }else{
                    $errorMessage = "Les mots de passes ne correspondent pas...";
                }
            }else {
                $errorMessage = "Votre Email n'est pas valide";
            }
        }else {
            $errorMessage = "Le pseudo est trop long";
        }

    } else {
        $errorMessage = "Try again";
    }
    
}

?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Inscription</title>
</head>
<body>
    <div class="container">
    <div class="#">
    <h3>Blog</h3>
    <a href="index.php">Accueil</a>
    <a href="connexion.php">Se Connecter</a>
    </div>
    
    <div class="#">
        <h3>Inscription</h3>
        <?php  if(isset($errorMessage)) { ?> <p style="color: red;"><?= $errorMessage ?></p><?php } ?>
        <?php if (isset($succesMessage)) { ?> <p style="color: green;"><?= $succesMessage ?></p><?php } ?>
        
        <form method="post" action="">
            <span>Pseudo : </span> <br>
            <input type="text" name="pseudo" placeholder="Pseudo"> <br>

            <span>Email :</span> <br>
            <input type="email" name="email" placeholder="Email"><br>

            <span>Mot de passe :</span><br>
            <input type="password" name="password" placeholder="Mot de passe"><br>

            <span>Confirmation de mot de passe</span><br>
            <input type="password" name="password_confirm" placeholder="Confirmation du mot de passe"><br>

            <input type="submit" name="submit" value="Envoyer">
        </form>
    </div>
</div>
</body>
</html>