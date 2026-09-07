<?php

//Commun à toutes les pages
require_once '../core/error-exception.php';
require_once '../src/initialization.php';
require_once SRC . '/Page.php';

notAdminRedirectHome();

// Spécifique à cette page
require_once CORE . '/Database.php';
require_once SRC . '/ProductDAL.php';

const ACTIVE_PAGE = Page::AdminProducts;

$products = ProductDAL::selectAll(Database::getConnexion($dbConfig));

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
            <h1 class="py-3 mt-3">Gestion des produits</h1>

            <hr>
            <a href="<?= Page::AdminProductAdd->url() ?>" class="btn btn-success mt-auto align-self-start"><?= Page::AdminProductAdd->text() ?></a>
            <hr>

            <!--Bloc produits-Products block-->
                        
            <?php foreach ($products as $product) : ?>

            <div class="text-body-secondary pt-3"> 
                
                <img class="pb-3" style="max-width:250px" src="<?= PRODUCT_IMG . '/' . $product['image'] ?>"/>
                
                <p class="pb-3 mb-0 large lh-sm"> 
                    <strong class="d-block text-gray-dark"><?= $product['title'] ?></strong>
                    <div><?= $product['description'] ?></div>
                </p> 
                
                <p>
                    <a href="<?= Page::AdminProductEdit->url() . '?id=' . $product['id'] ?>" class="btn btn-primary mt-auto align-self-start"><?= Page::AdminProductEdit->text() ?></a>
                    <a href="<?= Page::AdminProductDelete->url() . '?id=' . $product['id'] ?>" class="btn btn-danger mt-auto align-self-start"><?= Page::AdminProductDelete->text() ?></a>
                </p>

            </div>

            <hr>

            <?php endforeach; ?>

            
            <!--Bloc produits-Products block-->

        </main>
        
        <!--Bloc pied de page-Footer block-->
        <?php include_once TEMPLATE . '/footer.php'; ?>
        <!--Bloc pied de page-Footer block-->
        
    </div>
    <!--Contenant principal-->
   
</body>
</html>

