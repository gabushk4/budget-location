<?php

//Commun à toutes les pages
require_once 'core/error-exception.php';
require_once 'src/initialization.php';
require_once 'src/Page.php';

// Spécifique à cette page
const ACTIVE_PAGE = Page::About;

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
            <h1 class="py-3 mt-3">Une entreprise de confiance</h1>

            <div class="px-4 py-5 my-5 text-center"> 
                <h1 class="fw-bold text-body-emphasis">Avec vous depuis longtemps</h1> 
                <div class="col-lg-9 mx-auto"> 
                    <p class="lead mb-4">
                        Fondée il y a plus de trente ans avec une vision simple — rendre le transport professionnel accessible à tous — notre entreprise a commencé son parcours avec seulement trois véhicules d'occasion et une volonté inébranlable de servir les artisans locaux. Ce qui n'était au départ qu'une modeste agence de quartier s'est rapidement imposé comme un acteur de référence grâce à une réputation bâtie sur la fiabilité et la proximité.
                    </p>
                    
                    <p class="lead mb-4">
                       Au fil des décennies, nous avons su anticiper les mutations du secteur, passant d'une gestion manuelle traditionnelle à une organisation logistique optimisée, tout en conservant l'esprit entrepreneurial et le sens du service client qui ont marqué nos premières années d'existence.
                    </p> 

                    <img class="d-block mx-auto mb-4 img-fluid" src="<?= IMG . '/team.webp' ?>" alt="Notre équipe"> 
                
                    <p class="lead mb-4">
                        Au cours de notre développement, nous avons franchi des étapes clés qui ont jalonné notre croissance, notamment par l'élargissement progressif de notre flotte pour inclure des technologies de plus en plus performantes et écologiques. Chaque nouvelle décennie a été l'occasion d'intégrer des innovations majeures, qu'il s'agisse de la digitalisation de nos processus de réservation ou de l'adoption de motorisations à faibles émissions pour répondre aux défis climatiques actuels.
                    </p>

                    <p class="lead mb-4">
                       Aujourd'hui, notre héritage est un mélange équilibré entre la solidité acquise au fil du temps et une agilité constante, ce qui nous permet de soutenir avec la même passion les nouveaux défis logistiques de nos clients, qu'ils soient des particuliers ou des grands comptes.
                    </p>
                    
                </div> 
            </div>

        </main>
        
        <!--Bloc pied de page-Footer block-->
        <?php include_once TEMPLATE . '/footer.php'; ?>
        <!--Bloc pied de page-Footer block-->
        
    </div>
    <!--Contenant principal-->
   
</body>
</html>

