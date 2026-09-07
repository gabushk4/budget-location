<?php

//Commun à toutes les pages
require_once 'core/error-exception.php';
require_once 'src/initialization.php';
require_once SRC . '/Page.php';

// Si l'utilisateur est déjà authentifié on redirige vers l'accueil
if (IS_AUTH) header('Location: '. Page::Home->url());

// Spécifique à cette page
require_once CORE . '/Validation.php';
require_once CORE . '/Email.php';
require_once CORE . '/Database.php';
require_once SRC . '/AccountDAL.php';

const ACTIVE_PAGE = Page::Creation;

//===============================================================

// On prépare les variables qui serviront à l'affichage dans le html
// Souvent on nomme les variables commme les champs du formulaire
$email = '';
$messages = [];

// On peut déclarer aussi des variables pour contrôler l'affichage.
$globalMessageColor = 'text-danger';

// Valider et récupérer le contenu du formulaire seulement s'il a été soumit
if (IS_POST) {

    // Si la donnée de email n'est pas présente dans le POST alors null sera retourné
    // Si la donnée est présente mais invalide alors la valeur 'false' sera assigée
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);

    // Le courriel est obligatoire
    // À cause de input_filter on sait que les valeurs possibles sont : false, null ou string
    if ( !is_string($email) ) {

        $messages['email'] = 'Le courriel est obligatoire.';

        // Puisque $email contient null ou false on doit récupérer le courriel pour préparer l'affichage
        $email = $_POST['email'] ?? '';

    }    

    $password = $_POST['password'] ?? '';
    $password2 = $_POST['password2'] ?? '';

    if (empty($password) || $password !== $password2 || !Validation::passwordIsValid($password,MATCH_PATTERN,PASSWORD_SIZE)) {

        $messages['password'] = 'Le mot de passe est obligatoire et les deux champs Mots de passe doivent être identiques.';

    }
    
    // La logique actuelle est basée sur la présence d'un ou plus message d'erreur
    // Nous pourrions faire aussi avec :!empty($messages)
    if (count($messages) > 0) {

        $messages['global'] = 'Le formulaire est invalide.';

    } else {

        // Vérification du courriel en base de donnée
        $connexion = Database::getConnexion($dbConfig);
        $user = AccountDAL::selectByEmail($connexion, $email);

        if($user === false){

            // On peut créer le compte
            $hash = password_hash($password, PASSWORD_DEFAULT);

            // if(AccountDAL::insertOne($connexion, $email, $hash)) {

            //     // Courriel de bienvenue
            //     $subject = 'Merci d\'avoir créé un compte.';

            //     $message = <<<HTML
            //     <h1>Merci d'avoir créé un compte.</h1>
            //     <a href="http://boutique.ca:8080">Validez votre courriel</a>
            //     HTML;

            //     Email::readConfig(SRC . '/gmail.ini');
                
            //     // true pour bloquer l'envoi de courriel dans les tests
            //     if (true || Email::send($email, $subject, $message)) {

            //         $_SESSION['new-account'] = true;
            //         header('Location: ' . Page::Connexion->url());

            //     }  
                
            // }             

            header('Location: ' . Page::Connexion->url());

        } else{

            // Le compte existe
            $messages['global'] = 'Ce courriel n\'est pas disponible pour créer un compte. ';

        }

              

    }
    
}

?>
<!DOCTYPE html>
<html lang="fr">

<!--Bloc entête document-Head block-->
<?php include_once TEMPLATE . '/head.php'; ?>
<!--Bloc entête document-Head block-->

<body>
    
    <!--Contenant principal pour largeur du contenu-Main container-->
    <div class="container">

        <!--Bloc entête-Header block-->
        <?php include_once TEMPLATE . '/header.php'; ?>
        <!--Bloc entête-Header block-->
        
        <main>
            <h1 class="py-3 mt-3">La boutique d'informatique sur la rive-nord</h1>

            <div class="fs-4 text-center my-5">Entrez vos informations de création de compte.</div>

            <!--Formulaire authenfification-Authentication form-->
            <div class="col-md-4 mx-auto">                         

                <form method="post" novalidate>

                    <div class="mb-3">
                        <label for="email" class="form-label"><span class="text-danger">* </span>Courriel</label>
                        <input name="email" type="email" class="form-control" id="email" aria-describedby="emailHelp" value="<?= htmlspecialchars($email) ?>" autofocus>
                        <div id="emailHelp" class="form-text text-danger"><?= $messages['email'] ?? '' ?></div>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label"><span class="text-danger">* </span>Mot de passe</label>
                        <input name="password" type="password" class="form-control" id="empasswordail" aria-describedby="passwordHelp">
                        <div id="passwordHelp" class="form-text text-danger"><?= $messages['password'] ?? '' ?></div>
                    </div>

                    <div class="mb-3">
                        <label for="password2" class="form-label"><span class="text-danger">* </span>Confirmez le mot de passe</label>
                        <input name="password2" type="password" class="form-control" id="empasswordail2" aria-describedby="password2Help">
                        <div id="passwordHelp2" class="form-text text-danger"><?= $messages['password2'] ?? '' ?></div>
                    </div>

                    <div>
                        Le mot de passe doit contenir : 
                        <ul>
                            <li>au moins une lettre minuscule</li>
                            <li>au moins une lettre majuscule</li>
                            <li>au moins un chiffre</li>
                            <li>au moins un symbole @#-_$%^&+=§!?</li>
                        </ul>

                    </div>

                    <div class="py-3 text-danger">* Champs requis</div>
                    
                    <button type="submit" class="btn btn-primary">Envoyer</button>

                </form>

                <div id="global-message" class="my-3 <?= $globalMessageColor ?>"><?= $messages['global'] ?? '' ?></dib>

                <div class="py-3"><a href="<?= Page::Connexion->url() ?>">Connexion à un compte</a></div>

            </div>
            <!--Formulaire authenfification-Authentication form-->

        </main>
        
        <!--Bloc pied de page-Footer block-->
        <?php include_once TEMPLATE . '/footer.php'; ?>
        <!--Bloc pied de page-Footer block-->
        
    </div>
    <!--Contenant principal-->
   
</body>
</html>