<?php

//Commun à toutes les pages
require_once '../core/error-exception.php';
require_once '../src/initialization.php';
require_once SRC . '/Page.php';

notAdminRedirectHome();

// Spécifique à cette page
require_once CORE . '/Database.php';
require_once SRC . '/TruckDAL.php';

const ACTIVE_PAGE = Page::AdminTruckDelete;

$id = filter_input(INPUT_GET,'id', FILTER_VALIDATE_INT) ?? false;

if ($id === false) {

    header('Location: '. Page::AdminTrucks->url());

}

$connexion = Database::getConnexion($dbConfig);
$truck =  TruckDAL::selectById($connexion, $id); 

if ($truck === false) {

    header('Location: '. Page::AdminTrucks->url());

}

$action = $_GET['action'] ?? '';

if ($action === 'delete') {

    // Si l'image était unique au produit on devrait aussi la supprimer
    // unlink(path)

    $Truck = TruckDAL::deleteById($connexion, $id);  
    
    header('Location: '. Page::AdminTrucks->url());
    
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
            <h1 class="py-3 mt-3">Supprimer un camion</h1>

            <hr>
            <a href="<?= Page::AdminTrucks->url() ?>" class="btn btn-success mt-auto align-self-start"><?= Page::AdminTrucks->text() ?></a>
            <hr>

            <!--Bloc produits-Trucks block-->
            <div class="text-body-secondary pt-3"> 
                
                <img class="pb-3" style="max-width:250px" src="<?= PRODUCT_IMG . '/' . $truck['image'] ?>"/>
                
                <p class="pb-3 mb-0 large lh-sm"> 
                    <div>ID : <?= $truck['id'] ?></div>
                    <strong class="d-block text-gray-dark"><?= $truck['maker'] ?></strong>
                    <div><?= $truck['model'] ?></div>
                </p> 
                
                <p>
                    <a href="<?= Page::AdminTruckDelete->url() . '?id=' . $truck['id'] ?>&action=delete" class="btn btn-danger mt-auto align-self-start">Confirmer</a>
                </p>

            </div>
            <!--Bloc produits-Trucks block-->

        </main>
        
        <!--Bloc pied de page-Footer block-->
        <?php include_once TEMPLATE . '/footer.php'; ?>
        <!--Bloc pied de page-Footer block-->
        
    </div>
    <!--Contenant principal-->
   
</body>
</html>

