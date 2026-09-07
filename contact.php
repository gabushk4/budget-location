<?php

//Commun à toutes les pages
require_once 'core/error-exception.php';
require_once 'src/initialization.php';
require_once 'src/Page.php';

// Spécifique à cette page
require_once 'core/Validation.php';

const ACTIVE_PAGE = Page::Contact;

//===============================================================
// Simplement pour simuler l'envoi d'un courriel dans cet exemple
function email($email, $message) {
    // var_dump('envoyer email');
    // var_dump($email);
    // var_dump($message);
    return true;
}
//===============================================================

// On prépare les variables qui serviront à l'affichage dans le html
// Souvent on nomme les variables commme les champs du formulaire
$email = '';
$message = '';
$messages = [];

// On peut déclarer aussi des variables pour contrôler l'affichage.
$globalMessageColor = 'text-success';

// Valider et récupérer le contenu du formulaire seulement s'il a été soumit
if (IS_POST) {

    // Si la donnée de email n'est pas présente dans le POST alors null sera retourné
    // Si la donnée est présente mais invalide alors la valeur 'false' sera assigée
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $message = $_POST['message'] ?? '';

    // Le courriel est obligatoire
    // À cause de input_filter on sait que les valeurs possibles sont : false, null ou string
    if ( !is_string($email) ) {

        $messages['email'] = 'Le courriel est invalide';
        $email = $_POST['email'] ?? '';

    }

    // Le message est obligatoire et taille minimum 10 caractère
    if (!Validation::stringIsSize($message, 10)) {

        $messages['message'] = 'Le message est invalide.<br>Il doit avoir une longueur minimale de 10 caractères.';

    }
    
    // La logique actuelle est basée sur la présence d'un ou plus message d'erreur
    // Nous pourrions faire aussi avec :!empty($messages)
    if (count($messages) > 0) {

        $messages['global'] = 'Le formulaire est invalide';
        $globalMessageColor = 'text-danger';

    } else {

        // Simule une action qui utilise les données
        $success = email($email, $message);

        if($success) {

            // Comme tout a fonctionné on réinitialise les variables pour l'interface
            // en affichant un message de succès.
            $email = '';
            $message = '';
            $messages['global'] = 'Merci de nous avoir contactés';

        } else {

            //Si le courriel ne s'est pas envoyé on informe l'utilisateur
            $messages['global'] = 'Une erreur est survenur lors du traitement de la demande';
            $globalMessageColor = 'text-danger';

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
            <h1 class="py-3 mt-3">Votre satisfaction est notre priorité</h1>

            <div class="fs-4 text-center my-5">Contactez-nous pour toutes questions ou commentaires.</div>

            <!--Bloc formulaire contact-Contact form block-->
            <div class="col-md-4 mx-auto">                         

                <form method="post" novalidate>

                    <div class="mb-3">
                        <label for="email" class="form-label">Courriel</label>
                        <input name="email" type="email" class="form-control" id="email" aria-describedby="emailHelp" value="<?= htmlspecialchars($email) ?>" autofocus>
                        <div id="emailHelp" class="form-text text-danger"><?= $messages['email'] ?? '' ?></div>
                    </div>

                    <div class="mb-3">
                        <label for="message" class="form-label">Votre message</label>
                        <textarea name="message" class="form-control" id="message" rows="3" aria-describedby="messageHelp" ><?= htmlspecialchars($message) ?></textarea>
                        <div id="messageHelp" class="form-text text-danger"><?= $messages['message'] ?? '' ?></div>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Envoyer</button>

                </form>

                <div id="global-message" class="my-5 <?= $globalMessageColor ?>"><?= $messages['global'] ?? '' ?></dib>

            </div>
            <!--Bloc formulaire contact-Contact form block-->

        </main>
        
        <!--Bloc pied de page-Footer block-->
        <?php include_once TEMPLATE . '/footer.php'; ?>
        <!--Bloc pied de page-Footer block-->
        
    </div>
    <!--Contenant principal-->
   
</body>
</html>