<?php
    function contentTypeIsJson(array $headers): bool{
        if (!isset($headers['content-type']))
            return false;
        
        $contentType = $headers['content-type'];

        if ($contentType === CONTENT_TYPE_JSON)
            return true;

        return false;
    }

    function createHeader(string $headerKey, array $headerValues): string{
        return $headerKey . ": " . implode(", ", $headerValues);
    }