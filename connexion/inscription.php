<?php 
    require 'function.php';
    require_once 'config.php'; // On inclu la connexion à la bdd
    init_session_php();
    $tab_metier = array('Plombier', 'Serrurier', 'Electricien');

    if(isset($_GET['artisan'])){
        if ($_GET['artisan']==1){
            // Si les variables existent et qu'elles ne sont pas vides
            if(!empty($_POST['metier']) && !empty($_POST['nom']) && !empty($_POST['email']) && !empty($_POST['numeroTel']) && !empty($_POST['adresse']) && !empty($_POST['codePostal']) && !empty($_POST['ville']) && !empty($_POST['password']) && !empty($_POST['password_retype']))
            {
                // Patch XSS
                $abonnement = htmlspecialchars($_POST['abonnement']);
                $metier = htmlspecialchars($_POST['metier']);
                $nom = htmlspecialchars($_POST['nom']);
                $email = strtolower(htmlspecialchars($_POST['email']));
                $numeroTel = htmlspecialchars($_POST['numeroTel']);
                $adresse = htmlspecialchars($_POST['adresse']);
                $ville = htmlspecialchars($_POST['ville']);
                $codePostal = htmlspecialchars($_POST['codePostal']);
                $password = htmlspecialchars($_POST['password']);
                $password_retype = htmlspecialchars($_POST['password_retype']);

                 // On vérifie si le mail existe
                $check = $bdd->prepare('SELECT id_artisan FROM  coordonnees WHERE email = ?');
                $check->execute(array($email));
                $data = $check->fetch();
                $row = $check->rowCount();
                if($row==0){
                     // On vérifie si le nom existe
                    $check = $bdd->prepare('SELECT id_artisan FROM artisans WHERE nom = ?');
                    $check->execute(array($nom));
                    $data = $check->fetch();
                    $row = $check->rowCount();
                    if($row==0){
                        if($abonnement!='0' || $abonnement!='1'){
                            if(in_array($metier, $tab_metier)){
                                if (strlen($nom)<=200){
                                    if(strlen($email)<=200){
                                        if(filter_var($email, FILTER_VALIDATE_EMAIL)){
                                            if(is_numeric($adresse[0])==true){
                                                if(strlen($adresse) <= 300){
                                                    if(is_numeric($codePostal) && strlen($codePostal)==5){
                                                        if(strlen($ville)<=50){
                                                            if(strlen($password) >= 8 && strlen($password_retype) >= 8){
                                                                if(preg_match("/[0-9]/", $password) && preg_match("/[a-z]/", $password) && preg_match("/[A-Z]/", $password) && preg_match("/[0-9]/", $password_retype) && preg_match("/[a-z]/", $password_retype) && preg_match("/[A-Z]/", $password_retype)){
                                                                     if($password==$password_retype){
                                                                        //On hash le mot de passe
                                                                        $password = password_hash($password, PASSWORD_BCRYPT);

                                                                        // On insère L'Artisan dans la base de données
                                                                        $insert = $bdd->prepare('INSERT INTO Artisans(`abonnement`, `metier`, `nom`) VALUES(:abonnement, :metier, :nom)');
                                                                        $insert->execute(array(
                                                                            'abonnement' => $abonnement,
                                                                            'metier' => $metier,
                                                                            'nom' => $nom
                                                                        ));

                                                                        // On insère le token dans la base de données 
                                                                        $insert = $bdd->prepare("INSERT INTO Coordonnees(`email`, `numeroTel`, `adresse`, `codePostal`, `ville`, `id_Artisan`) VALUES(:email, :numeroTel, :adresse, :codePostal, :ville, (SELECT id_Artisan FROM Artisans WHERE nom = :nom))");
                                                                        $insert->execute(array(
                                                                            'email' => $email,
                                                                            'numeroTel' => $numeroTel,
                                                                            'adresse' => $adresse,
                                                                            'codePostal' => $codePostal,
                                                                            'ville' => $ville,
                                                                            'nom' => $nom
                                                                        ));
                                                                        // On insère le mot de passe de l'artisan dans la base de données
                                                                        $insert = $bdd->prepare("INSERT INTO MotDePasse(`mdp`, `id_Artisan`) VALUES(:password, (SELECT id_Artisan FROM Artisans WHERE nom = :nom))");
                                                                        $insert->execute(array(
                                                                            'password' => $password,
                                                                            'nom' => $nom
                                                                        ));
                                                                        // On insère le token dans la base de données 
                                                                        $insert = $bdd->prepare("INSERT INTO Privilege(`privilege`, `id_Artisan`) VALUES(1, (SELECT id_Artisan FROM Artisans WHERE nom = ?))");
                                                                        $insert->execute(array($nom));

                                                                        $insert = $bdd->prepare("SELECT id_Artisan FROM Artisans WHERE nom = ?");
                                                                        $insert->execute(array($nom));
                                                                        $data = $insert->fetch();
                                                                        $id = $data['id_Artisan'];
                                                                        $_SESSION['id_Artisan']=$id;
                                                                        $_SESSION['metier']=$metier;
                                                                        $_SESSION['nom']=$nom;
                                                                        $_SESSION['privilege']=1;
                                                                        $_SESSION['nb_connexion']=1;
                                                                        // On redirige avec le message de succès
                                                                        header('Location: /EspaceArtisan/homepageArtisan.php?err=success');
                                                                        die();

                                                                    }else{header('Location: register.php?err=password_match');die;}
                                                                }else {header('Location: register.php?err=password_diversity');die;}
                                                            }else {header('Location: register.php?err=password_length');die;}
                                                        }else {header('Location: register.php?err=city_length');die;}
                                                    }else {header('Location: register.php?err=wrong_postal_code');die;}
                                                }else {header('Location: register.php?err=address_length');die;}
                                            }else {header('Location: register.php?err=no_number_in_addr');die;}
                                        }else {header('Location: register.php?err=wrong_mail_format');die;}
                                    }else {header('Location: register.php?err=mail_length');die;}
                                }else {header('Location: register.php?err=name_length');die;}
                            }else {header('Location: register.php?err=inscription_failure');die;}
                        }else {header('Location: register.php?err=inscription_failure');die;}
                    }else {header('Location; register.php?err=name_already_used');die;}
                }else {header('Location: register.php?err=mail_already_used'); die;}
            } else {header('Location: register.php?err=values_missing');die;}
        }
        elseif ($_GET['artisan']==0) {
            // Si les variables existent et qu'elles ne sont pas vides
            if(!empty($_POST['prenom']) && !empty($_POST['nom']) && !empty($_POST['email']) && !empty($_POST['numeroTel']) && !empty($_POST['adresse']) && !empty($_POST['ville']) && !empty($_POST['codePostal']) && !empty($_POST['password']) && !empty($_POST['password_retype']))
            {
                // Patch XSS
                $prenom = htmlspecialchars($_POST['prenom']);
                $nom = htmlspecialchars($_POST['nom']);
                $email = htmlspecialchars($_POST['email']);
                $numeroTel = htmlspecialchars($_POST['numeroTel']);
                $adresse = htmlspecialchars($_POST['adresse']);
                $ville = htmlspecialchars($_POST['ville']);
                $codePostal = htmlspecialchars($_POST['codePostal']);
                $password = htmlspecialchars($_POST['password']);
                $password_retype = htmlspecialchars($_POST['password_retype']);

                // On vérifie si le mail existe
                $check = $bdd->prepare('SELECT id_Particulier FROM Particuliers WHERE nom = :nom AND prenom = :prenom');
                $check->execute(array(
                'nom' => $nom,
                'prenom' => $prenom
                ));
                $data = $check->fetch();
                $row = $check->rowCount();
                if($row==0){
                    // On vérifie si le nom existe
                    $check = $bdd->prepare('SELECT id_Particulier FROM Coordonnees WHERE email = ?');
                    $check->execute(array($email));
                    $data = $check->fetch();
                    $row = $check->rowCount();
                    if($row==0){
                        if (strlen($nom)<=200){
                            if(strlen($email)<=200){
                                if(filter_var($email, FILTER_VALIDATE_EMAIL)){
                                    if(is_numeric($adresse[0])==true){
                                        if(strlen($adresse) <= 300){
                                            if(is_numeric($codePostal) && strlen($codePostal)==5){
                                                if(strlen($ville)<=50){
                                                    if(strlen($password) >= 8 && strlen($password_retype) >= 8){
                                                        if(preg_match("/[0-9]/", $password) && preg_match("/[a-z]/", $password) && preg_match("/[A-Z]/", $password) && preg_match("/[0-9]/", $password_retype) && preg_match("/[a-z]/", $password_retype) && preg_match("/[A-Z]/", $password_retype)){
                                                            if($password==$password_retype){
                                                                //On hash le mot de passe
                                                                $password = password_hash($password, PASSWORD_BCRYPT);

                                                                // On insère L'Artisan dans la base de données
                                                                $insert = $bdd->prepare('INSERT INTO Particuliers(`prenom`, `nom`) VALUES(:prenom, :nom)');
                                                                $insert->execute(array(
                                                                    'prenom' => $prenom,
                                                                    'nom' => $nom
                                                                ));

                                                                // On insère le token dans la base de données 
                                                                $insert = $bdd->prepare("INSERT INTO Coordonnees(`email`, `numeroTel`, `adresse`, `codePostal`, `ville`, `id_Particulier`) VALUES(:email, :numeroTel, :adresse, :codePostal, :ville, (SELECT id_Particulier FROM Particuliers WHERE nom = :nom AND prenom = :prenom))");
                                                                $insert->execute(array(
                                                                    'email' => $email,
                                                                    'numeroTel' => $numeroTel,
                                                                    'adresse' => $adresse,
                                                                    'codePostal' => $codePostal,
                                                                    'ville' => $ville,
                                                                    'nom' => $nom,
                                                                    'prenom' => $prenom
                                                                ));
                                                                // On insère le mot de passe de l'artisan dans la base de données
                                                                $insert = $bdd->prepare("INSERT INTO MotDePasse(`mdp`, `id_Particulier`) VALUES(:password, (SELECT id_Particulier FROM Particuliers WHERE nom = :nom AND prenom = :prenom))");
                                                                $insert->execute(array(
                                                                    'password' => $password,
                                                                    'nom' => $nom,
                                                                    'prenom' => $prenom
                                                                ));
                                                                // On insère le token dans la base de données 
                                                                $insert = $bdd->prepare("INSERT INTO Privilege(`privilege`, `id_Particulier`) VALUES(1, (SELECT id_Particulier FROM Particuliers WHERE nom = :nom AND prenom = :prenom))");
                                                                $insert->execute(array(
                                                                    'nom' => $nom,
                                                                    'prenom' => $prenom
                                                                ));

                                                                $insert = $bdd->prepare("SELECT id_Particulier FROM Particuliers WHERE nom = :nom AND prenom = :prenom");
                                                                $insert->execute(array(
                                                                    'nom' => $nom,
                                                                    'prenom' => $prenom
                                                                ));
                                                                $data = $insert->fetch();
                                                                $id = $data['id_Particulier'];
                                                                $_SESSION['id_Particulier']=$id;
                                                                $_SESSION['prenom']=$prenom;
                                                                $_SESSION['nom']=$nom;
                                                                $_SESSION['privilege']=1;
                                                                $_SESSION['nb_connexion']=1;
                                                                // On redirige avec le message de succès
                                                                header('Location: /EspaceParticulier/homepageParticulier.php?err=success');
                                                                die();

                                                            }else{
                                                                header('Location: register.php?err=password_match');
                                                                die;
                                                            }
                                                        }else{
                                                            header('Location: register.php?err=password_diversity');
                                                            die;
                                                        }
                                                    }
                                                    else{
                                                        header('Location: register.php?err=password_length');
                                                        die;
                                                    }
                                                }else{
                                                    header('Location: register.php?err=city_length');
                                                    die;
                                                }
                                            }else{
                                                header('Location: register.php?err=wrong_postal_code');
                                                die;
                                            }
                                        }else{
                                            header('Location: register.php?err=address_length');
                                            die;
                                        }
                                    }else{
                                        header('Location: register.php?err=no_number_in_addr');
                                        die;
                                    }
                                }else{
                                    header('Location: register.php?err=wrong_mail_format');
                                    die;
                                }
                            }else{
                                header('Location: register.php?err=mail_length');
                                die;
                            }
                        }else{
                            header('Location: register.php?err=name_length');
                            die;
                        }
                    }else{
                        header('Location: register.php?err=mail_already_used');
                        die;
                    }
                }else{
                    header('Location: register.php?err=name_already_used');
                    die;
                }
            }else{
                header('Location: register.php?err=values_missing');
                die;
            }
        }else{
            header('Location: register.php?err=inscription_failure');
            die;
        }
        
    }else {
        header('Location: register.php?err=inscription_failure');
        die;
    }
    