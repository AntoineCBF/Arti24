<?php
    $root = realpath($_SERVER["DOCUMENT_ROOT"]);
    require "$root/connexion/function.php";
    require "$root/connexion/config.php";
    init_session_php();
    if(is_logged() && is_particulier()){
        if(isset($_POST["metier"]) && !empty($_POST["metier"]) && isset($_POST["type_urgence"]) && !empty($_POST["type_urgence"]) && isset($_POST["debut"]) && !empty($_POST["debut"]) && isset($_POST["fin"]) && !empty($_POST["fin"]) && isset($_POST["date"]) && !empty($_POST["date"])){
            $date=htmlspecialchars($_POST["date"]);
            $debut=htmlspecialchars($_POST["debut"]);
            $fin=htmlspecialchars($_POST["fin"]);
            $metier=htmlspecialchars($_POST["metier"]);
            $type_urgence=htmlspecialchars($_POST["type_urgence"]);
            //vérification du créneau :
            $check = $bdd->prepare('SELECT temps FROM Metier WHERE metier=? AND type_urgence=?');
            $check->execute(array($metier, $type_urgence));
            $time = $check->fetch(PDO::FETCH_ASSOC);
            $row = $check->rowCount();
            if ($row!=1){
                header('Location: /EspaceParticulier/homepageParticulier.php?err=error');die;
            }
            echo "metier: ".$_POST["metier"].", type_urgence: ".$_POST["type_urgence"].", creneau : ".$_POST["debut"]." - ".$_POST["fin"].", date: ".$_POST["date"];
            //verification du créneau et de la date :
            if (checkcreneau($debut, $fin, $date, $time["temps"])){
                //recherche des artisans avec le bon métier et le bon type d'urgence, puis filtrer avec le périmètre.
            }
            else{ header('Location: /EspaceParticulier/homepageParticulier.php?wrong_value'); die;}
        }
        else { header('Location: /EspaceParticulier/homepageParticulier.php?missing_value'); die; }
}
else{
    header('Location: /index.php?err=dest_unreachable'); die;
}