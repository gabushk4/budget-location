<?php

require_once VENDOR . '/RentalFleet/exceptions.php';
require_once VENDOR . '/RentalFleet/constants.php';
require_once VENDOR . '/RentalFleet/tools.php';

class Curl {

    public static function send(
        string $method, 
        string $route, 
        array $headers = [], 
        array $data = [],
        int $connectTimeout = 3,
        int $timeout = 5
    ){

        // Initialisation de l'objet cURL
        $ch = curl_init();
        
        // Contiendra les en-têtes de la réponse
        $responseHeaders = [];

        /* 
            Enregistrement de la fonction qui créé le tableau des
            en-têtes de la réponse. 
            
            Fonction "callback".
        */
        curl_setopt($ch, CURLOPT_HEADERFUNCTION, function($curl, $header) use (&$responseHeaders) {
            $len = strlen($header);
            $parts = explode(':', $header, 2);

            if (count($parts) === 2) {
                $name  = strtolower(trim($parts[0]));
                $value = trim($parts[1]);

                if (isset($responseHeaders[$name])) {
                    if (!is_array($responseHeaders[$name])) {
                        $responseHeaders[$name] = [$responseHeaders[$name]];
                    }
                    $responseHeaders[$name][] = $value;
                } else {
                    $responseHeaders[$name] = $value;
                }
            }

            return $len;
        });
        /*
            Fin de la fonction "callback"
        */


        // Code qu'on voudra modifier : en-têtes de requête
        $requestHeaders = [
            // 'accept: application/json, text/plain'
            // HTTP_HEADER_ACCEPT . ': ' . CONTENT_TYPE_APPLICATION_JSON . ', ' . CONTENT_TYPE_TEXT_PLAIN
            createHeader(HTTP_HEADER_ACCEPT, CONTENT_TYPE_APPLICATION_JSON, CONTENT_TYPE_TEXT_PLAIN )
        ];
        //===========================
        
        curl_setopt($ch, CURLOPT_HEADER, false); // Do not include headers in output repsonse

        // array_merge : les données du 2e tableau écrasent celles du 1er tableau
        curl_setopt($ch, CURLOPT_HTTPHEADER, array_merge($requestHeaders, $headers));

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Returns the response as a string instead of echoing it
        

        // Définir Méthode
        switch($method) {

            // GET
            case HTTP_METHOD_GET:

                curl_setopt($ch, CURLOPT_HTTPGET, true); // HTTP default Method     
                break;

            // POST
            case HTTP_METHOD_POST:
                break;
            // PUT
            case HTTP_METHOD_PUT:          
                break;
            // PATCH
            case HTTP_METHOD_PATCH:
                break;
            // DELETE
            case HTTP_METHOD_DELETE:
                break;  
        }

        // Définir route/URL
        curl_setopt($ch, CURLOPT_URL, $route);

        //===========================

        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $connectTimeout); // 3 seconds to connect
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);        // 5 seconds total max execution

        $response = curl_exec($ch);

        $errno = curl_errno($ch);
        $error = curl_error($ch);
        
        // Traite une erreur de communication et lance l'exception appropriée
        // Est-ce que notre client réussi à parler à l'API ?
        if ($response === false) {

            if ($errno === CURLE_OPERATION_TIMEDOUT) {
                $info = curl_getinfo($ch);
                
                // Time taken to establish the connection (TCP handshake + SSL/TLS handshake)
                $connectTime = $info['connect_time']; 

                // If connect_time is near 0 or near your 3-second limit, the failure happened during connection setup.
                // Otherwise, connection succeeded, but the data transfer phase exceeded the 5-second total limit.
                if ($connectTime === 0.0 || $connectTime >= 2.9) {

                    throw new ApiConnectTimeoutException("Connection timed out before establishing host link: {$error}");
                
                } else {
                
                    throw new ApiResponseTimeoutException("Connected successfully in {$connectTime}s, but response stalled: {$error}");
                
                }
            } else {

                throw new ApiUnavailableException($errno);

            }
        }
        
        // Nous avons réussi à parler à l'API
        // Nous avons eu une réponse, on retourne les informations
        
        // Code status HTTP
        // Tableau associatif des en-têtes de la réponse
        // Tableau associatif des données du corps du message de réponse
        
        return [
            'status' => curl_getinfo($ch, CURLINFO_HTTP_CODE),
            'headers' => array_change_key_case($responseHeaders, CASE_LOWER),
            'body' => json_decode($response, true)
        ];

    }

}