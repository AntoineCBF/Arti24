<?php
    $root = realpath($_SERVER["DOCUMENT_ROOT"]);
    require "$root/connexion/function.php";
    require "$root/connexion/config.php";
    init_session_php();
    if (is_logged() && is_artisan()){
    // On vérifie si les horraires sont déjà dans la BDD
    $check = $bdd->prepare('SELECT id_artisan FROM disponibiliteartisan WHERE id_Artisan = ?');
    $check->execute(array($_SESSION['id_Artisan']));
    $data = $check->fetch();
    $row = $check->rowCount();
    $first=($row==0);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HomePage Artisan</title>
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
            <li> <a href ="/EspaceParticulier/homepageArtisan.php"> Mes Disponibilités </a> </li>
            <?php endif;?>
            <?php else:?>
            <li> <a href ="/connexion/login.php"> Se Connecter </a> </li>
            <li> <a href ="/connexion/register.php"> S'inscrire </a> </li>
            <?php endif;?>
        </ul>
    </nav>
    <h1>Bienvenue <?php if(isset($_SESSION['nom'])){echo $_SESSION['nom'];}?></h1>
    <p>Spécifiez ici vos horraires de travail !</p>
    <form action="artisan.php?horraire=classique" method="post">
        <?php if (!$first){
            $check = $bdd->prepare('SELECT heure_debut,heure_fin,heure_debut_urgence,heure_fin_urgence,id_jour FROM disponibiliteartisan WHERE id_Artisan = ? AND id_jour = 1');
            $check->execute(array($_SESSION['id_Artisan']));
            $data = $check->fetch(PDO::FETCH_ASSOC);
            $lundiDeb=$data["heure_debut"];
            $lundiFin=$data["heure_fin"];
            $check = $bdd->prepare('SELECT heure_debut,heure_fin,heure_debut_urgence,heure_fin_urgence,id_jour FROM disponibiliteartisan WHERE id_Artisan = ? AND id_jour = 2');
            $check->execute(array($_SESSION['id_Artisan']));
            $data = $check->fetch(PDO::FETCH_ASSOC);
            $mardiDeb=$data["heure_debut"];
            $mardiFin=$data["heure_fin"];
            $check = $bdd->prepare('SELECT heure_debut,heure_fin,heure_debut_urgence,heure_fin_urgence,id_jour FROM disponibiliteartisan WHERE id_Artisan = ? AND id_jour = 3');
            $check->execute(array($_SESSION['id_Artisan']));
            $data = $check->fetch(PDO::FETCH_ASSOC);
            $mercrediDeb=$data["heure_debut"];
            $mercrediFin=$data["heure_fin"];
            $check = $bdd->prepare('SELECT heure_debut,heure_fin,heure_debut_urgence,heure_fin_urgence,id_jour FROM disponibiliteartisan WHERE id_Artisan = ? AND id_jour = 4');
            $check->execute(array($_SESSION['id_Artisan']));
            $data = $check->fetch(PDO::FETCH_ASSOC);
            $jeudiDeb=$data["heure_debut"];
            $jeudiFin=$data["heure_fin"];
            $check = $bdd->prepare('SELECT heure_debut,heure_fin,heure_debut_urgence,heure_fin_urgence,id_jour FROM disponibiliteartisan WHERE id_Artisan = ? AND id_jour = 5');
            $check->execute(array($_SESSION['id_Artisan']));
            $data = $check->fetch(PDO::FETCH_ASSOC);
            $vendrediDeb=$data["heure_debut"];
            $vendrediFin=$data["heure_fin"];
            $check = $bdd->prepare('SELECT heure_debut,heure_fin,heure_debut_urgence,heure_fin_urgence,id_jour FROM disponibiliteartisan WHERE id_Artisan = ? AND id_jour = 6');
            $check->execute(array($_SESSION['id_Artisan']));
            $data = $check->fetch(PDO::FETCH_ASSOC);
            $samediDeb=$data["heure_debut"];
            $samediFin=$data["heure_fin"];
            $check = $bdd->prepare('SELECT heure_debut,heure_fin,heure_debut_urgence,heure_fin_urgence,id_jour FROM disponibiliteartisan WHERE id_Artisan = ? AND id_jour = 7');
            $check->execute(array($_SESSION['id_Artisan']));
            $data = $check->fetch(PDO::FETCH_ASSOC);
            $dimancheDeb=$data["heure_debut"];
            $dimancheFin=$data["heure_fin"];
        }
        else{
            $lundiDeb=$mardiDeb=$mercrediDeb=$jeudiDeb=$vendrediDeb=$samediDeb=$dimancheDeb="08:00";
            $lundiFin=$mardiFin=$mercrediFin=$jeudiFin=$vendrediFin=$samediFin=$dimancheFin="18:00";
        }?>
        <ul class="horraire_trav">
            <li>
                <label for="lundideb">Lundi :</label> <input type="time" name="lundideb" id="lundideb" value="<?php echo $lundiDeb;?>"/> - <input type="time" name="lundifin" id="lundifin" value="<?php echo $lundiFin;?>"/>
            </li>
            <li>
                <label for="mardideb">Mardi :</label> <input type="time" name="mardideb" id="mardideb" value="<?php echo $mardiDeb;?>"/> - <input type="time" name="mardifin" id="mardifin" value="<?php echo $mardiFin;?>"/>
            </li>
            <li>
                <label for="mercredideb">Mercredi :</label> <input type="time" name="mercredideb" id="mercredideb" value="<?php echo $mercrediDeb;?>"/> - <input type="time" name="mercredifin" id="mercredifin" value="<?php echo $mercrediFin;?>"/>
            </li>
            <li>
                <label for="jeudideb">Jeudi :</label> <input type="time" name="jeudideb" id="jeudideb" value="<?php echo $jeudiDeb;?>"/> - <input type="time" name="jeudifin" id="jeudifin" value="<?php echo $jeudiFin;?>"/>
            </li>
            <li >
                <label for="vendredideb">Vendredi :</label> <input type="time" name="vendredideb" id="vendredideb" value="<?php echo $vendrediDeb;?>"/> - <input type="time" name="vendredifin" id="vendredifin" value="<?php echo $vendrediFin;?>"/>
            </li>
            <li>
                <label for="samedideb">Samedi :</label> <input type="time" name="samedideb" id="samedideb" value="<?php echo $samediDeb;?>"/> - <input type="time" name="samedifin" id="samedifin" value="<?php echo $samediFin;?>"/>
            </li>
            <li>
                <label for="dimanchedeb">Dimanche :</label> <input type="time" name="dimanchedeb" id="dimanchedeb" value="<?php echo $dimancheDeb;?>"/> - <input type="time" name="dimanchefin" id="dimanchefin" value="<?php echo $dimancheFin;?>"/>
            </li>
        </ul>
        <div class="button">
            <button type="submit" id="classique">Valider</button>
        </div>
    </form>
    <form action="artisan.php?horraire=urgence" method="post">
        <?php
            // On vérifie si les horraires sont déjà dans la BDD
            $check = $bdd->prepare('SELECT id_Artisan FROM disponibiliteartisan WHERE id_Artisan = ? AND heure_debut_urgence IS NOT NULL AND heure_fin_urgence IS NOT NULL');
            $check->execute(array($_SESSION['id_Artisan']));
            $data = $check->fetch();
            $row = $check->rowCount();
            $first_urg=($row==0);
            if($first_urg && $first){
                $lundiDeb_urg=$mardiDeb_urg=$mercrediDeb_urg=$jeudiDeb_urg=$vendrediDeb_urg=$samediDeb_urg=$dimancheDeb_urg="08:00";
                $lundiFin_urg=$mardiFin_urg=$mercrediFin_urg=$jeudiFin_urg=$vendredriFin_urg=$samediFin_urg=$dimancheFin_urg="18:00";
                $perimetre=50;
            }
            else if ($first_urg && !$first){
                $lundiDeb_urg=$lundiDeb;
                $mardiDeb_urg=$mardiDeb;
                $mercrediDeb_urg=$mercrediDeb;
                $jeudiDeb_urg=$jeudiDeb;
                $vendrediDeb_urg=$vendrediDeb;
                $samediDeb_urg=$samediDeb;
                $dimancheDeb_urg=$dimancheDeb;
                $lundiFin_urg=$lundiFin;
                $mardiFin_urg=$mardiFin;
                $mercrediFin_urg=$mercrediFin;
                $jeudiFin_urg=$jeudiFin;
                $vendredriFin_urg=$vendrediFin;
                $samediFin_urg=$samediFin;
                $dimancheFin_urg=$dimancheFin;
                $perimetre=50;
            }
            else if (!$first_urg){
                $check = $bdd->prepare('SELECT heure_debut,heure_fin,heure_debut_urgence,heure_fin_urgence,id_jour FROM disponibiliteartisan WHERE id_Artisan = ? AND id_jour = 1');
                $check->execute(array($_SESSION['id_Artisan']));
                $data = $check->fetch(PDO::FETCH_ASSOC);
                $lundiDeb_urg=$data["heure_debut_urgence"];
                $lundiFin_urg=$data["heure_fin_urgence"];
                $check = $bdd->prepare('SELECT heure_debut,heure_fin,heure_debut_urgence,heure_fin_urgence,id_jour FROM disponibiliteartisan WHERE id_Artisan = ? AND id_jour = 2');
                $check->execute(array($_SESSION['id_Artisan']));
                $data = $check->fetch(PDO::FETCH_ASSOC);
                $mardiDeb_urg=$data["heure_debut_urgence"];
                $mardiFin_urg=$data["heure_fin_urgence"];
                $check = $bdd->prepare('SELECT heure_debut,heure_fin,heure_debut_urgence,heure_fin_urgence,id_jour FROM disponibiliteartisan WHERE id_Artisan = ? AND id_jour = 3');
                $check->execute(array($_SESSION['id_Artisan']));
                $data = $check->fetch(PDO::FETCH_ASSOC);
                $mercrediDeb_urg=$data["heure_debut_urgence"];
                $mercrediFin_urg=$data["heure_fin_urgence"];
                $check = $bdd->prepare('SELECT heure_debut,heure_fin,heure_debut_urgence,heure_fin_urgence,id_jour FROM disponibiliteartisan WHERE id_Artisan = ? AND id_jour = 4');
                $check->execute(array($_SESSION['id_Artisan']));
                $data = $check->fetch(PDO::FETCH_ASSOC);
                $jeudiDeb_urg=$data["heure_debut_urgence"];
                $jeudiFin_urg=$data["heure_fin_urgence"];
                $check = $bdd->prepare('SELECT heure_debut,heure_fin,heure_debut_urgence,heure_fin_urgence,id_jour FROM disponibiliteartisan WHERE id_Artisan = ? AND id_jour = 5');
                $check->execute(array($_SESSION['id_Artisan']));
                $data = $check->fetch(PDO::FETCH_ASSOC);
                $vendrediDeb_urg=$data["heure_debut_urgence"];
                $vendrediFin_urg=$data["heure_fin_urgence"];
                $check = $bdd->prepare('SELECT heure_debut,heure_fin,heure_debut_urgence,heure_fin_urgence,id_jour FROM disponibiliteartisan WHERE id_Artisan = ? AND id_jour = 6');
                $check->execute(array($_SESSION['id_Artisan']));
                $data = $check->fetch(PDO::FETCH_ASSOC);
                $samediDeb_urg=$data["heure_debut_urgence"];
                $samediFin_urg=$data["heure_fin_urgence"];
                $check = $bdd->prepare('SELECT heure_debut,heure_fin,heure_debut_urgence,heure_fin_urgence,id_jour FROM disponibiliteartisan WHERE id_Artisan = ? AND id_jour = 7');
                $check->execute(array($_SESSION['id_Artisan']));
                $data = $check->fetch(PDO::FETCH_ASSOC);
                $dimancheDeb_urg=$data["heure_debut_urgence"];
                $dimancheFin_urg=$data["heure_fin_urgence"];

                $check = $bdd->prepare('SELECT perimetre_intervention FROM typeintervention WHERE id_Artisan = ?');
                $check->execute(array($_SESSION['id_Artisan']));
                $data = $check->fetch(PDO::FETCH_ASSOC);
                $perimetre=$data["perimetre_intervention"];
            }
        ?>
        <ul>
            <p>Spécifiez ici vos horraires d'urgences :</p>
                <ul class="horraire_trav_urg">
                    <li>
                        <label for="lundideb_urg">Lundi :</label> <input type="time" name="lundideb_urg" id="lundideb_urg" value="<?php echo $lundiDeb_urg;?>"/> - <input type="time" name="lundifin_urg" id="lundifin_urg" value="<?php echo $lundiFin_urg;?>"/>
                    </li>
                    <li>
                        <label for="mardideb_urg">Mardi :</label> <input type="time" name="mardideb_urg" id="mardideb_urg" value="<?php echo $mardiDeb_urg;?>"/> - <input type="time" name="mardifin_urg" id="mardifin_urg" value="<?php echo $mardiFin_urg;?>"/>
                    </li>
                    <li>
                        <label for="mercredideb_urg">Mercredi :</label> <input type="time" name="mercredideb_urg" id="mercredideb_urg" value="<?php echo $mercrediDeb_urg;?>"/> - <input type="time" name="mercredifin_urg" id="mercredifin_urg" value="<?php echo $mercrediFin_urg;?>"/>
                    </li>
                    <li>
                        <label for="jeudideb_urg">Jeudi :</label> <input type="time" name="jeudideb_urg" id="jeudideb_urg" value="<?php echo $jeudiDeb_urg;?>"/> - <input type="time" name="jeudifin_urg" id="jeudifin_urg" value="<?php echo $jeudiFin_urg;?>"/>
                    </li>
                    <li>
                        <label for="vendredideb_urg">Vendredi :</label> <input type="time" name="vendredideb_urg" id="vendredideb_urg" value="<?php echo $vendrediDeb_urg;?>"/> - <input type="time" name="vendredifin_urg" id="vendredifin_urg" value="<?php echo $vendrediFin_urg;?>"/>
                    </li>
                    <li>
                        <label for="samedideb_urg">Samedi :</label> <input type="time" name="samedideb_urg" id="samedideb_urg" value="<?php echo $samediDeb_urg;?>"/> - <input type="time" name="samedifin_urg" id="samedifin_urg" value="<?php echo $samediFin_urg;?>"/>
                    </li>
                    <li>
                        <label for="dimanchedeb_urg">Dimanche :</label> <input type="time" name="dimanchedeb_urg" id="dimanchedeb_urg" value="<?php echo $dimancheDeb_urg;?>"/> - <input type="time" name="dimanchefin_urg" id="dimanchefin_urg" value="<?php echo $dimancheFin_urg;?>"/>
                    </li>
                </ul>
            <li>
                <p>Sur quelle distance êtes-vous prêt à intervenir ?</p>
                <label for="<?php echo "perimetre"; ?>"> Perimetre d'intervention (en km)</label> <input type="number" id="<?php echo "perimetre"; ?>" name="perimetre" value="<?php echo $perimetre;?>">
            </li>
            <p>Sur quels types d'urgence souhaitez vous intervenir ?</p>
            <li>
                <ul class="type_urg">
                    <?php
                        $check = $bdd->prepare('SELECT type_urgence FROM metier WHERE metier = ?');
                        $check->execute(array($_SESSION['metier']));
                        $data = $check->fetchAll(PDO::FETCH_ASSOC);
                        
                        $values = $bdd->prepare('SELECT type_inter FROM typeintervention WHERE id_Artisan = ?');
                        $values->execute(array($_SESSION['id_Artisan']));
                        $valuesArt = $values->fetchAll(PDO::FETCH_ASSOC);
                        $i=0;
                        foreach ($data as $type){
                            $flag=0;
                            foreach ($valuesArt as $val){
                                if ($val["type_inter"]==$type["type_urgence"]){
                                    $flag=1;
                                }
                            }
                            ?>
                            <label for="<?php echo $type["type_urgence"];?>"><?php echo $type["type_urgence"];?></label>
                            <input type="checkbox" id="<?php echo $type["type_urgence"];?>" name="<?php echo "type_inter".$i; ?>" value="<?php echo $type["type_urgence"];?>" <?php if ($flag==1){echo "checked";} ?>/>
                            <br>
                            <?php
                            $i++;
                        }
                    ?>
                </ul>
            </li>
        </ul>
        <div class="button">
            <button type="submit">Valider</button>
        </div>
    </form>
</body>
<script> 
    let lundideb = "lundideb";
    let lundifin = "lundifin";
    let mardideb = "mardideb";
    let mardifin = "mardifin";
    let mercredideb = "mercredideb";
    let mercredifin = "mercredifin";
    let jeudideb = "jeudideb";
    let jeudifin = "jeudifin";
    let vendredideb = "vendredideb";
    let vendredifin = "vendredifin";
    let samedideb = "samedideb";
    let samedifin = "samedifin";
    let dimanchedeb = "dimanchedeb";
    let dimanchefin = "dimanchefin";
    var input1 = document.getElementById(lundideb);
    var input11 = document.getElementById(lundifin);
    var input2 = document.getElementById(mardideb);
    var input21 = document.getElementById(mardifin);
    var input3 = document.getElementById(mercredideb);
    var input31 = document.getElementById(mercredifin);
    var input4 = document.getElementById(jeudideb);
    var input41 = document.getElementById(jeudifin);
    var input5 = document.getElementById(vendredideb);
    var input51 = document.getElementById(vendredifin);
    var input6 = document.getElementById(samedideb);
    var input61 = document.getElementById(samedifin);
    var input7 = document.getElementById(dimanchedeb);
    var input71 = document.getElementById(dimanchefin);

    let v = input1.value;
    <?php if ($first_urg)
    {
        ?>
    changeUrg();
    input1.onchange = function() {changeUrg()};
    input11.onchange = function() {changeUrg()};
    input2.onchange = function() {changeUrg()};
    input21.onchange = function() {changeUrg()};
    input3.onchange = function() {changeUrg()};
    input31.onchange = function() {changeUrg()};
    input4.onchange = function() {changeUrg()};
    input41.onchange = function() {changeUrg()};
    input5.onchange = function() {changeUrg()};
    input51.onchange = function() {changeUrg()};
    input6.onchange = function() {changeUrg()};
    input61.onchange = function() {changeUrg()};
    input7.onchange = function() {changeUrg()};
    input71.onchange = function() {changeUrg()};
    <?php
    }
    ?>
    function changeUrg(){
        v = input1.value;
        document.getElementById(lundideb.concat("_urg")).value = v;
        v = input11.value;
        document.getElementById(lundifin.concat("_urg")).value = v;
        v = input2.value;
        document.getElementById(mardideb.concat("_urg")).value = v;
        v = input21.value;
        document.getElementById(mardifin.concat("_urg")).value = v;
        v = input3.value;
        document.getElementById(mercredideb.concat("_urg")).value = v;
        v = input31.value;
        document.getElementById(mercredifin.concat("_urg")).value = v;
        v = input4.value;
        document.getElementById(jeudideb.concat("_urg")).value = v;
        v = input41.value;
        document.getElementById(jeudifin.concat("_urg")).value = v;
        v = input5.value;
        document.getElementById(vendredideb.concat("_urg")).value = v;
        v = input51.value;
        document.getElementById(vendredifin.concat("_urg")).value = v;
        v = input6.value;
        document.getElementById(samedideb.concat("_urg")).value = v;
        v = input61.value;
        document.getElementById(samedifin.concat("_urg")).value = v;
        v = input7.value;
        document.getElementById(dimanchedeb.concat("_urg")).value = v;
        v = input71.value;
        document.getElementById(dimanchefin.concat("_urg")).value = v;
    }
</script>
</html>
<?php
}
else{
    header('Location: /index.php?err=dest_unreachable');
}?>