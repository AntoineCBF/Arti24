<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
require "$root/connexion/function.php";
require "$root/connexion/config.php";
init_session_php();
if (is_logged() && is_particulier())
{
    // $check = $bdd->prepare('INSERT INTO avis(`note`,`type_inter`,`commentaire`, `prix`, `date_inter`, `id_intervention`) VALUES (4, "Coupure", "Le plombier Jojo a été très à l\'écoute de mes problèmes. Toujours souriant, il a su intervenir de manière efficace.", 70, "2024-03-07", 2)');
    // $check->execute();
    $check = $bdd->prepare('SELECT DISTINCT metier FROM Metier');
    $check->execute();
    $metiers = $check->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HomePage Particulier</title>
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
    <h1>Bienvenue <?php if(isset($_SESSION['prenom'])){echo $_SESSION['prenom'];}?></h1>
    <h2>Vous avez une urgence ?</h2>
    <form action="/traitement/urgence.php" method="post">
        <div class="metier">
            <p>Quelle corps de métier peut s'occuper de vous?</p>
            <select onchange=changeMetier() name="metier" id="metier">
                <option value="">Choisissez votre métier ici</option>
            <?php foreach($metiers as $m){
                ?>
                <option value="<?php echo $m['metier'];?>"><?php echo $m['metier'];?></option>
                <?php
            }?>
            </select>
        </div>
        <?php foreach($metiers as $m){?>
        <div class="type_metier" id="<?php echo $m['metier'];?>">
            <?php 
            $check = $bdd->prepare('SELECT DISTINCT type_urgence, temps FROM Metier WHERE metier=?');
            $check->execute(array($m['metier']));
            $type_urgence = $check->fetchAll(PDO::FETCH_ASSOC);
            foreach($type_urgence as $type){
            ?>
            <div class="<?php echo $m['metier'];?>">
                <label for="<?php echo $type['type_urgence'];?>"><?php echo $type['type_urgence'];?></label>
                <input type="radio" name="type_urgence" id="<?php echo $type['type_urgence'];?>" value="<?php echo $type['type_urgence'];?>" />
                <p><?php echo $type['temps'];?> minutes</p>
            </div>
            <?php
            }
            ?>
        </div>
        <?php
        }
        ?>
        <input type="button" onclick="openPopup()" value="Valider"/>
        <div id="popUp" style="display: none;">
            <label for="creneau">Sur quelle créneau êtes-vous disponible ? </label>
            <input type="time" name="debut" id="creneau" value="12:00"/> - <input type="time" name="fin" value="14:00"/> <br/>
            <label for="day">Le : </label>
            <input type="date" id="day" name="date" value=<?php echo date("Y-m-d"); ?> min=<?php echo date("Y-m-d"); ?> max=<?php echo date("Y-m-d", strtotime(date("Y-m-d")." + 7 days")); ?> /> </br>
            <button type="submit">Trouver son artisan </button>
        </div>
    </form>
    <script src="function.js"></script>
</body>
</html>
<?php
}
else{
    header('Location: /index.php?err=dest_unreachable');
}
?>
<style>
    .type_metier{
        display: none;
    }
</style>