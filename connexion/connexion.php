<?php
    require 'function.php';
    require_once 'config.php'; // On inclu la connexion à la bdd
    init_session_php();
    if(isset($_GET['artisan'])){
        if (!empty($_POST['email'] && !empty($_POST['password']))){
            $email = htmlspecialchars($_POST['email']);
            $password = htmlspecialchars($_POST['password']);
            $check = $bdd->prepare('SELECT id_Artisan, id_Particulier FROM Coordonnees WHERE email = ?');
            $check->execute(array($email));
            $data = $check->fetch(PDO::FETCH_ASSOC);
            $row = $check->rowCount();
            if ($row<1){
                header('Location: login.php?err=not_registered');
                die;
            }
            if ($_GET['artisan']==1){
                $id=$data['id_Artisan'];
                $check = $bdd->prepare('SELECT mdp FROM Motdepasse WHERE id_Artisan = ?');
                $check->execute(array($id));
                $data = $check->fetch(PDO::FETCH_ASSOC);
                if (password_verify($password,$data['mdp'])){
                    $check = $bdd->prepare('UPDATE artisans SET nb_connexion = `nb_connexion` + 1 WHERE id_Artisan = ?');
                    $check->execute(array($id));
                    $check = $bdd->prepare('SELECT nb_connexion FROM artisans WHERE id_Artisan = ?');
                    $check->execute(array($id));
                    $data = $check->fetch(PDO::FETCH_ASSOC);
                    $nb_connexion=$data['nb_connexion'];
                    $check = $bdd->prepare('SELECT privilege FROM Privilege WHERE id_Artisan = ?');
                    $check->execute(array($id));
                    $data = $check->fetch(PDO::FETCH_ASSOC);
                    $privilege=$data['privilege'];
                    $check = $bdd->prepare('SELECT nom, metier FROM Artisans WHERE id_Artisan = ?');
                    $check->execute(array($id));
                    
                    $data = $check->fetch(PDO::FETCH_ASSOC);
                    $_SESSION['nom']=$data['nom'];
                    $_SESSION['metier']=$data['metier'];
                    $_SESSION['id_Artisan']=$id;
                    $_SESSION['privilege']=$privilege;
                    $_SESSION['nb_connexion']=$nb_connexion;
                    header('Location: /EspaceArtisan/monEspaceArtisan.php?err=success');
                }
                else{
                    header('Location: login.php?err=wrong_pass');
                    die;
                }

            }
            elseif ($_GET['artisan']==0){
                $id=$data['id_Particulier'];
                $check = $bdd->prepare('SELECT mdp FROM Motdepasse WHERE id_Particulier = ?');
                $check->execute(array($id));
                $data = $check->fetch(PDO::FETCH_ASSOC);
                if (password_verify($password,$data['mdp'])){
                    $check = $bdd->prepare('UPDATE particuliers SET nb_connexion = `nb_connexion` + 1 WHERE id_Particulier = ?');
                    $check->execute(array($id));
                    $check = $bdd->prepare('SELECT nb_connexion FROM particuliers WHERE id_Particulier = ?');
                    $check->execute(array($id));
                    $data = $check->fetch(PDO::FETCH_ASSOC);
                    $nb_connexion=$data['nb_connexion'];
                    $check = $bdd->prepare('SELECT privilege FROM Privilege WHERE id_Particulier = ?');
                    $check->execute(array($id));
                    $data = $check->fetch(PDO::FETCH_ASSOC);
                    $privilege=$data['privilege'];
                    $check = $bdd->prepare('SELECT nom, prenom FROM Particuliers WHERE id_Particulier = ?');
                    $check->execute(array($id));
                    $data = $check->fetch(PDO::FETCH_ASSOC);
                    $_SESSION['nom']=$data['nom'];
                    $_SESSION['prenom']=$data['prenom'];
                    $_SESSION['id_Particulier']=$id;
                    $_SESSION['privilege']=$privilege;
                    $_SESSION['nb_connexion']=$nb_connexion;
                    header('Location: /EspaceParticulier/homepageParticulier.php?err=success');
                }
                else{
                    header('Location: login.php?err=wrong_pass');
                    die;
                }
            }else{
                header('Location: login.php?err=connection_failure');
                die;
            }
        }
        else{
            header('Location: login.php?err=missing_values');
            die;
        }
    }
    else header('Location: login.php?err=connection_failure');