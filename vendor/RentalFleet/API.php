<?php

require_once VENDOR . '/RentalFleet/exceptions.php';
require_once VENDOR . '/RentalFleet/constants.php';
require_once VENDOR . '/RentalFleet/tools.php';
require_once VENDOR . '/RentalFleet/Curl.php';
class API {

    // Demande à Curl d'envoyer la requête et gère les exceptions de connexion
    // Va éventuellement gérer l'authentification avec l'API
    private static function loginAndRequest(
        string $method, 
        string $route, 
        array $headers = [], 
        array $data = [],
        int $connectTimeout = 3,
        int $timeout = 5
    ){
        
        try {

            // Fait la requête à l'API
            $response = Curl::send(
                method: $method,
                route: API_DOMAIN . $route, 
                headers: $headers,
                data: $data,
                connectTimeout: $connectTimeout,
                timeout: $timeout
            );
                     
            [$status, $headers, $body] = array_values($response);

            return [
                'status' => $status,
                'headers' => $headers,
                'body' => $body
            ];     

        } catch (ApiConnectTimeoutException | ApiResponseTimeoutException | ApiUnavailableException $e) {
            throw $e;   
        } 
        catch (Exception $e) {
            throw $e;
        }

    }

    
    // Cette fonction va retourner une liste de produit ou une liste vide
    public static function getProducts() : array {

        // Utilisation de paramètre nommés 
        // car certains paramètres sont optionnels et ont une valeur par défaut
        
        // Utilisation API::loginAndRequest
        $response = self::loginAndRequest(
            method:HTTP_METHOD_GET,
            route: ROUTE_PRODUCTS,    
            headers: [createHeader(HTTP_HEADER_CONTENT_TYPE, CONTENT_TYPE_APPLICATION_JSON)]
        );

        if($response == null){
            return [];
        }
       
        [$status, $headers, $body] = array_values($response); 

        if ($status === HTTP_STATUS_OK && $headers[HTTP_HEADER_CONTENT_TYPE] === CONTENT_TYPE_APPLICATION_JSON) {

            return $body;

        }

        // Dans les cas d'erreurs on va retourner un tableau vide
        // pour que la fonction qui appelle la fonction ne soit pas affectée
        return [];
        
    }

}