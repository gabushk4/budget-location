<?php

//Commun à toutes les pages
require_once 'core/error-exception.php';
require_once 'src/initialization.php';
require_once 'src/Page.php';

// Spécifique à cette page
const ACTIVE_PAGE = Page::Home;

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
            <h1 class="py-3 mt-3">La location de camions à faible prix</h1>

            <!--Bloc ?-->
            <div class="px-4 py-5 my-5 text-center"> 
                <h1 class="fw-bold text-body-emphasis">LA référence</h1> 
                <div class="col-lg-9 mx-auto"> 
                    <p class="lead mb-4">
                        La location de camions offre une solution flexible et économique pour répondre à tous vos besoins logistiques, qu'il s'agisse d'un déménagement résidentiel ou du transport de marchandises pour votre activité professionnelle.
                    </p>
                    <p class="lead mb-4">
                        Au-delà de la simple mise à disposition du véhicule, notre priorité est de vous accompagner à chaque étape pour garantir le succès de vos déplacements. Nous proposons des contrats de location sur mesure — à l'heure, à la journée ou sur le long terme — afin de s'ajuster précisément à votre planning.
                    </p> 

                    <img class="d-block mx-auto mb-4 img-fluid" src="<?= IMG . '/office.jpg' ?>" alt="Centre de lotation"> 
                
                    <p class="lead mb-4">
                        Grâce à une flotte diversifiée, allant du petit utilitaire maniable aux camions de grand gabarit équipés de hayons élévateurs, vous disposez toujours du véhicule parfaitement adapté à votre chargement.
                    </p>

                    <p class="lead mb-4">
                        Avec des services additionnels tels que l'assurance tout risque, la mise à disposition d'équipements de manutention comme des diables ou des couvertures de protection, et un service d'assistance disponible 24h/24, nous nous engageons à vous offrir une tranquillité d'esprit totale sur la route.
                    </p>
                    
                </div> 
            </div>
            <!--Bloc ?-->            

        </main>
        
        <!--Bloc pied de page-Footer block-->
        <?php include_once TEMPLATE . '/footer.php'; ?>
        <!--Bloc pied de page-Footer block-->
        
    </div>
    <!--Contenant principal-->
   
</body>
</html>

