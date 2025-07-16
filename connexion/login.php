<!-- CREDENTIALS TESTTEST ARTISAN :
email : testtest@test.com
mdp : Bonjour123

CREDENTIALS ANTO PARTICULIER :
email : anto.test@gmail.com
mdp : Azerty1212

-->


<?php
    require 'function.php';
    init_session_php();

    if(isset($_GET['action']) && !empty($_GET['action']) && $_GET['action']=="logout"){
        clean_php_session();
        header('Location: /index.php?action=logout');
    }
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Arti'24 : Se connecter</title>
    <script src="https://kit.fontawesome.com/768b004a56.js" crossorigin="anonymous"></script>
</head>
<body>
    <nav class="navbar">
        <ul>
            <li id="logo"> <a href ="/index.php"> LOGO </a></li>
            <li> <a href ="/quiSommesNous.php"> Qui sommes-nous ?</a>
            <?php if(is_logged()):?>
            <li> <a href ="/connexion/login.php?action=logout"> Se Déconnecter </a> </li>
            <?php if(is_artisan()):?>
            <li> <a href ="/EspaceArtisan/monEspaceArtisan.php"> Mon Espace </a> </li>
            <?php elseif(is_particulier()):?>
            <li> <a href ="/EspaceParticulier/monEspaceParticulier.php"> Mon Espace </a> </li>
            <?php endif;?>
            <?php else:?>
            <li> <a href ="/connexion/login.php"> Se Connecter </a> </li>
            <li> <a href ="/connexion/register.php"> S'inscrire </a> </li>
            <?php endif;?>
        </ul>
    </nav>
    <div class="body">
        <h1> Se connecter :</h1>
            <?php
                if(isset($_GET['err'])){
                    $err = htmlspecialchars($_GET['err']);
                    ?>
                    <div class="popup">
                    <?php
                    switch($err){
                        case 'connection_failure':
                            ?>
                            <p><strong> Erreur...</strong></p>
                            <?php
                            break;
                        case 'missing_values':
                            ?>
                            <p><strong> Erreur : </strong>Valeurs manquantes !</p>
                            <?php
                            break;
                        case 'not_registered':
                            ?>
                            <p><strong> Erreur : </strong>Aucun compte avec ce mail. Vous devez d'abord créer un compte</p>
                            <?php
                            break;
                        case 'wrong_pass':
                            ?>
                            <p><strong> Erreur : </strong>Mot de passe incorrect</p>
                            <?php
                            break;
                    }?>
                    </div>
                    <?php
                }?>
        <div class="Artisan">
            <h2>Je suis un Artisan</h2> 
            <form action="connexion.php?artisan=1" method="post">
                <ul>
                    <li>
                        <label for="mail1">Email :</label> <br/>
                        <input type="email" id="mail1" name="email" required="required" maxlength="100" placeholder="abcd@exemple.com" autocomplete="on">
                    </li>
                    <li>
                        <label for="mdpA">Mot de Passe :</label> <br/>
                        <input type="password" id="mdpA" name="password" required="required" placeholder="Mot de Passe" autocomplete="on">
                    </li>
                </ul>
                <div class="button">
                    <button type="submit">Se connecter</button>
                </div>
            </form>
        </div>
        <div class="Particulier">
            <h2>Je suis un Particulier</h2> 
            <form action="connexion.php?artisan=0" method="post">
                <ul>
                    <li>
                        <label for="mail2">Email :</label> <br/>
                        <input type="email" id="mail2" name="email" required="required" maxlength="100" placeholder="abcd@exemple.com" autocomplete="on">
                    </li>
                    <li>
                        <label for="mdp">Mot de Passe :</label> <br/>
                        <input type="password" id="mdp" name="password" required="required" placeholder="Mot de Passe" autocomplete="on">
                    </li>
                </ul>
                <div class="button">
                    <button type="submit">Se connecter</button>
                </div>
            </form>
        </div>
    </div>
    <footer>
        <p> Copyrights © 2023, by Arti'24. All rights reserved.</p>
    </footer>
</body>
</html>