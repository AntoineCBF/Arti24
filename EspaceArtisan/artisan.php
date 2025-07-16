<?php

// NOTE POUR PLUS TARD, FAIRE LE CAS OU L'ARTISAN NE TRAVAILLE PAS LE DIMANCHE PAR EXEMPLE
// BOUCLE FOR EACH SUR LE LA VARIABLE $_POST, if isempty : value = 00:00 
    $root = realpath($_SERVER["DOCUMENT_ROOT"]);
    require "$root/connexion/function.php";
    require "$root/connexion/config.php";
    init_session_php();
    if (is_logged() && is_artisan()){
        if (isset($_GET['rib']) && !empty($_GET['rib'])){
            $rib = htmlspecialchars($_GET['rib']);
            if (isset($_POST['IBAN']) && !empty($_POST['IBAN']) ){
                $iban = htmlspecialchars($_POST['IBAN']);
                if(checkIBAN($iban)){
                    if ($rib==1){
                        $check = $bdd->prepare('SELECT RIB FROM banque WHERE id_Artisan = ?');
                        $check->execute(array($_SESSION['id_Artisan']));
                        $row = $check->rowCount();
                        if ($row<1){
                            $check = $bdd->prepare('INSERT INTO banque(`RIB`, `id_Artisan`) VALUES (:val, :id)');
                            $check->execute(array('val' => $iban,
                                                'id' => $_SESSION['id_Artisan']));
                            header('Location: /EspaceArtisan/monEspaceArtisan.php?err=validate');die();
                        }
                        else header('Location: /EspaceArtisan/monEspaceArtisan.php?err=error');die();
                    }
                    else if ($rib==2){
                        $update = $bdd->prepare("UPDATE banque SET RIB=:val WHERE id_Artisan=:id");
                        $update->execute(array('val' => $iban,
                                                'id' => $_SESSION['id_Artisan']));
                        header('Location: /EspaceArtisan/monEspaceArtisan.php?err=modified');die();
                    }
                    else header('Location: /EspaceArtisan/monEspaceArtisan.php?err=error');die();
                }
                else header('Location: /EspaceArtisan/monEspaceArtisan.php?err=wrong_iban');die();
            }
            else header('Location: /EspaceArtisan/monEspaceArtisan.php?err=not_provided');die();     
        }
        else if(isset($_GET['horraire']) && !empty($_GET['horraire'])){
            $horr = htmlspecialchars($_GET['horraire']);
            // On vérifie si les horraires sont déjà dans la BDD
            $check = $bdd->prepare('SELECT id_artisan FROM disponibiliteartisan WHERE id_Artisan = ? AND heure_debut IS NOT NULL AND heure_fin IS NOT NULL');
            $check->execute(array($_SESSION['id_Artisan']));
            $data = $check->fetch();
            $row = $check->rowCount();
            $first=($row==0);
            // On vérifie si les horraires sont déjà dans la BDD
            $check = $bdd->prepare('SELECT id_artisan FROM disponibiliteartisan WHERE id_Artisan = ? AND heure_debut_urgence IS NOT NULL AND heure_fin_urgence IS NOT NULL');
            $check->execute(array($_SESSION['id_Artisan']));
            $data = $check->fetch();
            $row = $check->rowCount();
            $first_urg=($row==0);
            if ($horr=="classique"){     
                if(!empty($_POST['lundideb']) && !empty($_POST['lundifin']) && !empty($_POST['mardideb']) && !empty($_POST['mardifin']) && !empty($_POST['mercredideb']) && !empty($_POST['mercredifin']) && !empty($_POST['jeudideb']) && !empty($_POST['jeudifin']) && !empty($_POST['vendredideb']) && !empty($_POST['vendredifin']) && !empty($_POST['samedideb']) && !empty($_POST['samedifin']) && !empty($_POST['dimanchedeb']) && !empty($_POST['dimanchefin'])){
                    $lundiDeb=htmlspecialchars($_POST['lundideb']);
                    $lundiFin=htmlspecialchars($_POST['lundifin']);
                    $mardiDeb=htmlspecialchars($_POST['mardideb']);
                    $mardiFin=htmlspecialchars($_POST['mardifin']);
                    $mercrediDeb=htmlspecialchars($_POST['mercredideb']);
                    $mercrediFin=htmlspecialchars($_POST['mercredifin']);
                    $jeudiDeb=htmlspecialchars($_POST['jeudideb']);
                    $jeudiFin=htmlspecialchars($_POST['jeudifin']);
                    $vendrediDeb=htmlspecialchars($_POST['vendredideb']);
                    $vendrediFin=htmlspecialchars($_POST['vendredifin']);
                    $samediDeb=htmlspecialchars($_POST['samedideb']);
                    $samediFin=htmlspecialchars($_POST['samedifin']);
                    $dimancheDeb=htmlspecialchars($_POST['dimanchedeb']);
                    $dimancheFin=htmlspecialchars($_POST['dimanchefin']);
                    if ($first && $first_urg){
                        $insert = $bdd->prepare("INSERT INTO disponibiliteartisan(`heure_debut`, `heure_fin`,`id_Artisan`, `id_jour`) VALUES (:heure_deb1, :heure_fin1, :id_art1, :id_jour1), (:heure_deb2, :heure_fin2, :id_art2, :id_jour2), (:heure_deb3, :heure_fin3, :id_art3, :id_jour3), (:heure_deb4, :heure_fin4, :id_art4, :id_jour4), (:heure_deb5, :heure_fin5, :id_art5, :id_jour5), (:heure_deb6, :heure_fin6, :id_art6, :id_jour6), (:heure_deb7, :heure_fin7, :id_art7, :id_jour7)");
                        $insert->execute(array(
                            'heure_deb1' => $lundiDeb,
                            'heure_fin1' => $lundiFin,
                            'id_art1' => $_SESSION['id_Artisan'],
                            'id_jour1' => 1,
                            'heure_deb2' => $mardiDeb,
                            'heure_fin2' => $mardiFin,
                            'id_art2' => $_SESSION['id_Artisan'],
                            'id_jour2' => 2,
                            'heure_deb3' => $mercrediDeb,
                            'heure_fin3' => $mercrediFin,
                            'id_art3' => $_SESSION['id_Artisan'],
                            'id_jour3' => 3,
                            'heure_deb4' => $jeudiDeb,
                            'heure_fin4' => $jeudiFin,
                            'id_art4' => $_SESSION['id_Artisan'],
                            'id_jour4' => 4,
                            'heure_deb5' => $vendrediDeb,
                            'heure_fin5' => $vendrediFin,
                            'id_art5' => $_SESSION['id_Artisan'],
                            'id_jour5' => 5,
                            'heure_deb6' => $samediDeb,
                            'heure_fin6' => $samediFin,
                            'id_art6' => $_SESSION['id_Artisan'],
                            'id_jour6' => 6,
                            'heure_deb7' => $dimancheDeb,
                            'heure_fin7' => $dimancheFin,
                            'id_art7' => $_SESSION['id_Artisan'],
                            'id_jour7' => 7
                        ));
                        header('Location: /EspaceArtisan/homepageArtisan.php?err=success');die();
                    }
                    else if (!$first || ($first && !$first_urg)){
                        $update = $bdd->prepare("UPDATE disponibiliteartisan SET heure_debut=:heure_deb, heure_fin=:heure_fin WHERE id_Artisan=:id_art AND id_jour=1");
                        $update->execute(array(
                            'heure_deb' => $lundiDeb,
                            'heure_fin' => $lundiFin,
                            'id_art' => $_SESSION['id_Artisan']
                        ));
                        $update = $bdd->prepare("UPDATE disponibiliteartisan SET heure_debut=:heure_deb, heure_fin=:heure_fin WHERE id_Artisan=:id_art AND id_jour=2");
                        $update->execute(array(
                            'heure_deb' => $mardiDeb,
                            'heure_fin' => $mardiFin,
                            'id_art' => $_SESSION['id_Artisan']
                        ));
                        $update = $bdd->prepare("UPDATE disponibiliteartisan SET heure_debut=:heure_deb, heure_fin=:heure_fin WHERE id_Artisan=:id_art AND id_jour=3");
                        $update->execute(array(
                            'heure_deb' => $mercrediDeb,
                            'heure_fin' => $mercrediFin,
                            'id_art' => $_SESSION['id_Artisan']
                        ));
                        $update = $bdd->prepare("UPDATE disponibiliteartisan SET heure_debut=:heure_deb, heure_fin=:heure_fin WHERE id_Artisan=:id_art AND id_jour=4");
                        $update->execute(array(
                            'heure_deb' => $jeudiDeb,
                            'heure_fin' => $jeudiFin,
                            'id_art' => $_SESSION['id_Artisan']
                        ));
                        $update = $bdd->prepare("UPDATE disponibiliteartisan SET heure_debut=:heure_deb, heure_fin=:heure_fin WHERE id_Artisan=:id_art AND id_jour=5");
                        $update->execute(array(
                            'heure_deb' => $vendrediDeb,
                            'heure_fin' => $vendrediFin,
                            'id_art' => $_SESSION['id_Artisan']
                        ));
                        $update = $bdd->prepare("UPDATE disponibiliteartisan SET heure_debut=:heure_deb, heure_fin=:heure_fin WHERE id_Artisan=:id_art AND id_jour=6");
                        $update->execute(array(
                            'heure_deb' => $samediDeb,
                            'heure_fin' => $samediFin,
                            'id_art' => $_SESSION['id_Artisan']
                        ));
                        $update = $bdd->prepare("UPDATE disponibiliteartisan SET heure_debut=:heure_deb, heure_fin=:heure_fin WHERE id_Artisan=:id_art AND id_jour=7");
                        $update->execute(array(
                            'heure_deb' => $dimancheDeb,
                            'heure_fin' => $dimancheFin,
                            'id_art' => $_SESSION['id_Artisan']
                        ));
                        header('Location: /EspaceArtisan/homepageArtisan.php?err=success');die();
                    }
                }
            }
            else if($horr == "urgence"){
                if(isset($_POST['perimetre']) && !empty($_POST['perimetre']) && !empty($_POST['lundideb_urg']) && !empty($_POST['lundifin_urg']) && !empty($_POST['mardideb_urg']) && !empty($_POST['mardifin_urg']) && !empty($_POST['mercredideb_urg']) && !empty($_POST['mercredifin_urg']) && !empty($_POST['jeudideb_urg']) && !empty($_POST['jeudifin_urg']) && !empty($_POST['vendredideb_urg']) && !empty($_POST['vendredifin_urg']) && !empty($_POST['samedideb_urg']) && !empty($_POST['samedifin_urg']) && !empty($_POST['dimanchedeb_urg']) && !empty($_POST['dimanchefin_urg'])){
                    $check = $bdd->prepare('SELECT type_urgence FROM metier WHERE metier = ?');
                    $check->execute(array($_SESSION['metier']));
                    $data = $check->fetchAll(PDO::FETCH_ASSOC);
                    $row = $check->rowCount();
                    for ($i=0;$i<$row;$i++){
                        if (isset($_POST['type_inter'.$i]) && !empty($_POST['type_inter'.$i])){
                            $type_inter[$i]=htmlspecialchars($_POST['type_inter'.$i]);
                        }
                    }
                    $perimetre=htmlspecialchars($_POST['perimetre']);
                    $lundiDeb_urg=htmlspecialchars($_POST['lundideb_urg']);
                    $lundiFin_urg=htmlspecialchars($_POST['lundifin_urg']);
                    $mardiDeb_urg=htmlspecialchars($_POST['mardideb_urg']);
                    $mardiFin_urg=htmlspecialchars($_POST['mardifin_urg']);
                    $mercrediDeb_urg=htmlspecialchars($_POST['mercredideb_urg']);
                    $mercrediFin_urg=htmlspecialchars($_POST['mercredifin_urg']);
                    $jeudiDeb_urg=htmlspecialchars($_POST['jeudideb_urg']);
                    $jeudiFin_urg=htmlspecialchars($_POST['jeudifin_urg']);
                    $vendrediDeb_urg=htmlspecialchars($_POST['vendredideb_urg']);
                    $vendrediFin_urg=htmlspecialchars($_POST['vendredifin_urg']);
                    $samediDeb_urg=htmlspecialchars($_POST['samedideb_urg']);
                    $samediFin_urg=htmlspecialchars($_POST['samedifin_urg']);
                    $dimancheDeb_urg=htmlspecialchars($_POST['dimanchedeb_urg']);
                    $dimancheFin_urg=htmlspecialchars($_POST['dimanchefin_urg']);
                    if($first_urg && $first){
                        $insert = $bdd->prepare("INSERT INTO disponibiliteartisan(`heure_debut_urgence`, `heure_fin_urgence`,`id_Artisan`, `id_jour`) VALUES (:heure_deb1, :heure_fin1, :id_art1, :id_jour1), (:heure_deb2, :heure_fin2, :id_art2, :id_jour2), (:heure_deb3, :heure_fin3, :id_art3, :id_jour3), (:heure_deb4, :heure_fin4, :id_art4, :id_jour4), (:heure_deb5, :heure_fin5, :id_art5, :id_jour5), (:heure_deb6, :heure_fin6, :id_art6, :id_jour6), (:heure_deb7, :heure_fin7, :id_art7, :id_jour7)");
                        $insert->execute(array(
                            'heure_deb1' => $lundiDeb_urg,
                            'heure_fin1' => $lundiFin_urg,
                            'id_art1' => $_SESSION['id_Artisan'],
                            'id_jour1' => 1,
                            'heure_deb2' => $mardiDeb_urg,
                            'heure_fin2' => $mardiFin_urg,
                            'id_art2' => $_SESSION['id_Artisan'],
                            'id_jour2' => 2,
                            'heure_deb3' => $mercrediDeb_urg,
                            'heure_fin3' => $mercrediFin_urg,
                            'id_art3' => $_SESSION['id_Artisan'],
                            'id_jour3' => 3,
                            'heure_deb4' => $jeudiDeb_urg,
                            'heure_fin4' => $jeudiFin_urg,
                            'id_art4' => $_SESSION['id_Artisan'],
                            'id_jour4' => 4,
                            'heure_deb5' => $vendrediDeb_urg,
                            'heure_fin5' => $vendrediFin_urg,
                            'id_art5' => $_SESSION['id_Artisan'],
                            'id_jour5' => 5,
                            'heure_deb6' => $samediDeb_urg,
                            'heure_fin6' => $samediFin_urg,
                            'id_art6' => $_SESSION['id_Artisan'],
                            'id_jour6' => 6,
                            'heure_deb7' => $dimancheDeb_urg,
                            'heure_fin7' => $dimancheFin_urg,
                            'id_art7' => $_SESSION['id_Artisan'],
                            'id_jour7' => 7
                        ));
                        foreach ($type_inter as $inter){
                            $insert = $bdd->prepare("INSERT INTO typeintervention(`type_inter`,`perimetre_intervention`,`id_Artisan`) VALUES (:type_inter, :perimetre_inter, :id_art)");
                            $insert->execute(array(
                                'type_inter' => $inter,
                                'perimetre_inter' => $perimetre,
                                'id_art' => $_SESSION['id_Artisan']
                            ));
                        }
                        header('Location: /EspaceArtisan/homepageArtisan.php?err=success');die();
                    }
                    else if (($first_urg && !$first) || !$first_urg){
                        $update = $bdd->prepare("UPDATE disponibiliteartisan SET heure_debut_urgence=:heure_deb, heure_fin_urgence=:heure_fin WHERE id_Artisan=:id_art AND id_jour=1");
                        $update->execute(array(
                            'heure_deb' => $lundiDeb_urg,
                            'heure_fin' => $lundiFin_urg,
                            'id_art' => $_SESSION['id_Artisan']
                        ));
                        $update = $bdd->prepare("UPDATE disponibiliteartisan SET heure_debut_urgence=:heure_deb, heure_fin_urgence=:heure_fin WHERE id_Artisan=:id_art AND id_jour=2");
                        $update->execute(array(
                            'heure_deb' => $mardiDeb_urg,
                            'heure_fin' => $mardiFin_urg,
                            'id_art' => $_SESSION['id_Artisan']
                        ));
                        $update = $bdd->prepare("UPDATE disponibiliteartisan SET heure_debut_urgence=:heure_deb, heure_fin_urgence=:heure_fin WHERE id_Artisan=:id_art AND id_jour=3");
                        $update->execute(array(
                            'heure_deb' => $mercrediDeb_urg,
                            'heure_fin' => $mercrediFin_urg,
                            'id_art' => $_SESSION['id_Artisan']
                        ));
                        $update = $bdd->prepare("UPDATE disponibiliteartisan SET heure_debut_urgence=:heure_deb, heure_fin_urgence=:heure_fin WHERE id_Artisan=:id_art AND id_jour=4");
                        $update->execute(array(
                            'heure_deb' => $jeudiDeb_urg,
                            'heure_fin' => $jeudiFin_urg,
                            'id_art' => $_SESSION['id_Artisan']
                        ));
                        $update = $bdd->prepare("UPDATE disponibiliteartisan SET heure_debut_urgence=:heure_deb, heure_fin_urgence=:heure_fin WHERE id_Artisan=:id_art AND id_jour=5");
                        $update->execute(array(
                            'heure_deb' => $vendrediDeb_urg,
                            'heure_fin' => $vendrediFin_urg,
                            'id_art' => $_SESSION['id_Artisan']
                        ));
                        $update = $bdd->prepare("UPDATE disponibiliteartisan SET heure_debut_urgence=:heure_deb, heure_fin_urgence=:heure_fin WHERE id_Artisan=:id_art AND id_jour=6");
                        $update->execute(array(
                            'heure_deb' => $samediDeb_urg,
                            'heure_fin' => $samediFin_urg,
                            'id_art' => $_SESSION['id_Artisan']
                        ));
                        $update = $bdd->prepare("UPDATE disponibiliteartisan SET heure_debut_urgence=:heure_deb, heure_fin_urgence=:heure_fin WHERE id_Artisan=:id_art AND id_jour=7");
                        $update->execute(array(
                            'heure_deb' => $dimancheDeb_urg,
                            'heure_fin' => $dimancheFin_urg,
                            'id_art' => $_SESSION['id_Artisan']
                        ));
                        $update = $bdd->prepare("UPDATE typeintervention SET perimetre_intervention=:perimetre WHERE id_Artisan=:id_art");
                        $update->execute(array(
                            'perimetre' => $perimetre,
                            'id_art' => $_SESSION['id_Artisan']
                        ));
                        $check = $bdd->prepare('SELECT type_inter FROM typeintervention WHERE id_Artisan = ?');
                        $check->execute(array($_SESSION['id_Artisan']));
                        $data = $check->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($data as $donnees){
                            $flag=0;
                            foreach ($type_inter as $inter){
                                if ($donnees["type_inter"]==$inter){
                                    $flag=1;
                                }
                            }
                            if ($flag==0){
                                $update = $bdd->prepare("DELETE FROM typeintervention WHERE id_Artisan=:id_art AND type_inter = :type_inter");
                                $update->execute(array(
                                    'id_art' => $_SESSION['id_Artisan'],
                                    'type_inter' => $donnees["type_inter"]                                    
                                ));
                            }
                        }
                        foreach ($type_inter as $inter){
                            $flag=0;
                            foreach ($data as $donnees){
                                if ($donnees["type_inter"]==$inter){
                                    $flag=1;
                                }
                            }
                            if ($flag==0){
                                $update = $bdd->prepare("INSERT INTO typeintervention(`type_inter`,`perimetre_intervention`,`id_Artisan`) VALUES (:type_inter, :perimetre_inter, :id_art)");
                                $update->execute(array(
                                    'type_inter' => $inter,
                                    'perimetre_inter' => $perimetre,
                                    'id_art' => $_SESSION['id_Artisan']                                 
                                ));
                            }
                        }
                        header('Location: /EspaceArtisan/homepageArtisan.php?err=success');die();
                    }
                }
            }
        }
        else header('Location: /EspaceArtisan/homepageArtisan.php?err=error');die();
    }

    