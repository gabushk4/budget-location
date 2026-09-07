<?php

//Commun à toutes les pages
require_once '../core/error-exception.php';
require_once '../src/initialization.php';
require_once SRC . '/Page.php';

notAdminRedirectHome();

// Spécifique à cette page
require_once CORE . '/Database.php';
require_once SRC . '/TruckDAL.php';

const ACTIVE_PAGE = Page::AdminTrucks;

$trucks = TruckDAL::selectAll(Database::getConnexion($dbConfig));

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
            <h1 class="py-3 mt-3">Gestion des camions</h1>

            <hr>
            <a href="<?= Page::AdminTruckAdd->url() ?>" class="btn btn-success mt-auto align-self-start"><?= Page::AdminTruckAdd->text() ?></a>
            <hr>

            <!--Bloc camions-Trucks block-->
                        
            <?php foreach ($trucks as $truck) : ?>

            <div class="text-body-secondary pt-3"> 
                
                <img class="pb-3" style="max-width:250px" src="<?= PRODUCT_IMG . '/' . $truck['image'] ?>"/>
                
                <p class="pb-3 mb-0 large lh-sm"> 
                    <strong class="d-block text-gray-dark"><?= $truck['maker'] ?></strong>
                    <div><?= $truck['model'] ?></div>
                </p> 
                
                <p>
                    <a href="<?= Page::AdminTruckEdit->url() . '?id=' . $truck['id'] ?>" class="btn btn-primary mt-auto align-self-start"><?= Page::AdminTruckEdit->text() ?></a>
                    <a href="<?= Page::AdminTruckDelete->url() . '?id=' . $truck['id'] ?>" class="btn btn-danger mt-auto align-self-start"><?= Page::AdminTruckDelete->text() ?></a>
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

