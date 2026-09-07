<?php

//Commun à toutes les pages
require_once 'core/error-exception.php';
require_once 'src/initialization.php';
require_once 'src/Page.php';

// Si l'utilisateur n'est pas authentifié on redirige vers l'accueil
if (!IS_AUTH) header('Location: '. Page::Home->url());

$_SESSION = [];
session_destroy();

$name = session_name();
$expire = new DateTime("-1 year");
$expireTimestamp =  $expire->getTimestamp();
$params = session_get_cookie_params();

setcookie(
    $name, 
    "", 
    $expireTimestamp, 
    $params["path"], 
    $params["domain"], 
    $params["secure"], 
    $params["httponly"]
);


header("Location: " . Page::Connexion->url());