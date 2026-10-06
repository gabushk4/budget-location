<?php
require_once VENDOR . "/RentalFleet/constants.php";

    function contentTypeIsJson(array $headers): bool{
        if (!isset($headers['content-type']))
            return false;
        
        $contentType = $headers['content-type'];

        if ($contentType === HTTP_HEADER_CONTENT_TYPE)
            return true;

        return false;
    }

    function createHeader(string $headerKey, ...$headerValues): string{
        return $headerKey . ": " . implode(", ", $headerValues);
    }