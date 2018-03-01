<?php

return [
    /*
     |--------------------------------------------------------------------------
     | Laravel CORS
     |--------------------------------------------------------------------------
     |
     | allowedOrigins, allowedHeaders and allowedMethods can be set to array('*')
     | to accept any value.
     |
     */
    'supportsCredentials' => false,
    'allowedOrigins' => ['*'],
    'allowedHeaders' => ['X-API-KEY', 'Content-Type', 'X-Requested-With', 'Authorization', 'Application'],
    'allowedMethods' => ['*'], //['GET', 'POST', 'PUT', 'DELETE', 'OPTIONS', 'PATCH'],
    'exposedHeaders' => [],
    'maxAge' => 0,
];
