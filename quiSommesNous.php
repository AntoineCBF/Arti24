<?php
    $root = realpath($_SERVER["DOCUMENT_ROOT"]);
    require "$root/connexion/function.php";
    init_session_php();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Arti'24</title>
</head>
<body>
    <nav class="navbar">
        <ul>
            <li id="logo"> <a href ="/index.php"> LOGO </a></li>
            <li> <a href ="/quiSommesNous.php"> Qui sommes-nous ?</a>
            <?php if(is_logged()):?>
            <li> <a href ="/connexion/login.php?action=logout"> Se Deconnecter </a> </li>
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
    
</body>
</html>