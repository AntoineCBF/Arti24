<?php
    require "connexion/function.php";
    init_session_php();

    $check = $bdd->prepare('SELECT note, date_inter, commentaire, prenom FROM avis INNER JOIN interventions ON avis.id_intervention = interventions.id_intervention INNER JOIN particuliers ON particuliers.id_Particulier=interventions.id_Particulier ORDER BY date_inter LIMIT 4');
    $check->execute();
    $tab_client = $check->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/768b004a56.js" crossorigin="anonymous"></script>
    <title>Arti'24 : Bienvenue !</title>
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
    <div class="popup">
    <?php
    if(!is_logged() && isset($_GET['action']) && !empty($_GET['action']) && $_GET['action']=="logout"){
        ?> <p>Vous avez bien été déconnecté !</p><?php
    }
    if(isset($_GET['err']) && !empty($_GET['err'])){
        $err = htmlspecialchars($_GET['err']);
        switch($err){
            case 'dest_unreachable':
                ?>
                <p><strong>Erreur...</strong></p>
                <?php
        }
    }?>
    </div>
    <div class="upper-body">
        <h1> Une Urgence ? Arti'24 </h1>
        <div class="description">
            <ul>
                <li>Artisan : <p> Vous etes un Artisan ? Inscrivez vous pour pouvoir répondre aux urgences de nos particuliers</p></li>
                <li>Particulier : <p> Vous etes un Particulier ? Rejoignez nous pour que les Artisans de votre région vous dépanne !</li>
            </ul>
        </div>
    </div>
    <div class="lower-body">
        <h2> Ils nous ont fait confiance : </h2>
        <ul> 
            <?php foreach($tab_client as $client) { ?>
                <li> <?php echo $client["prenom"].'<br>'. $client["date_inter"].'<br>'.$client["note"].'<i class="fa-solid fa-star"></i><p>'.$client["commentaire"].'</p>'?></li>
            <?php } ?>
        </ul>
        <footer>
            <p> Copyrights © 2023, by Arti'24. All rights reserved.</p>
        </footer>
</body>
</html>