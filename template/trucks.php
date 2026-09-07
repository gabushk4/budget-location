<?php

// Par simplicité on ne valide pas l'existence du fichier
require_once CORE . '/Database.php';
require_once SRC . '/TruckDAL.php';

$connexion = Database::getConnexion($dbConfig);

$trucks = TruckDAL::selectAll($connexion);

?>
<!--Ligne qui contient des colonnes-Row-->
<div class="row">
    
    <?php foreach($trucks as $truck) : ?>

    <!--Colonne-Column-->
    <div class="col-lg-4 d-flex align-items-stretch">                        
            
        <!--Carte-Card-->
        <div class="card mt-4 ">
            <img src="<?= PRODUCT_IMG . '/' . $truck['image'] ?>" class="card-img-top" alt="">
                        
            <div class="card-body d-flex flex-column">
                
                <h5 class="card-title"><?= $truck['maker'] ?></h5>
                <p class="card-text "><?= $truck['model'] ?></p>                
                
                <?php if (IS_USER) : ?>
                <a href="" class="btn btn-primary mt-auto align-self-start">Ajouter au panier</a>
                <?php endif; ?>                
                
            </div>
        </div>
        
    </div>
    <!--Colonne-->

    <?php endforeach; ?>    

</div>
<!--Ligne--> 