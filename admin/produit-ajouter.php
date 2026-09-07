<?php

//Commun à toutes les pages
require_once '../core/error-exception.php';
require_once '../src/initialization.php';
require_once SRC . '/Page.php';

notAdminRedirectHome();

// Spécifique à cette page
require_once CORE . '/Database.php';
require_once SRC . '/ProductDAL.php';
require_once CORE . '/Upload.php';

const ACTIVE_PAGE = Page::AdminProductAdd;

$messages = [];

$globalMessageColor = 'text-danger';

$allowedTypes = ['image/png', 'image/jpeg', 'image/avif', 'image/webp'];

$title = '';
$description = '';
$image = '';
$alt = '';

if (IS_POST) {

    //var_dump($_POST);
    //var_dump($_FILES);

    // Volontairement ici nous ne validons pas l'image ou la taille du texte)
    // Normalement nous ferions toute la série des validations

    $title = $_POST['title'] ?? '';
    if (empty($title)) {
        $messages['title'] = 'Le titre est obligatoire.';
    }

    $description = $_POST['description'] ?? '';
    if (empty($description)) {
        $messages['description'] = 'La description est obligatoire.';
    }

    $image = $_FILES['image']['name'] ?? '';
    if (empty($image)) {
        $messages['image'] = 'L\'image est obligatoire.';
    }

    $alt = $_POST['alt'] ?? '';
    if (empty($alt)) {
        $messages['alt'] = 'L\'attribut ALT est obligatoire.';
    }

    //var_dump($messages);

    if(empty($messages)) {

        Upload::move('image', UPLOAD, $allowedTypes);

        $connexion = Database::getConnexion($dbConfig);

        if (ProductDAL::insertOne($connexion, $title, $description, $image, $alt)) {

            $title = '';
            $description = '';
            $alt = '';

            $messages['global'] = 'Le produit a été ajouté.';
            $globalMessageColor = 'text-success';

        } else {

            $messages['global'] = 'Une erreur est survenue au moment de l\'enregistrement.';

        }

    } else {

        $messages['global'] = 'Le formulaire est invalide.';

    }
 
} else {

    $messages['global'] = 'Tous les champs sont obligatoires.';

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
            <h1 class="py-3 mt-3">Ajouter un produit</h1>

            <hr>
            <a href="<?= Page::AdminProducts->url() ?>" class="btn btn-success mt-auto align-self-start"><?= Page::AdminProducts->text() ?></a>
            <hr>

            <!--Bloc formulaire-->
            <div class="col-md-4 mx-auto">                         

                <form method="post" enctype="multipart/form-data" novalidate>

                    <div class="mb-3">
                        <label for="title" class="form-label"><span class="text-danger">*</span> Titre</label>
                        <input name="title" type="text" class="form-control" id="title" aria-describedby="titleHelp" value="<?= htmlspecialchars($title) ?>" autofocus>
                        <div id="titleHelp" class="form-text text-danger"><?= $messages['title'] ?? '' ?></div>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label"><span class="text-danger">*</span>Description</label>
                        <input name="description" type="text" class="form-control" id="description" aria-describedby="descriptionHelp" value="<?= htmlspecialchars($description) ?>">
                        <div id="descriptionHelp" class="form-text text-danger"><?= $messages['description'] ?? '' ?></div>
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label"><span class="text-danger">*</span>Image</label>
                        <input name="image" type="file" class="form-control" id="image" aria-describedby="imageHelp" accept=".jpg,.png,.webp,.avif">
                        <div id="imageHelp" class="form-text text-danger"><?= $messages['image'] ?? '' ?></div>
                    </div>

                    <div class="mb-3">
                        <label for="alt" class="form-label"><span class="text-danger">*</span>Attribut ALT</label>
                        <input name="alt" type="text" class="form-control" id="alt" aria-describedby="altHelp" value="<?= htmlspecialchars($alt) ?>">
                        <div id="altHelp" class="form-text text-danger"><?= $messages['alt'] ?? '' ?></div>
                    </div>
                    
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

