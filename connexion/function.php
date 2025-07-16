<?php
require_once 'config.php';

function init_session_php() :bool
{
    if(!session_id())
    {
        session_start();
        session_regenerate_id();
        return true;
    }
    return false;
}

function clean_php_session() : void
{
    session_unset();
    session_destroy();
}

function is_logged() : bool
{
    if (isset($_SESSION['privilege'])){
        if($_SESSION['privilege']==1){
            return true;
        }
    }
    return false;;
}

function is_artisan() : bool
{
    if (isset($_SESSION['id_Artisan']) && !empty($_SESSION['id_Artisan'])){
        return true;
    }
    return false;
}

function is_particulier() : bool
{
    if (isset($_SESSION['id_Particulier']) && !empty($_SESSION['id_Particulier'])){
        return true;
    }
    return false;
}

function is_firstConnexion() : bool
{
    return (isset($_SESSION['nb_connexion']) && !empty($_SESSION['nb_connexion']) && $_SESSION['nb_connexion']==1);
}

function get_rendezvous($bdd)
{
    if(is_particulier()){
        $check = $bdd->prepare("SELECT nom, metier, date_jour, date_debut, date_fin, type_urgence FROM interventions NATURAL JOIN Artisans NATURAL JOIN metier WHERE id_Particulier=:id AND type_urgence=type_intervention AND date_jour >= :date_j");
        $check->execute(array(
            'id' => $_SESSION['id_Particulier'],
            'date_j' => date("Y-m-d") 
        ));
    }
    else if(is_artisan()){
        $check = $bdd->prepare("SELECT prenom, adresse, ville, date_jour, date_debut, date_fin, type_intervention, prix FROM interventions NATURAL JOIN Particuliers INNER JOIN coordonnees ON Particuliers.id_Particulier=coordonnees.id_Particulier WHERE interventions.id_Artisan=:id AND date_jour >= :date_j");
        $check->execute(array(
            'id' => $_SESSION['id_Artisan'],
            'date_j' => date("Y-m-d") 
        ));
    }
    $data = $check->fetchAll(PDO::FETCH_ASSOC);
    return $data;
}

function checkIBAN($iban)
{
    if(strlen($iban) < 5) return false;
    $iban = strtolower(str_replace(' ','',$iban));
    $Countries = array('al'=>28,'ad'=>24,'at'=>20,'az'=>28,'bh'=>22,'be'=>16,'ba'=>20,'br'=>29,'bg'=>22,'cr'=>21,'hr'=>21,'cy'=>28,'cz'=>24,'dk'=>18,'do'=>28,'ee'=>20,'fo'=>18,'fi'=>18,'fr'=>27,'ge'=>22,'de'=>22,'gi'=>23,'gr'=>27,'gl'=>18,'gt'=>28,'hu'=>28,'is'=>26,'ie'=>22,'il'=>23,'it'=>27,'jo'=>30,'kz'=>20,'kw'=>30,'lv'=>21,'lb'=>28,'li'=>21,'lt'=>20,'lu'=>20,'mk'=>19,'mt'=>31,'mr'=>27,'mu'=>30,'mc'=>27,'md'=>24,'me'=>22,'nl'=>18,'no'=>15,'pk'=>24,'ps'=>29,'pl'=>28,'pt'=>25,'qa'=>29,'ro'=>24,'sm'=>27,'sa'=>24,'rs'=>22,'sk'=>24,'si'=>19,'es'=>24,'se'=>24,'ch'=>21,'tn'=>24,'tr'=>26,'ae'=>23,'gb'=>22,'vg'=>24);
    $Chars = array('a'=>10,'b'=>11,'c'=>12,'d'=>13,'e'=>14,'f'=>15,'g'=>16,'h'=>17,'i'=>18,'j'=>19,'k'=>20,'l'=>21,'m'=>22,'n'=>23,'o'=>24,'p'=>25,'q'=>26,'r'=>27,'s'=>28,'t'=>29,'u'=>30,'v'=>31,'w'=>32,'x'=>33,'y'=>34,'z'=>35);

    if(array_key_exists(substr($iban,0,2), $Countries) && strlen($iban) == $Countries[substr($iban,0,2)]){
                
        $MovedChar = substr($iban, 4).substr($iban,0,4);
        $MovedCharArray = str_split($MovedChar);
        $NewString = "";

        foreach($MovedCharArray AS $key => $value){
            if(!is_numeric($MovedCharArray[$key])){
                if(!isset($Chars[$MovedCharArray[$key]])) return false;
                $MovedCharArray[$key] = $Chars[$MovedCharArray[$key]];
            }
            $NewString .= $MovedCharArray[$key];
        }
        
        if(bcmod($NewString, '97') == 1)
        {
            return true;
        }
    }
    return false;
}

function moyenne($tab){
    $len = sizeof($tab);
    $sum=0;
    foreach($tab as $val){
        $sum += $val["note"];
    }
    return $sum/$len;
}

function calculAvis($bdd){
    $val = [0, 0, 0, 0, 0];
    $check = $bdd->prepare("SELECT note FROM avis INNER JOIN interventions ON avis.id_intervention = interventions.id_intervention WHERE id_Artisan = ?");
    $check->execute(array($_SESSION['id_Artisan']));
    $data = $check->fetchAll(PDO::FETCH_ASSOC);
    foreach($data as $note){
        switch($note["note"]){
            case 1:
                $val[0]+=1;
                break;
            case 2:
                $val[1]+=1;
                break;
            case 3:
                $val[2]+=1;
                break;
            case 4:
                $val[3]+=1;
                break;
            case 5:
                $val[4]+=1;
                break;
            default:
                break;
        }
    }
    return $val;
}

function countDays($date){
    $current = time();
    $epochdate = strtotime($date);
    $ago = $current - $epochdate;
    $min=60;
    $heure=$min*60;
    $jour=$heure*24;
    $moi=$jour*30;
    $year=$moi*365;
    if($ago<$jour){
        $temps = "moins d'un";
        $section = "jour";
    }
    else if($ago >= $jour && $ago < $moi){
        $temps = $ago%$jour;
        $section="jours";
        if($temps==1){
            $section="jour";
        }
    }
    else if($ago >= $moi && $ago < $year){
        $temps=$ago%$moi;
        $section="mois";
        if($temps==1){
            $section="moi";
        }
    }
    else{
        $temps=$ago%$year;
        $section="années";
        if($temps==1){
            $section="année";
        }
    }
    return "Il y a ".$temps." ".$section;
}

function checkcreneau($debut, $fin, $date, $time){
    $flag=false;
    //Vérification de la date :
    if (strtotime($date)>= strtotime(date("Y-m-d")) && strtotime(date("Y-m-d")." + 7 days") >= strtotime($date)){
        $debut_epoch = strtotime($debut);
        $fin_epoch = strtotime($fin);
        //Vérification de la durée du créneau
        $time_epoch = $time*60;
        if($time_epoch <= $fin_epoch - $debut_epoch){
            $flag=true;
        }
    }
    return $flag;
}