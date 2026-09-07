<?php
include_once 'exceptions.php';
require_once 'constants.php';
require_once 'tools.php';

class Curl {

    public static function send($url){

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
            createHeader('Accept', ['application/json', 'text/plain']),
            createHeader('Content-Type', ['application/json'])
        ];
        //===========================
        

        curl_setopt($ch, CURLOPT_HEADER, false); // Do not include headers in output repsonse
        curl_setopt($ch, CURLOPT_HTTPHEADER, $requestHeaders);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Returns the response as a string instead of echoing it
        

        // Code qu'on voudra modifier : Méthode et URL
        curl_setopt($ch, CURLOPT_HTTPGET, true); // HTTP default Method        
        curl_setopt($ch, CURLOPT_URL, $url);
        //===========================


        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3); // 3 seconds to connect
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);        // 5 seconds total max execution

        $response = curl_exec($ch);

        $errno = curl_errno($ch);
        $error = curl_error($ch);

        
        // Traite une erreur de connexion et lance l'exception appropriée
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

                throw new ApiUnavailableException($error);

            }
        }


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