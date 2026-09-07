<?php

// Par simplicité on ne valide pas l'existence du fichier
require_once CORE . '/Database.php';
require_once SRC . '/ProductDAL.php';
require_once VENDOR . '/RentalFleet/Curl.php';
require_once VENDOR . '/RentalFleet/constants.php';
require_once VENDOR . '/RentalFleet/tools.php';

$connexion = Database::getConnexion($dbConfig);

$search = $_GET['search'] ?? '';

if (!empty($search)) {

    $search = "%" . strtolower($search) . "%";
    $products = ProductDAL::selectByTitle($connexion, $search); 

} else {

    $products = ProductDAL::selectAll($connexion);   
    
    //API call to RentalFleet     
    try {    
        [$status, $headers, $body] = array_values(Curl::send(ROUTE_PRODUCTS));
        if($status === 200 && contentTypeIsJson($headers)){
            foreach ($body as $product) {
                $products[] = [
                    'id' => $product['id'],
                    'title' => $product['name'],
                    'description' => '',
                    'image' => $product['picture'],
                    'alt' => '',
                    'price' => $product['price'],
                    'source' => 'api'
                ];
            }
        }
    }catch(Exception $e){
        throw $e;
    }
}



?>
<!--Ligne qui contient des colonnes-Row-->
<div class="row">
    
    <?php foreach($products as $product) : ?>

    <!--Colonne-Column-->
    <div class="col-lg-4 d-flex align-items-stretch">                        
            
        <!--Carte-Card-->
        <div class="card mt-4 ">
            <img src="<?= PRODUCT_IMG . '/' . $product['image'] ?>" class="card-img-top" alt="<?= $product['alt'] ?>">
                        
            <div class="card-body d-flex flex-column">
                
                <h5 class="card-title"><?= $product['title'] ?></h5>
                <p class="card-text "><?= $product['description'] ?></p>     
                <p class="card-price"><?= $product['price'] ?>$</p>           
                
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