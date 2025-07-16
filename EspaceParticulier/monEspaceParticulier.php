<?php
    $root = realpath($_SERVER["DOCUMENT_ROOT"]);
    require "$root/connexion/config.php";
    require "$root/connexion/function.php";
    init_session_php();
    if (is_logged() && is_particulier()){
        //$insert = $bdd->prepare("INSERT INTO interventions(date_debut, date_fin, date_jour, id_Artisan, id_Particulier) VALUES ('22:00', '23:00', '2024-05-07', '15', '6')");
        //$insert->execute();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Espace Particulier</title>
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
            <li> <a href ="/EspaceParticulier/homepageParticulier.php"> Une Urgence? </a> </li>
            <?php endif;?>
            <?php else:?>
            <li> <a href ="/connexion/login.php"> Se Connecter </a> </li>
            <li> <a href ="/connexion/register.php"> S'inscrire </a> </li>
            <?php endif;?>
        </ul>
    </nav>
    <h1>Bienvenue <?php echo $_SESSION['prenom']?></h1>
    <div class="rdv">
        <h2>Mes rendez-vous :</h2>
        <ul>
            <?php $value = get_rendezvous($bdd);
            foreach($value as $val){
                echo "<li>Votre Artisan : ".$val['nom'].", profession : ".$val['metier'].", Date : ".$val['date_jour'].", ".$val['type_urgence']." à ".$val['date_debut']." jusqu'à ".$val['date_fin']."</li>";
            }
        ?>
        </ul>
    </div>
    <div class="urgence">
        <h2>Une urgence ?</h2>
        <p>Cliquez ici pour rencontrer un Artisan</p>
        <a href="homepageParticulier.php"><button>Urgence</button></a>
    </div>
</body>
</html>

<?php
    }
    else{
        header('Location: /index.php?err=dest_unreachable');
    }
    ?>