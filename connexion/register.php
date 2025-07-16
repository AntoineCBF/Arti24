<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Arti'24 : S'inscrire</title>
    <script src="https://kit.fontawesome.com/768b004a56.js" crossorigin="anonymous"></script>
</head>
<body>
    <nav class="navbar">
        <ul>
            <li id="logo"> <a href ="/index.php"> LOGO </a></li>
            <li> <a href ="/quiSommesNous.php"> Qui sommes-nous ?</a>
            <li> <a href ="/connexion/login.php"> Se Connecter </a> </li>
            <li> <a href ="/connexion/register.php"> S'inscrire </a> </li>
        </ul>
    </nav>
    <div class="body">
    <?php 
        if(isset($_GET['err']))
        {
            $err = htmlspecialchars($_GET['err']);?>
            <div class="popup">
            <?php
            switch($err){
                case 'values_missing':
                    ?>
                    <p><strong>Erreur : </strong>Vous n'avez pas remplie tous les champs nécessaires à l'inscription.</p>
                    <?php
                    break;
                case 'mail_already_used':
                    ?>
                    <p><strong>Erreur : </strong>Votre mail est déjà utilisé pour un autre compte...</p>
                    <?php
                    break;
                case 'name_already_used':
                    ?>
                    <p><strong>Erreur : </strong>Votre nom est déjà utilisé pour un autre compte...</p>
                    <?php
                    break;
                case 'inscription_failure':
                    ?>
                    <p><strong>Erreur...</strong></p>
                    <?php
                    break;
                case 'name_length':
                    ?>
                    <p><strong>Erreur : </strong>La taille de votre Nom d'entreprise est trop long</p>
                    <?php
                    break;
                case 'mail_length':
                    ?>
                    <p><strong>Erreur : </strong>La taille de votre adresse email est trop longue</p>
                    <?php
                    break;
                case 'wrong_mail_format':
                    ?>
                    <p><strong>Erreur : </strong>Le format de l'email n'est pas correct</p>
                    <?php
                    break;
                case 'no_number_in_addr':
                    ?>
                    <p><strong>Erreur : </strong>Vous n'avez pas spécifié votre numéro de rue dans l'adresse</p>
                    <?php
                    break;
                case 'address_length':
                    ?>
                    <p><strong>Erreur : </strong>Votre adresse est trop longue</p>
                    <?php
                    break;
                case 'wrong_postal_code':
                    ?>
                    <p><strong>Erreur : </strong>Code postal incorrect</p>
                    <?php
                    break;
                case 'city_length':
                    ?>
                    <p><strong>Erreur : </strong>Nom de Ville incorrect</p>
                    <?php
                    break;
                case 'password_length':
                    ?>
                    <p><strong>Erreur : </strong>Vous devez avoir au minimum 8 charactères dans votre mot de passe</p>
                    <?php
                    break;
                case 'password_diversity':
                    ?>
                    <p><strong>Erreur : </strong>Il faut au minimum une majuscule, une minuscule et un chiffre</p>
                    <?php
                    break;
                case 'password_match':
                    ?>
                    <p><strong>Erreur : </strong>Les deux mots de passe ne sont pas les mêmes.</p>
                    <?php
                    break;
                case 'success':
                    ?>
                    <p><strong>Félicitation : </strong>Vous êtes correctement enregisté !!</p>
                    <?php
                    break;
                    ?>
            </div>
            <?php
            }
        }?>
        <h1>Je suis un : </h1>
        <div class="Artisan">
            <h2>Artisan</h2>
            <form action="inscription.php?artisan=1" method="post">
                <fieldset>
                    <ul>
                        <li>
                            <ul class="abonnement">
                                <h3>Abonnement :</h3>
                                <p> En vous inscrivant avec la version <strong>CLASSIQUE</strong>, une commission de 15% sera prélevé sur le montant de chaque intervention. </p>
                                <p> En souscrivant à un abonnement avec la version <strong>PREMIUM</strong> à hauteur de 299€HT aucune commition ne sera prélevée.</p>
                                <li>
                                    <input type="radio" id="premium" name="abonnement" value="1" />
                                    <label for="premium">PREMIUM</label>
                                </li>
                                <li>
                                    <input type="radio" id="classique" name="abonnement" value="0" checked />
                                    <label for="classique">CLASSIQUE</label>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <label for="metier">Corps de métier :</label> <br/>
                            <select name="metier" id="metier">
                                <option value="">Choisissez votre métier ici</option>
                                <option value="Plombier">Plombier</option>
                                <option value="Serrurier">Serrurier</option>
                                <option value="Electricien">Electricien</option>
                                <option value="parrot">test</option>
                                <option value="spider">zzz</option>
                                <option value="goldfish">abc</option>
                            </select>
                        </li>
                        <li>
                            <label for="nomE">Nom Entreprise (Ou nom propre complet) :</label><br/>
                            <input type="text" id="nomE" name="nom" required placeholder="exemple = Arti'24" maxlength="200"/>
                        </li>
                        <li>
                            <label for="mailE">Email :</label><br/>
                            <input type="email" id="mailE" name="email" required="required" maxlength="200" placeholder="abcd@exemple.com" autocomplete="on">
                        </li>
                        <li>
                            <label for="numeroE">Téléphone :</label><br/>
                            <input id="numeroE" name="numeroTel" type="tel" minlength="10" maxlength="10" required pattern="[0-9]{10}" placeholder="0707070707" autocomplete="on"/>
                        </li>
                        <li>
                            <label for="adresseE">Adresse Postale</label><br/>
                            <input type="text" id="adresseE" name="adresse" required placeholder="12 allée des cerisiers" maxlength="300" autocomplete="on"/>
                        </li>
                        <li>
                            <label for="codePostalE">Code Postal</label><br/>
                            <input type="text" id="codePostalE" name="codePostal" required placeholder="69000" maxlength="10" autocomplete="on"/>
                        </li>
                        <li>
                            <label for="villeE">Ville :</label><br/>
                            <input type="text" id="villeE" name="ville" required maxlength="50" placeholder="Lyon" autocomplete="on"/>
                        </li>
                        <li>
                            <label for="mdpE">Mot de Passe, 8 caractères minimum (Avec au moins une majuscule, un chiffre):</label> <br/>
                            <input type="password" id="mdpE" name="password" required="required" minlength="8" placeholder="Mot de Passe" autocomplete="on">
                        </li>
                        <li>
                            <label for="mdpRetypeE">Mot de Passe, 8 caractères minimum (Avec au moins une majuscule, un chiffre):</label> <br/>
                            <input type="password" id="mdpRetypeE" name="password_retype" required="required" minlength="8" placeholder="Mot de Passe" autocomplete="on">
                        </li>
                    </ul>
                    <div class="button">
                        <button type="submit">S'inscrire</button>
                    </div>
                </fieldset>
            </form>
        </div>
        <div class="Particulier">
            <h2>Particulier</h2>
            <form action="inscription.php?artisan=0" method="post">
                <fieldset>
                    <ul>
                        <li>
                            <label for="prenom">Prenom :</label><br/>
                            <input type="text" id="prenom" name="prenom" required maxlength="100" placeholder="Pierre" autocomplete="on"/>
                        </li>
                        <li>
                            <label for="nom">Nom :</label><br/>
                            <input type="text" id="nom" name="nom" required maxlength="200" placeholder="Dupond" autocomplete="on"/>
                        </li>
                        <li>
                            <label for="mail">Email :</label><br/>
                            <input type="email" id="mail" name="email" required="required" maxlength="200" placeholder="abcd@exemple.com" autocomplete="on">
                        </li>
                        <li>
                            <label for="numero">Téléphone :</label><br/>
                            <input id="numero" name="numeroTel" type="tel" minlength="10" maxlength="10" required pattern="[0-9]{10}" placeholder="0707070707" autocomplete="on"/>
                        </li>
                        <li>
                            <label for="adresse">Adresse Postale</label><br/>
                            <input type="text" id="adresse" name="adresse" required maxlength="300" autocomplete="on" placeholder="12 allée des cerisiers"/>
                        </li>
                        <li>
                            <label for="codePostal">Code Postal</label><br/>
                            <input id="codePostal" name="codePostal" type="text" required autocomplete="on" placeholder="69000" maxlength="5">
                        </li>
                        <li>
                            <label for="ville">Ville :</label><br/>
                            <input type="text" id="ville" name="ville" required maxlength="50" autocomplete="on" placeholder="Lyon"/>
                        </li>
                        <li>
                            <label for="mdp">Mot de Passe, 8 caractères minimum (Avec au moins une majuscule, un chiffre):</label> <br/>
                            <input type="password" id="mdp" name="password" required="required" minlength="8" placeholder="Mot de Passe" autocomplete="on">
                        </li>
                        <li>
                            <label for="mdpRetype">Mot de Passe, 8 caractères minimum (Avec au moins une majuscule, un chiffre):</label> <br/>
                            <input type="password" id="mdpRetype" name="password_retype" required="required" minlength="8" placeholder="Mot de Passe" autocomplete="on">
                        </li>
                    </ul>
                    <div class="button">
                        <button type="submit">S'inscrire</button>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>

    <footer>
        <p> Copyrights © 2023, by Arti'24. All rights reserved.</p>
    </footer>
</body>
</html>