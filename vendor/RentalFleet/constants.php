<?php

// Méthodes HTTP
const HTTP_METHOD_GET = 'GET';
const HTTP_METHOD_POST = 'POST';
const HTTP_METHOD_DELETE = 'DELETE';
const HTTP_METHOD_PUT = 'PUT';
const HTTP_METHOD_PATCH = 'PATCH';

// Statut HTTP
const HTTP_STATUS_OK = 200;

// En-têtes HTTP
const HTTP_HEADER_ACCEPT = 'accept';
const HTTP_HEADER_CONTENT_TYPE = 'content-type';

// Types de contenu
const CONTENT_TYPE_APPLICATION_JSON = 'application/json';
const CONTENT_TYPE_TEXT_PLAIN = 'text/plain';

// Routes de base
// Dans ce projet on va garder les routes au plus simple possible
const ROUTE_PRODUCTS = '/products';

// API domain
const API_DOMAIN = 'http://local.api.rental-fleet.com:3000';
const API_CDN = 'http://local.cdn.rental-fleet.com';
