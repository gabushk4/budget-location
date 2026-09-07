<?php

//Commun à toutes les pages
require_once '../core/error-exception.php';
require_once '../src/initialization.php';
require_once SRC . '/Page.php';

notAdminRedirectHome();

// Spécifique à cette page
require_once CORE . '/Database.php';
require_once SRC . '/TruckDAL.php';
require_once CORE . '/Upload.php';

const ACTIVE_PAGE = Page::AdminTruckEdit;

$messages = [];
$globalMessageColor = 'text-danger';

$allowedTypes = ['image/png', 'image/jpeg', 'image/avif', 'image/webp'];

$maker = '';
$model = '';
$image = '';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT) ?? false;

if ($id === false) {

    header('Location: '. Page::AdminTrucks->url());

}

$connexion = Database::getConnexion($dbConfig);
$truck = TruckDAL::selectById($connexion, $id);

if ($truck === false) {

    header('Location: '. Page::AdminTrucks->url());

}

if (IS_POST) {

    //var_dump($_POST);
    //var_dump($_FILES);

    // Volontairement ici nous ne validons pas l'image ou la taille du texte)
    // Normalement nous ferions toute la série des validations

    $maker = $_POST['maker'] ?? '';
    if (empty($maker)) {
        $messages['maker'] = 'Le manufacturier est obligatoire.';
        $maker = $truck['maker'];
    }

    $model = $_POST['model'] ?? '';
    if (empty($model)) {
        $messages['model'] = 'Le modèle est obligatoire.';
        $model = $truck['model'];
    }

    // Comme l'image n'est pas obligatoire, on doit partir de l'information en base de donnée
    $image = $truck['image'];
    
    //var_dump($messages);

    if(empty($messages)) {

        if (!empty($_FILES['image']['name']) && Upload::move('image', UPLOAD, $allowedTypes)) {
            
            $image = $_FILES['image']['name'];

        }

        if (TruckDAL::updateById($connexion, $id, $maker, $model, $image)) {

            $messages['global'] = 'Le camion a été modifié.';
            $globalMessageColor = 'text-success';

        } else {

            $messages['global'] = 'Une erreur est survenue au moment de l\'enregistrement.';

        }

    } else {

        $messages['global'] = 'Le formulaire est invalide.';

    }
 
} else{

    // Affichage par défaut
    $maker = $truck['maker'];
    $model = $truck['model'];
    $image = $truck['image'];

    $messages['global'] = 'Tous les champs, sauf image, sont obligatoires.';

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
            <h1 class="py-3 mt-3">Modifier un produit</h1>

            <hr>
            <a href="<?= Page::AdminTrucks->url() ?>" class="btn btn-success mt-auto align-self-start"><?= Page::AdminTrucks->text() ?></a>
            <hr>

            <!--Bloc formulaire-->
            <div class="col-md-4 mx-auto">                         

                <form method="post" enctype="multipart/form-data" novalidate>

                    <div class="mb-3">
                        <label for="maker" class="form-label"><span class="text-danger">*</span> Manufacturier</label>
                        <input name="maker" type="text" class="form-control" id="maker" aria-describedby="makerHelp" value="<?= htmlspecialchars($maker) ?>" autofocus>
                        <div id="makerHelp" class="form-text text-danger"><?= $messages['maker'] ?? '' ?></div>
                    </div>

                    <div class="mb-3">
                        <label for="model" class="form-label"><span class="text-danger">*</span>Modèle</label>
                        <input name="model" type="text" class="form-control" id="model" aria-describedby="modelHelp" value="<?= htmlspecialchars($model) ?>">
                        <div id="modelHelp" class="form-text text-danger"><?= $messages['model'] ?? '' ?></div>
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label"><span class="text-danger">*</span>Image</label>
                        <input name="image" type="file" class="form-control" id="image" aria-describedby="imageHelp" accept=".jpg,.png,.webp,.avif">
                        <div id="imageHelp" class="form-text text-danger"><?= $messages['image'] ?? '' ?></div>
                    </div>

                    <div><img class="pb-3" style="max-width:250px" src="<?= PRODUCT_IMG . '/' . $image ?>"/></div>

                    <button type="submit" class="btn btn-primary">Enregistrer</button>

                </form>

                <div id="global-message" class="my-5 <?= $globalMessageColor ?>"><?= $messages['global'] ?? '' ?></dib>

            </div>
            <!--Bloc formulaire-->
                        
        </main>
        
        <!--Bloc pied de page-Footer block-->
        <?php include_once TEMPLATE . '/footer.php'; ?>
        <!--Bloc pied de page-Footer block-->
        
    </div>
    <!--Contenant principal-->
   
</body>
</html>

