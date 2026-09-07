<?php
enum Page
{
    case Home;
    case About;
    case Products;
    
    case Trucks;
    case Availability;
    case Modify;
    case Order;
    case Cart;

    case Contact;    

    case Connexion;
    case Creation;
    case Logout;

    case AdminProducts;
    case AdminProductAdd;
    case AdminProductEdit;
    case AdminProductDelete;

    case AdminTrucks;
    case AdminTruckAdd;
    case AdminTruckEdit;
    case AdminTruckDelete;
    
    public function text(): string {

        return match($this) {
            
            Page::Home => 'Accueil',
            Page::About => 'À propos',
            Page::Products => 'Produits',

            Page::Trucks => 'Camions',
            Page::Availability => 'Disponibilité',
            Page::Modify => 'Modifier',
            Page::Order => 'Commander',
            Page::Cart => 'Panier',
            
            Page::Contact => 'Contact',

            Page::Connexion => 'Connexion',
            Page::Creation => 'Création',
            Page::Logout => 'Déconnexion',

            Page::AdminProducts => 'Gestion des produits',
            Page::AdminProductAdd => 'Ajouter un produit',
            Page::AdminProductEdit => 'Modifier ce produit',
            Page::AdminProductDelete => 'Supprimer ce produit',

            Page::AdminTrucks => 'Gestion des camions',
            Page::AdminTruckAdd => 'Ajouter un camion',
            Page::AdminTruckEdit => 'Modifier ce camion',
            Page::AdminTruckDelete => 'Supprimer ce camion',

        };

    }

    public function url(): string {

        return match($this) {
            
            Page::Home => URL_ROOT,
            Page::Products => URL_ROOT . 'produits.php',

            Page::Trucks => URL_ROOT . 'camions.php',
            Page::Availability => URL_ROOT . 'location/disponibilite.php',
            Page::Modify => URL_ROOT . 'location/modifier.php',
            Page::Order => URL_ROOT . 'location/commander.php',
            Page::Cart => URL_ROOT . 'location/panier.php',

            Page::About => URL_ROOT . 'a-propos.php',
            Page::Contact => URL_ROOT . 'contact.php',

            Page::Connexion => URL_ROOT . 'connexion.php',
            Page::Creation => URL_ROOT . 'creation.php',
            Page::Logout => URL_ROOT . 'logout.php',

            Page::AdminProducts => URL_ROOT . 'admin/produits.php',
            Page::AdminProductAdd => URL_ROOT . 'admin/produit-ajouter.php',
            Page::AdminProductEdit => URL_ROOT . 'admin/produit-modifier.php',
            Page::AdminProductDelete => URL_ROOT . 'admin/produit-supprimer.php',

            Page::AdminTrucks => URL_ROOT . 'admin/camions.php',
            Page::AdminTruckAdd => URL_ROOT . 'admin/camion-ajouter.php',
            Page::AdminTruckEdit => URL_ROOT . 'admin/camion-modifier.php',
            Page::AdminTruckDelete => URL_ROOT . 'admin/camion-supprimer.php',

        };

    }

}