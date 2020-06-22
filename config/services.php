<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'google' => [
        'client_id' => '270786535137-tc6hofsn5ijmicm7dkdfihni8ta8j20g.apps.googleusercontent.com',
        'client_secret' => 'nkdylfOeY0dOCerNoDn3fJ3p',
        'redirect' => 'http://servertest.sytes.net/perfumesFront/public/google/login/callback'],
    
    'facebook' => [
        'client_id' => '1398681316992199',
        'client_secret' => 'ed7d196af7c133152a45d1863baacaaa',
        'redirect' => 'http://localhost:8000/facebook/login/callback'],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

];
