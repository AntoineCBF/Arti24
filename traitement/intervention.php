<?php
    $root = realpath($_SERVER["DOCUMENT_ROOT"]);
    require "$root/connexion/function.php";
    require "$root/connexion/config.php";
    init_session_php();
    if(is_logged() && is_artisan()){
        

}
else{
    header('Location: /index.php?err=dest_unreachable'); die;
}