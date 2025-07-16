<?php
    $root = realpath($_SERVER["DOCUMENT_ROOT"]);
    require "$root/connexion/function.php";
    init_session_php();
    if(is_logged() && is_artisan()){
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/768b004a56.js" crossorigin="anonymous"></script>
    <title>Mon Espace Artisan</title>
</head>
<body>
    <nav class="navbar">
        <ul>
            <li id="logo"> <a href ="/index.php"> LOGO </a></li>
            <li> <a href ="/quiSommesNous.php"> Qui sommes-nous ?</a>
            <?php if(is_logged()):?>
            <li> <a href ="/connexion/login.php?action=logout"> Se Deconnecter </a> </li>
            <?php if(is_artisan()):?>
            <li> <a href ="/EspaceArtisan/homepageArtisan.php"> Paramètres </a> </li>
            <?php elseif(is_particulier()):?>
            <li> <a href ="/EspaceParticulier/homepageParticulier.php"> Mes Disponibilités </a> </li>
            <?php endif;?>
            <?php else:?>
            <li> <a href ="/connexion/login.php"> Se Connecter </a> </li>
            <li> <a href ="/connexion/register.php"> S'inscrire </a> </li>
            <?php endif;?>
        </ul>
    </nav>
    <h1>Bienvenue <?php if(isset($_SESSION['nom'])){echo $_SESSION['nom'];}?></h1>
    <div class="portefeuille">
        <?php
        $check = $bdd->prepare('SELECT * FROM banque WHERE id_Artisan = ?');
        $check->execute(array($_SESSION['id_Artisan']));
        $data = $check->fetch(PDO::FETCH_ASSOC);
        $row = $check->rowCount();
        ?>
        <h2>Votre portefeuille : <?php if ($row < 1) {echo "0";}else{echo $data['portefeuille'];} ?> €</h2>
        <div class="details">
            <ul>
                <li>
                    <?php echo $data['portefeuille']; ?> € Hors Taxe
                </li>
                <li>
                    <?php echo $data['portefeuille']/1.1; ?> € TTC
                </li>
            </ul>
        </div>
        <?php
        if ($row < 1){
            ?>
            <span>Vous n'avez pas encore spécifié votre RIB :</span>
            <form action="artisan.php?rib=1" method="post">
                <label for="iban">IBAN :</label>
                <input type="text" name="IBAN" size="27" id="iban">
                <label for="bic">BIC :</label>
                <input type="text" name="BIC" id="bic">
                <button name="valider">Valider</button>
            </form>
            <?php
        }
        else{
            ?>
            <span>Modifier mon RIB :</span>
            <form action="artisan.php?rib=2" method="post">
                <label for="iban">IBAN :</label>
                <input type="text" name="IBAN" size="27" id="iban">
                <label for="bic">BIC :</label>
                <input type="text" name="BIC" id="bic">
                <button name="valider">Valider</button>
            </form>
            <?php
        } ?>
    </div>
    <div class="notation">
        <?php
        $check = $bdd->prepare('SELECT note FROM avis INNER JOIN interventions ON avis.id_intervention = interventions.id_intervention WHERE id_Artisan = ?');
        $check->execute(array($_SESSION['id_Artisan']));
        $data = $check->fetchAll(PDO::FETCH_ASSOC);
        $row = $check->rowCount();
        if($row < 1){
            $moy = 0;
            $val = [0, 0, 0, 0, 0];
        }
        else{
            $moy = moyenne($data);
            $val = calculAvis($bdd);
        }
        ?>
        <p>Les clients m'ont attribué en moyenne la note de <strong><?php echo $moy; ?></strong></p>
        <div class="notationdetail">
            <ul>
                <li>
                    5 <i class="fa-solid fa-star"></i> : <?php echo $val[4]; ?>
                </li>
                <li>
                    4 <i class="fa-solid fa-star"></i> : <?php echo $val[3]; ?>
                </li>
                <li>
                    3 <i class="fa-solid fa-star"></i> : <?php echo $val[2]; ?>
                </li>
                <li>
                    2 <i class="fa-solid fa-star"></i> : <?php echo $val[1]; ?>
                </li>
                <li>
                    1 <i class="fa-solid fa-star"></i> : <?php echo $val[0]; ?>
                </li>
            </ul>
        </div>
    </div>
    <div class="compterendu">
        <?php 
        //Modifier le inférieur strict ?? A voir plus tard
        $check = $bdd->prepare('SELECT prenom, note, prix, date_jour FROM interventions INNER JOIN avis ON avis.id_intervention = interventions.id_intervention INNER JOIN particuliers ON interventions.id_particulier=particuliers.id_particulier WHERE id_Artisan = ? and date_jour < ?');
        $check->execute(array($_SESSION['id_Artisan'],date("Y-m-d")));
        // echo date('h:i:s', time()); Ajouter la timezone
        $data = $check->fetchAll(PDO::FETCH_ASSOC);
        $row = $check->rowCount();
        ?>
        <p>Compte rendu de mes interventions :</p>
        <ul>
            <?php
            if ($row <1){
                echo"Vous n'avez pas encore fait d'interventions...";
            }
            else{
                foreach($data as $line){
                    ?><li><?php echo $line["prenom"].", note: ".$line["note"]."<i class=\"fa-solid fa-star\"></i>/5 prix: ".$line["prix"]." € </br>".countDays($line["date_jour"]); ?></li>
                <?php }
            } ?>
        </ul>
    </div>
    <div class="valider">
        <p>Valider une intervention :</p>
        <ul>
            <li>
                Prénom, type_inter, adresse, date
                <form action="/traitement/intervention.php?id_inter=XXX" method="post"> 
                    <button name="valider" value="1">Valider cette intervention</button>
                    <button name="signaler" value="1">Signaler</button>
                </form>
            </li>
            <li>
                Prénom, type_inter, adresse, date
                <form action="/traitement/intervention.php?id_inter=XXX" method="post"> 
                    <button name="valider" value="2">Valider cette intervention</button>
                    <button name="signaler" value="2">Signaler</button>
                </form>
            </li>
            <li>
                Prénom, type_inter, adresse, date
                <form action="/traitement/intervention.php?id_inter=XXX" method="post"> 
                    <button name="valider" value="3">Valider cette intervention</button>
                    <button name="signaler" value="3">Signaler</button>
                </form>
            </li>
        </ul>
    </div>
    <div class="prochaine">
        <p>Mes prochaines interventions :</p>
        <ul>
            <?php $tab=get_rendezvous($bdd);
            if(sizeof($tab)<1){
                echo "Vous n'avez aucune interventions de prévue...";
            }
            else{
                foreach($tab as $line){
                    echo "<li>".$line["prenom"].", Type d'intervention: ".$line["type_intervention"].", prix: ".$line["prix"]."</br>A ".$line["adresse"]." Ville: ".$line["ville"]."</br>Le : ".$line["date_jour"]." De ".$line["date_debut"]." à ".$line["date_fin"].".</li>";
                }
            }
            ?>
        </ul>
    </div>
</body>
</html>
<?php 
}
else{
    header('Location: /index.php?err=dest_unreachable');
}
?>