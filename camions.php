<?php

//Commun à toutes les pages
require_once 'core/error-exception.php';
require_once 'src/initialization.php';
require_once 'src/Page.php';

// Spécifique à cette page
const ACTIVE_PAGE = Page::Trucks;

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
            <h1 class="py-3 mt-3">Choix de véhicules à petit prix</h1>

            <!--Bloc produits-Products block-->
            <?php include_once TEMPLATE . '/trucks.php'; ?>
            <!--Bloc produits-Products block-->

        </main>
        
        <!--Bloc pied de page-Footer block-->
        <?php include_once TEMPLATE . '/footer.php'; ?>
        <!--Bloc pied de page-Footer block-->
        
    </div>
    <!--Contenant principal-->
   
</body>
</html>

