<?php

// Nous aurons besoin de $_SESSION dans toutes les pages
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

//=======================================================

// Chemin d'accès système
define('ROOT', dirname(__DIR__));

// On pourrait faire des constantes pour d'autres dossiers
const TEMPLATE = ROOT . '/template';
const CORE = ROOT . '/core';
const SRC = ROOT . '/src';
const UPLOAD = ROOT . '/upload';
const VENDOR = ROOT . '/vendor';
const JWT = ROOT . '/jwt';

//=======================================================

// Url publique
const URL_ROOT = '/';

// On pourrait faire des constantes pour d'autres url
const IMG = URL_ROOT . 'public/img';
const CSS = URL_ROOT . 'public/css';
const PRODUCT_IMG = URL_ROOT . 'upload';

//=======================================================

// Simplifie le code des pages
define('IS_POST', $_SERVER['REQUEST_METHOD'] === 'POST');
define('IS_AUTH', isset($_SESSION['id']));
define('IS_ADMIN', IS_AUTH && $_SESSION['role'] === 1);
define('IS_USER', IS_AUTH && $_SESSION['role'] === 0);

//=======================================================

//mySql

$dbConfig = [
    "dbHost" => "127.0.0.1",
    "dbPort" => 3306,
    "dbName" => "budget-location",
    "dbUser" => "root",
    "dbPass" => "Test1234",
    "dbParams" => [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_CASE => PDO::CASE_NATURAL,
        PDO::ATTR_ORACLE_NULLS => PDO::NULL_EMPTY_STRING, 
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC       
    ],
];

//==========================================

const PASSWORD_SIZE = 8;
const MATCH_PATTERN ='/^(?=.*\d)(?=.*[@#\-_$%^&+=§!\?])(?=.*[a-z])(?=.*[A-Z])[0-9A-Za-z@#\-_$%^&+=§!\?]{8,20}$/';

/* 
minimum 1 lettre minuscule
minimum 1 lettre majuscule
minimum un chiffre
au moins un symbole @#-_$%^&+=§!?
*/  

// EX: !123Abc$

//==========================================

// Exceptionnellement des require ici car on veut toujours avoir accès
// et les constantes de chemin sont définie

require_once SRC . '/tools.php';