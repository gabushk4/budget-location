<?php

class Json
{
    public static function importJson(string $path): null|array
    {
        $jsonString = file_get_contents($path);
        
        $decode = json_decode($jsonString, true);

        if(empty($decode)) {
            return null;
        }

        return $decode;
    } 

    public static function exportJson(array $data, string $path): int|false
    {
        $encode = json_encode($data, JSON_PRETTY_PRINT);
        
        // Retourne false si l'écriture ne réussie pas
        // Retourne la taille du contenu écrit si ça réussie
        return file_put_contents($path, $encode, LOCK_EX);
    }

}