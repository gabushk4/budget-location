<?php

//Commun à toutes les pages
require_once '../core/error-exception.php';
require_once '../src/initialization.php';
require_once SRC . '/Page.php';

notAdminRedirectHome();

// Spécifique à cette page
require_once CORE . '/Database.php';
require_once SRC . '/ProductDAL.php';

const ACTIVE_PAGE = Page::AdminProductDelete;

$id = filter_input(INPUT_GET,'id', FILTER_VALIDATE_INT) ?? false;

if ($id === false) {

    header('Location: '. Page::AdminProducts->url());

}

$connexion = Database::getConnexion($dbConfig);
$product =  ProductDAL::selectById($connexion, $id); 

if ($product === false) {

    header('Location: '. Page::AdminProducts->url());

}

$action = $_GET['action'] ?? '';

if ($action === 'delete') {

    // Si l'image était unique au produit on devrait aussi la supprimer
    // unlink(path)

    $product = ProductDAL::deleteById($connexion, $id);  
    
    header('Location: '. Page::AdminProducts->url());
    
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
            <h1 class="py-3 mt-3">Supprimer un produit</h1>

            <hr>
            <a href="<?= Page::AdminProducts->url() ?>" class="btn btn-success mt-auto align-self-start"><?= Page::AdminProducts->text() ?></a>
            <hr>

            <!--Bloc produits-Products block-->
            <div class="text-body-secondary pt-3"> 
                
                <img class="pb-3" style="max-width:250px" src="<?= PRODUCT_IMG . '/' . $product['image'] ?>"/>
                
                <p class="pb-3 mb-0 large lh-sm"> 
                    <div>ID : <?= $product['id'] ?></div>
                    <strong class="d-block text-gray-dark"><?= $product['title'] ?></strong>
                    <div><?= $product['description'] ?></div>
                </p> 
                
                <p>
                    <a href="<?= Page::AdminProductDelete->url() . '?id=' . $product['id'] ?>&action=delete" class="btn btn-danger mt-auto align-self-start">Confirmer</a>
                </p>

            </div>
            <!--Bloc produits-Products block-->

        </main>
        
        <!--Bloc pied de page-Footer block-->
        <?php include_once TEMPLATE . '/footer.php'; ?>
        <!--Bloc pied de page-Footer block-->
        
    </div>
    <!--Contenant principal-->
   
</body>
</html>

