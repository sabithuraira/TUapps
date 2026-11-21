<?php

return [
    /*
    |--------------------------------------------------------------------------
    | BPS SSO (Keycloak / OpenID Connect)
    |--------------------------------------------------------------------------
    | Values are read from .env so the client secret is not stored in code.
    */
    'url'           => env('KEYCLOAK_URL', 'https://accounts.bps.go.id'),
    'realm'         => env('KEYCLOAK_REALM', 'pegawai'),
    'client_id'     => env('KEYCLOAK_CLIENT_ID', '11600-musi-3wy'),
    'client_secret' => env('KEYCLOAK_CLIENT_SECRET'),
    'redirect_uri'  => env('KEYCLOAK_REDIRECT_URI', 'http://localhost:8000/'),
];
