<?php 
$DB_DSN = "mysql:host=localhost;dbname=arti24";
$DB_USER = "root";
$DB_PASS = "";

    try 
    {
        $bdd = new PDO($DB_DSN, $DB_USER, $DB_PASS);
    }
    catch(PDOException $e)
    {
        die('Erreur : '.$e->getMessage());
    }