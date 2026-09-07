<?php

//=======================================================
// Les fonctions personnalisées de gestion d'erreur
//=======================================================

// errno = numéro de l'erreur
// errstr = chaîne de l'erreur
// errfile = fichier ou est l'erreur
// errline = ligne ou est l'erreur dans le fichier

function customErrorHandler($errno, $errstr, $errfile, $errline) {

    error_log(date('Y-m-d H:i') . " [{$errno}] : $errstr (File : {$errfile}, Line : {$errline})" . PHP_EOL, 3, ERROR_LOG_FILE);
    
    // Ici on pourrait demander d'envoyer un courriel au responsable.
    
    // On redirige vers une page qui informe l'utilisateur
    if (REDIRECT_ERROR_PAGE) {
        header('Location: '. ERROR_PAGE);
    }
   

}

function customExceptionHandler(Throwable $exception)
{
    $errno = $exception->getCode();
    $errstr = $exception->getMessage();
    $errfile = $exception->getFile();
    $errline = $exception->getLine();

    error_log(date('Y-m-d H:i') . " [{$errno}] : $errstr (File : {$errfile}, Line : {$errline})" . PHP_EOL, 3, ERROR_LOG_FILE);
    
    // Ici on pourrait demander d'envoyer un courriel au responsable.
    
    // On redirige vers une page qui informe l'utilisateur
    if (REDIRECT_ERROR_PAGE) {
        header('Location: '. ERROR_PAGE);
    }

}

// Gestion des erreurs fatales
function handleFatalError() {

    // Dernière erreur enregistrée
    $last_error = error_get_last();

    // Vérification si c'est une erreurs fatale
    if ($last_error && ($last_error['type'] === E_ERROR || $last_error['type'] === E_PARSE || $last_error['type'] === E_CORE_ERROR || $last_error['type'] === E_COMPILE_ERROR)) {
        
        $error_message = "Fatal error: {$last_error['message']} in {$last_error['file']} on line {$last_error['line']}";
        
        error_log($error_message, 3, __DIR__ . '/' . ERROR_LOG_FILE);    

        // On redirige vers une page qui informe l'utilisateur
        if (REDIRECT_ERROR_PAGE) {
            header('Location: '. ERROR_PAGE);
        }
        
    }
}


//=======================================================
// On défini des valeurs et des constantes
//=======================================================

// Affiche ou non les erreurs dans la page Web
// En développement on veut voir les erreurs
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');

// Engegistre ou non les erreurs dans un fichier de journal
ini_set('log_errors', 1);

// Enregistre tout type d'erreur
ini_set('error_reporting', E_ALL);

// Page pour informer l'utilisateur d'une erreur grave
CONST ERROR_PAGE = 'http://142.44.247.33/~luc/erreur.html';

// Pour enregistrer les erreurs dans le journal
CONST ERROR_LOG_FILE = 'error-log.txt';


//===========================================================================================
// En production on enregistre l'utilisation des fonctions personnalisées de gestion d'erreur
//===========================================================================================

// En développement on ne veut pas aller sur la page d'erreur
// car on veut voir le problème et le corriger
const IS_PRODUCTION_ENV = false;
const REDIRECT_ERROR_PAGE = false;


// On modifie la configuration d'affichage
// et on enregistre les fonctions personnalisées
if (IS_PRODUCTION_ENV) {

    // En production on ne veut pas afficher les erreurs
    ini_set('display_errors', 0);
    ini_set('display_startup_errors', 0);

    set_error_handler('customErrorHandler');

    set_exception_handler('customExceptionHandler');

    register_shutdown_function('handleFatalError');

}

